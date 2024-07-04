<?php
include('connection.php');
include('scoreupdate.php');
error_reporting(0);
//collecting data from database
    $query = "SELECT username,codechef,codeforces,geeksforgeeks,leetcode,spoj,interviewbit FROM scores_data;";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
    $usernames = [
        'codechef' => $row['codechef'],
        'codeforces' => $row['codeforces'],
        'leetcode'=> $row['leetcode'],
        'interviewbit'=> $row['interviewbit'],
        'spoj'=> $row['spoj'],
        'geeksforgeeks'=> $row['geeksforgeeks'],
    ];
    // Step 2: Calculate Scores using the function
    $scores = getallcodingprofilesscores($usernames);
    //Step 3: Update Database
    $update_query = "UPDATE scores_data SET 
        c_score = '" . $scores['codechef']['score'] . "',
        c_cc = '" . $scores['codechef']['cc'] . "',
        c_fs= '" . $scores['codechef']['fs'] . "',
        c_ps= '" . $scores['codechef']['ps'] . "',
        cf_rank= '" . $scores['codeforces']['rank'] . "',
        cf_rating = '" . $scores['codeforces']['rating'] . "',
        cf_solved = '" . $scores['codeforces']['solved'] . "',
        l_score= '" . $scores['leetcode']['score'] . "',
        l_solved= '" . $scores['leetcode']['solved'] . "',
        i_name='" . $scores['interviewbit']['name'] . "',
        i_r='" . $scores['interviewbit']['r'] . "',
        i_s='" . $scores['interviewbit']['s'] . "',
        i_st ='". $scores['interviewbit']['st'] . "',
        s_ps='" . $scores['spoj']['ps'] . "',
        s_ns='" . $scores['spoj']['ns'] . "',
        g_rank ='". $scores['geeksforgeeks']['rank'] . "',
        g_os='" . $scores['geeksforgeeks']['os'] . "',
        g_ps='" . $scores['geeksforgeeks']['ps'] . "',
        g_ms='" . $scores['geeksforgeeks']['ms'] . "'
        WHERE username = '" . $row['username'] . "'";
    $query2 = "UPDATE specialscores SET 
        codechef='" . $scores['specialScores']['codechef'] . "',
        cf='" . $scores['specialScores']['codeforces'] . "',
        leetcode='" . $scores['specialScores']['leetcode'] . "',
        ib='" . $scores['specialScores']['interviewbit'] . "',
        spoj='" . $scores['specialScores']['spoj'] . "',
        gfg='" . $scores['specialScores']['geeksforgeeks'] . "',
        total='" . (0.4 * $scores['specialScores']['codechef'])+ (0.3 * $scores['specialScores']['leetcode'])+ (0.2 * $scores['specialScores']['codeforces'])+ (0.05 * $scores['specialScores']['interviewbit'])+ (0.03 * $scores['specialScores']['geeksforgeeks'])+ (0.02 * $scores['specialScores']['spoj']) . "'
        WHERE username='" . $row['username'] . "'";
    mysqli_query($conn, $update_query);
    mysqli_query($conn, $query2);
    echo "Updated " . $row['username'] . "<br>";
}
?>
