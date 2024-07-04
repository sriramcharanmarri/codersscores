<?php
error_reporting(0);
$websites = array(
    'codechef' => 'https://www.codechef.com/users/',
    'codeforces' => 'https://codeforces.com/profile/',
    'leetcode' => 'https://leetcode.com/',
    'interviewbit' => 'https://www.interviewbit.com/profile/',
    'spoj' => 'https://www.spoj.com/users/',
    'geeksforgeeks' => 'https://auth.geeksforgeeks.org/user/'
);
include("simple_html_dom.php");
function isvalid($username, $website) {
    global $websites;
    $url = $websites[$website] . $username . '/';
    $headers = @get_headers($url);
    return ($headers && strpos($headers[0], '200') !== false);
}

function getscore($username, $website) {
    global $websites;
    if (!isvalid($username, $website)) {
        return "notfound";
    }
    $html = file_get_html($websites[$website] . $username . '/');
    
    switch ($website) {
        case 'codechef':
            return getcodechefscore($html);
        case 'codeforces':
            return getcodeforcesscore($html, $username);
        case 'leetcode':
            return getleetcodescore($username);
        case 'interviewbit':
            return getinterviewbitscore($html);
        case 'spoj':
            return getspojscore($html);
        case 'geeksforgeeks':
            return getgeeksforgeeksscore($html);
        default:
            return "unknown";
    }
}
function getcodechefscore($html) {
    $name = $html->find('.h2-style', 0)->plaintext;
    $score = toNum($html->find('.rating-number', 0)->plaintext);
    $contestCount = toNum($html->find('.contest-participated-count', 0)->plaintext);
    $content = $html->find('.content', 0);
    $fs = toNum($content->find('h5', 0)->plaintext);
    $ps = toNum($content->find('h5', 1)->plaintext);
    return [
        // 'name' => $name,
        'score' => $score,
        // 'contestCount' => $contestCount,
        'solved' => $fs,
        // 'ps' => $ps,
    ];
}

function getgeeksforgeeksscore($html) {
    $rank = checkEmpty(toNum($html->find('span.rankNum', 0)->plaintext));
    $os = checkEmpty(toNum($html->find('span.score_card_value', 0)->plaintext));
    $ps = checkEmpty(toNum($html->find('span.score_card_value', 1)->plaintext));
    $ms = checkEmpty(toNum($html->find('span.score_card_value', 2)->plaintext));
    return [
        // 'rank' => $rank,
        'os' => $os,
        'ps' => $ps,
        // 'ms' => $ms,
    ];
}

function getspojscore($html) {
    $ps = $html->find('dd', 0)->plaintext;
    $ns = $html->find('dd', 1)->plaintext;
    return [
        'ps' => $ps,
        'ns' => $ns,
    ];
}

function getinterviewbitscore($html) {
    $name = $html->find('h3.name', 0)->plaintext;
    $r = toNum($html->find('.txt', 0)->plaintext);
    $s = toNum($html->find('.txt', 1)->plaintext);
    $st = toNum($html->find('.txt', 2)->plaintext);
    return [
        // 'name' => $name,
        'r' => $r,
        's' => $s,
        // 'st' => $st,
    ];
}
function getleetcodescore($username) {
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
    return [
        'score' => $ranking,
        'solved' => $count,
    ];
}

function getcodeforcesscore($html, $username) {
    $apiEndpoint = "https://codeforces.com/api/user.info?handles=" . $username;
    $response = file_get_contents($apiEndpoint);
    $data = json_decode($response, true);
    if ($data["status"] == "OK") {
        $user = $data["result"][0];
        $rank = $user["rank"];
        $rating = $user["rating"];
        $maxRank = $user["maxRank"];
        $maxRating = $user["maxRating"];
        $ps = toNum($html->find('._UserActivityFrame_counterValue', 0)->plaintext);
    } else {
        echo "Error: " . $data["comment"];
    }
    return [
        // 'rank' => $rank,
        // 'rating' => $rating,
        // 'maxRank' => $maxRank,
        'score' => $maxRating,
        'solved' => $ps,
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
// $username = "y7t7t";
// $website = 'spoj';
// $userinfo = getscore($username, $website);
// print_r($userinfo);
?>