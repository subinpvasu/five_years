<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Twilio extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}
        function sent_message()
        {
            $this->load->library('reminder');
            $msg = new reminder();
            $msg->send_sms('+919495546474','welcome to ooty');
        }
        function send_notifications()
        {
            $this->load->model('appointments_model');
            $this->load->model('user_model');
            $seventh_day = strtotime('+7 day', strtotime(date('y-m-d')));
            $tomorrow = strtotime('+1 day', strtotime(date('y-m-d')));
            //send 7 days and tomorrow
            
            $data['seven'] = $this->appointments_model->select_appointments_notification($seventh_day);
            $data['tomorrow'] = $this->appointments_model->select_appointments_notification($tomorrow);
            
            foreach ($data['seven'] as $seven)
            {
                //check user contact mode
                $data['user'] = $this->user_model->get_user_data($seven->id_users_customer);
                switch ($data['user'][0]->contact_mode)
                {
                    case 'SMS':sent_notification_sms($user);break;
                    case 'Email':sent_notification_email($user);break;
                    default:break;
                }
                
            }
            foreach ($data['tomorrow'] as $tomorrow)
            {
                //check user contact mode
                $data['user'] = $this->user_model->get_user_data($tomorrow->id_users_customer);
                switch ($data['user'][0]->contact_mode)
                {
                    case 'SMS':sent_notification_sms($user);break;
                    case 'Email':sent_notification_email($user);break;
                    default:break;
                }
                
            }
            
            
                    
            
            
        }
        
        public function sent_notification_email($user)
        {
            
        $this->load->model('appointments_model');
        $this->load->library('email');
        $this->load->helper('html');
        $this->load->helper('url');
        $config = array(
            'mailtype' => 'html',
            'charset' => 'utf-8'
        );
        
        $data['appointment'] = $this->appointments_model->get_row($userid);
        
        
        $this->email->initialize($config);
        $this->email->clear();
        $this->email->clear(true);
        $message = 'you have got an appointment on ';
        $this->email->from('info@btwdivedb.com', 'info@btwdive.com');
        $this->email->reply_to('info@btwdive.com', 'Ian Roberts');
        $this->email->to('subinpvasu@gmail.com');
        $this->email->subject('live test mail '); // remove live test
        $this->email->message($message);
        $this->email->send();
            
        }
        
        
        
        public function sent_notification_sms($user)
        {
            $this->load->model('appointments_model');
            $this->load->library('reminder');
            $data['appointment'] = $this->appointments_model->get_row($userid);
            $msg = new reminder();
            $msg->send_sms('+919495546474','welcome to ooty');
        }
       

}