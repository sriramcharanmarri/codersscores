<?php
// Set the time zone to India Standard Time (IST)
date_default_timezone_set('Asia/Kolkata');

$hosts = ["leetcode.com", "codechef.com", "spoj.com", "geeksforgeeks.org", "codeforces.com"];

function getcontest($host) {
    $apiUrl = "https://clist.by/api/v3/contest/?username=coderscores&api_key=89b5e06a6415ea725451594aa386d766c1c4189c&limit=3&total_count=true&with_problems=false&format_time=true&upcoming=true&host=" . $host . "&order_by=start";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
    } else {
        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "API Response Error: " . json_last_error_msg() . PHP_EOL;
            echo "API Response: " . $response . PHP_EOL;
        } else {
            echo "<h1>Host: " . $host . "</h1><br>";

            foreach ($data['objects'] as $contestData) {
                // Modify the date format
                $contestStartTime = DateTime::createFromFormat('d.m D H:i', $contestData['start']);
                $contestEndTime = DateTime::createFromFormat('d.m D H:i', $contestData['end']);
                $currentTime = new DateTime();

                // Set time zone for start and end times
                $contestStartTime->setTimezone(new DateTimeZone('Asia/Kolkata'));
                $contestEndTime->setTimezone(new DateTimeZone('Asia/Kolkata'));

                echo "Contest Name: " . $contestData['event'] . "<br>";
                echo "URL: <a href=" . $contestData['href'] . ">Contest Link</a><br>";

                if ($currentTime < $contestStartTime) {
                    $interval = $currentTime->diff($contestStartTime);
                    $timeLeft = $interval->format('%a days %H hours %i minutes %s seconds');
                    echo "The contest will start in $timeLeft.<br>";
                } else if ($currentTime >= $contestStartTime && $currentTime <= $contestEndTime) {
                    echo "Status: Live<br>";
                } else {
                    echo "Status: Ended<br>";
                }

                echo "Start Time (IST): " . $contestStartTime->format('d.m D H:i') . "<br>";
                echo "End Time (IST): " . $contestEndTime->format('d.m D H:i') . "<br>";
                echo "Duration: " . $contestData['duration'] . "<br>";
                echo "<br>";
            }
        }
    }

    curl_close($ch);
}

foreach ($hosts as $host) {
    getcontest($host);
    echo "<hr>";
}
?>
