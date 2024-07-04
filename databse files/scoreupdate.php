<?php
// error_reporting(0);
include("simple_html_dom.php");
const WEBSITES = [
    'codechef' => 'https://www.codechef.com/users/',
    'codeforces' => 'https://codeforces.com/profile/',
    'leetcode' => 'https://leetcode.com/',
    'interviewbit' => 'https://www.interviewbit.com/profile/',
    'spoj' => 'https://www.spoj.com/users/',
    'geeksforgeeks' => 'https://auth.geeksforgeeks.org/user/',
];
$specialScores = array(
    'codechef' => 0,
    'codeforces' => 0,
    'leetcode' => 0,
    'interviewbit' => 0,
    'spoj' => 0,
    'geeksforgeeks' => 0,
);
function getallcodingprofilesscores($usernames) {
    $allScores = [];
    global $specialScores;
    $specialScores = array(
        'codechef' => 0,
        'codeforces' => 0,
        'leetcode' => 0,
        'interviewbit' => 0,
        'spoj' => 0,
        'geeksforgeeks' => 0,
    );
    foreach ($usernames as $website => $username) {
        $html = file_get_html(WEBSITES[$website] . $username . '/');
        $functionName = "get" . $website . "score";
        $allScores[$website]=$functionName($html, $username);
        }
    $allScores['specialScores']=$specialScores;
    return $allScores;
}

function getcodechefscore($html,$username) {
    global $specialScores;
    if($username=="" || $username=="-1" || $username==null){
        return [
            'score' => 0,
            'cc' => 0,
            'fs' => 0,
            'ps' => 0,
        ];
    }
    //html has error continue        
    $score = toNum($html->find('.rating-number', 0)->plaintext);
    $contestCount = toNum($html->find('.contest-participated-count', 0)->plaintext);
    $content = $html->find('.content', 0);
    $fs = toNum($content->find('h3', 4)->plaintext);
    $ps = toNum($content->find('h3', 5)->plaintext);
    $specialScores['codechef']=(0.6 * $score) + (0.4 * $contestCount); 
    return [
        'score' => $score,
        'cc' => $contestCount,
        'fs' => $fs,
        'ps' => $ps,
    ];
}
 
function getcodeforcesscore($html, $username) { 
    global $specialScores;
    if($username=="" || $username=="-1" || $username==null){
        return [
            'rank' => 0,
            'rating' => 0,
            'solved' => 0,
        ];
    }   
    $apiEndpoint = "https://codeforces.com/api/user.info?handles=" . $username;
    $response = file_get_contents($apiEndpoint);
    $data = json_decode($response, true);
    if ($data["status"] == "OK") {
        $user = $data["result"][0];
        $rank = $user["rank"];
        $rating = $user["rating"];
        $ps = toNum($html->find('._UserActivityFrame_counterValue', 0)->plaintext);
        $specialScores['codeforces']=$rating;
    } else {
        echo "Error: " . $data["comment"];
    }
    return [
        'rank' => $rank,
        'rating' => $rating,
        'solved' => $ps,
    ];
}
function getleetcodescore($html, $username) {
    global $specialScores;
    if($username=="" || $username=="-1" || $username==null){
        return [
            'score' => 0,
            'solved' => 0,
        ];
    }
    $graphqlEndpoint = 'https://leetcode.com/graphql';
    $query = 'query getUserProfile($username: String!) {
      matchedUser(username: $username) {
        profile {
          reputation
          ranking
        }
        submitStats {
          acSubmissionNum {
            difficulty
            count
            submissions
          }
        }
      }
    }';
    $variables = [
        'username' => $username
    ];
    $data = [
        'operationName' => 'getUserProfile',
        'query' => $query,
        'variables' => $variables,
    ];
    
    $jsonData = json_encode($data);
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\n"
                . "Referer: https://leetcode.com/problemset/all/\r\n",
            'content' => $jsonData,
        ],
    ];
    $context = stream_context_create($options);
    $response = file_get_contents($graphqlEndpoint, false, $context);
    if ($response === false) {
        die('Error: Failed to fetch the data.');
    }
    $data = json_decode($response, true);
    $ranking = $data['data']['matchedUser']['profile']['ranking'];
    $count = $data['data']['matchedUser']['submitStats']['acSubmissionNum'][0]['count'];
    $specialScores['leetcode']=$count;
    return [
        'score' => $ranking,
        'solved' => $count,
    ];
}

function getinterviewbitscore($html, $username) {
    global $specialScores;
    if($username=="" || $username=="-1" || $username==null){
        return [
            'name' => 0,
            'r' => 0,
            's' => 0,
            'st' => 0,
        ];
    }
    $name = $html->find('h3.name', 0)->plaintext;
    $r = toNum($html->find('.txt', 0)->plaintext);
    $s = toNum($html->find('.txt', 1)->plaintext);
    $st = toNum($html->find('.txt', 2)->plaintext);
    $specialScores['interviewbit']=($s*0.25);
    return [
        'name' => $name,
        'r' => $r,
        's' => $s,
        'st' => $st,
    ];
}

function getspojscore($html, $username) {
    global $specialScores;
    if($username=="" || $username=="-1" || $username==null){
        return [
            'ps' => 0,
            'ns' => 0,
        ];
    }
    $ps = $html->find('dd', 0)->plaintext;
    $ns = $html->find('dd', 1)->plaintext;
    $specialScores['spoj']=$ps;
    return [
        'ps' => $ps,
        'ns' => $ns,
    ];
}
function checkEmpty($str) {
    if (empty($str)) {
        return "0";
    } else {
        return $str;
    }
}
function toNum($str) {
    return preg_replace('/[^0-9]/', '', $str);
}
function getgeeksforgeeksscore($html, $username) {
    global $specialScores;
    if($username=="" || $username=="-1" || $username==null){
        return [
            'rank' => 0,
            'os' => 0,
            'ps' => 0,
            'ms' => 0,
        ];
    }
    $rank = checkEmpty(toNum($html->find('span.rankNum', 0)->plaintext));
    $os = checkEmpty(toNum($html->find('span.score_card_value', 0)->plaintext));
    $ps = checkEmpty(toNum($html->find('span.score_card_value', 1)->plaintext));
    $ms = checkEmpty(toNum($html->find('span.score_card_value', 2)->plaintext));
    $specialScores['geeksforgeeks']=(0.6 * $os) + (0.4 * $ps);
    return [
        'rank' => $rank,
        'os' => $os,
        'ps' => $ps,
        'ms' => $ms,
    ];
}
function validspoj($url){
    $html = file_get_html($url);
        $h3_element = $html->find('h3', 0);
        if ($h3_element) {
            $x = $h3_element->plaintext;
            // If $x equals "Activity over the last year", then the account exists
            if ($x === "Activity over the last year") {
                return true;
            }
            return false;
}
}
?>
