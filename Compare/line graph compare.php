<?php
header('Content-Type: text/html; charset=UTF-8');
include("final.php");
error_reporting(0);
$li1 = json_encode([]);
$li2 = json_encode([]);

if (isset($_POST["user1"]) && isset($_POST["user2"])) {
    $u1 = $_POST["user1"];
    $u2 = $_POST["user2"];
    $con = mysqli_connect("localhost", "root", "", "test-1");
    if ($con) {
        $q1 = "select * from specialscores where username='$u1';";
        $q2 = "select * from specialscores where username='$u2';";
        $r1 = mysqli_query($con, $q1);
        $r2 = mysqli_query($con, $q2);
        if ($r1) {
            while ($row = mysqli_fetch_assoc($r1)) {
                $cc1 = $row['codechef'];
                $cf1 = $row['cf'];
                $lc1 = $row['leetcode'];
                $gg1=$row['gfg'];
                $sp1=$row['spoj'];
                $ib1=$row['ib'];
                $total1=$row['total'];
            }
        }
        if ($r2) {
            while ($row = mysqli_fetch_assoc($r2)) {
                $cc2 = $row['codechef'];
                $cf2 = $row['cf'];
                $lc2 = $row['leetcode'];
                $gg2=$row['gfg'];
                $sp2=$row['spoj'];
                $ib2=$row['ib'];
                $total2=$row['total'];
            }
        }

        $l1 = array($u1,$cc1, $cf1, $lc1, $gg1, $sp1, $ib1, $total1);
        $li1 = json_encode($l1);

        $l2 = array($u2,$cc2, $cf2, $lc2, $gg2, $sp2, $ib2, $total2);
        $li2 = json_encode($l2);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodersScores | Compare</title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }
    </style>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", { packages: ["bar"] });
        function drawChart() {
            var ar1 = <?php echo $li1; ?>;
            var ar2 = <?php echo $li2; ?>;
            console.log(ar1);
            console.log(ar2);
            // $l1 = array($u1,$cc1, $cf1, $lc1, $gg1, $sp1, $ib1, $total1);
            var data = google.visualization.arrayToDataTable([
                ["Performance", ar1[0], ar2[0]],
                ["CodeChef", ar1[1], ar2[1]],
                ["CodeForces", ar1[2], ar2[2]],
                ["LeetCode", ar1[3], ar2[3]],
                ["GeeksForGeeks ", ar1[4], ar2[4]],
                ["Spoj ", ar1[5], ar2[5]],
                ["InterviewBit", ar1[6], ar2[6]],
            ]);
            
            var options = {
                chart: {
                    title: ar1[0] + " vs " + ar2[0],
                    subtitle: "If there's a battle between 2 Coders, definitely Coder will Win",
                },
            };

            var chart = new google.charts.Bar(
                document.getElementById("columnchart_material")
            );

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>
</head>
<body>
    <form method="post">
        <label for="user1">Username 1 :</label>
        <input type="text" name="user1" id="u1"> <br>
        <label for="user2">Username 2 :</label>
        <input type="text" name="user2" id="u2"> <br>
        <button type="submit">Fetch</button>
    </form>
    <button onclick="drawChart()">Compare</button>
    <div id="columnchart_material" style="width: device-width; height: 500px"></div>
</body>
</html>
