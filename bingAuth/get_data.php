<?php
// session_start();

// // The BingAds OAuth access token will be in session data. This is the token used
// // to access BingAds data on behalf of the customer.
// $accessToken = $_SESSION['access_token'];

// printf("Implement code to retrieve data with access token: %s", $accessToken);

// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";

session_start();

// The BingAds OAuth access token will be in session data. This is the token used
// to access BingAds data on behalf of the customer.
$accessToken = $_SESSION['access_token'];

printf("Implement code to retrieve data with access token: %s", $accessToken);


file_put_contents('AuthenticationToken.txt',$_SESSION['access_token']);
file_put_contents('RefreshToken.txt',$_SESSION['refresh_token']);

echo "<pre>";
print_r($_SESSION);
echo "</pre>";