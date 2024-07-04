<?php
include("connection.php");
include("scoreupdate.php");
error_reporting(0);
session_start();
if((!isset($_SESSION['loggedin'])) || ($_SESSION['loggedin'] != true)) {
    header("location:login.php");
    exit;
}
$user = $_SESSION['username'];
$select=$connect->prepare("SELECT * FROM scores_data WHERE username=?");
$select->bind_param("s", $user);
$select->execute();
$data=$select->get_result();
// $query="SELECT * FROM scores_data WHERE username='$user'";
// $data=mysqli_query($connect, $query);
$total=mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update_Profile</title>
</head>
<body>
    <h1>CODING PROFILE UPDTAE</h1>
    <h2>Enter user names</h2>
    <form action="coding_profile_update.php" method="POST">
        Codechef : <input type="text" name="cocname" placeholder="<?php echo $total['codechef']; ?>" ><br><br>
        CodeForces : <input type="text" name="cofname" placeholder="<?php echo $total['codeforces']; ?>" ><br><br>
        GeeksforGeeks : <input type="text" name="gfgname" placeholder="<?php echo $total['geeksforgeeks']; ?>" ><br><br>
        Leetcode : <input type="text" name="ltcname" placeholder="<?php echo $total['leetcode']; ?>" ><br><br>
        Spoj : <input type="text" name="spname" placeholder="<?php echo $total['spoj']; ?>"><br><br>
        InterviewBit : <input type="text" name="ib" placeholder="<?php echo $total['interviewbit']; ?>"><br><br>
        <input type="submit" name="update" value="update">
    </form>
</body>
</html>

<?php
$websites = [
    'cocname' => 'https://www.codechef.com/users/',
    'cofname' => 'https://codeforces.com/profile/',
    'ltcname' => 'https://leetcode.com/',
    'gfgname' => 'https://auth.geeksforgeeks.org/user/',
    'spname' => 'https://www.spoj.com/users/',
    'ib' => 'https://www.interviewbit.com/profile/',
];

