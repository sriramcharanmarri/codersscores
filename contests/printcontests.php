<?php
error_reporting(0);
echo "<style>
        .logo-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
        }
    </style>";
const LOGOS = [
    'codechef.com' => "https://s3.amazonaws.com/codechef_shared/sites/all/themes/abessive/logo.png",
    'codeforces.com'=>"https://sta.codeforces.com/s/52845/images/codeforces-logo-with-telegram.png",
    'getgeeksforgeeks.org'=>"https://media.geeksforgeeks.org/wp-content/cdn-uploads/gfg_200X200.png",
    'leetcode.com'=>"https://leetcode.com/static/images/LeetCode_logo.png",
    'spoj.com'=>"https://www.spoj.com/gfx/spoj.gif"
];    
$servername = "localhost";
$username = "root";
$password = "";
$database = "coderscore_udata";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to retrieve all data from the 'contests' table
$sql = "SELECT * FROM contests";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Contest Data</h1>";
    echo "<table>
    <tr>
    <th>ICON</th>
    <th>Host</th>
    <th>Contest Name</th>
    <th>URL</th>
    <th>Start Time (IST)</th>
    <th>End Time (IST)</th>
    <th>Duration</th>
    </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><div class='logo-circle' style='background-image: url(" . LOGOS[$row["host"]] . ")'></div></td>";
        echo "<td>" . $row["host"] . "</td>";
        echo "<td>" . $row["contest_name"] . "</td>";
        echo "<td><a href='" . $row["url"] . "'>Contest Link</a></td>";
        echo "<td>" . $row["start_time"] . "</td>";
        echo "<td>" . $row["end_time"] . "</td>";
        echo "<td>" . $row["duration"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No contest data found.";
}

// Close the database connection
$conn->close();
?>
