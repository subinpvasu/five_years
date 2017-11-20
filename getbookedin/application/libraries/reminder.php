<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

// Google API PHP Client is necessary to perform sync operations.
require_once __DIR__ . '/external/twilio/Services/Twilio.php';

class reminder{
    public $account;
    public $auth;
    public $service;


    public function __construct() {
        $this->account = 'AC4748e8596aa315dc8c8d3975731e0d30';
        $this->auth = '29f15f3a008dd72e382ffbd33180566c';
        $this->service = new Services_Twilio($this->account, $this->auth);
    }
    
    public function send_sms($to,$body)
    {
        $message = $this->service->account->messages->create(array(
    "From" => "+12105987617", // From a valid Twilio number
//    "To" => "+919495546474",   // Text this number
    "To" => $to,   // Text this number
//    "Body" => "Hello from Subin latest",
    "Body" => $body,
));

// Display a confirmation message on the screen
echo "Sent message {$message->sid}";
//echo "Sent message";
    }
}
