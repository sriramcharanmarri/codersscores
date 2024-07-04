<?php
header('Content-Type: text/html; charset=UTF-8');
include("final.php");
error_reporting(0);
$li1 = json_encode([]);
$li2 = json_encode([]);

if (isset($_POST["user1"]) && isset($_POST["user2"])) {
    $u1 = $_POST["user1"];
    $u2 = $_POST["user2"];
    $con = mysqli_connect("localhost", "root", "", "coderscore_udata");
    if ($con) {
        $q1 = "select * from scores_data where username='$u1';";
        $q2 = "select * from scores_data where username='$u2';";
        $r1 = mysqli_query($con, $q1);
        $r2 = mysqli_query($con, $q2);
        if ($r1) {
            while ($row = mysqli_fetch_assoc($r1)) {
                $cc1 = $row['codechef'];
                $cf1 = $row['codeforces'];
                $lc1 = $row['leetcode'];
                $ib1 = $row['interviewbit'];
                $sp1=$row['spoj'];
                $gfg1=$row['geeksforgeeks'];
            }
        }
        if ($r2) {
            while ($row = mysqli_fetch_assoc($r2)) {
                $cc2 = $row['codechef'];
                $cf2 = $row['codeforces'];
                $lc2 = $row['leetcode'];
            }
        }
        $l1 = array($u1, getscore($cc1, 'codechef'), getscore($cf1, 'codeforces'), getscore($lc1, 'leetcode'));
        $li1 = json_encode($l1);

        $l2 = array($u2, getscore($cc2, 'codechef'), getscore($cf2, 'codeforces'), getscore($lc2, 'leetcode'));
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
            var ar1= <?php echo $li1; ?>;
            var ar2=<?php echo $li2; ?>;
            // var ar1 = ["user1",13,14];
            // var ar2 = ["user2",{score:13,solved:14}]};
            console.log(ar1);
            console.log(ar2);
            var data = google.visualization.arrayToDataTable([
                ["Performance", ar1[0], ar2[0]],
                ["CodeChef (Rating)", ar1[1]['score'], ar2[1]['score']],
                ["CodeChef (Problems Solved)", ar1[1]['solved'], ar2[1]['solved']],
                ["CodeForces (Rating)", ar1[2]['score'], ar2[2]['score']],
                ["CodeForces (Problems Solved)", ar1[2]['solved'], ar2[2]['solved']],
                ["LeetCode (Rating)", ar1[3]['score'], ar2[3]['score']],
                ["LeetCode (Problems Solved)", ar1[3]['solved'], ar2[3]['solved']],
            ]);
            var options = {
                chart: {
                    title: ar1[0] + " vs " + ar2[0],
                    // subtitle: 'In past wars were held b/w countries, but now its b/w Coders',
                    subtitle:
                        "If there's a battle between 2 Coders, definitely Coder will Win",
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