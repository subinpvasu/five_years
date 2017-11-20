<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require "./Services/Twilio.php";

$AccountSid = "AC4748e8596aa315dc8c8d3975731e0d30"; // Your Account SID from www.twilio.com/console
$AuthToken = "29f15f3a008dd72e382ffbd33180566c";   // Your Auth Token from www.twilio.com/console

$client = new Services_Twilio($AccountSid, $AuthToken);

$message = $client->account->messages->create(array(
    "From" => "+12105987617", // From a valid Twilio number
    "To" => "+919495546474",   // Text this number
    "Body" => "Hello from Subin",
));

// Display a confirmation message on the screen
echo "Sent message {$message->sid}";