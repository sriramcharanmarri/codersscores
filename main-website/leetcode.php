<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Leetcode | CodersScores</title>
        <link rel="icon" type="image/png" sizes="1563x1563" href="assets/img/cs-favicon.png?h=808b0f007c19a2dde5ee50bf3d3a0cca">
        <link rel="icon" type="image/png" sizes="1563x1563" href="assets/img/cs-favicon.png?h=808b0f007c19a2dde5ee50bf3d3a0cca">
        <link rel="icon" type="image/png" sizes="1563x1563" href="assets/img/cs-favicon.png?h=808b0f007c19a2dde5ee50bf3d3a0cca">
        <link rel="icon" type="image/png" sizes="1563x1563" href="assets/img/cs-favicon.png?h=808b0f007c19a2dde5ee50bf3d3a0cca">
        <link rel="icon" type="image/png" sizes="1563x1563" href="assets/img/cs-favicon.png?h=808b0f007c19a2dde5ee50bf3d3a0cca">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css?h=97fdfa31c346c923d830c27d591ac4aa">
        <link rel="manifest" href="manifest.json?h=65ac0ca7879eade2ccd98a06259e3483">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
        <link rel="stylesheet" href="assets/css/styles.min.css?h=9020295c5354ebe5ae06800eb847dfe4">
    </head>
    <body>
         <!-- Start: Navbar Centered Links --><nav class="navbar navbar-expand-md navbar-shrink py-3 navbar-light" id="mainNav" style="margin-bottom: -29px;padding-bottom: 14px;"><div class="container"><a href="index.html"><img data-aos="fade-down" data-aos-duration="600" width="126" height="62" src="assets/img/cs-logo.svg?h=a10ffaa555c1ef7d4fe9aeeb5242cf7a" class="ps-xl-0"></a><a class="navbar-brand d-flex align-items-center" href="/"></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse" id="navcol-1"><ul class="navbar-nav mx-auto"><li class="nav-item"><a class="nav-link active" data-aos="fade-down" data-aos-duration="600" data-aos-once="true" href="#Home"><strong>Home</strong></a></li><li class="nav-item"><a class="nav-link active" data-aos="fade-down" data-aos-duration="600" data-aos-delay="50" data-aos-once="true" href="#about"><strong>About</strong></a></li><li class="nav-item"><a class="nav-link active" data-aos="fade-down" data-aos-duration="600" data-aos-delay="100" data-aos-once="true" href="#trynow"><strong>Try now</strong></a></li><li class="nav-item"></li><li class="nav-item"><a class="nav-link active" data-aos="fade-down" data-aos-duration="600" data-aos-delay="150" data-aos-once="true" href="#team"><strong>Team</strong></a></li></ul><a class="btn btn-primary shadow" role="button" data-aos="fade-down" data-aos-duration="600" data-aos-delay="200" data-aos-once="true" href="login.html" style="margin-right: 2px;">Login</a></div></div></nav><!-- End: Navbar Centered Links -->
    <!-- Start: Login Form -->
    <section class="py-4 py-md-5 my-5" style="margin-bottom: 52px;padding-bottom: 94px;">
    <div class="container py-md-5">
        <div class="row">
            <div class="col-md-6 text-center">
                <img class="img-fluid w-100" src="assets/img/LeetCode.svg" width="476" height="248" style="padding-bottom: 0px;margin-bottom: 0px;padding-top: 0px;margin-top: 36px;">
            </div>
            <div class="col-md-5 col-xl-4 text-center text-md-start">
                <h2 class="display-6 fw-bold mb-5"></h2>
                <form method="post" data-bs-theme="light">
                    <div class="mb-3">
                    <input class="form-control" type="text" name="uname" placeholder="Leetcode user name" required="">
                </div>
                <div class="mb-5">
                    <button class="btn btn-primary shadow" type="submit">Track</button>
                </div>
            </form>
            <!-- <p>Paragraph</p> -->
        </div></div></div></section><footer class="text-center"></footer><!-- End: Footer Basic -->
<?php
error_reporting(0);
if (isset($_POST["uname"])){
    $username = $_POST["uname"];
    // echo "<center><h1>$username</h1></center>";
    $url='https://leetcode.com/u/'.$username.'/';
    $headers = @get_headers($url);
    if ($headers && strpos($headers[0], '200') == false) {
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
    echo '<div class="container"><h4 style="text-align:center;">Hey! <b>'.$username.'</b></h4>
    <div class="table-responsive text-center text-sm-center text-md-center text-lg-center text-xl-center text-xxl-center shadow-lg">
    <table class="table table-hover">
    <thead>
            <tr>
                <th scope="col">Details</th>
                <th scope="col">Values</th>
            </tr>
    </thead>
        <tbody>
            <tr><td>Rank</td><td>'.$ranking.'</td></tr>
            <tr><td>Problems Solved</td><td>'.$count.'</td></tr>
        </tbody>
    </table>
</div></div>';
    } 
    else {
    echo '<div class="container">
    <h4 style="text-align:center;">Invalid user name  <b><del>'.$username.'</del></b></h4>
    </div>';
    }
}
function toNum($str) {
    return preg_replace('/[^0-9]/', '', $str);
}
function checkEmpty($str) {
    if (empty($str)) {
        return "0";
    }
    return $str;
}
?>
<!-- Start: Footer Basic --><footer class="text-center"><div class="container py-4 py-lg-5"><p class="text-bg-dark mb-0">Copyright © 2023 coders scores</p></div></footer><!-- End: Footer Basic --><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script><script src="assets/js/script.min.js?h=e2e934151fcc02da274eaadcd4e2503d"></script>
</body>
</html>