<?php
$clientId = '000000004C14EC82';
$clientSecret = 'FISWN5fY3xRM91KVCAcg4U5WDlxFt30X';

$redirectUriPath = "http://vbridge.co.uk/dev/bingAuth/oauth2callback.php";    // This is the url that the client browser will be redirected to after authentication
$getDataRedirectUriPath = "get_data.php"; // this is the page in your application that will access client-owned data

// bing ads user name
$username = "vbridgellp";
// bing ads password
$password = "vbridge123";
// developer token to access bing ads
$developerToken = "0071M925I6679867";

// refresh token
$refreshToken = trim(file_get_contents("RefreshToken.txt"));

// Authentication Token
$authenticationToken = trim(file_get_contents("AuthenticationToken.txt"));

$customerId = 8008098;

$applicationToken = "";

$accountId = 1118271;