$valid = array_fill_keys(array_keys($websites), 0);
// $atLeastOneInputFilled = false;
// foreach ($websites as $key => $website) {
//     if (isset($_POST[$key])) {
//         if($_POST[$key] !== ""){
//             $atLeastOneFieldFilled = true;
//             break;
//         }
//         if ($_POST[$key] == "-1") {
//             $valid[$key] = -1;
//         } elseif ($_POST[$key] == "" || isvalid($_POST[$key], $key)) {
//             $valid[$key] = 1;
//         }
//     }
// }
if (isset($_POST['update'])) {
    $atLeastOneInputFilled = false;
    foreach ($websites as $key => $website) {
        if (isset($_POST[$key])) {
            if ($_POST[$key] == "-1") {
                $valid[$key] = -1;
            } elseif ($_POST[$key] == "" || isvalid($_POST[$key], $key)) {
                $valid[$key] = 1;
            }
            if($_POST[$key] !== ""){
                $atLeastOneFieldFilled = true;
            }
        }
    }
    if (!$atLeastOneFieldFilled) {
        echo "Please fill atleast one field";
    }
    else
        if (!in_array(0, $valid, true)) {
            $cocname = $_POST['cocname'];
            $cofname = $_POST['cofname'];
            $gfgname = $_POST['gfgname'];
            $ltcname = $_POST['ltcname'];
            $spname = $_POST['spname'];
            $ibname = $_POST['ib'];
            
            $scores = getallcodingprofilesscores([
                'codechef' => $cocname,
                'codeforces' => $cofname,
                'leetcode'=> $ltcname,
                'interviewbit'=> $ibname,
                'spoj'=> $spname,
                'geeksforgeeks'=> $gfgname,
            ]);
            $query1=$connect->prepare("UPDATE scores_data SET 
                codechef=?, codeforces=?, geeksforgeeks=?, leetcode=?, spoj=?, interviewbit=?,
                c_score=?, c_cc=?, c_fs=?, c_ps=?, cf_rank=?, cf_rating=?, cf_solved=?, l_score=?, l_solved=?, i_name=?, i_r=?, i_s=?, i_st=?, s_ps=?, s_ns=?, g_rank=?, g_os=?, g_ps=?, g_ms=?
                WHERE username=?");
            $query1->bind_param("ssssssiiiiiiiiisiiiiiiiiisssssss", $cocname, $cofname, $gfgname, $ltcname, $spname, $ibname, $scores['codechef']['score'], $scores['codechef']['cc'], $scores['codechef']['fs'], $scores['codechef']['ps'], $scores['codeforces']['rank'], $scores['codeforces']['rating'], $scores['codeforces']['solved'], $scores['leetcode']['score'], $scores['leetcode']['solved'], $scores['interviewbit']['name'], $scores['interviewbit']['r'], $scores['interviewbit']['s'], $scores['interviewbit']['st'], $scores['spoj']['ps'], $scores['spoj']['ns'], $scores['geeksforgeeks']['rank'], $scores['geeksforgeeks']['os'], $scores['geeksforgeeks']['ps'], $scores['geeksforgeeks']['ms'], $user);
            $query1->execute();
            $query1->close();
            $cc=$connect->prepare("UPDATE codechef SET codechef_handle=?,stars=?,score=?,contests=?,p_problems=?,c_problems=? WHERE username=?");
            $cc->bind_param("ssssssss",$cocname, $score['codechef']['stars'], $scores['codechef']['score'], $scores['codechef']['cc'], $scores['codechef']['ps'], $scores['codechef']['fs'], $user);
            $cc->execute();
            $cc->close();
            $cf=$connect->prepare("UPDATE codeforces SET codeforces=?,rating=?,maxrating=?,problems=?,rank=?,maxrank=? WHERE username=?");
            $cf->bind_param("ssiiiiis", $cofname, $scores['codeforces']['rating'], $scores['codeforces']['maxRating'], $scores['codeforces']['solved'], $scores['codeforces']['$rank'],$scores['codeforces']['maxRank'], $user);
            $cf->execute();
            $cf->close();
            $lt=$connect->prepare("UPDATE leetcode SET leetcode=?,rank=?,problems solved=? WHERE username=?");
            $lt->bind_param("ssss", $ltcname, $scores['leetcode']['score'], $scores['leetcode']['solved'], $user);
            $lt->execute();
            $lt->close();
            $ib=$connect->prepare("UPDATE interviewbit SET ib=?,rank=?,score=?,streak=? WHERE username=?");
            $ib->bind_param("sssss", $ibname, $scores['interviewbit']['r'], $scores['interviewbit']['s'], $scores['interviewbit']['st'], $user);
            $query2 = "UPDATE specialscores SET 
                codechef='" . $scores['specialScores']['codechef'] . "',
                cf='" . $scores['specialScores']['codeforces'] . "',
                leetcode='" . $scores['specialScores']['leetcode'] . "',
                ib='" . $scores['specialScores']['interviewbit'] . "',
                spoj='" . $scores['specialScores']['spoj'] . "',
                gfg='" . $scores['specialScores']['geeksforgeeks'] . "',
                total='" . (0.4 * $scores['specialScores']['codechef'])+ (0.3 * $scores['specialScores']['leetcode'])+ (0.2 * $scores['specialScores']['codeforces'])+ (0.05 * $scores['specialScores']['interviewbit'])+ (0.03 * $scores['specialScores']['geeksforgeeks'])+ (0.02 * $scores['specialScores']['spoj']) . "'
                WHERE username='$user'";
            $data1 = mysqli_query($connect, $query1);
            $data2 = mysqli_query($connect, $query2);
            if ($data1 && $data2) {
                echo "Updated successfully";
            } else {
                echo "Failed to Update: " . mysqli_error($connect);
            }
    
        } else {
            $profile = array(
                'cocname' => 'Codechef',
                'cofname' => 'Codeforces',
                'ltcname' => 'Leetcode',
                'gfgname' => 'Geeksforgeeks',
                'spname' => 'Spoj',
                'ib' => 'Interviewbit',        
            );
            $invalidKeys = array_keys($valid, 0, true);
            $invalidProfiles = array_intersect_key($profile, array_flip($invalidKeys));
            echo "Accounts not found for: " . implode(", ", $invalidProfiles);    }
    }
function isvalid($username, $websiteKey) {
    global $websites;
    $url = $websites[$websiteKey] . $username . '/';
    if ($websiteKey === 'spname') {
        return validspoj($url);
    } else {
        $headers = @get_headers($url);
        return ($headers && strpos($headers[0], '200') !== false);
    }
}
?>
