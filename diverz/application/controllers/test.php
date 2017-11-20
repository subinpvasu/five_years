<?php
/**
 * @author       Asim Zeeshan
 * @web         http://www.asim.pk/
 * @date     13th May, 2009
 * @copyright    No Copyrights, but please link back in any way
 */

class Test extends CI_Controller {
    public function __construct() {
        parent::__construct ();
        $this->load->model ( 'customer_model' );
        $this->load->library ( 'session' );
        date_default_timezone_set('US/Pacific');

    }

     function index()
     {
           $this->load->library ( 'email' );
    $this->load->helper ( 'html' );
    $this->load->helper ( 'url' );
    $config = array(
        'mailtype'  => 'html',
        'charset'   => 'utf-8'
    );
    $this->email->initialize($config);
    $this->email->clear();
    $this->email->clear(true);



    $this->email->from ( 'info@btwdive.com', 'BTWDive Diver' );
    $this->email->reply_to('info@btwdive.com','Ian Roberts');


    $message = '<p style="text-align:justify">This is a friendly reminder that your Outstanding Balance of  is now 6 weeks past due.</b><br/>
        As a small business it’s difficult for us to carry balances and spend time collecting.
        Please remember your payment is due on receipt of the invoice.
        We have, in good faith, serviced your boat again, without payment for the prior service, but cannot further extend anymore work.
        Please reply with your payment intentions to <b>info@btwdive.com</b>.
There is a credit card PayPal link on our website http://btwdive.com/online-pay.html - <b>(No PayPal account necessary.)</b><br/>
We also accept major credit cards over the phone, if needed; we can keep the card info on file and bill monthly to avoid any disruptions.

</p>';

    $message .= '<br/>';

    $message = $message . "We appreciate your business<br/>";
    $message = $message . "Ian Roberts<br/>";
    $message = $message . "310.918.5631";


        $this->email->to ('subinpvasu@gmail.com');

    $this->email->bcc ( 'subinpvasuatyahoo.com@gmail.com' );


    $this->email->subject ( 'Payment Due Notification-index');



    $this->email->message ( $message );

    $this->email->send();
    echo '0';
     }

     function test() {
          $this->load->library ( 'email' );
    $this->load->helper ( 'html' );
    $this->load->helper ( 'url' );
    $config = array(
        'mailtype'  => 'html',
        'charset'   => 'utf-8'
    );
    $this->email->initialize($config);
    $this->email->clear();
    $this->email->clear(true);



    $this->email->from ( 'info@btwdive.com', 'BTWDive Diver' );
    $this->email->reply_to('info@btwdive.com','Ian Roberts');


    $message = '<p style="text-align:justify">This is a friendly reminder that your Outstanding Balance of  is now 6 weeks past due.</b><br/>
        As a small business it’s difficult for us to carry balances and spend time collecting.
        Please remember your payment is due on receipt of the invoice.
        We have, in good faith, serviced your boat again, without payment for the prior service, but cannot further extend anymore work.
        Please reply with your payment intentions to <b>info@btwdive.com</b>.
There is a credit card PayPal link on our website http://btwdive.com/online-pay.html - <b>(No PayPal account necessary.)</b><br/>
We also accept major credit cards over the phone, if needed; we can keep the card info on file and bill monthly to avoid any disruptions.

</p>';

    $message .= '<br/>';

    $message = $message . "We appreciate your business<br/>";
    $message = $message . "Ian Roberts<br/>";
    $message = $message . "310.918.5631";


        $this->email->to ('subinpvasu@gmail.com');

    $this->email->bcc ( 'subinpvasuatyahoo.com@gmail.com' );


    $this->email->subject ( 'Payment Due Notification-test');



    $this->email->message ( $message );

    $this->email->send();
    echo '1';
     }

}