<?php
session_start();

// The BingAds OAuth access token will be in session data. This is the token used
// to access BingAds data on behalf of the customer.
$accessToken = $_SESSION['access_token'];

printf("Implement code to retrieve data with access token: %s", $accessToken);

echo '----------------------------------------------------------------------<br/>';
print_r($_SESSION);
