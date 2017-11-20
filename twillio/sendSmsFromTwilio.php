<?php
require "Services/Twilio.php";

//Messaging
$account_sid = 'AC87241ecf0624548b0a9ec23596f388e5';
$auth_token = 'cf7282b3380e6ad49c15af41b8ab18a5';
$client = new Services_Twilio($account_sid, $auth_token);

$client->account->messages->create(array(
    'To' => "9495546474",
    'From' => "+18452622254",
    'Body' => "Hi Test",
));
