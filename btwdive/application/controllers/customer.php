<?php

/*
 * The page works as the main controller of the project
 * all control flow comes to here and results are sent from here.
 * new task updates on 15/02/2016
 *
 */
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer extends CI_Controller
{
    /*
     * controller contructor initializes here....
     * session also starts here
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_model');
        $this->load->library('session');
        date_default_timezone_set('US/Pacific');
    }
    
    /*
     * there is a conversion between us date format and db date format .
     * here the db format date is converted to us date format
     */
    public function date_format_us($date)
    {
        return $newDate = date("m/d/Y", strtotime($date));
    }
    /*
     * us format date is revert back to db format.
     */
    function date_format_db($date)
    {
        return $newDate = date("Y-m-d", strtotime($date));
    }
    /*
     * index page controller.
     * index page starts from here with the index.php view.
     */
    public function index()
    {
        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->library('form_validation');
        
        $this->customer_model->set_database_auto_session();
        
        $data['errormsg'] = '';
        if ($this->session->userdata('administrator') == 'admin' || $this->session->userdata('administrator') == 'diver') {
            $this->load->view('templates/header');
            $this->load->view('customer/index');
        } else {
            $this->load->view('templates/header');
            $this->load->view('customer/subindex');
        }
        
        // $this->sub_index();
    }

    public function letThemLog()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if ($this->customer_model->set_privilege_session($username, $password)) {
            switch ($this->session->userdata('administrator')) {
                case 'admin':
                    
                    $this->session->set_userdata('logger', 'admin');
                    echo '1';
                    break;
                case 'diver':
                    $this->session->set_userdata('logger', 'diver');
                    echo '1';
                    break;
                default:
                    echo '0';
                    break;
            }
        }
    }

    public function sub_index()
    {
        $this->load->helper('url');
        $this->load->helper('html');
        if ($this->session->userdata('administrator') == 'admin' || $this->session->userdata('administrator') == 'diver') {
            
            $this->load->view('templates/header');
            $this->load->view('customer/index');
        } else {
            $this->load->view('templates/header');
            $this->load->view('customer/subindex');
        }
    }
    
    /*
     * HOME->CUSTOMER->NEW CUSTOMER->CUSTOMER
     * HOME->CUSTOMER->MODIFY CUSTOMER->CUSTOMER
     *
     * Where is a form for entering the customer details to the system with the necessary fields.
     * if the $customer is null then the user is fresh else the user is already registered.
     * so the function works as per the customer value.
     */
    public function customer_registration($customers = NULL)
    {
        if (! is_null($customers) && ! is_numeric($customers)) {
            show_404();
        }
        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->library('form_validation');
        
        $this->session->set_userdata('dbms', false);
        
        if (! is_null($customers)) {
            $data['customer'] = $this->customer_model->get_customer_registration_details($customers);
            if ($this->session->userdata('modify') && $this->session->userdata('customerid') != $customers) {
                echo '<script>
        alert("It is unable to process more than ONE Profile at a time.Please EXIT all other opened profiles to continue.");
        this.window.close();

        </script>';
                // redirect ( '/customer/customer_registration/' . $this->session->userdata ( 'customerid' ), 'refresh' );
            } else {
				$this->session->set_userdata('modify', true);
                $this->session->set_userdata('dbms', true);
                $this->session->set_userdata('customerid', $customers);
                $this->session->set_userdata('customer_number', $customers);
                $this->session->set_userdata('vessel_number', $data['customer'][0]->PK_VESSEL);
                $this->session->set_userdata('customer', $data['customer'][0]->FIRST_NAME . "&nbsp;" . $data['customer'][0]->LAST_NAME);
                $this->session->set_userdata('ves_vessel_name', $data['customer'][0]->VESSEL_NAME);
                $this->session->set_userdata('status', $data['customer'][0]->STATUS);
                $this->session->set_userdata('statusdb', $data['customer'][0]->STATUS);
                $this->session->set_userdata('statuswb', $data['customer'][0]->STATUS);
                $this->session->set_userdata('return', false);
                $this->session->set_userdata('return_status', false);
            }
        } else {
            if ($this->session->userdata('customer_master') != 'wait') {
                $data['account'] = $this->customer_model->get_customer_account_number();
                $customer_number = $data['account'][0]->PK_CUSTOMER;
                $customer_number ++;
                $this->session->set_userdata('customer_number', $customer_number);
                $this->session->set_userdata('brandnew', true);
            } else {
                $data['account'] = $this->customer_model->get_customer_account_number();
                $this->session->set_userdata('brandnew', true);
            }
        }
        if (($this->input->post('submit')) == 'Save' || ($this->input->post('submit')) == 'Next') :
            /**
             * ****************** Repopulation
             * **************************************
             */
            $this->session->set_userdata('customer', $this->input->post('first_name'));
            $this->session->set_userdata('first', $this->input->post('first_name'));
            
            $this->session->set_userdata('account_no', $this->input->post('account_no'));
            $this->session->set_userdata('customer_code', $this->input->post('customer_code'));
            $this->session->set_userdata('first_name', $this->input->post('first_name'));
            $this->session->set_userdata('middle_name', $this->input->post('middle_name'));
            $this->session->set_userdata('last_name', $this->input->post('last_name'));
            $this->session->set_userdata('address', $this->input->post('address'));
            $this->session->set_userdata('address1', $this->input->post('address1'));
            $this->session->set_userdata('city', $this->input->post('city'));
            $this->session->set_userdata('state', $this->input->post('state'));
            $this->session->set_userdata('zip', $this->input->post('zip'));
            $this->session->set_userdata('country', $this->input->post('country'));
            $this->session->set_userdata('email', $this->input->post('email'));
            $this->session->set_userdata('home_phone', $this->input->post('home_phone'));
            $this->session->set_userdata('cell', $this->input->post('cell'));
            $this->session->set_userdata('office_phone', $this->input->post('office_phone'));
            $this->session->set_userdata('fax', $this->input->post('fax'));
            $this->session->set_userdata('contact', $this->input->post('contact'));
            $this->session->set_userdata('bill_to', $this->input->post('bill_to'));
            $this->session->set_userdata('bill_mode', $this->input->post('bill_mode'));
            $this->session->set_userdata('bill_address', $this->input->post('bill_address'));
            $this->session->set_userdata('bill_address1', $this->input->post('bill_address1'));
            $this->session->set_userdata('bill_city', $this->input->post('bill_city'));
            $this->session->set_userdata('bill_state', $this->input->post('bill_state'));
            $this->session->set_userdata('bill_zip', $this->input->post('bill_zip'));
            $this->session->set_userdata('bill_country', $this->input->post('bill_country'));
            $this->session->set_userdata('referred_contact', $this->input->post('referred_contact'));
            $this->session->set_userdata('referred_home_phone', $this->input->post('referred_home_phone'));
            $this->session->set_userdata('referred_cell', $this->input->post('referred_cell'));
            $this->session->set_userdata('referred_office_phone', $this->input->post('referred_office_phone'));
            $this->session->set_userdata('referred_fax', $this->input->post('referred_fax'));
            $this->session->set_userdata('status', $this->input->post('status'));
            $this->session->set_userdata('statuswb', $this->input->post('status'));
            $this->session->set_userdata('payment', $this->input->post('payment_terms'));
            $this->session->set_userdata('emailcc', $this->input->post('emailcc'));
            $this->session->set_userdata('emailbcc', $this->input->post('emailbcc'));
        








		/******************** Repopulation ***************************************/
		endif;
        
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email Address', 'callback_email_check'); // phone_number_check
        $this->form_validation->set_rules('zip', 'Zip', 'callback_zip_fax');
        $this->form_validation->set_rules('bill_zip', 'Billing Address Zip', 'callback_zip_fax');
        $this->form_validation->set_rules('home_phone', 'Home Phone', 'callback_phone_number_check');
        $this->form_validation->set_rules('office_phone', 'Office Phone', 'callback_phone_number_check');
        $this->form_validation->set_rules('cell', 'Cell', 'callback_phone_number_check');
        $this->form_validation->set_rules('referred_home_phone', 'Referred By Home Phone', 'callback_phone_number_check');
        $this->form_validation->set_rules('referred_office_phone', 'Referred By Office Phone', 'callback_phone_number_check');
        $this->form_validation->set_rules('referred_cell', 'Referred By Cell', 'callback_phone_number_check');
        $this->form_validation->set_rules('fax', 'Fax', 'callback_phone_number_check');
        $this->form_validation->set_rules('referred_fax', 'Referred By Fax', 'callback_phone_number_check');
        $this->form_validation->set_rules('bill_mode', '', 'callback_bill_mode_email_check');
        
        $this->form_validation->set_error_delimiters('<br/><div style="color:red">', '</div>');
        
        $data['bill'] = $this->customer_model->get_options_billmode();
        $data['terms'] = $this->customer_model->get_options_terms();
        
        if ($this->form_validation->run() === FALSE) {
            $this->session->userdata('population', true);
            if ($this->session->userdata('modify') == $this->session->userdata('brandnew')) {
                echo '
				<script> alert("Please Close all Other BTW Dive tabs to continue.");
				window.location="' . base_url() . 'index.php/customer/customer_session";
				</script>
				';
            }
            $this->load->view('templates/header');
            $this->load->view('customer/customer_banner');
            $this->load->view('customer/customer_registration', $data);
            $this->load->view('templates/footer');
        } else {
            if ($this->session->userdata('dbms') == false) :
                $this->session->set_userdata('customer', $this->input->post('first_name') . "&nbsp;" . $this->input->post('last_name'));
                $this->session->set_userdata('first', $this->input->post('first_name'));
                
                $this->session->set_userdata('account_no', $this->input->post('account_no'));
                $this->session->set_userdata('customer_code', $this->input->post('customer_code'));
                $this->session->set_userdata('first_name', $this->input->post('first_name'));
                $this->session->set_userdata('middle_name', $this->input->post('middle_name'));
                $this->session->set_userdata('last_name', $this->input->post('last_name'));
                $this->session->set_userdata('address', $this->input->post('address'));
                $this->session->set_userdata('address1', $this->input->post('address1'));
                $this->session->set_userdata('city', $this->input->post('city'));
                $this->session->set_userdata('state', $this->input->post('state'));
                $this->session->set_userdata('zip', $this->input->post('zip'));
                $this->session->set_userdata('country', $this->input->post('country'));
                $this->session->set_userdata('email', $this->input->post('email'));
                $this->session->set_userdata('home_phone', $this->input->post('home_phone'));
                $this->session->set_userdata('cell', $this->input->post('cell'));
                $this->session->set_userdata('office_phone', $this->input->post('office_phone'));
                $this->session->set_userdata('fax', $this->input->post('fax'));
                $this->session->set_userdata('contact', $this->input->post('contact'));
                $this->session->set_userdata('bill_to', $this->input->post('bill_to'));
                $this->session->set_userdata('bill_mode', $this->input->post('bill_mode'));
                $this->session->set_userdata('bill_address', $this->input->post('bill_address'));
                $this->session->set_userdata('bill_address1', $this->input->post('bill_address1'));
                $this->session->set_userdata('bill_city', $this->input->post('bill_city'));
                $this->session->set_userdata('bill_state', $this->input->post('bill_state'));
                $this->session->set_userdata('bill_zip', $this->input->post('bill_zip'));
                $this->session->set_userdata('bill_country', $this->input->post('bill_country'));
                $this->session->set_userdata('referred_contact', $this->input->post('referred_contact'));
                $this->session->set_userdata('referred_home_phone', $this->input->post('referred_home_phone'));
                $this->session->set_userdata('referred_cell', $this->input->post('referred_cell'));
                $this->session->set_userdata('referred_office_phone', $this->input->post('referred_office_phone'));
                $this->session->set_userdata('referred_fax', $this->input->post('referred_fax'));
                $this->session->set_userdata('status', $this->input->post('status'));
                $this->session->set_userdata('statuswb', $this->input->post('status'));
                $this->session->set_userdata('payment', $this->input->post('payment_terms'));
                $this->session->set_userdata('emailcc', $this->input->post('emailcc'));
                $this->session->set_userdata('emailbcc', $this->input->post('emailbcc'));
                
                $this->session->set_userdata('customer_master', 'wait');
            










			endif;
            
            if (($this->input->post('submit')) == 'Next') {
                
                $this->session->set_userdata('return_status', true);
            }
            if (($this->input->post('submit')) == 'Save') {
                
                $data['workopen'] = $this->customer_model->check_workorder_open($this->session->userdata('customerid'));
                if (count($data['workopen']) < 1) {
                    $this->session->set_userdata('open', true);
                } else {
                    $this->session->set_userdata('open', false);
                }
                
                $this->session->set_userdata('return_status', false);
            }
            $this->customer_model->set_customer_data();
            $this->session->set_userdata('primary', true);
            redirect('/customer/customer_vessel/' . $this->session->userdata('customerid'));
        }
    }
    /*
     * HOME->CUSTOMER->NEW CUSTOMER->VESSEL
     * HOME->CUSTOMER->MODIFY CUSTOMER->VESSEL
     *
     * The customers are provided to fill up the details of the vessel they are using.
     *
     *
     *
     *
     */
    public function customer_vessel($customer = NULL)
    {
        if (! is_null($customer) && ! is_numeric($customer)) {
            show_404();
        }
        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->library('form_validation');
        
        if (! is_null($customer)) {
            $data2['customer'] = $this->customer_model->get_customer_registration_details($customer);
            $this->session->set_userdata('modify', true);
            $this->session->set_userdata('dbms', true);
            $this->session->set_userdata('customerid', $customer);
            $this->session->set_userdata('customer_number', $customer);
            $this->session->set_userdata('customer', $data2['customer'][0]->FIRST_NAME . "&nbsp;" . $data2['customer'][0]->LAST_NAME);
            $data['customer'] = $this->customer_model->get_customer_vessel_details($customer);
            $pkv = $data['customer'][0]->PK_VESSEL;
            $this->session->set_userdata('vessel_number', $pkv);
        } else {
            if ($this->session->userdata('customer_vessel') != 'wait') {
                $data['account_vessel'] = $this->customer_model->get_vessel_primary_key();
                $vessel_number = $data['account_vessel'][0]->PK_VESSEL;
                
                $this->session->set_userdata('vessel_number', $vessel_number);
            } else {
                $data['account_vessel'] = $this->customer_model->get_vessel_primary_key();
            }
        }
        
        $data['options'] = $this->customer_model->get_options_vessel();
        $data['paint'] = $this->customer_model->get_options_paint();
        $data['types'] = $this->customer_model->get_vessel();
        if (($this->input->post('submit')) == 'Save' || ($this->input->post('submit')) == 'Next') :
            /**
             * **************************** Repopulation
             * ************************************
             */
            $this->session->set_userdata('ves_location', $this->input->post('location'));
            $this->session->set_userdata('ves_type', $this->input->post('type'));
            $this->session->set_userdata('ves_slip', $this->input->post('slip'));
            $this->session->set_userdata('ves_cfno', $this->input->post('cfno'));
            $this->session->set_userdata('ves_make', $this->input->post('make'));
            $this->session->set_userdata('ves_model', $this->input->post('model'));
            $this->session->set_userdata('ves_length', $this->input->post('length'));
            $this->session->set_userdata('ves_vessel_name', $this->input->post('vessel_name'));
            $this->session->set_userdata('ves_tender_dinghy', $this->input->post('tender_dinghy'));
            $this->session->set_userdata('ves_vessel_description', $this->input->post('vessel_description'));
            $this->session->set_userdata('ves_paint_cycle', $this->input->post('paint_cycle'));
		/***************************** Repopulation ****************************************/
				endif;
        $this->form_validation->set_rules('location', 'Location', 'required');
        $this->form_validation->set_error_delimiters('<div style="color:red">', '</div>');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header');
            $this->load->view('customer/customer_banner');
            $this->load->view('customer/customer_vessel', $data);
            $this->load->view('templates/footer');
            ;
        } else {
            if ($this->session->userdata('dbms') == false) :
                $this->session->set_userdata('ves_location', $this->input->post('location'));
                $this->session->set_userdata('ves_type', $this->input->post('type'));
                $this->session->set_userdata('ves_slip', $this->input->post('slip'));
                $this->session->set_userdata('ves_cfno', $this->input->post('cfno'));
                $this->session->set_userdata('ves_make', $this->input->post('make'));
                $this->session->set_userdata('ves_model', $this->input->post('model'));
                $this->session->set_userdata('ves_length', $this->input->post('length'));
                $this->session->set_userdata('ves_vessel_name', $this->input->post('vessel_name'));
                $this->session->set_userdata('ves_tender_dinghy', $this->input->post('tender_dinghy'));
                $this->session->set_userdata('ves_vessel_description', $this->input->post('vessel_description'));
                $this->session->set_userdata('ves_paint_cycle', $this->input->post('paint_cycle'));                
                $this->session->set_userdata('customer_vessel', 'wait');
			endif;
            if (($this->input->post('submit')) == 'Next') {
                
                $this->session->set_userdata('return_status', true);
            }
            if (($this->input->post('submit')) == 'Save') {
                $data['workopen'] = $this->customer_model->check_workorder_open($this->session->userdata('customerid'));
                if (count($data['workopen']) < 1) {
                    $this->session->set_userdata('open', true);
                } else {
                    $this->session->set_userdata('open', false);
                }
                
                $this->session->set_userdata('return_status', false);
            }
            $this->customer_model->set_vessel_data();
			$this->session->set_userdata('secondary', true);
            redirect('/customer/customer_services/' . $this->session->userdata('customerid'), 'refresh');
        }
    }
    
    /*
     * HOME->CUSTOMER->NEW CUSTOMER->SERVICES
     * HOME->CUSTOMER->MODIFY CUSTOMER->SERVICES
     *
     * The type of the service for the vessel are selected here.
     * summer and winter seasons are considered here
     */
    public function customer_services($customer = NULL)
    {
        if (! is_null($customer) && ! is_numeric($customer)) {
            show_404();
        }
        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('calendar');
        
        if (! is_null($customer)) {
            $data['customer'] = $this->customer_model->get_customer_service_details($customer);
            $data['account_service'] = $this->customer_model->get_vessel_service_primary_key();
            $service_number = $data['account_service'][0]->PK_VESSEL_SERVICE;
            $service_number ++;
            $this->session->set_userdata('service_number', $service_number);
        } else {
            $data['account_service'] = $this->customer_model->get_vessel_service_primary_key();
            $service_number = $data['account_service'][0]->PK_VESSEL_SERVICE;
            $service_number ++;
            $this->session->set_userdata('service_number', $service_number);
        }
        
        /*
         * $data['options'] = $this->customer_model->get_options_vessel();
         * $data['types'] = $this->customer_model->get_vessel();
         * //$this->load->view('customer/customer_vessel',$data);
         */
        
        $data['hullclean'] = $this->customer_model->get_hull_clean_type();
        $data['bow'] = $this->customer_model->get_bow_rate();
        $data['aft'] = $this->customer_model->get_aft_rate();
        if (($this->input->post('submit')) == 'Save' || ($this->input->post('submit')) == 'Next') :
            /**
             * ************************************* Repopulation
             * ***********************************************
             */
            $this->session->set_userdata('hullclean', $this->input->post('hullclean'));
            $this->session->set_userdata('startdate', $this->input->post('startdate'));
            // $this->session->set_userdata('discount',$this->input->post('discount'));
            
            $this->session->set_userdata('summer', $this->input->post('summer'));
            $this->session->set_userdata('summer_first_service', $this->input->post('summer_first_service'));
            $this->session->set_userdata('summer_second_service', $this->input->post('summer_second_service'));
            $this->session->set_userdata('summer_first_service_price', $this->input->post('summer_first_service_price'));
            $this->session->set_userdata('summer_second_service_price', $this->input->post('summer_second_service_price'));
            $this->session->set_userdata('summer_first_discount_price', $this->input->post('summer_first_discount_price'));
            $this->session->set_userdata('summer_second_discount_price', $this->input->post('summer_second_discount_price'));
            
            $this->session->set_userdata('winter', $this->input->post('winter'));
            $this->session->set_userdata('winter_first_service', $this->input->post('winter_first_service'));
            $this->session->set_userdata('winter_second_service', $this->input->post('winter_second_service'));
            $this->session->set_userdata('winter_first_service_price', $this->input->post('winter_first_service_price'));
            $this->session->set_userdata('winter_second_service_price', $this->input->post('winter_second_service_price'));
            $this->session->set_userdata('winter_first_discount_price', $this->input->post('winter_first_discount_price'));
            $this->session->set_userdata('winter_second_discount_price', $this->input->post('winter_second_discount_price'));
            
            $this->session->set_userdata('bow', $this->input->post('bow'));
            $this->session->set_userdata('bow_list_price', $this->input->post('bow_list_price'));
            $this->session->set_userdata('bow_discount_price', $this->input->post('bow_discount_price'));
            
            $this->session->set_userdata('both', $this->input->post('both'));
            $this->session->set_userdata('both_list_price', $this->input->post('both_list_price'));
            $this->session->set_userdata('both_discount_price', $this->input->post('both_discount_price'));
            
            $this->session->set_userdata('lastdate', $this->input->post('lastdate'));
            
            $this->session->set_userdata('dinghy', $this->input->post('dinghy'));
            $this->session->set_userdata('dinghy_list_price', $this->input->post('dinghy_list_price'));
            $this->session->set_userdata('dinghy_discount_price', $this->input->post('dinghy_discount_price'));
        








		/****************************************** Repopulation **********************************************/
		endif;
        $this->form_validation->set_rules('startdate', 'Starting From', 'required|callback_date_check'); // |callback_date_check
        $this->form_validation->set_rules('lastdate', 'Last Cleaned Date', 'callback_date_check');
        $this->form_validation->set_error_delimiters('<div style="color:red">', '</div>');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header');
            $this->load->view('customer/customer_banner');
            $this->load->view('customer/customer_services', $data);
            $this->load->view('templates/footer');
            ;
        } else {
            if ($this->session->userdata('dbms') == false) :
                $this->session->set_userdata('hullclean', $this->input->post('hullclean'));
                $this->session->set_userdata('startdate', $this->input->post('startdate'));
                // $this->session->set_userdata('discount',$this->input->post('discount'));
                
                $this->session->set_userdata('summer', $this->input->post('summer'));
                $this->session->set_userdata('summer_first_service', $this->input->post('summer_first_service'));
                $this->session->set_userdata('summer_second_service', $this->input->post('summer_second_service'));
                $this->session->set_userdata('summer_first_service_price', $this->input->post('summer_first_service_price'));
                $this->session->set_userdata('summer_second_service_price', $this->input->post('summer_second_service_price'));
                $this->session->set_userdata('summer_first_discount_price', $this->input->post('summer_first_discount_price'));
                $this->session->set_userdata('summer_second_discount_price', $this->input->post('summer_second_discount_price'));
                
                $this->session->set_userdata('winter', $this->input->post('winter'));
                $this->session->set_userdata('winter_first_service', $this->input->post('winter_first_service'));
                $this->session->set_userdata('winter_second_service', $this->input->post('winter_second_service'));
                $this->session->set_userdata('winter_first_service_price', $this->input->post('winter_first_service_price'));
                $this->session->set_userdata('winter_second_service_price', $this->input->post('winter_second_service_price'));
                $this->session->set_userdata('winter_first_discount_price', $this->input->post('winter_first_discount_price'));
                $this->session->set_userdata('winter_second_discount_price', $this->input->post('winter_second_discount_price'));
                
                $this->session->set_userdata('bow', $this->input->post('bow'));
                $this->session->set_userdata('bow_list_price', $this->input->post('bow_list_price'));
                $this->session->set_userdata('bow_discount_price', $this->input->post('bow_discount_price'));
                
                $this->session->set_userdata('both', $this->input->post('both'));
                $this->session->set_userdata('both_list_price', $this->input->post('both_list_price'));
                $this->session->set_userdata('both_discount_price', $this->input->post('both_discount_price'));
                
                $this->session->set_userdata('lastdate', $this->input->post('lastdate'));
                
                $this->session->set_userdata('dinghy', $this->input->post('dinghy'));
                $this->session->set_userdata('dinghy_list_price', $this->input->post('dinghy_list_price'));
                $this->session->set_userdata('dinghy_discount_price', $this->input->post('dinghy_discount_price'));
            










			endif;
            if (($this->input->post('submit')) == 'Next') {
                
                $this->session->set_userdata('return_status', true);
            }
            if (($this->input->post('submit')) == 'Save') {
                $data['workopen'] = $this->customer_model->check_workorder_open($this->session->userdata('customerid'));
                if (count($data['workopen']) < 1) {
                    $this->session->set_userdata('open', true);
                } else {
                    $this->session->set_userdata('open', false);
                }
                
                $this->session->set_userdata('return_status', false);
            }
            $this->customer_model->set_service_data();
            
            redirect('/customer/customer_anodes/' . $this->session->userdata('customerid'), 'refresh');
            // $this->load->view('customer/customer_vessel');
        }
    }
    
    /*
     * HOME->CUSTOMER->NEW CUSTOMER->ANODES
     * HOME->CUSTOMER->MODIFY CUSTOMER->ANODES
     *
     * The anodes/zincs belongs to vessel are selected here.
     */
    public function customer_anodes($customer = NULL)
    {
        if (! is_null($customer) && ! is_numeric($customer)) {
            show_404();
        }
        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $data['customer'] = NULL;
        
        if (! is_null($customer)) {
            
            $data['session_customer'] = $this->customer_model->get_customer_registration_details($customer);
            $data['ses_customer'] = $customer;
            $data['ses_vessel'] = $data['session_customer'][0]->PK_VESSEL;
            $data['customer'] = $this->customer_model->get_customer_anodes_details($customer);
            $data['account_anode'] = $this->customer_model->get_vessel_anode_primary_key();
            $anode_number = $data['account_anode'][0]->PK_VESSEL_ANODE;
            $anode_number ++;
            $this->session->set_userdata('anode_number', $anode_number);
        } else 
            if (is_numeric($this->session->userdata('customer_number')) && is_numeric($this->session->userdata('vessel_number')) && is_numeric($this->session->userdata('anode_number'))) {
                $data['session_customer'] = $this->customer_model->get_customer_anodes_details($this->session->userdata('customer_number'));
                $data['ses_customer'] = $this->session->userdata('customer_number');
                $data['ses_vessel'] = $this->session->userdata('vessel_number');
            } else {
                $data['ses_customer'] = $this->session->userdata('customer_number');
                $data['ses_vessel'] = 0;
                $data['account_anode'] = $this->customer_model->get_vessel_anode_primary_key();
                $anode_number = $data['account_anode'][0]->PK_VESSEL_ANODE;
                $anode_number ++;
                $this->session->set_userdata('anode_number', $anode_number);
            }
        $this->form_validation->set_error_delimiters('<div style="color:red">', '</div>');
        $this->form_validation->set_rules('discount', 'Discount', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header');
            $this->load->view('customer/customer_banner');
            $this->load->view('/customer/customer_anodes', $data);
            $this->load->view('templates/footer');
            ;
        } else {
            if (($this->input->post('submit')) == 'Next') {
                
                $this->session->set_userdata('return_status', true);
            }
            if (($this->input->post('submit')) == 'Save') {
                
                $data['workopen'] = $this->customer_model->check_workorder_open($this->session->userdata('customerid'));
                
                if (count($data['workopen']) < 1) {
                    $this->session->set_userdata('open', true);
                } else {
                    $this->session->set_userdata('open', false);
                }
                $this->session->set_userdata('return', true);
                $this->session->set_userdata('return_status', false);
            }
            redirect('/customer/customer_misc/' . $this->session->userdata('customerid'));
        }
    }
    /*
     * HOME->CUSTOMER->NEW CUSTOMER->MISC
     * HOME->CUSTOMER->MODIFY CUSTOMER->MISC
     *
     * miscellaneous details and some notes are saved here for further use.
     */
    public function customer_misc($customer = NULL)
    {
        if (! is_null($customer) && ! is_numeric($customer)) {
            show_404();
        }
        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $data['customer'] = NULL;
        if (! is_null($customer)) {
            $data['customer'] = $this->customer_model->get_customer_misc_details($customer);
        }
        if (($this->input->post('submit')) == 'Save' || ($this->input->post('submit')) == 'Next') :
            $this->session->set_userdata('cleaning_instructions', $this->input->post('cleaning_instructions'));
            $this->session->set_userdata('anode_instructions', $this->input->post('anode_instructions'));
            $this->session->set_userdata('mechanical_instructions', $this->input->post('mechanical_instructions'));
            $this->session->set_userdata('comments', $this->input->post('comments'));
			$this->session->set_userdata('ZincReplacement', $this->input->post('ZincReplacement'));
            $this->session->set_userdata('notes', $this->input->post('notes'));
        

		endif;
        $this->form_validation->set_rules('cleaning_instructions', 'Cleaning', '');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header');
            $this->load->view('customer/customer_banner');
            $this->load->view('customer/customer_misc', $data);
            $this->load->view('templates/footer');
        } else {
            $this->session->set_userdata('cleaning_instructions', $this->input->post('cleaning_instructions'));
            $this->session->set_userdata('anode_instructions', $this->input->post('anode_instructions'));
            $this->session->set_userdata('mechanical_instructions', $this->input->post('mechanical_instructions'));
            $this->session->set_userdata('comments', $this->input->post('comments'));
			$this->session->set_userdata('ZincReplacement', $this->input->post('ZincReplacement'));
            $this->session->set_userdata('notes', $this->input->post('notes'));
            if (($this->input->post('submit')) == 'Next') {                
                $this->session->set_userdata('return_status', true);
            }
            if (($this->input->post('submit')) == 'Save') {
                $data['workopen'] = $this->customer_model->check_workorder_open($this->session->userdata('customerid'));
                if (count($data['workopen']) < 1) {
                    $this->session->set_userdata('open', true);
                } else {
                    $this->session->set_userdata('open', false);
                }
                
                $this->session->set_userdata('return_status', false);
            }
            $this->customer_model->set_misc_data();
            redirect('/customer/customer_redirect/' . $customer, 'refresh');
        }
    }
    /*
     * HOME->CUSTOMER->CUSTOMER ACCOUNT
     * this page will list the details of the customer till date.
     * customer is selected by the search at home page.
     *
     */
    public function customer_account($customer)
    {
        $this->load->helper('url');
        $data['customers'] = $this->customer_model->get_customer_invoice_info($customer);
        $data['invoices'] = $this->customer_model->get_customer_invoice_details($customer);
        
        $this->load->view('templates/header');
        
        $this->load->view('customer/customer_account', $data);
        $this->load->view('templates/footer');
    }
    // credit payment details
    public function credit_payment_details($customer, $invoice_status = 0)
    {
        $this->load->helper('url');
        $data['cid'] = $customer;
        
        $data['cname'] = $this->customer_model->get_cname_in_payment($customer);
        
        $data['customers'] = $this->customer_model->get_credit_billing_details($customer);
        $data['amount'] = $this->customer_model->get_credits_amount_billed($customer);
        $data['payment'] = $this->customer_model->get_credit_payment_details($customer);
        // check the credit card status
        $data['creditcard'] = $this->customer_model->check_delivery_mode($customer);
        $data['credit_card'] = 'Email';
        foreach ($data['creditcard'] as $cc) {
            $data['credit_card'] = $cc->DELIVERY_MODE;
        }
        
        if ($invoice_status > 0) {
            $data['repair'] = 1;
        } else {
            $data['repair'] = 0;
        }
        $this->load->view('templates/header');
        $this->load->view('customer/credit_payment_details', $data);
    }
    /* Notification for the credit card details */
    function sendNotificationCreditCard($customer)
    {
        $this->load->library('email');
        $this->load->helper('html');
        $this->load->helper('url');
        $config = array(
            'mailtype' => 'html',
            'charset' => 'utf-8'
        );
        $this->email->initialize($config);
        $this->email->clear();
        $this->email->clear(true);
        
        $data['customer'] = $this->customer_model->get_customer_registration_details($customer);
        
        $this->email->from('info@btwdive.com', 'Ian Roberts');
        $this->email->reply_to('info@btwdive.com', 'Ian Roberts');
        
        // $this->email->to ($data['customer'][0]->EMAIL);//$data['customer'][0]->EMAIL
        $this->email->to('subinpvasu@gmail.com');
        // $this->email->bcc ( 'caarif123@gmail.com' );
        
        $this->email->subject('BTW Dive - Credit Card Update');
        
        $message = "Dear " . $data['customer'][0]->FIRST_NAME . ",<br/><br/>";
        $message .= 'Please
call the office (310) 918-5631 to update your credit card information.<br/>
The card was declined on our last attempt to charge for recent services.<br/><br/>';
        $message = $message . 'Ian Roberts' . "<br/>";
        $message = $message . "Owner<br/>";
        $message = $message . 'B.T.W. Dive Service' . "<br/>";
        $message = $message . "310.918.5631";
        
        $this->email->message($message);
        
        $this->email->send();
        echo 'Request Sent to ' . $data['customer'][0]->FIRST_NAME;
        // echo $message;
    }
    
    // payment details
    public function payment_details($invoice, $k = null, $cid = null)
    {
        $this->load->helper('url');
        $data['inv'] = $invoice;
        
        if ($invoice == 'C') {
            $data['customers'] = $this->customer_model->get_cpay_bil_details($cid);
            $data['billing'] = $this->customer_model->get_c_billing_details($cid);
        } else {
            $data['customers'] = $this->customer_model->get_payment_billing_details($invoice);
            $data['billing'] = $this->customer_model->get_billing_details_invoice($invoice);
        }
        // print_r($data['customers']);exit();
        $data['cid'] = $data['customers'][0]->pk_customer;
        $data['creditcard'] = $this->customer_model->check_delivery_mode($data['customers'][0]->pk_customer);
        $data['credit_card'] = 'Email';
        foreach ($data['creditcard'] as $cc) {
            $data['credit_card'] = $cc->DELIVERY_MODE;
        }
        
        $data['payment'] = $this->customer_model->get_payment_details_invoice($invoice);
        $data['wo_no'] = $this->customer_model->get_work_order_no($invoice);
        
        foreach ($data['wo_no'] as $wo) :
            
            $data['disc'][] = $this->customer_model->get_total_discount_wonum($wo->pk_wo);
        endforeach
        ;
        
        $this->load->view('templates/header');
        $this->load->view('customer/payment_details', $data);
    }
    /*
     * HOME->CUSTOMER->WORK HISTORY
     *
     * Will let you know the work order details till date.
     */
    public function customer_workhistory($customer = NULL)
    {
        $this->load->helper('url');
        $data['customers'] = $this->customer_model->get_customer_invoice_info($customer);
        $data['workhistory'] = $this->customer_model->get_customer_work_history($customer);
        $this->load->view('templates/header');
        
        $this->load->view('customer/customer_workhistory', $data);
        $this->load->view('templates/footer');
    }
    
    // Monthly invoices
    public function monthly_invoices($from, $to)
    {
        $data['from'] = $this->date_format_db($from);
        $data['to'] = $this->date_format_db($to);
        $this->load->helper('url');
        $this->load->helper('html');
        $current = 0;
        $query = null;
        $this->load->helper(array(
            'dompdf',
            'file'
        ));
        $data['current'] = $current;
        $data['balances'] = $this->customer_model->get_monthly_invoices_list($current, 32, $query, $data);
        $data['amountrecd'] = $this->customer_model->get_monthly_amountrecd_list($current, 32, $query, $data);
        
        $this->load->view('customer/monthly_invoices', $data);
    }
    // month wise monthly invoices
    public function monthwise_monthly_invoices($monYear)
    {
        $data['mon_year'] = $monYear;
        $this->load->helper('url');
        $this->load->helper('html');
        $current = 0;
        $query = null;
        $this->load->helper(array(
            'dompdf',
            'file'
        ));
        $data['current'] = $current;
        $data['balances'] = $this->customer_model->get_monthwise_moninv_list($data);
        $data['amountrecd'] = $this->customer_model->get_monthwise_amtrecd_list($data);
        $this->load->view('customer/monthly_invoices', $data);
    }
    
    // diver commission print page
    public function print_diver_commission($diver, $from, $to, $current, $query = null)
    {
        $from = $this->date_format_db(str_replace("^", "/", urldecode($from)));
        $to = $this->date_format_db(str_replace("^", "/", urldecode($to)));
        $data['from'] = $this->date_format_us($from);
        $data['to'] = $this->date_format_us($to);
        $data['diverid'] = $diver;
        $this->load->helper("url");
        $this->load->helper('html');
        $this->load->helper(array(
            'dompdf',
            'file'
        ));
        $data['current'] = $current;
        $data['diver'] = $this->customer_model->get_diver_commission_list($diver, $from, $to, $current);
        $data['total'] = $this->customer_model->get_diver_full_commission_list($diver, $from, $to);
        $data['comm_total'] = $this->customer_model->get_total_commission($diver, $from, $to);
        $data['materials'] = $this->customer_model->get_deduction_commission($diver, $from, $to);
        
        $data['diverdetails'] = $this->customer_model->get_diver_name_fromid($diver);
        $data['diver_name'] = $data['diverdetails'][0]->diver_name;
        
        if ($this->input->post('submitted') == 'pagepdf') {
            $data['diver'] = $this->customer_model->get_diver_full_commission_list($diver, $from, $to);
            $data['sum'] = 1;
            
            $html = $this->load->view('customer/diverComm_pdf', $data, true);
            pdf_create($html, 'diver_comm_report');
        }
        if ($this->input->post('submitted') == 'pagethis') {
            $data['diver'] = $this->customer_model->get_diver_commission_list($diver, $from, $to, $current);
            $data['sum'] = 0;
            $html = $this->load->view('customer/diverComm_pdf', $data, true);
            pdf_create($html, 'diver_comm_report');
        }
        if ($this->input->post('submitted') == 'pagenext') {
            if ($this->input->post('current') == 0) {
                $current = 45;
            } else {
                $current = $current + 45;
            }
            redirect('/customer/print_diver_commission/' . $diver . '/' . $from . '/' . $to . '/' . $current . '/' . $query, 'refresh');
        }
        if ($this->input->post('submitted') == 'pageback') {
            if ($this->input->post('current') == 0) {
                $current = 0;
            } else {
                $current = $current - 45;
            }
            redirect('/customer/print_diver_commission/' . $diver . '/' . $from . '/' . $to . '/' . $current . '/' . $query, 'refresh');
        }
        
        $this->load->view('templates/header');
        $this->load->view('customer/pdf_banner', $data);
        $this->load->view('customer/print_diver_commission', $data);
        $this->load->view('templates/footer');
    }

    /**
     * HOME->CUSTOMER->OUTSTANDING BALANCE
     * 
     * @param number $current
     *            : last entry no, serial no of the last entry
     * @param string $query
     *            : search query used, if any.
     */
    public function outstanding_balance($current = 0, $query = null)
    {
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->helper(array(
            'dompdf',
            'file'
        ));
        $data['current'] = $current;
        $data['balances'] = $this->customer_model->get_outstanding_balance_list($current, 32, $query);
        $data['total'] = $this->customer_model->get_outstanding_balance_list_no_limit();
        
        if ($this->input->post('submitted') == 'pagepdf') {
            $data['balances'] = $this->customer_model->get_outstanding_balance_list_no_limit();
            $html = $this->load->view('customer/outbalance_pdf', $data, true);
            pdf_create($html, 'outstanding_balance_report');
        }
        if ($this->input->post('submitted') == 'pagethis') {
            $data['balances'] = $this->customer_model->get_outstanding_balance_list($current);
            $html = $this->load->view('customer/outbalance_pdf', $data, true);
            pdf_create($html, 'outstanding_balance_report');
        }
        if ($this->input->post('submitted') == 'pagenext') {
            if ($this->input->post('current') == 0) {
                $current = 32;
            } else {
                $current = $current + 32;
            }
            redirect('/customer/outstanding_balance/' . $current . '/' . $query, 'refresh');
        }
        if ($this->input->post('submitted') == 'pageback') {
            if ($this->input->post('current') == 0) {
                $current = 0;
            } else {
                $current = $current - 32;
            }
            redirect('/customer/outstanding_balance/' . $current . '/' . $query, 'refresh');
        }
        
        $this->load->view('templates/header');
        $this->load->view('customer/pdf_banner', $data);
        $this->load->view('customer/outstanding_balance', $data);
        $this->load->view('templates/footer');
    }
    // missing work order
    public function missing_workorder()
    {
        $this->load->helper("url");
        $this->load->helper('html');
        
        $this->load->view('templates/header');
        $this->load->view('customer/missing_workorder');
        $this->load->view('templates/footer');
    }
    
    // List of invoices
    public function list_invoices($from, $to, $current, $query = null)
    {
        $from = $this->date_format_db(str_replace("^", "/", urldecode($from)));
        $to = $this->date_format_db(str_replace("^", "/", urldecode($to)));
        
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->helper(array(
            'dompdf',
            'file'
        ));
        $data['from'] = $this->date_format_us($from);
        $data['to'] = $this->date_format_us($to);
        $data['current'] = $current;
        $data['balances'] = $this->customer_model->get_list_invoices_list($from, $to, $current);
        $data['total'] = $this->customer_model->get_list_invoices_limit($from, $to);
        
        if ($this->input->post('submitted') == 'pagepdf') {
            $data['present'] = 'no';
            $data['amount'] = $this->customer_model->get_list_total_amount($from, $to);
            $data['balances'] = $this->customer_model->get_list_invoices_limit($from, $to);
            $html = $this->load->view('customer/listinvoice_pdf', $data, true);
            pdf_create($html, 'list_invoice_report');
        }
        if ($this->input->post('submitted') == 'pagethis') {
            $data['present'] = 'yes';
            $data['balances'] = $this->customer_model->get_list_invoices_list($from, $to, $current);
            $html = $this->load->view('customer/listinvoice_pdf', $data, true);
            pdf_create($html, 'list_invoice_report');
        }
        if ($this->input->post('submitted') == 'pagenext') {
            if ($this->input->post('current') == 0) {
                $current = 32;
            } else {
                $current = $current + 32;
            }
            redirect('/customer/list_invoices/' . $from . '/' . $to . '/' . $current . '/' . $query, 'refresh');
        }
        if ($this->input->post('submitted') == 'pageback') {
            if ($this->input->post('current') == 0) {
                $current = 0;
            } else {
                $current = $current - 32;
            }
            redirect('/customer/list_invoices/' . $from . '/' . $to . '/' . $current . '/' . $query, 'refresh');
        }
        
        $this->load->view('templates/header');
        $this->load->view('customer/pdf_banner', $data);
        $this->load->view('customer/list_invoices', $data);
        $this->load->view('templates/footer');
    }

    /**
     * HOME->WORK ORDER->CLEANING WORK ORDER
     * Will let you manage the cleaning work order of any customer like change, update, delete and complete..etc.
     */
    public function cleaning_work_order($pkwork = null)
    {
        // pkwo get_total_services_info
        $this->load->helper('url');
        $data['pkwork'] = $pkwork;
        $data['customers'] = $this->customer_model->get_customer_workorder_info($pkwork);
        $data['cleanings'] = $this->customer_model->get_cleaning_work_order_info($pkwork);
		$date = $data['cleanings'][0]->ENTRY_DATE;        
        $custom = $data['customers'][0]->P;
        $data['totalservice'] = $this->customer_model->get_total_services_info($custom, $date);
        
        if (! empty($data['cleanings'])) {
            $data['divers'] = $this->customer_model->get_diver_name();
            $this->load->view('templates/header');
            $this->load->view('customer/cleaning_work_order', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/header');
            $this->load->view('customer/work_order_not_found');
            $this->load->view('templates/footer');
        }
    }

    /**
     * Which is used in * HOME->WORK ORDER->ADD NEW WORK ORDER->CLEANING
     * CLEANING WORK ORDER details will be listed there to create/schedule the work order for the next session.
     *
     * @param unknown $pkcustomer
     *            : primary keyof the customer
     * @param string $oldpk
     *            : primary key of last cleaning work order.
     */
    public function cleaning_frame($scheduled_date="",$pkcustomer, $oldpk = null, $old = null)
    {
	    $this->load->helper('url');
        $data['older'] = $oldpk;
        $data['old'] = $old;
		echo $this->what_season_present_new($scheduled_date);
        $data['comments'] = $this->customer_model->get_vessel_details_pkcustomer_comments($pkcustomer);
        $data['cleanings'] = $this->customer_model->get_clean_work_order_info_pkcustomer($pkcustomer, $this->what_season_present_new($scheduled_date));
        $data['divers'] = $this->customer_model->get_diver_name();
        $this->load->view('templates/header');
        $this->load->view('customer/cleaning_frame', $data);
    }
	public function what_season_present_new($date_added="")
    {
        if($date_added == "")$date = date("Y-m-d");
		else 
		{
			
			$date_added = str_replace("_","-",$date_added);
			$date = date("Y-m-d",strtotime("$date_added"));
		}
		$d = date_parse_from_format("Y-m-d", $date);
        if ($d['month'] >= 4 && $d['month'] <= 10) {
                return 'S';
				}
             else {
                return 'W';
            }
            
    }

    public function what_season_present($date_added="")
    {
        if($date_added == "")$date = date("Y-m-d");
		else 
		{
			
			$date_added = str_replace("_","-",$date_added);
			$date = date("Y-m-d",strtotime("$date_added"));
		}
		$d = date_parse_from_format("Y-m-d", $date);
        
        if ($d['month'] >= 4 && $d['month'] <= 10) {
            if ($d['month'] >= 4 && $d['month'] < 10) {
                return 'S';
            } else 
                if ($d['month'] == 10 && $d['day'] < 17) {
                    return 'S';
                } else {
                    return 'W';
                }
        } else {
            if ($d['month'] < 3) {
                return 'W';
            }
            if ($d['month'] > 10) {
                return 'W';
            }
            if ($d['month'] == 3 && $d['day'] < 17) {
                return 'W';
            } else {
                return 'S';
            }
        }
    }

    /**
     * Will help you to print the cleaning work order.
     *
     * @param unknown $pkwork
     *            : Work Order Primary key
     */
    public function cleaning_pdf($pkwork)
    {
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->helper(array(
            'dompdf',
            'file'
        ));
        $data['pkwork'] = $pkwork;
        $data['second'] = 0;
        $data['customers'] = $this->customer_model->get_customer_workorder_info($pkwork);
        $data['cleanings'] = $this->customer_model->get_cleaning_work_order_info($pkwork);
        $data['divers'] = $this->customer_model->get_diver_name();
        $data['anodes'] = $this->customer_model->get_anodes_cleaning_work($pkwork);
        $this->customer_model->update_work_order_status_printed($pkwork);
        $html = $this->load->view('customer/cleaning_pdf', $data, true);
        pdf_create($html, 'cleaning_work_order-' . $pkwork);
    }

    /**
     * While printing the work order at very large scale the the cleaning doc should be re-designed to met the page standard.
     *
     * @param unknown $pkwork
     *            :primary key of the work order
     * @param string $cnt
     *            : page number of the doc
     * @return html of the desired page.
     */
    public function cleaning_pdf_bulk($pkwork, $cnt = null)
    {
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->helper(array(
            'dompdf',
            'file'
        ));
        $data['pkwork'] = $pkwork;
        $data['customers'] = $this->customer_model->get_customer_workorder_info($pkwork);
        $data['cleanings'] = $this->customer_model->get_cleaning_work_order_info($pkwork);
        $data['divers'] = $this->customer_model->get_diver_name();
        $data['anodes'] = $this->customer_model->get_anodes_cleaning_work($pkwork);
        $this->customer_model->update_work_order_status_printed($pkwork);
        
        if (! is_null($cnt)) {
            $data['second'] = 1;
            $html = $this->load->view('customer/cleaning_pdf', $data, true);
        } else {
            $data['second'] = 0;
            $html = $this->load->view('customer/cleaning_pdf', $data, true);
        }
        
        return $html;
    }

    /**
     * HOME->WORK ORDER->ANODE WORK ORDER
     * 
     * @param string $pkwork
     *            : primary key of the anode work order.
     *            
     *            Anode work order details will be listed here.
     *            
     */
    public function anode_work_order($pkwork = null)
    {
        $this->load->helper('url');
        $data['pkwork'] = $pkwork;
        $data['customers'] = $this->customer_model->get_customer_workorder_info($pkwork);
        $custom = $data['customers'][0]->P;
        $data['totalanodes'] = $this->customer_model->get_total_anodes_info($custom);
        
        $data['anodes'] = $this->customer_model->get_anode_work_order_info($pkwork);
        $data['divers'] = $this->customer_model->get_diver_name();
        if (! empty($data['anodes'])) {
            $this->load->view('templates/header');
            $this->load->view('customer/anode_work_order', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/header');
            $this->load->view('customer/work_order_not_found');
            $this->load->view('templates/footer');
        }
    }

    /**
     * Which is used in * HOME->WORK ORDER->ADD NEW WORK ORDER->ANODES
     * ANODE WORK ORDER details will be listed there to create/schedule the work order for the next session.
     *
     * @param unknown $pkcustomer
     *            : primary keyof the customer
     *            
     */
    public function anode_frame($pkcustomer)
    {
        $this->load->helper('url');
        // check db for open anode
        $data['open'] = $this->customer_model->work_order_open_anode($pkcustomer);
        $data['anodes'] = $this->customer_model->get_anode_work_order_info_pkcustomer($pkcustomer);
        $data['comments'] = $this->customer_model->get_vessel_details_pkcustomer_comments($pkcustomer);
        $data['divers'] = $this->customer_model->get_diver_name();
        $this->load->view('templates/header');
        $this->load->view('customer/anode_frame', $data);
    }

    /**
     * Will help you to print the anode work order.
     * 
     * @param unknown $pkwork
     *            :primary key of the anode work order.
     */
    public function anode_pdf($pkwork)
    {
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->helper(array(
            'dompdf',
            'file'
        ));
        $data['pkwork'] = $pkwork;
        $data['second'] = 0;
        $data['customers'] = $this->customer_model->get_customer_workorder_info($pkwork);
        $data['anodes'] = $this->customer_model->get_anode_work_order_info($pkwork);
        $data['divers'] = $this->customer_model->get_diver_name();
        $this->customer_model->update_work_order_status_printed($pkwork);
        $html = $this->load->view('customer/anode_pdf', $data, true);
        pdf_create($html, 'anode_work_order-' . $pkwork);
    }

    /**
     *
     * * While printing the work order at very large scale the the cleaning doc should be re-designed to met the page standard.
     *
     * @param unknown $pkwork
     *            :primary key of the work order
     * @param string $cnt
     *            : page number of the doc
     * @return html of the desired page.
     */
    public function anode_pdf_bulk($pkwork, $cnt = null)
    {
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->helper(array(
            'dompdf',
            'file'
        ));
        $data['pkwork'] = $pkwork;
        $data['customers'] = $this->customer_model->get_customer_workorder_info($pkwork);
        $data['anodes'] = $this->customer_model->get_anode_work_order_info($pkwork);
        $data['divers'] = $this->customer_model->get_diver_name();
        $this->customer_model->update_work_order_status_printed($pkwork);
        $this->load->view('customer/anode_pdf', $data, true);
        if (! is_null($cnt)) {
            $data['second'] = 1;
            $html = $this->load->view('customer/anode_pdf', $data, true);
        } else {
            $data['second'] = 0;
            $html = $this->load->view('customer/anode_pdf', $data, true);
        }
        return $html;
    }

    /**
     * HOME->WORK ORDER->MECHANICAL WORK ORDER
     * 
     * @param string $pkwork
     *            : primary key of the anode work order.
     *            
     *            Anode work order details will be listed here.
     *            
     */
    public function mechanical_work_order($pkwork = null)
    {
        $this->load->helper('url');
        $data['pkwork'] = $pkwork;
        $data['customers'] = $this->customer_model->get_customer_workorder_info($pkwork);
        $data['mechanical'] = $this->customer_model->get_mechanical_work_order_info($pkwork);
        $data['divers'] = $this->customer_model->get_diver_name();
        if (! empty($data['mechanical'])) {
            $this->load->view('templates/header');
            $this->load->view('customer/mechanical_work_order', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/header');
            $this->load->view('customer/work_order_not_found');
            $this->load->view('templates/footer');
        }
    }

    /**
     * Which is used in * HOME->WORK ORDER->ADD NEW WORK ORDER->MECHANICAL
     * MECHANICAL WORK ORDER details will be listed there to create/schedule the work order for the next session.
     *
     * @param unknown $pkcustomer
     *            : primary keyof the customer
     *            
     */
    public function mechanical_frame($pkwork = null)
    {
        $this->load->helper('url');
        $data['pkwork'] = $pkwork;
        $data['mechanical'] = $this->customer_model->get_mechanical_work_order_info($pkwork);
        $data['comments'] = $this->customer_model->get_vessel_details_pkcustomer_comments($pkwork);
        $data['divers'] = $this->customer_model->get_diver_name();
        $this->load->view('templates/header');
        $this->load->view('customer/mechanical_frame', $data);
    }

    /**
     * Will help you to print the mechanical work order.
     * 
     * @param unknown $pkwork
     *            :primary key of the mechanical work order.
     */
    public function mechanical_pdf($pkwork)
    {
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->helper(array(
            'dompdf',
            'file'
        ));
        $data['pkwork'] = $pkwork;
        $data['second'] = 0;
        $data['customers'] = $this->customer_model->get_customer_workorder_info($pkwork);
        $data['mechanical'] = $this->customer_model->get_mechanical_work_order_info($pkwork);
        $data['divers'] = $this->customer_model->get_diver_name();
        $this->customer_model->update_work_order_status_printed($pkwork);
        $html = $this->load->view('customer/mechanical_pdf', $data, true);
        pdf_create($html, 'mechanical_work_order-' . $pkwork);
    }

    /**
     *
     * * While printing the work order at very large scale the the cleaning doc should be re-designed to met the page standard.
     *
     * @param unknown $pkwork
     *            :primary key of the work order
     * @param string $cnt
     *            : page number of the doc
     * @return html of the desired page.
     */
    public function mechanical_pdf_bulk($pkwork, $cnt = null)
    {
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->helper(array(
            'dompdf',
            'file'
        ));
        $data['pkwork'] = $pkwork;
        $data['customers'] = $this->customer_model->get_customer_workorder_info($pkwork);
        $data['mechanical'] = $this->customer_model->get_mechanical_work_order_info($pkwork);
        $data['divers'] = $this->customer_model->get_diver_name();
        $this->customer_model->update_work_order_status_printed($pkwork);
        
        if (! is_null($cnt)) {
            $data['second'] = 1;
            $html = $this->load->view('customer/mechanical_pdf', $data, true);
        } else {
            $data['second'] = 0;
            $html = $this->load->view('customer/mechanical_pdf', $data, true);
        }
        
        return $html;
    }

    /**
     * Completedd work orders are viewed from here.by putting the primary key as input.
     * Work order are sorted here
     * 
     * @param string $pkwork
     *            : primary key of the work order.
     */
    public function completed_work_order($pkwork = null)
    {
        $this->load->helper('url');
        $data['pkwork'] = $pkwork;
        $data['customers'] = $this->customer_model->get_customer_workorder_info($pkwork);
        $data['divers'] = $this->customer_model->get_diver_name();
        $this->load->view('templates/header');
        switch ($data['customers'][0]->Z) {
            case 'A':
                $data['anodes'] = $this->customer_model->get_anode_work_order_info($pkwork);
                $this->load->view('customer/anode_work_order', $data);
                break;
            case 'C':
                $data['cleanings'] = $this->customer_model->get_cleaning_work_order_info($pkwork);
                $this->load->view('customer/cleaning_work_order', $data);
                break;
            case 'M':
                $data['mechanical'] = $this->customer_model->get_mechanical_work_order_info($pkwork);
                $this->load->view('customer/mechanical_work_order', $data);
                break;
            default:
                break;
        }
        $this->load->view('templates/footer');
    }
    /*
     * ADD NEW WORK ORDER CONTROLLER
     */
    public function add_new_work_order($customer, $date = null, $oldpk = null)
    {
		$this->load->helper('url');
        $data['customers'] = $this->customer_model->get_customer_workorder_info_pk_customer($customer);
        if (is_null($date)) {
            $this->session->set_userdata('previlege', 1);
        } else {
            $this->session->set_userdata('previlege', 0);
        }
        /*
         * check whether the customer have pervious cleaning work order.if so
         * find the next schedule date.
         */
        $data['pkcustomer'] = $customer;
		if (is_null($date)) {    
			$data['scheduledate'] = $this->customer_model->get_customer_schedule_date($customer, 'C');
			if (count($data['scheduledate']) > 0) {
                $scheduled = $data['scheduledate'][0]->SCHEDULE_DATE;
				$schedule = date('Y-m-d', strtotime($scheduled));
				$customer_id = $data['scheduledate'][0]->PK_CUSTOMER;
                $type = $data['scheduledate'][0]->WORK_TYPE;
                $data['newdate'] = $this->calculateScheduleDate($scheduled, $type);
				//print_r($data['scheduledate']);
				$type = strtoupper($type);
				//echo $type;
				if($type == 'BI MONTHLY (SAIL)' ||$type == 'BI-MONTHLY (POWER/SAIL)' ||$type == 'BI-MONTHLY - FULL CLEAN 2 WK.' || $type == 'BI-MONTHLY (POWER)' || $type == 'BI-MONTHLY (OUT DRIVES)')
				{
					$current_year = date('Y',strtotime("$scheduled"));
					$current_mon = date('m',strtotime("$scheduled"));
					if($current_mon == 10) 
					{
						$contractDateBegin = date('Y-m-d', strtotime("$current_year/10/17"));
						$contractDateEnd = date('Y-m-d', strtotime("$current_year/10/31"));
					}
					else 
					{
						$contractDateBegin = date('Y-m-d', strtotime("$current_year/03/17"));
						$contractDateEnd = date('Y-m-d', strtotime("$current_year/03/31"));
					}
					if ($schedule > $contractDateBegin && $schedule <= $contractDateEnd)
					{
						echo 1;
						$new_date = date('Y-m-d',strtotime('+2 weeks', strtotime($schedule)));
						//echo $this->what_season_present_new($new_date);
						$new_season_wo_info = $this->customer_model->get_clean_work_order_info_pkcustomer($customer_id,$this->what_season_present_new($new_date));
						//echo '<pre>';
						//print_r($new_season_wo_info);
						if(!empty($new_season_wo_info))
						{
							foreach($new_season_wo_info as $selected_season_wo_info)
							{
								if($selected_season_wo_info->SERVICE_TYPE == 'MONTHLY ONLY' || $selected_season_wo_info->SERVICE_TYPE == 'MONTHLY')
								{
									$data['newdate'] = $this->calculateScheduleDate($scheduled, 'MONTHLY ONLY');
									//echo $data['newdate'];
								}
								
							}
						}
					}
				}
            } else {
                $data['newdate'] = date("m/d/Y");
				
            }
        } else {
            $data['scheduledate'] = $this->customer_model->get_customer_schedule_date($customer, 'C');
            $date = str_replace("^", "/", urldecode($date));
			$scheduled = $date;
				$schedule = date('Y-m-d', strtotime($scheduled));
				$customer_id = $data['scheduledate'][0]->PK_CUSTOMER;
                $type = $data['scheduledate'][0]->WORK_TYPE;
                $data['newdate'] = $this->calculateScheduleDate($scheduled, $type);
				$type = strtoupper($type);
				if($type == 'BI MONTHLY (SAIL)' ||$type == 'BI-MONTHLY (POWER/SAIL)' ||$type == 'BI-MONTHLY - FULL CLEAN 2 WK.' || $type == 'BI-MONTHLY (POWER)' || $type == 'BI-MONTHLY (OUT DRIVES)')
				{
					$current_year = date('Y',strtotime("$scheduled"));
					$current_mon = date('m',strtotime("$scheduled"));
					 
					if($current_mon == 10) 
					{
						$contractDateBegin = date('Y-m-d', strtotime("$current_year/10/17"));
						$contractDateEnd = date('Y-m-d', strtotime("$current_year/10/31"));
					}
					else 
					{
						$contractDateBegin = date('Y-m-d', strtotime("$current_year/03/17"));
						$contractDateEnd = date('Y-m-d', strtotime("$current_year/03/31"));
					}
					if ($schedule > $contractDateBegin && $schedule <= $contractDateEnd)
					{
						
						$new_date = date('Y-m-d',strtotime('+2 weeks', strtotime($schedule)));
						$new_season_wo_info = $this->customer_model->get_clean_work_order_info_pkcustomer($customer_id,$this->what_season_present($new_date));
						if(!empty($new_season_wo_info))
						{
							foreach($new_season_wo_info as $selected_season_wo_info)
							{
								if($selected_season_wo_info->SERVICE_TYPE == 'MONTHLY ONLY' || $selected_season_wo_info->SERVICE_TYPE == 'MONTHLY')
								{
									$data['newdate'] = $this->calculateScheduleDate($scheduled, 'MONTHLY ONLY');
									//echo $data['newdate'];
								}
								
							}
						}
					}
				}
            //$data['newdate'] = $date;
        }
        $data['oldpk'] = $oldpk;
        $this->load->view('templates/header');
        $this->load->view('customer/add_new_work_order', $data);
        $this->load->view('templates/footer');
    }

    /**
     * HOME->WORK ORDER->DAILY WORK ORDER
     * Daly work order view is given from here.
     */
    public function daily_work_order()
    {
        $this->load->helper("url");
        $this->load->view('templates/header');
        $this->load->view('customer/daily_work_order');
        $this->load->view('templates/footer');
    }

    /**
     * Insert/Update the comment in invoice document appear at the bottom of the invoice document entered
     * when the workorder are being send to invoice from COMPLETED WORKORDER.ALL work orders are using this option only in Phase -1.
     *
     * WORK ORDER -> COMPLETED WORK ORDER -> Create Invoice
     */
    public function updateVesselComment()
    {
        $vessel = $_POST['vessel'];
        $comment = $_POST['comment'];
        $this->customer_model->update_vessel_comment($vessel, $comment);
    }
    /*
     * INVOICE STARTS HERE
     */
    public function send_invoices()
    {
        $this->load->helper("url");
        $this->load->view('templates/header');
        $this->load->view('customer/send_invoices');
        $this->load->view('templates/footer');
    }
    // Diver commission
    public function diver_commission()
    {
        $this->load->helper("url");
        $this->load->helper('html');
        $data['options'] = $this->customer_model->get_diver();
        $data['diver_deduction'] = $this->customer_model->get_diver_deductions();
        $this->load->view('templates/header');
        
        $this->load->view('customer/diver_commission', $data);
        $this->load->view('templates/footer');
    }

    public function create_invoice_from_wo($customer = null, $diver = null, $date = null, $dual = null)
    {
        $this->load->helper('url');
        $data['diver'] = '';
        $data['date'] = '';
        $data['user'] = '';
        $data['dual'] = '';
        
        if (is_numeric($customer)) {
            $data['invoices'] = $this->customer_model->get_complete_wo_for_invoice($customer);
            $data['user'] = $customer;
        } else {
            
            if (is_null($customer)) {
                $data['invoices'] = $this->customer_model->get_complete_wo_for_invoice();
                $data['user'] = 'nouser';
            }
            if ($customer == 'diver') {
                $data['invoices'] = $this->customer_model->get_complete_wo_for_invoice($customer, $diver);
                $data['user'] = $customer;
                $data['diver'] = $diver;
            }
            if ($customer == 'date') {
                $diver = $this->date_format_db($diver);
                $date = $this->date_format_db($date);
                $data['invoices'] = $this->customer_model->get_complete_wo_for_invoice($customer, $diver, $date);
                $data['user'] = $customer;
                $data['diver'] = $this->date_format_us($diver);
                $data['date'] = $this->date_format_us($date);
            }
            if ($customer == 'dual') {
                $date = $this->date_format_db($date);
                $dual = $this->date_format_db($dual);
                
                $data['invoices'] = $this->customer_model->get_complete_wo_for_invoice($customer, $diver, $date, $dual);
                $data['user'] = $customer;
                $data['diver'] = $diver;
                $data['date'] = $this->date_format_us($date);
                $data['dual'] = $this->date_format_us($dual);
            }
        }
        $data['alldivers'] = $this->customer_model->get_diver_name();
        
        // diver name and date range filter.
        
        // diver
        if ($this->input->post("diving") == 'yes') {
            $diver = $this->input->post("id_diver");
            redirect('/customer/create_invoice_from_wo/diver/' . $diver, 'refresh');
        }
        // data range
        if ($this->input->post("daterange") == 'yes') {
            $diver = $this->date_format_db($this->input->post("datefrom"));
            $date = $this->date_format_db($this->input->post("dateto"));
            redirect('/customer/create_invoice_from_wo/date/' . $diver . '/' . $date, 'refresh');
        }
        if ($this->input->post("dual") == 'yes') {
            $diver = $this->input->post("who");
            $date = $this->date_format_db($this->input->post("start"));
            $dual = $this->date_format_db($this->input->post("end"));
            redirect('/customer/create_invoice_from_wo/dual/' . $diver . '/' . $date . '/' . $dual, 'refresh');
        }
        
        $this->load->view('templates/header');
        $this->load->view('customer/create_invoice_from_wo', $data);
        $this->load->view('templates/footer');
    }

    /**
     * HOME ->INVOICING->View Invoice/Print Individual Invoices.
     *
     * @param unknown $invoices
     *            : Array of invoice Primary key;
     *            Will display the invoices like the desktop system, where we can choose the invoice to view.
     */
    public function displayAllInvoices($invoices)
    {
        $this->load->helper('url');
        $this->load->helper('html');
        $invoices = urldecode($invoices);
        $invoice = explode("^", $invoices);
        $data['invoices'] = $invoice;
        $this->load->view('templates/header');
        $this->load->view('customer/invoice_banner');
        $this->load->view('customer/displayAllInvoices', $data);
        $this->load->view('templates/footer');
    }
    // monthly invoices listing
    public function displayMonthlyInvoices($from, $to)
    {
        $data['from'] = $this->date_format_db(str_replace("^", "/", urldecode($from)));
        $data['to'] = $this->date_format_db(str_replace("^", "/", urldecode($to)));
        $this->load->helper('url');
        $this->load->helper('html');
        $current = 0;
        $query = null;
        $this->load->helper(array(
            'dompdf',
            'file'
        ));
        $data['current'] = $current;
        $data['balances'] = $this->customer_model->get_monthly_invoices_list($current, 32, $query, $data);
        $data['amountrecd'] = $this->customer_model->get_monthly_amountrecd_list($current, 32, $query, $data);
        if ($this->input->post('submitted') == 'pagepdf') {
            $data['balances'] = $this->customer_model->get_monthly_invoices_list($current, 32, $query, $data);
            $html = $this->load->view('customer/monthly_invoices', $data, true);
            pdf_create($html, 'monthly_invoices');
        }
        
        $this->load->view('templates/header');
        $this->load->view('customer/monthlyInv_banner');
        $this->load->view('customer/displayMonthlyInvoices', $data);
        $this->load->view('templates/footer');
    }

    /**
     *
     * @param unknown $invoice
     *            : Primary key of the Invoice
     * @param string $pdf
     *            : Invoice Primary key; Only for individual invoices
     */
    public function invoice_pdf($invoice, $pdf = null)
    {
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->helper(array(
            'dompdf',
            'file'
        ));
        $data['company'] = $this->customer_model->get_company_details();
        $data['message'] = $this->customer_model->get_custom_message_invoice();
        $data['invoice'] = $this->customer_model->get_invoice_details($invoice);
        $data['worked'] = $this->customer_model->get_work_order_invoice($invoice);
        $data['paint'] = $this->customer_model->get_options_paint();
        if (! is_null($pdf)) {
            $html = $this->load->view('customer/invoice_pdf', $data, true);
            pdf_create($html, 'invoice_' . $pdf);
        } else {
            $this->load->view('templates/header');
            $this->load->view('customer/invoice_pdf', $data);
        }
    }

    /**
     *
     * @param unknown $invoice
     *            : Primary key of the Invoice
     *            Save the document in server
     */
    public function invoice_pdf_here($invoice)
    {
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->helper(array(
            'dompdf',
            'file'
        ));
        $this->load->helper('file');
        
        $data['company'] = $this->customer_model->get_company_details();
        $data['message'] = $this->customer_model->get_custom_message_invoice();
        $data['invoice'] = $this->customer_model->get_invoice_details($invoice);
        $data['worked'] = $this->customer_model->get_work_order_invoice($invoice);
        $data['paint'] = $this->customer_model->get_options_paint();
        $html = $this->load->view('customer/invoice_pdf', $data, true);
        $data = pdf_create($html, '', false);
        write_file('invoice/Invoice_' . $invoice . '.pdf', $data);
    }

    /**
     *
     * @param unknown $invoice
     *            : Priamry key of the Invoice Document
     * @return html page for the processing of the pdf doc.
     */
    public function invoice_pdf_bulk($invoice)
    {
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->helper(array(
            'dompdf',
            'file'
        ));
        $data['company'] = $this->customer_model->get_company_details();
        $data['message'] = $this->customer_model->get_custom_message_invoice();
        $data['invoice'] = $this->customer_model->get_invoice_details($invoice);
        $data['worked'] = $this->customer_model->get_work_order_invoice($invoice);
        $data['paint'] = $this->customer_model->get_options_paint();
        
        $html = $this->load->view('customer/invoice_pdf', $data, true);
        return $html;
    }
    /*
     * INTERNAL SETUP STARTS HERE
     */
    /**
     * HOME->INTERNAL SETUP->ANODES
     * Generates the view
     */
    public function create_modify_anodes()
    {
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->view('templates/header');
        $this->load->view('customer/create_modify_anodes');
        $this->load->view('templates/footer');
    }
	/**
     * HOME->INTERNAL SETUP->SERVICES
     * Generates the view
     */
    public function create_modify_cleaning()
    {
        $this->load->helper('url');
        $this->load->helper('html');
        $data['clean'] = $this->customer_model->get_hull_clean_type();
        $this->load->view('templates/header');
        $this->load->view('customer/create_modify_cleaning', $data);
        $this->load->view('templates/footer');
    }

    /**
     * HOME->INTERNAL SETUP->OPTIONS
     * Generates the view
     */
    public function create_modify_options()
    {
        $this->load->helper('url');
        $this->load->helper('html');
        $data['options'] = $this->customer_model->get_general_options();
        $this->load->view('templates/header');
        $this->load->view('customer/create_modify_options', $data);
        $this->load->view('templates/footer');
    }
    
    // Payments- Reports----------
    public function payment_reports()
    {
        $this->load->helper('url');
        $this->load->helper('html');
        // $data['options'] = $this->customer_model->get_payment_details();
        $this->load->view('templates/header');
        $this->load->view('customer/payment_reports');
        $this->load->view('templates/footer');
    }

    /**
     * HOME->INTERNAL SETUP->DIVERS
     * Generates the view
     */
    public function create_modify_diver()
    {
        $this->load->helper('url');
        $this->load->helper('html');
        $data['diver'] = $this->customer_model->get_diver_details();
        $this->load->view('templates/header');
        $this->load->view('customer/create_modify_diver', $data);
        $this->load->view('templates/footer');
    }

    /**
     * HOME->INTERNAL SETUP->CUSTOM INVOICING
     * Generates the view
     * ALLOW TO CHANGE THE INVOICE CONTENTS.
     */
    public function create_modify_invoicing()
    {
        $this->load->helper('url');
        $this->load->helper('html');
        $data['invoice'] = $this->customer_model->get_custom_message_invoice();
        $this->load->view('templates/header');
        $this->load->view('customer/create_modify_invoicing', $data);
        $this->load->view('templates/footer');
    }

    /**
     * HOME->INTERNAL SETUP->EMAIL TEXT
     * Generates the view
     * ALLOWS TO CHANGE THE EMAIL TEXT
     */
    public function create_modify_email()
    {
        $this->load->helper('url');
        $this->load->helper('html');
        $data['mail'] = $this->customer_model->get_email_fillup();
        $this->load->view('templates/header');
        $this->load->view('customer/create_modify_email', $data);
        $this->load->view('templates/footer');
    }
	/**
     * HOME->EXTRA->Manage MWO
	 */
	public function create_modify_mwos()
    {
        $this->load->helper ( 'url' );
        $this->load->helper ( 'html' );
        $this->load->view ( 'templates/header' );
        $this->load->view ( 'customer/create_modify_mwos');
        $this->load->view ( 'templates/footer' );
    }
    
    /**
     * HOME->EXTRA->CUSTOMERS WITH BOW
     *
     * @param number $current:
     *            CURRENT ELEMENT
     * @param string $query
     *            : SEARCH QUERY
     */
    public function customer_bowaft($current = 0, $query = null)
    {
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->helper(array(
            'dompdf',
            'file'
        ));
        $data['current'] = $current;
        $data['balances'] = $this->customer_model->get_customer_bowaft($current, 32, $query);
        $data['total'] = $this->customer_model->get_customer_bowaft_nolimit();
        
        if ($this->input->post('submitted') == 'pagepdf') {
            $data['balances'] = $this->customer_model->get_customer_bowaft_nolimit();
            $html = $this->load->view('customer/customer_bowaftpdf', $data, true);
            pdf_create($html, 'customers_bowaft');
        }
        if ($this->input->post('submitted') == 'pagethis') {
            $data['balances'] = $this->customer_model->get_customer_bowaft($current);
            $html = $this->load->view('customer/customer_bowaftpdf', $data, true);
            pdf_create($html, 'customers_bowaft');
        }
        if ($this->input->post('submitted') == 'pagenext') {
            if ($this->input->post('current') == 0) {
                $current = 32;
            } else {
                $current = $current + 32;
            }
            redirect('/customer/customer_bowaft/' . $current . '/' . $query, 'refresh');
        }
        if ($this->input->post('submitted') == 'pageback') {
            if ($this->input->post('current') == 0) {
                $current = 0;
            } else {
                $current = $current - 32;
            }
            redirect('/customer/customer_bowaft/' . $current . '/' . $query, 'refresh');
        }
        
        $this->load->view('templates/header');
        $this->load->view('customer/pdf_banner', $data);
        $this->load->view('customer/customer_bowaft', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Internal Function for management of SESSION
     */
    public function customer_session()
    {
        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->library('form_validation');
        
        $this->load->view('templates/header');
        
        $this->load->view('customer/customer_session');
        $this->load->view('templates/footer');
        $this->form_validation->set_rules('worker', 'worker', 'required');
        if ($this->form_validation->run() === FALSE) {} else {
            $this->load->helper('url');
            // $this->session->sess_destroy ();
            $a = array(
                "session_id",
                "ip_address",
                "user_agent",
                "last_activity",
                "user_data",
                "administrator",
                "logger"
            )
            ;
            
            foreach (array_keys($this->session->userdata) as $key) {
                
                if (array_search($key, $a) === FALSE) {
                    $this->session->unset_userdata($key);
                }
            }
            // redirect ( '', 'refresh' );
            echo '<script>this.window.close();</script>';
        }
    }

    /**
     * Redirection at the end of the registration/modification of the customer is being carried out.
     */
    public function customer_redirect()
    {
        $this->load->helper('html');
        $this->load->helper('url');
        
        /*
         * inactive customer redirect to home page.else to work order.
         */
        if ($this->session->userdata('status') != 'ACTIVE' && $this->session->userdata('modify') == true) {
            echo '<script>
          alert("Unable to Create Work Order for Inactive Customer.");
          window.location="' . base_url() . 'index.php/customer/customer_session";</script>';
        } else {
            if ($this->session->userdata('primary') == true && $this->session->userdata('secondary') == true && $this->session->userdata('brandnew') == true) {
                $this->load->view('templates/header');
                
                $this->load->view('customer/customer_redirect');
                $this->load->view('templates/footer');
            } else 
                if ($this->session->userdata('status') == 'ACTIVE' && $this->session->userdata('modify') == true) {
                    $this->load->view('templates/header');
                    
                    $this->load->view('customer/customer_redirect');
                    $this->load->view('templates/footer');
                } else {
                    echo '<script>
              alert("Unable to Create Profile with incomplete data.");
              window.location="' . base_url() . 'index.php/customer/customer_session"; </script>';
                }
        }
    }

    /**
     *
     * @param unknown $date
     *            : input string for checking whether it's a date or not
     * @return boolean: true|false
     */
    public function date_check($date)
    {
        if ($date != '') {
            $date = $this->date_format_db($date);
            if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date)) {
                $test_arr = explode('-', $date); // 2014-01-31
                if (checkdate($test_arr[1], $test_arr[2], $test_arr[0])) {
                    return true;
                } else {
                    $this->form_validation->set_message('date_check', 'The %s field should be a real date');
                    return false;
                }
            } else {
                $this->form_validation->set_message('date_check', 'The %s field should be a real date');
                return false;
            }
        } else {
            return true;
        }
    }

    /**
     *
     * @param unknown $email
     *            : input string read as email
     * @return boolean : true|false
     */
    public function email_check($email)
    {
        if ($email != '') {
            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->form_validation->set_message('email_check', 'The %s field should be valid email ID');
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    /**
     *
     * @param unknown $zip_fax
     *            : input read as zip/fax number
     * @return boolean : true|false
     */
    public function zip_fax($zip_fax)
    {
        if ($zip_fax != '') {
            if (is_numeric($zip_fax) && strlen($zip_fax) >= 5) {
                return true;
            } else {
                $this->form_validation->set_message('zip_fax', 'The %s field should be a number');
                return false;
            }
        } else {
            return true;
        }
    }

    /**
     *
     * @param unknown $number
     *            : input read as Phone number
     * @return boolean : true|false
     */
    public function phone_number_check($number)
    {
        if ($number != '') {
            if (! preg_match('/^\(?(\d{3})\)?[-\. ]?(\d{3})[-\. ]?(\d{4})$/', $number)) {
                $this->form_validation->set_message('phone_number_check', 'The %s field should be a number');
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    /**
     *
     * @param unknown $mode
     *            : Bill Mode of the customer
     * @return boolean :true|false
     */
    public function bill_mode_email_check($mode)
    {
        $email = $this->input->post('email');
        if ($mode == 'EMAIL' || $mode == 'US MAIL & EMAIL' || $mode == 'CREDIT CARD & EMAIL') {
            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->form_validation->set_message('bill_mode_email_check', 'Your Bill Mode need a valid Email ID ');
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    /**
     *
     * @param unknown $mails
     *            :email id
     * @return boolean true|false
     */
    public function email_check_twice($mails)
    {
        $mail = explode(",", $mails);
        foreach ($mail as $v) {
            if ($v != '') {
                if (! filter_var($v, FILTER_VALIDATE_EMAIL)) {
                    $this->form_validation->set_message('email_check_twice', 'The %s field should be valid email ID');
                    return false;
                } else {
                    return true;
                }
            } else {
                
                return true;
            }
        }
    }
    /*
     * ajax functions starts from here..
     */
    /**
     * CUSTOMER->OUTSTANDING BALANCE
     *
     * @param unknown $qry
     *            : search query.
     */
    public function ajax_balance_search($qry)
    {
        $data['balances'] = $this->customer_model->get_outstanding_balance_list(0, 100, $qry);
        $temp = '
        <h2 style="width:100%;text-align:center;padding-top:15px;">OUTSTANDING BALANCE REPORT</h2>
        <table style="text-align:center;border:none;white-space: nowrap;margin:0px auto;">
        <tr><td style="border:none;text-align: right;width:100%;line-height:2px;" colspan="6"><h4 style="border:none;text-align: right;width:100%;">' . date("F  d, Y") . '</h4></td></tr>
        <tr><th style="text-align:left;padding:0 5px;">ACCOUNT NO</th><th style="text-align:left;padding:0 5px;">CUSTOMER</th><th style="text-align:left;padding:0 5px;">VESSEL</th><th style="text-align:right;padding:0 5px;">DEBIT</th><th style="text-align:right;padding:0 5px;">CREDIT</th><th  style="text-align:right;padding:0 5px;">BALANCE</th></tr>
';
        
        foreach ($data['balances'] as $balance) :
            $temp = $temp . '<tr><td style="border:none;text-align:left;width:auto;padding:0 5px;">' . $balance->ACCOUNT_NO . '</td>
        <td style="border:none;text-align:left;width:auto;padding:0 5px;">' . $balance->FIRST_NAME . ' ' . $balance->LAST_NAME . '</td>
        <td style="border:none;text-align:left;width:auto;padding:0 5px;">' . $balance->VESSEL_NAME . '</td>
        <td style="border:none;text-align:right;width:auto;padding:0 5px;">' . $balance->DEBIT . '</td>
        <td style="border:none;text-align:right;width:auto;padding:0 5px;">' . $balance->CREDIT . '</td>
        <td style="border:none;text-align:right;width:auto;padding:0 5px;">' . $balance->BALANCE . '</td></tr>';
        endforeach
        ;
        echo $temp;
    }
    // ajax search list invoice
    public function ajax_list_invoice_search($from, $to, $current, $perpage, $query)
    {
        $from = $this->date_format_db($from);
        $to = $this->date_format_db($to);
        $data['invoice_list'] = $this->customer_model->get_list_invoices_list($from, $to, $current, $perpage, $query);
        $temp = '
    <div style="background-color: white;color:black;width:66%;margin:0% auto;text-align: center;" id="balanceout">
<h2 style="width:100%;text-align:left;padding-top:15px;">B.T.W Dive Service </h2>
<h2 style="width:100%;text-align:center;padding-top:5px;">Monthly Invoice Report </h2>
<h2 style="width:100%;text-align:center;padding-top:5px;"> ' . $from . ' To ' . $to . '  </h2>
<p style="text-align: left;width:100%;">' . date("m/ d/Y") . '<p>
<table style="text-align:center;border:none;white-space: nowrap;margin:0px auto;">
<tr>
<td style="border:none;text-align: right;width:100%;line-height:2px;" colspan="6">
</td></tr>
<tr><th style="text-align:left;padding:0 5px;">Customer Name</th>
<th style="text-align:left;padding:0 5px;">Invoice Number</th>
<th style="text-align:left;padding:0 5px;">Invoice Date</th>
<th style="text-align:right;padding:0 5px;">List Price Value</th>
<th style="text-align:right;padding:0 5px;">Invoiced Value</th>
</tr> ';
        
        foreach ($data['invoice_list'] as $balance) :
            $temp = $temp . '<tr>
    <td style="border:none;text-align:left;width:auto;padding:0 5px;">' . $balance->CUSTOMER_NAME . '</td>
    <td style="border:none;text-align:left;width:auto;padding:0 5px;">' . $balance->PK_INVOICE . '</td>
    <td style="border:none;text-align:left;width:auto;padding:0 5px;">' . $balance->INVOICE_DATE . '</td>
    <td style="border:none;text-align:right;width:auto;padding:0 5px;">' . $balance->LP_AMOUNT_INVOICED . '</td>
    <td style="border:none;text-align:right;width:auto;padding:0 5px;">' . $balance->NET_AMOUNT_INVOICED . '</td>
    </tr>';
        endforeach
        ;
        $temp = $temp . '</table></div>';
        echo $temp;
    }
    // ajax diver commision search
    public function ajax_diver_commi_search($diverid, $from, $to, $current, $perpage, $query)
    {
        $from = $this->date_format_db($from);
        $to = $this->date_format_db($to);
        $data['divercomm_list'] = $this->customer_model->get_diver_commission_list($diverid, $from, $to, $current, $perpage, $query);
        $data['diverdetails'] = $this->customer_model->get_diver_name_fromid($diverid);
        $temp = '
    <div style="background-color: white;color:black;font-size:12px;width:66%;margin:0% auto;text-align: center;" id="balanceout">
<h2 style="width:100%;text-align:left;padding-top:15px;">B.T.W Dive Service </h2>
<h2 style="width:100%;text-align:center;padding-top:5px;">Commission Report </h2>
<h2 style="width:100%;text-align:center;padding-top:5px;"> Date Range From' . $from . ' To ' . $to . '  </h2>
<table style="text-align:center;border:none;white-space: nowrap;margin:0px auto;">
<tr>
<td style="border:none;text-align: right;width:100%;line-height:2px;" colspan="6">
</td></tr>
<tr><th style="text-align:left;padding:0 1px;">VESSEL NAME</th>
<th style="text-align:left;padding:0 1px;">LOCATION</th>
<th style="text-align:left;padding:0 1px;">WORK TYPE</th>
<th style="text-align:right;padding:0 1px;">WORK ORDER</th>
<th style="text-align:right;padding:0 1px;">SCH DATE</th>
<th style="text-align:left;padding:0 1px;">COUT</th>
<th style="text-align:right;padding:0 1px;">RATE</th>
<th style="text-align:right;padding:0 1px;">COMMISSION</th></tr> ';
        
        foreach ($data['divercomm_list'] as $divercom) :
            $temp = $temp . '<tr>
    <td style="border:none;text-align:left;width:auto;padding:0 1px;">' . $divercom->vessel_name . '</td>
    <td style="border:none;text-align:left;width:auto;padding:0 1px;">' . $divercom->location . '</td>
    <td style="border:none;text-align:left;width:auto;padding:0 1px;">' . $divercom->work_type . '</td>
    <td style="border:none;text-align:right;width:auto;padding:0 1px;">' . $divercom->wo_number . '</td>
    <td style="border:none;text-align:right;width:auto;padding:0 1px;">' . $divercom->schedule_date . '</td>
        <td style="border:none;text-align:left;width:auto;padding:0 1px;">' . $divercom->scount . '</td>
    <td style="border:none;text-align:right;width:auto;padding:0 1px;">' . $divercom->commission_rate . '%</td>
    <td style="border:none;text-align:right;width:auto;padding:0 1px;">' . $divercom->discount . ' &nbsp;&nbsp;' . $divercom->commission_amount . '</td></tr>';
        endforeach
        ;
        $temp = $temp . '</table></div>';
        echo $temp;
    }

    /**
     * HOME -> EXTRA ->CUSTOMERS WITH BOW
     * 
     * @param unknown $qry
     *            : search query
     */
    public function ajax_bowaft_search($qry)
    {
        $data['customers'] = $this->customer_model->get_customer_bowaft(0, 32, $qry);
        $temp = '<h2 style="width:100%;text-align:center;padding-top:15px;">List of Customers With Bow/Aft Service</h2>
<table style="text-align:center;border:none;white-space: nowrap;margin:0px auto;">
<tr><td style="border:none;text-align: right;width:100%;line-height:2px;" colspan="3"><h4 style="border:none;text-align: right;width:100%;">' . date("F  d, Y") . '</h4></td></tr>
<tr><th style="text-align:left;padding:0 5px;">Customer Name</th><th style="text-align:left;padding:0 5px;">Vessel</th><th style="text-align:left;padding:0 5px;">Location</th></tr>
    ';
        foreach ($data['customers'] as $balance) :
            $temp = $temp . '<tr>
<td style="border:none;text-align:left;width:auto;padding:0 5px;">' . $balance->FIRST_NAME . ' ' . $balance->LAST_NAME . '</td>
<td style="border:none;text-align:left;width:auto;padding:0 5px;">' . $balance->VESSEL_NAME . '</td>
<td style="border:none;text-align:left;width:auto;padding:0 5px;">' . $balance->LOCATION . ' &nbsp; ' . $balance->SLIP . '</td></tr>';
        endforeach
        ;
        echo $temp;
    }

    /**
     * Searched document are printed from here...
     * 
     * @param string $num:
     *            number for identify the type of the doc.
     */
    public function searched_pdf($num = null)
    {
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->helper(array(
            'dompdf',
            'file'
        ));
        $html = $_POST['data'];
        if (is_null($num)) {
            pdf_create($html, 'outstanding_balance_report');
        } else 
            if ($num == 1) {
                pdf_create($html, 'customer_bowaft');
            } else {
                pdf_create($html, 'list_invoice');
            }
    }

    /**
     */
    function show_popup()
    {
        echo "Y";
    }

    function show_popupnow($k)
    { // $k = $this->input->post('data');
        echo urldecode($k);
    }

    /**
     * HOME->NEW/MODIFY CUSTOMER->ANODES
     *
     * @param unknown $string:
     *            Search query input string.
     */
    function screenSearchResults($string)
    {
        $temp = "";
        $string = urldecode($string);
        $data['results'] = $this->customer_model->get_search_results($string);
        foreach ($data['results'] as $values) {
            if (empty($temp)) {
                $temp = $values->PK_ANODE . "|" . $values->ANODE_TYPE . "|" . $values->DESCRIPTION . "|" . $values->RATE . "|" . $values->SCHEDULE_CHANGE;
            } else {
                $temp = $temp . "!" . $values->PK_ANODE . "|" . $values->ANODE_TYPE . "|" . $values->DESCRIPTION . "|" . $values->RATE . "|" . $values->SCHEDULE_CHANGE;
            }
        }
        echo $temp;
    }

    /**
     * HOME->NEW/MODIFY CUSTOMER->ANODES
     * Display the features of the selected anode.
     * 
     * @param unknown $anode
     *            : primary key anode-table anodes
     */
    function getAnodeDetails($anode)
    {
        $data['anode_details'] = $this->customer_model->get_anode_property($anode);
        foreach ($data['anode_details'] as $values) {
            $temp = $values->PK_ANODE . "|" . $values->ANODE_TYPE . "|" . $values->DESCRIPTION . "|" . $values->RATE . "|" . $values->SCHEDULE_CHANGE;
        }
        echo $temp;
    }

    /**
     * HOME->NEW/MODIFY CUSTOMER->ANODES
     * Get the details of the added anodes
     * 
     * @param unknown $anode            
     */
    function getAnodeDetailsFromVessel($anode)
    {
        $data['anode_details'] = $this->customer_model->get_anode_property_from_vessel($anode);
        foreach ($data['anode_details'] as $values) {
            $temp = $anode . "|" . $values->ANODE_TYPE . "|" . $values->DESCRIPTION . "|" . $values->LIST_PRICE . "|" . $values->SCHEDULE_CHANGE . "|" . $values->DISCOUNT_PRICE . "|" . $values->DISCOUNT . "|";
            if ($values->ADDFIELD1 == '0000-00-00' || $values->ADDFIELD1 == '1969-12-31') {
                $temp .= '';
            } else {
                $temp .= $this->date_format_us($values->ADDFIELD1);
            }
        }
        echo $temp;
    }

    /**
     * Fill the summer and winter service fields .
     *
     * @param unknown $service
     *            : string SERVICE NAME.
     */
    function ajaxWinterUpdate($service)
    {
        $summer_data = array();
        $services = rawurldecode(urldecode($service));
        $data['services'] = $this->customer_model->get_hullclean_data($services);
        foreach ($data['services'] as $value) {
            $temp = $value->SERVICE_NAME . "|" . $value->F_DESCRIPTION . "|" . $value->S_DESCRIPTION . "|" . $value->F_RATE . "|" . $value->S_RATE;
        }
        echo $temp;
    }

    /**
     * Populate the vessel options list
     */
    function fetch_customer()
    {
        $data['types'] = $this->customer_model->get_vessel();
        foreach ($data['types'] as $single_data) {
            echo $single_data->OPTIONS;
        }
    /**
     * vessel_anodes tables are manipulated by here while adding the anode.
     */
    }

    function updateAnodeTable()
    {
        $customer = $_POST['customer'];
        $vessel = $_POST['vessel'];
        $anodeid = $this->session->userdata('anode_number');
        if (empty($anodeid)) {
            $anodeid = $this->input->post('anodes');
        }
        $anodeid ++;
        $anodetype = $_POST['type'];
        $anodedescription = $_POST['description'];
        $anodediscount = $_POST['discount'];
        $anodediscountprice = $_POST['discount_price'];
        $anodelistprice = $_POST['list_price'];
        $anodelastdate = $this->date_format_db($_POST['lastdate']);
        $anodeschedule = $_POST['schedule'];
        $total = $_POST['total'];
        // echo $customer."|".$vessel."|".$anodeid;exit();
        
        for ($i = 0; $i < $total; $i ++) {
            $this->customer_model->update_table_vessel_anode($customer, $vessel, $anodeid, $anodetype, $anodedescription, $anodediscount, $anodediscountprice, $anodelistprice, $anodelastdate, $anodeschedule);
            $anodeid ++;
        }
        
        $this->session->set_userdata('anode_number', $anodeid);
        echo $anodeid;
    }

    /**
     * Update anode table while modify customer
     */
    function updateAnodeTableEdited()
    {
        $customer = $_POST['customer'];
        $vessel = $_POST['vessel'];
        $anodeid = $this->session->userdata('anode_number');
        $anode = $_POST['anodes'];
        $anodetype = $_POST['type'];
        $anodedescription = $_POST['description'];
        $anodediscount = $_POST['discount'];
        $anodediscountprice = $_POST['discount_price'];
        $anodelistprice = $_POST['list_price'];
        $anodelastdate = $this->date_format_db($_POST['lastdate']);
        $anodeschedule = $_POST['schedule'];
        $total = $_POST['total'];
        
        $this->customer_model->update_table_vessel_anode_edited($anode, $anodelastdate, $anodetype, $anodedescription, $anodediscount, $anodediscountprice, $anodelistprice, $anodeschedule);
        if ($total > 1) {
            for ($i = 1; $i < $total; $i ++) {
                
                $this->customer_model->update_table_vessel_anode($customer, $vessel, $anodeid, $anodetype, $anodedescription, $anodediscount, $anodediscountprice, $anodelistprice, $anodelastdate, $anodeschedule);
                $anodeid ++;
            }
        }
        if ($total > 1) {
            $this->session->set_userdata('anode_number', $anodeid);
            echo $anodeid;
        } else {
            echo "Y";
        }
    }

    /**
     * I think it's not used anywhere, but hard to delete/remove
     */
    function getPrimaryKeyAnode()
    {
        $anode = $_POST['anodes'];
        
        echo $anode;
        exit();
        $data['primary'] = $this->customer_model->get_primary_key_from_table($anode);
        print_r($data['primary']);
    }

    /**
     */
    function newItem()
    {
        $data['good'] = $this->customer_model->get_details();
        
        foreach ($data['good'] as $good) {
            echo $good->NUMBERS;
        }
    }

    /**
     * Search result s for the HOME->CUSTOMER->MODIFY CUSTOMER
     * 
     * @param unknown $string
     *            : search query
     */
    function ajaxCusomerListCustomer($string)
    {
        $this->load->helper('url');
        $data['customer'] = $this->customer_model->get_customers_from_db($string, 'ACTIVE');
        $temp = '<table><tr><th>Customer Code</th><th>Name</th><th>Boat Name</th><th>Location</th></tr>';
        foreach ($data['customer'] as $cst) {
            $temp = $temp . '<tr onclick="document.getElementById(&quot;' . $cst->account . '&quot;).click();"><a href="' . base_url() . 'index.php/customer/customer_registration/' . $cst->customer_id . '" target="_blank" id="' . $cst->account . '"></a><td>' . $cst->account . '</td><td>' . $cst->firstname . '&nbsp;' . $cst->lastname . '</td><td>' . $cst->vesselname . '</td><td>' . $cst->location . '&nbsp;' . $cst->slip . '</td></tr>';
        }
        echo $temp;
    }
    // credits get_credits_from_db
    function ajaxCredits($string)
    {
        $this->load->helper('url');
        $data['customer'] = $this->customer_model->get_credits_from_db($string, 'ACTIVE');
        $temp = '<table><tr><th>Customer Code</th><th>Name</th><th>Boat Name</th><th>Location</th></tr>';
        foreach ($data['customer'] as $cst) {
            $temp = $temp . '<tr onclick="document.getElementById(&quot;' . $cst->account . '&quot;).click();"><a href="' . base_url() . 'index.php/customer/credit_payment_details/' . $cst->customer_id . '" target="_blank" id="' . $cst->account . '"></a><td>' . $cst->account . '</td><td>' . $cst->firstname . '&nbsp;' . $cst->lastname . '</td><td>' . $cst->vesselname . '</td><td>' . $cst->location . '&nbsp;' . $cst->slip . '</td></tr>';
        }
        echo $temp;
    }
    /*
     * Function for Listing Customers @ WORKORDER -> ADD NEW WORK ORDER.
     */
    function checkCorrectDate()
    {
        $date = $this->date_format_db($_POST['date']);
        
        if ($date != '') {
            if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date)) {
                $test_arr = explode('-', $date); // 2014-01-31
                if (checkdate($test_arr[1], $test_arr[2], $test_arr[0])) {
                    echo "Y";
                } else {
                    
                    echo "N";
                }
            } else {
                
                echo "N";
            }
        } else {
            echo "N";
        }
    }

    /**
     * HOME->WORK ORDER->ADD NEW WORK ORDER
     * 
     * @param unknown $string
     *            : search query
     */
    function ajaxAddNewWork($string)
    {
        $this->load->helper('url');
        $data['customer'] = $this->customer_model->get_customers_from_db($string, 'ACTIVE');
        $temp = '<table><tr><th>Customer Code</th><th>Name</th><th>Boat Name</th><th>Location</th></tr>';
        foreach ($data['customer'] as $cst) {
            $temp = $temp . '<tr onclick="document.getElementById(&quot;' . $cst->account . '&quot;).click();"><a href="' . base_url() . 'index.php/customer/add_new_work_order/' . $cst->customer_id . '" target="_blank" id="' . $cst->account . '"></a><td>' . $cst->account . '</td><td>' . $cst->firstname . '&nbsp;' . $cst->lastname . '</td><td>' . $cst->vesselname . '</td><td>' . $cst->location . '&nbsp;' . $cst->slip . '</td></tr>';
        }
        echo $temp;
    }

    /**
     * HOME->CUSTOMER->CUSTOMER ACCOUNT
     * 
     * @param unknown $string
     *            : search query
     */
    function ajaxCusomerListAccount($string)
    {
        $this->load->helper('url');
        $data['customer'] = $this->customer_model->get_customers_from_db($string, 'ACTIVE');
        $temp = '<table><tr><th>Customer Code</th><th>Name</th><th>Boat Name</th><th>Location</th></tr>';
        foreach ($data['customer'] as $cst) {
            $temp = $temp . '<tr onclick="document.getElementById(&quot;' . $cst->account . '&quot;).click();"><a href="' . base_url() . 'index.php/customer/customer_account/' . $cst->customer_id . '" target="_blank" id="' . $cst->account . '"></a><td>' . $cst->account . '</td><td>' . $cst->firstname . '&nbsp;' . $cst->lastname . '</td><td>' . $cst->vesselname . '</td><td>' . $cst->location . '&nbsp;' . $cst->slip . '</td></tr>';
        }
        
        echo $temp;
    }

    /**
     * HOME->CUSTOMER->INACTIVE CUSTOMERS
     * 
     * @param unknown $string
     *            : search query
     */
    function ajaxCusomerListInactive($string)
    {
        $this->load->helper('url');
        $data['customer'] = $this->customer_model->get_customers_from_db($string, 'INACTIVE');
        $temp = '<table><tr><th>Customer Code</th><th>Name</th><th>Boat Name</th><th>Location</th></tr>';
        foreach ($data['customer'] as $cst) {
            $temp = $temp . '<tr onclick="document.getElementById(&quot;' . $cst->account . '&quot;).click();"><a href="' . base_url() . 'index.php/customer/customer_registration/' . $cst->customer_id . '" target="_blank" id="' . $cst->account . '"></a><td>' . $cst->account . '</td><td>' . $cst->firstname . '&nbsp;' . $cst->lastname . '</td><td>' . $cst->vesselname . '</td><td>' . $cst->location . '&nbsp;' . $cst->slip . '</td></tr>';
        }
        
        echo $temp;
    }

    /**
     * HOME - >CUSTOMER->WORK HISTORY
     * 
     * @param unknown $string
     *            : search query
     */
    function ajaxCusomerListWork($string)
    {
        $this->load->helper('url');
        $data['customer'] = $this->customer_model->get_customers_from_db($string, 'ACTIVE');
        $temp = '<table><tr><th>Customer Code</th><th>Name</th><th>Boat Name</th><th>Location</th></tr>';
        foreach ($data['customer'] as $cst) {
            $temp = $temp . '<tr onclick="document.getElementById(&quot;' . $cst->account . '&quot;).click();"><a href="' . base_url() . 'index.php/customer/customer_workhistory/' . $cst->customer_id . '" target="_blank" id="' . $cst->account . '"></a><td>' . $cst->account . '</td><td>' . $cst->firstname . '&nbsp;' . $cst->lastname . '</td><td>' . $cst->vesselname . '</td><td>' . $cst->location . '&nbsp;' . $cst->slip . '</td></tr>';
        }
        
        echo $temp;
    }

    /**
     * HOME ->CUSTOMER->CUSTOMER ACCOUNT
     * WHEN CLICK ON THE ROW
     * 
     * @param unknown $ledger:primary
     *            key of the ledger table for the row
     */
    function get_ledger_details($ledger)
    {
        $data['ledger'] = $this->customer_model->get_ledger_from_db($ledger);
        foreach ($data['ledger'] as $ledger) {
            $temp = $ledger->INVOICE_NO . "|" . $ledger->TRANSACTION_DATE . "|" . $ledger->CHECK_NO . "|" . $this->date_format_us($ledger->CHECK_DATE) . "|" . $ledger->DEBIT . "|" . $ledger->CREDIT . "|" . $ledger->PK_LEDGER;
        }
        echo $temp;
    }

    /**
     * HOME ->CUSTOMER->CUSTOMER ACCOUNT
     * UPDATE THE CHANGES
     */
    function update_ledger_table()
    {
        $ledgerkey = $_REQUEST['ledgerkey'];
        $checkno = $_REQUEST['checkno'];
        $checkdate = $this->date_format_db($_REQUEST['checkdate']);
        $debit = $_REQUEST['debit'];
        $credit = $_REQUEST['credit'];
        
        $this->customer_model->update_general_ledger_account($ledgerkey, $checkno, $checkdate, $debit, $credit);
        echo "Y";
    }

    /**
     * HOME ->CUSTOMER->NEW/MODIFY CUSTOMER->ANODE
     * 
     * @param unknown $pk_vessel_anode
     *            : Primary key of the anode
     */
    function remove_anode_added($pk_vessel_anode)
    {
        $this->customer_model->remove_added_anode($pk_vessel_anode);
        echo "Y";
    }

    /**
     * Remove the row from the HOME->CUSOMER->CUSTOMER ACCOUNT
     */
    function remove_ledger_table_row()
    {
        $deleteid = $_REQUEST['ledgerkey'];
        $this->customer_model->remove_account_row_from_general_ledger($deleteid);
        echo "Y";
    }

    /**
     *
     * @param unknown $detaone            
     * @param unknown $detatwo            
     */
    public function getPrimaryKeyAnodes($detaone, $detatwo)
    {
        $data['primary'] = $this->customer_model->get_primary_key_from_table($detaone, $detatwo);
        foreach ($data['primary'] as $key) {
            echo $key;
        }
    }

    /**
     * Search when click on the CUSTOMER->CLEANING WOR ORDER.
     * 
     * @param unknown $string
     *            : search query
     */
    public function ajaxCleaningWork($string)
    {
        $this->load->helper('url');
        $data['cleaning'] = $this->customer_model->get_cleaning_wo_from_db($string);
        $temp = '<table style="white-space:nowrap;"><tr><th>Type</th><th>Work Order #</th><th>Name</th><th>Boat Name</th><th>Location</th></tr>';
        foreach ($data['cleaning'] as $cst) {
            if ($cst->INVOICE_SUB == 1) {
                $col = 'line-through';
            } else {
                $col = 'none';
            }
            
            $temp = $temp . '<tr style="text-decoration:' . $col . '" onclick="document.getElementById(&quot;' . $cst->WK . '&quot;).click();"><a href="' . base_url() . 'index.php/customer/cleaning_work_order/' . $cst->WK . '" target="_blank" id="' . $cst->WK . '"></a>
        <td>Clean</td>
        <td>' . $cst->R . '</td>
        <td>' . $cst->F . '&nbsp;' . $cst->L . '</td>
        <td>' . $cst->V . '</td>
        <td>' . $cst->O . '&nbsp;' . $cst->SL . '</tr>';
        }
        echo $temp;
    }

    /**
     * Search for WORK ORDER->ANODE WORK
     * 
     * @param unknown $string
     *            : search query
     */
    public function ajaxAnodeWork($string)
    {
        $this->load->helper('url');
        
        $data['cleaning'] = $this->customer_model->get_anode_wo_from_db($string);
        $temp = '<table><tr><th>Type</th><th>Work Order #</th><th>Name</th><th>Boat Name</th><th>Location</th></tr>';
        foreach ($data['cleaning'] as $cst) {
            $temp = $temp . '<tr onclick="document.getElementById(&quot;' . $cst->WK . '&quot;).click();"><a href="' . base_url() . 'index.php/customer/anode_work_order/' . $cst->WK . '" target="_blank" id="' . $cst->WK . '"></a>
        <td>Anode</td>
        <td>' . $cst->R . '</td>
        <td>' . $cst->F . '&nbsp;' . $cst->L . '</td>
        <td>' . $cst->V . '</td>
        <td>' . $cst->O . '&nbsp;' . $cst->SL . '</tr>';
        }
        echo $temp;
    }

    /**
     * WORK ORDER->MECHANICAL WORK ORDER
     * 
     * @param unknown $string
     *            : search query
     */
    public function ajaxMechanicalWork($string)
    {
        $this->load->helper('url');
        $data['cleaning'] = $this->customer_model->get_mechanical_wo_from_db($string);
        $temp = '<table><tr><th>Type</th><th>Work Order #</th><th>Name</th><th>Boat Name</th><th>Location</th></tr>';
        foreach ($data['cleaning'] as $cst) {
            $temp = $temp . '<tr onclick="document.getElementById(&quot;' . $cst->WK . '&quot;).click();"><a href="' . base_url() . 'index.php/customer/mechanical_work_order/' . $cst->WK . '" target="_blank" id="' . $cst->WK . '"></a>
        <td>Mech</td>
        <td>' . $cst->R . '</td>
        <td>' . $cst->F . '&nbsp;' . $cst->L . '</td>
        <td>' . $cst->V . '</td>
        <td>' . $cst->O . '&nbsp;' . $cst->SL . '</tr>';
        }
        echo $temp;
    }

    /**
     * WORK ORDER->COMPLETED WORK ORDER
     * 
     * @param unknown $string
     *            : search query
     */
    public function ajaxCompleteWork($string)
    {
        $this->load->helper('url');
        $data['complete'] = $this->customer_model->get_complete_wo_from_db($string);
        $temp = '<table><tr><th>Type</th><th>Work Order #</th><th>Name</th><th>Boat Name</th><th>Location</th></tr>';
        foreach ($data['complete'] as $cst) {
            $temp = $temp . '<tr onclick="document.getElementById(&quot;' . $cst->WK . '&quot;).click();"><a href="' . base_url() . 'index.php/customer/completed_work_order/' . $cst->WK . '" target="_blank" id="' . $cst->WK . '"></a>';
            
            switch ($cst->W) {
                case 'A':
                    $temp = $temp . '<td>Anode</td>';
                    break;
                case 'C':
                    $temp = $temp . '<td>Clean</td>';
                    break;
                case 'M':
                    $temp = $temp . '<td>Mech</td>';
                    break;
                default:
                    break;
            }
            
            $temp = $temp . '<td>' . $cst->R . '</td>
        <td>' . $cst->F . '&nbsp;' . $cst->L . '</td>
        <td>' . $cst->V . '</td>
        <td>' . $cst->O . '&nbsp;' . $cst->SL . '</td></tr>';
        }
        echo $temp;
    }

    /**
     * When the checkbox in completed work order checks
     */
    public function updateWorkOrderforInvoice()
    {
        $status = $_POST['status'];
        $wonum = $_POST['wnumber'];
        
        $this->customer_model->send_wo_invoice($status, $wonum);
        echo 'Y';
    }

    /**
     * INVOICING->PRINT INDIVIDUAL INVOICES
     * 
     * @param unknown $string
     *            : SEArch query
     */
    public function ajaxIndividualInvoices($string)
    {
        $this->load->helper("url");
        $data['invoice'] = $this->customer_model->get_individual_invoices_db($string);
        $temp = '<table><tr><th>Invoice No.</th><th>Name</th><th>Invoice Date</th><th>Amount</th><th>Sent On</th></tr>';
        foreach ($data['invoice'] as $invoice) :
            $temp = $temp . '<tr onclick="document.getElementById(&quot;link' . $invoice->PK_INVOICE . '&quot;).click()">
<a href="' . base_url() . 'index.php/customer/displayAllInvoices/' . $invoice->PK_INVOICE . '" id="link' . $invoice->PK_INVOICE . '" target="_blank"></a>
<td>' . $invoice->PK_INVOICE . '</td><td>' . $invoice->FIRST_NAME . '&nbsp' . $invoice->LAST_NAME . '</td>
<td>' . $this->date_format_us($invoice->INVOICE_DATE) . '</td><td>' . $invoice->NET_AMOUNT_INVOICED . '</td><td>' . $this->date_format_us($invoice->ENTRY_DATE) . '</td></tr>';
        endforeach
        ;
        echo $temp;
    }

    /**
     * EXCLUDED PORTION
     * 
     * @param unknown $string            
     */
    public function ajaxRestoreInvoices($string)
    {
        $this->load->helper("url");
        $data['invoice'] = $this->customer_model->get_restore_invoices_db($string);
        $temp = '<table><tr><th>Invoice No.</th><th>Name</th><th>Invoice Date</th><th>Amount</th><th>Sent On</th></tr>';
        foreach ($data['invoice'] as $invoice) :
            $temp = $temp . '<tr onclick="restoreInvoices(' . $invoice->PK_INVOICE . ')"><a href=""></a>
    <td>' . $invoice->PK_INVOICE . '</td><td>' . $invoice->FIRST_NAME . '&nbsp' . $invoice->LAST_NAME . '</td>
    <td>' . $this->date_format_us($invoice->INVOICE_DATE) . '</td><td>' . $invoice->NET_AMOUNT_INVOICED . '</td><td>' . $this->date_format_us($invoice->ENTRY_DATE) . '</td></tr>';
        endforeach
        ;
        echo $temp;
    }

    /**
     * EXCLUDED PORTION
     * 
     * @param unknown $string            
     */
    public function ajaxVoidInvoices($string)
    {
        $this->load->helper("url");
        $data['invoice'] = $this->customer_model->get_void_invoices_db($string);
        $temp = '<table><tr><th>Invoice No.</th><th>Name</th><th>Invoice Date</th><th>Amount</th><th>Sent On</th></tr>';
        foreach ($data['invoice'] as $invoice) :
            $temp = $temp . '<tr onclick="voidInvoices(' . $invoice->PK_INVOICE . ')"><a href=""></a>
    <td>' . $invoice->PK_INVOICE . '</td><td>' . $invoice->FIRST_NAME . '&nbsp' . $invoice->LAST_NAME . '</td>
    <td>' . $this->date_format_us($invoice->INVOICE_DATE) . '</td><td>' . $invoice->NET_AMOUNT_INVOICED . '</td><td>' . $this->date_format_us($invoice->ENTRY_DATE) . '</td></tr>';
        endforeach
        ;
        echo $temp;
    }

    /**
     * INVOICING->DELETE INVOICE
     * 
     * @param unknown $string
     *            : search query
     */
    public function ajaxDeleteInvoices($string)
    {
        $this->load->helper("url");
        $data['invoice'] = $this->customer_model->get_individual_invoices_db($string);
        $temp = '<table><tr><th>Invoice No.</th><th>Name</th><th>Invoice Date</th><th>Amount</th><th>Sent On</th></tr>';
        foreach ($data['invoice'] as $invoice) :
            $temp = $temp . '<tr onclick="deleteInvoiceNow(' . $invoice->PK_INVOICE . ')"><a href=""></a>
    <td>' . $invoice->PK_INVOICE . '</td><td>' . $invoice->FIRST_NAME . '&nbsp' . $invoice->LAST_NAME . '</td>
    <td>' . $this->date_format_us($invoice->INVOICE_DATE) . '</td><td>' . $invoice->NET_AMOUNT_INVOICED . '</td><td>' . $this->date_format_us($invoice->ENTRY_DATE) . '</td></tr>';
        endforeach
        ;
        echo $temp;
    }

    /**
     * EXTRA ->VOIDED WORK ORDERS
     * 
     * @param unknown $string
     *            : search query
     */
    public function ajaxRestoreWorkOrder($string)
    {
        $this->load->helper("url");
        $data['voidwork'] = $this->customer_model->get_all_void_work_order($string);
        $temp = '<table><tr><th>Type</th><th>Work Order #</th><th>Name(First/Last)</th><th>Boat Name</th><th>Location</th></tr>';
        foreach ($data['voidwork'] as $voidwork) :
            $temp = $temp . '<tr onclick="document.getElementById(&quot;' . $voidwork->WK . '&quot;).click()">';
            switch ($voidwork->W) {
                case 'A':
                    $temp = $temp . '<td>Anode</td><a href="' . base_url() . 'index.php/customer/anode_work_order/' . $voidwork->WK . '" id="' . $voidwork->WK . '" target="_blank"></a>';
                    break;
                case 'C':
                    $temp = $temp . '<td>Clean</td><a href="' . base_url() . 'index.php/customer/cleaning_work_order/' . $voidwork->WK . '" id="' . $voidwork->WK . '" target="_blank"></a>';
                    break;
                case 'M':
                    $temp = $temp . '<td>Mech</td><a href="' . base_url() . 'index.php/customer/mechanical_work_order/' . $voidwork->WK . '" id="' . $voidwork->WK . '" target="_blank"></a>';
                    break;
                default:
                    break;
            }
            
            $temp = $temp . '<td>' . $voidwork->R . '</td><td>' . $voidwork->F . '&nbsp' . $voidwork->L . '</td>
    <td>' . $voidwork->V . '</td><td>' . $voidwork->O . '&nbsp;' . $voidwork->SL . '</td></tr>';
        endforeach
        ;
        echo $temp;
    }

    /**
     * INVOICE ->SEND INVOICES
     *
     * @param unknown $invoice
     *            : PRIMARY KEY OF INVOICE
     */
    public function deleteCurrentInvoice($invoice)
    {
        $this->customer_model->delete_invoice_db($invoice);
        echo "Y";
    }

    /**
     * EXCLUDED PORTION, MAY WORK!
     * 
     * @param unknown $invoice            
     */
    public function restoreCurrentInvoice($invoice)
    {
        $this->customer_model->restore_current_invoice($invoice);
        echo "Y";
    }

    /**
     * EXCLUDED PORTION, MAY WORK!
     * 
     * @param unknown $invoice            
     */
    public function voidCurrentInvoice($invoice)
    {
        $this->customer_model->void_current_invoice($invoice);
        echo "Y";
    }

    /**
     * WORK ORDER->ANODE/CLEANING/MECHANICAL WORK ORDER
     * 
     * @param unknown $pkwork:PRIMARY
     *            KEY
     */
    public function voidWorkOrder($pkwork)
    {
        $this->customer_model->void_work_order($pkwork);
        echo 'Y';
    }

    /**
     * WORK ORDER->ANODE/CLEANING/MECHANICAL WORK ORDER
     * 
     * @param unknown $pkwork:PRIMARY
     *            KEY
     */
    public function deleteWorkOrder($pkwork)
    {
        $this->customer_model->delete_work_order($pkwork);
        echo 'Y';
    }

    /**
     * WORK ORDER->ANODE/CLEANING/MECHANICAL WORK ORDER
     * 
     * @param unknown $pkwork:PRIMARY
     *            KEY
     */
    public function completeWorkOrder($pkwork)
    {
        $this->customer_model->update_diver_commission_extra($pkwork);
        
        // $this->customer_model->complete_work_order ( $pkwork );
        // echo 'Y';
    }

    /**
     * WORK ORDER->ANODE/CLEANING/MECHANICAL WORK ORDER
     * wORK ORDER PARTS are updated here
     */
    public function updateWorkOrderParts()
    {
        $price = $_POST['wkprice'];
        $discount = $_POST['wkdiscount'];
        $disprice = $_POST['wkdisprice'];
        $process = $_POST['wkprocess'];
        $type = $_POST['wktype'];
        $description = $_POST['wkdescription'];
        $pk = $_POST['wkpk'];
        if (isset($_POST['flags'])) {
            $flag = $_POST['flags'];
        } else {
            $flag = 0;
        }
        $lastdate = $this->date_format_db($_POST['lastdate']);
        $this->customer_model->update_work_order_parts($pk, $price, $discount, $disprice, $process, $lastdate, $type, $description, $flag);
        echo "Y";
    }

    /**
     * WORK ORDER->ANODE/CLEANING/MECHANICAL WORK ORDER
     * Update workorder details
     */
    public function updateWorkOrder($status = null)
    {
        $pkwork = $_POST['workpk'];
        $comments = $_POST['commentspk'];
        $worknum = $_POST['wonom'];
        if ($comments == '') {
            $comments = null;
        }
        $dated = $this->date_format_db($_POST['date']);
        $diver = $_POST['divers'];
        if ($diver == '') {
            $diver = null;
        }
        $this->customer_model->update_work_order($pkwork, $worknum, $dated, $diver, $comments);
        echo "Y";
    }

    /**
     * WORK ORDER->DAILY WORKORDER
     * Ajax call for populatingthe daily work order
     */
    public function displayDailyWorkOrder()
    {
        $this->load->helper('url');
        $one = $_POST['one'];
        $two = $_POST['two'];
        $srt = $_POST['srt'];
        
        $data['work_order'] = $this->customer_model->get_work_order_incomplete($one, $two, $srt);
        $count = count($data['work_order']);
        $temp = '<table style="width:98%;float:left;text-align: center;padding-left:0px;">';
        foreach ($data['work_order'] as $work) :
            $temp = $temp . '<a href="' . base_url() . 'index.php/customer/customer_workhistory/' . $work->PK_CUSTOMER . '#lastrow" target="_blank" id="' . $work->WO . '"></a>
    <tr onclick="document.getElementById(' . $work->WO . ').click();"  class="' . $work->WC . '">
<td style="width:12%;float:left;text-align: center;padding:0px;border-right:1px solid black;"><input type="checkbox" class="printcheck"  name="printer[]" value="' . $work->WO . '"/></td>
<td style="width:15%;float:left;text-align: left;padding:0px;border-right:1px solid black;">' . $work->WN . '&nbsp;</td>
<td style="width:12%;float:left;text-align: left;padding:0px;border-right:1px solid black;">';
            $work->CS == 1 ? $temp = $temp . 'Yes' : $temp = $temp . 'No';
            $temp = $temp . '&nbsp;</td>
<td style="width:15%;float:left;text-align: left;padding:0px;border-right:1px solid black;">';
            if ($work->WC == 'A') {
                $temp = $temp . 'Anode';
            }
            if ($work->WC == 'M') {
                $temp = $temp . 'Mech';
            }
            if ($work->WC == 'C') {
                $temp = $temp . 'Clean';
            }
            $temp = $temp . '&nbsp;</td>
<td style="width:15%;float:left;text-align: left;padding:0px;border-right:1px solid black;">' . $work->FN . '&nbsp;' . $work->LN . '&nbsp;</td>
<td style="width:15%;float:left;text-align: left;padding:0px;border-right:1px solid black;">' . $work->VN . '&nbsp;</td>
<td style="width:14.2%;float:left;text-align: left;padding:0px;">' . $work->LO . '&nbsp;</td>
</tr>
    ';
        endforeach
        ;
        if ($count == 0) {
            $temp = $temp . '<tr><td colspan="7" style="text-align:center;font-weight:bold;background-color:white;">No Results Found.</td></tr></table><input type="hidden" id="totalcount" value="' . $count . '"/>';
        } else {
            $temp = $temp . '</table><input type="hidden" id="totalcount" value="' . $count . '"/>';
        }
        // $temp = $temp . '</table><input type="hidden" id="totalcount" value="' .
        // $count . '"/>';
        echo $temp;
    }

    /**
     * same with the date change
     */
    public function displayDailyWorkOrderDate()
    {
        $this->load->helper('url');
        $one = $this->date_format_db($_POST['one']);
        $two = $this->date_format_db($_POST['two']);
        $thr = $_POST['thr'];
        $srt = $_POST['srt'];
        $data['work_order'] = $this->customer_model->get_work_order_incomplete_date($one, $two, $thr, $srt);
        $count = count($data['work_order']);
        $temp = '<table style="width:98%;float:left;text-align: center;padding-left:0px;">';
        foreach ($data['work_order'] as $work) :
            $temp = $temp . '<a href="' . base_url() . 'index.php/customer/customer_workhistory/' . $work->PK_CUSTOMER . '#lastrow" target="_blank" id="' . $work->WO . '"></a>
    <tr onclick="document.getElementById(' . $work->WO . ').click();" class="' . $work->WC . '">
    <td style="width:12%;float:left;text-align: center;padding:0px;border-right:1px solid black;"><input type="checkbox" class="printcheck"  name="printer[]" value="' . $work->WO . '"/></td>
    <td style="width:15%;float:left;text-align: left;padding:0px;border-right:1px solid black;">' . $work->WN . '&nbsp;</td>
    <td style="width:12%;float:left;text-align: left;padding:0px;border-right:1px solid black;">';
            $work->CS == 1 ? $temp = $temp . 'Yes' : $temp = $temp . 'No';
            $temp = $temp . '&nbsp;</td>
    <td style="width:15%;float:left;text-align: left;padding:0px;border-right:1px solid black;">';
            if ($work->WC == 'A') {
                $temp = $temp . 'Anode';
            }
            if ($work->WC == 'M') {
                $temp = $temp . 'Mech';
            }
            if ($work->WC == 'C') {
                $temp = $temp . 'Clean';
            }
            $temp = $temp . '&nbsp;</td>
    <td style="width:15%;float:left;text-align: left;padding:0px;border-right:1px solid black;">' . $work->FN . '&nbsp;' . $work->LN . '&nbsp;</td>
    <td style="width:15%;float:left;text-align: left;padding:0px;border-right:1px solid black;">' . $work->VN . '&nbsp;</td>
    <td style="width:14.2%;float:left;text-align: left;padding:0px;">' . $work->LO . '&nbsp;</td>
    </tr>
    ';
        endforeach
        ;
        // $temp = $temp . '</table><input type="hidden" id="totalcount" value="' .
        // $count . '"/>';
        if ($count == 0) {
            $temp = $temp . '<tr><td colspan="7" style="text-align:center;font-weight:bold;background-color:white;">No Results Found.</td></tr></table><input type="hidden" id="totalcount" value="' . $count . '"/>';
        } else {
            $temp = $temp . '</table><input type="hidden" id="totalcount" value="' . $count . '"/>';
        }
        echo $temp;
    }
    /*
     * Insert into work order details to work_order_parts
     */
    public function addWorkOrderParts()
    {
        $pkwork = $_POST['pkwork'];
        $wkname = $_POST['wkname'];
        $wkclass = $_POST['wkclass'];
        $wkprice = $_POST['wkprice'];
        $wkdiscount = $_POST['wkdiscount'];
        $wkdisprice = $_POST['wkdisprice'];
        $wkprocess = $_POST['wkprocess'];
        $wktype = $_POST['wktype'];
        $date = $this->date_format_db($_POST['date']);
        $wkpk = $_POST['wkpk'];
        $desc = $_POST['description'];
        $change = $_POST['changes'];
        $data['workpart'] = $this->customer_model->last_pk_from_work_order_parts();
        $workpart = $data['workpart'][0]->PK_WO_PARTS;
        $workpart ++;
        $this->customer_model->add_new_work_order_parts($pkwork, $wkpk, $wkclass, $wkname, $wktype, $wkprice, $wkdiscount, $wkdisprice, $wkprocess, $change, $date, $desc);
        echo '1';
    }
    /*
     * Insert into work_order as new work order
     */
    public function addWorkOrder()
    {
        $wocustomer = $_POST['wocustomer'];
        $wovessel = $_POST['wovessel'];
        $wonum = $_POST['wonum'];
        $woclass = $_POST['woclass'];
        $date = $this->date_format_db($_POST['date']);
        $divers = $_POST['divers'];
        $comments = $_POST['commentspk'];
        /*
         * $data ['work'] = $this->customer_model->last_pk_from_work_order (); $workid =
         * $data ['work'] [0]->PK_WO; $workid ++;
         */
        $workid = $this->customer_model->add_new_work_order($wocustomer, $wovessel, $wonum, $woclass, $date, $divers, $comments);
        echo $workid ++;
    }

    /**
     * Date shift and convert the value to date
     *
     * @param unknown $dates            
     * @param unknown $days            
     * @param number $status            
     * @return string
     */
    public function changeCleaningDates($dates, $days, $status = 0) // 2013-08-20
    {
        $dates = $this->date_format_db(str_replace("^", "/", urldecode($dates)));
        
        switch ($status) {
            case 0:
                echo $this->date_format_us(date('Y-m-d', strtotime($dates . ' + ' . $days . ' days')));
                break;
            case 1:
                return $this->date_format_us(date('Y-m-d', strtotime($dates . ' + ' . $days . ' days')));
                break;
        }
    }

    /**
     * Latest type of printing the work order
     * 
     * @param string $allpk            
     * @param number $part            
     */
    public function printDocumentTitle($allpk = null, $part = 0)
    {
        if (is_null($allpk)) {
            $allpk = $_POST['pkwo'];
        } else {
            $allpk = urldecode($allpk);
        }
        
        $docpdf = '';
        
        $arrpk = explode("^", $allpk);
        
        $arrpk = array_slice($arrpk, 1);
        $i = 0;
        foreach ($arrpk as $pk) :
            $data['woclass'] = $this->customer_model->clear_work_class($pk);
            $woc = $data['woclass'][0]->WO_CLASS;
            switch ($woc) {
                case 'A':
                    $docpdf = $docpdf . $this->anode_pdf_bulk($pk, 1);
                    break;
                case 'C':
                    $docpdf = $docpdf . $this->cleaning_pdf_bulk($pk, 1);
                    break;
                case 'M':
                    $docpdf = $docpdf . $this->mechanical_pdf_bulk($pk, 1);
                    break;
                default:
                    break;
            }
            $i ++;
            if ($i % 5 == 0) {
                $docpdf .= '<b style="page-break-after: always;"></b>';
            }
        endforeach
        ;
        
        $today = $this->date_format_us(date("Y-m-d"));
        if ($part != 0) {
            pdf_create($docpdf, 'daily_work_order-' . time() . $today . $part);
        } else {
            pdf_create($docpdf, 'daily_work_order-' . time() . $today . $part);
        }
        
        echo '<script>self.close();</script>';
    }

    /**
     * Selected documents will be printed
     * 
     * @param string $allpk            
     * @param number $part            
     */
    public function printDocumentSelected($allpk = null, $part = 0)
    {
        if (is_null($allpk)) {
            $allpk = $_POST['pkwo'];
        } else {
            $allpk = urldecode($allpk);
        }
        
        $docpdf = '';
        
        $arrpk = explode("^", $allpk);
        
        $arrpk = array_slice($arrpk, 1);
        
        foreach ($arrpk as $pk) :
            $data['woclass'] = $this->customer_model->clear_work_class($pk);
            $woc = $data['woclass'][0]->WO_CLASS;
            switch ($woc) {
                case 'A':
                    $docpdf = $docpdf . $this->anode_pdf_bulk($pk);
                    break;
                case 'C':
                    $docpdf = $docpdf . $this->cleaning_pdf_bulk($pk);
                    break;
                case 'M':
                    $docpdf = $docpdf . $this->mechanical_pdf_bulk($pk);
                    break;
                default:
                    break;
            }
        endforeach
        ;
        
        $today = $this->date_format_us(date("Y-m-d"));
        if ($part != 0) {
            pdf_create($docpdf, 'daily_work_order-' . time() . $today . $part);
        } else {
            pdf_create($docpdf, 'daily_work_order-' . time() . $today . $part);
        }
        
        echo '<script>self.close();</script>';
    }

    /**
     *
     * @param unknown $data            
     */
    public function printDocumentIncomplete($data)
    {
        $this->load->helper(array(
            'dompdf',
            'file'
        ));
        
        $today = $this->date_format_us(date("Y-m-d"));
        
        pdf_create($data, 'incomplete_work_order-' . $today);
    }

    /**
     */
    public function printDocumentNow()
    {
        $this->load->helper(array(
            'dompdf',
            'file'
        ));
        $data = $_POST['data'];
        $today = $this->date_format_us(date("Y-m-d"));
        
        pdf_create($data, 'daily_work_order-' . $today);
    }

    /**
     * SEND INVOICE DISPLAY
     */
    public function displaySendInvoice()
    {
        $mode = $_POST['one'];
        
        $data['invoices'] = $this->customer_model->get_invoices_not_send($mode);
        
        $count = count($data['invoices']);
        $temp = '<table style="width:98%;float:left;text-align: center;padding-left:0px;">';
        foreach ($data['invoices'] as $invoice) :
            $temp = $temp . '
    <tr>
    <td style="width:12%;float:left;text-align: center;padding:0px;border-right:1px solid black;">
    <input type="checkbox" class="printcheck"  name="printer[]" value="' . $invoice->PK_INVOICE . '"/></td>
    <td style="width:12%;float:left;text-align: left;padding:0px;border-right:1px solid black;">' . $invoice->PK_INVOICE . '&nbsp;</td>
    <td style="width:12%;float:left;text-align: left;padding:0px;border-right:1px solid black;">' . $this->date_format_us($invoice->INVOICE_DATE) . '&nbsp;</td>
    <td style="width:12%;float:left;text-align: left;padding:0px;border-right:1px solid black;">' . $invoice->DELIVERY_MODE . '&nbsp;</td>
    <td style="width:12%;float:left;text-align: left;padding:0px;border-right:1px solid black;">' . $invoice->FIRST_NAME . '&nbsp;' . $invoice->LAST_NAME . '&nbsp;</td>
    <td style="width:12%;float:left;text-align: left;padding:0px;border-right:1px solid black;">' . $invoice->VESSEL_NAME . '&nbsp;</td>
    <td style="width:12%;float:left;text-align: left;padding:0px;border-right:1px solid black;">' . $invoice->NET_AMOUNT_INVOICED . '&nbsp;</td>
    <td style="width:12%;float:left;text-align: left;padding:0px;">' . $invoice->BALANCE . '&nbsp;</td>
    </tr>
    ';
        endforeach
        ;
        $temp = $temp . '</table><input type="hidden" id="totalcount" value="' . $count . '"/>';
        echo $temp;
    }
    
    // diver Commission
    public function displayDiverCommission()
    {
        $diverid = $_POST['one'];
        $from = $this->date_format_db($_POST['from']);
        $to = $this->date_format_db($_POST['to']);
        
        $data['invoices'] = $this->customer_model->get_diver_full_commission_list($diverid, $from, $to);
        $data['ctotal'] = $this->customer_model->get_total_commission($diverid, $from, $to);
        $data['materials'] = $this->customer_model->get_deduction_commission($diverid, $from, $to);
        
        foreach ($data['ctotal'] as $commi) :
            $c = $commi->comtotal;
        endforeach
        ;
        foreach ($data['materials'] as $material) :
            $deduction = $material->deductions;
        endforeach
        ;
        $temp = '<table style="width:99%;float:left;text-align: center;padding-left:0px;">';
        foreach ($data['invoices'] as $invoice) :
            $temp = $temp . '
	<tr onclick="popup(' . "'$invoice->pk_diver_trans'" . ')" style="cursor: pointer;">
	<td style="width:20%;float:left;text-align: left;padding:0px;border-right:1px solid black;">' . $invoice->vessel_name . '&nbsp;</td>
	<td style="width:15%;float:left;text-align: left;padding:0px;border-right:1px solid black;">' . $invoice->location . '&nbsp;</td>
	<td style="width:15%;float:left;text-align: left;padding:0px;border-right:1px solid black;">' . $invoice->work_type . '&nbsp;</td>
	<td style="width:20%;float:left;text-align: left;padding:0px;border-right:1px solid black;">' . $invoice->wo_number . '&nbsp;</td>
	<td style="width:15%;float:left;text-align: left;padding:0px;border-right:1px solid black;">' . $this->date_format_us($invoice->schedule_date) . '&nbsp;</td>
	<td style="width:13%;float:left;text-align: left;padding:0px;">' . $invoice->discount . " &nbsp;&nbsp;" . $invoice->commission_amount . '&nbsp;</td>

	</tr></a>
	';
        endforeach
        ;
        $temp = $temp . '</table><input type="hidden" id="totalc" value="' . $c . '"/><input type="hidden" id="deduction" value="' . $deduction . '"/>';
        echo $temp;
    }
    
    // missing wo disply
    public function displayMissingWo()
    {
        $this->load->helper('url');
        $data['invoices'] = $this->customer_model->get_missing_workorder_list();
        $temp = '<table style="width:99%;float:left;padding-left:0px;">';
        foreach ($data['invoices'] as $invoice) :
            $temp = $temp . '
          <tr style="cursor:pointer" onclick="document.getElementById(&quot;' . $invoice->pk_customer . '&quot;).click();"><a href="' . base_url() . 'index.php/customer/add_new_work_order/' . $invoice->pk_customer . '" target="_blank" id="' . $invoice->pk_customer . '"></a>

	<td style="width:20%;float:left;text-align: center;padding:0px;border-right:1px solid black;">' . $invoice->account_no . '&nbsp;</td>
	<td style="width:25%;float:left;text-align: left;padding:0px;border-right:1px solid black;">' . $invoice->cust_name . '</td>
	<td style="width:15%;float:left;text-align: left;padding:0px;border-right:1px solid black;">' . $invoice->vessel_name . '&nbsp;</td>
	<td style="width:24%;float:left;text-align: center;padding:0px;border-right:1px solid black;">' . $invoice->location . '&nbsp;</td>
	<td style="width:15%;float:left;text-align: center;">' . $this->date_format_us($invoice->schedule_date) . '&nbsp;</td>
	</tr></a>
	';
        endforeach
        ;
        $temp = $temp . '</table><input type="hidden" id="subinpvasu" value="' . count($data['invoices']) . '"/>';
        echo $temp;
    }

    /**
     * REPORTS-> DIVER COMMISSION
     */
    public function displayCommissionDetails()
    {
        $mode = $_POST['one'];
        $res = $this->customer_model->displayCommissionDetails($mode);
        $d = $res[0]->vessel_name . '|' . $res[0]->location . '|' . $res[0]->wo_number . '|' . $this->date_format_us($res[0]->schedule_date) . '|' . $res[0]->invoiced_rate . '|' . $res[0]->list_price . '|' . $res[0]->discount . '|' . $res[0]->scount . '|' . $res[0]->commission_rate . '|' . $res[0]->commission_amount . '|' . $res[0]->work_type;
        
        print $d;
    }

    /**
     * DELETE INVOICE
     */
    public function deleteInvoice()
    {
        $invoice = $_POST['one'];
        $this->customer_model->delete_current_invoice($invoice);
        
        echo "Invoice " . $invoice . " Deleted.";
    }
    // Delete Commission Details
    public function deleteDiverCommission()
    {
        $worknum = $_POST['wo'];
        
        $this->customer_model->delete_diver_commission_db($worknum);
        echo "Data " . $worknum . " Deleted.";
    }
    // delete credit payments
    public function deleteCreditPayment()
    {
        $ledger = $_POST['ledger_id'];
        
        $this->customer_model->delete_credit_payment($ledger);
        echo "Data " . $ledger . " Deleted.";
    }

    /**
     * EXCLUDED PORTION
     */
    public function voidInvoice()
    {
        $invoice = $_POST['one'];
        $this->customer_model->void_invoice_db($invoice);
        echo "Invoice " . $invoice . " Voided.";
    }

    /**
     * INVOICE ->CREATE INVOICES FROM WORK ORDER CREATES WORK ORDER.....
     */
    public function createInvoiceWork()
    {
        $temp = '';
        $invoices = $_POST['pkwo'];
        $invoice = explode(",", $invoices); // 10,11,12,13,15,18-(10,11)
        foreach ($invoice as $i) {
            // find the customer and check whose other completed work order numbers and
            // check with current array.
            if (in_array($i, $invoice)) {
                $data['otherwork'] = $this->customer_model->get_other_completed_work_order($i);
                $customer = $data['otherwork'][0]->PK_CUSTOMER;
                $data['completed'] = $this->customer_model->get_other_completed_work_order_customer($customer);
                foreach ($data['completed'] as $c) {
                    
                    if (in_array($c->PK_WO, $invoice)) {
                        if (($key = array_search($c->PK_WO, $invoice)) !== false) {
                            
                            unset($invoice[$key]);
                            $invoice = array_unique($invoice);
                            $invoice = array_values($invoice);
                        }
                        $i = $i . '|' . $c->PK_WO;
                    }
                }
                
                $i = explode("|", $i);
                $i = array_unique($i);
                $i = array_values($i);
                
                $data['invoiceid'] = $this->customer_model->create_invoice_from_work_order($i);
                
                $this->invoice_pdf_here($data['invoiceid']);
            }
        }
    }

    /**
     * Shift schedule date using the nature of the funcation
     * 
     * @param unknown $schedule
     *            : date
     * @param unknown $type
     *            : type of service
     * @return string
     */
    public function calculateScheduleDate($schedule, $type)
    { // changeCleaningDates($dates,$days)
        $type = strtoupper($type);
        switch ($type) {
            case 'MONTHLY ONLY':
                return $this->changeCleaningDates($schedule, 30, 1);
                break;
            case 'BI-MONTHLY - FULL CLEAN 2 WK.':
                return $this->changeCleaningDates($schedule, 14, 1);
                break;
            case 'BI-MONTHLY (POWER)':
                return $this->changeCleaningDates($schedule, 14, 1);
                break;
            case 'BI-MONTHLY (OUT DRIVES)':
                return $this->changeCleaningDates($schedule, 14, 1);
                break;
            case 'WEEKLY':
                return $this->changeCleaningDates($schedule, 7, 1);
                break;
            case 'THREE WEEK':
                return $this->changeCleaningDates($schedule, 21, 1);
                break;
            case 'SIX WEEK':
                return $this->changeCleaningDates($schedule, 42, 1);
                break;
            case 'TWO MONTHLY':
                return $this->changeCleaningDates($schedule, 60, 1);
                break;
            case 'BI MONTHLY (SAIL)':
                return $this->changeCleaningDates($schedule, 14, 1);
                break;
            case 'BI-MONTHLY (POWER/SAIL)':
                return $this->changeCleaningDates($schedule, 14, 1);
                break;
            case 'THREE MONTHS':
                return $this->changeCleaningDates($schedule, 90, 1);
                break;
            default:
                return $this->changeCleaningDates($schedule, 30, 1);
                break;
        }
    }

    /**
     * Send invoices attached with email
     * 
     * @param string $addresses
     *            : email id
     */
    public function sendInvoicesEmail($addresses = null)
    {
        $this->load->library('email');
        $this->load->helper('html');
        $this->load->helper('url');
        $config = array(
            'mailtype' => 'html',
            'charset' => 'utf-8'
        );
        $this->email->initialize($config);
        $data['messages'] = $this->customer_model->get_email_fillup();
        $data['company'] = $this->customer_model->get_company_details();
        
        $addresses = $_POST['address'];
        $addresses = urldecode($addresses);
        $address = explode("^", $addresses);
        $k = 0;
        $us = '';
        foreach ($address as $adr) :
            $this->email->clear();
            $this->email->clear(true);
            $message = '';
            $data['customer'] = $this->customer_model->get_invoice_details($adr);
            
            $this->email->from('info@btwdivedb.com', 'info@btwdive.com');
            $this->email->reply_to('info@btwdive.com', 'Ian Roberts');
            // $this->email->to ( $data ['customer'] [0]->EMAIL );//'info@btwdive.com'
            // $this->email->cc ( $data ['customer'] [0]->ADDFIELD1 );
            // $this->email->bcc ( $data ['customer'] [0]->ADDFIELD2 );
            $this->email->to('subinpvasu@gmail.com');
            if(file_exists("invoice/Invoice_" . $adr . ".pdf")){$this->email->attach("invoice/Invoice_" . $adr . ".pdf");}
            $this->email->subject('BTW Dive Serv - Invoice ' . $adr); // remove live test
            $message .=  $data['messages'][0]->dheader . '&nbsp;' . $data['customer'][0]->FIRST_NAME . "<br/>";
            $message .=  $data['messages'][0]->ddetail1 . "<br/><br/>";
            $message .=  $data['messages'][0]->ddetail2 . "<br/><br/>";
            $message .=  $data['messages'][0]->ddetail3 . "<br/><br/>";
            $message .=  $data['messages'][0]->ddetail4 . "<br/><br/>";
            $message .=  $data['messages'][0]->ENTRY_BY . "<br/>";
            $message .=  "Owner<br/>";
            $message .=  $data['company'][0]->BUSINESS_NAME . "<br/>";
            $message .= "310.918.5631";
            $this->email->message($message);
           
            
           if (stristr($data['customer'][0]->DELIVERY_MODE, "Email") == 'Email') 
            {
               
                $this->email->send();
                $this->customer_model->update_send_invoice($adr);
                $k ++;
            } 
           if (stristr($data['customer'][0]->DELIVERY_MODE, "Us")== 'Us Mail & Email')
            {
                    $us = $us . "^" . $adr;
                    $this->customer_model->update_send_invoice($adr);
            } 
            if (stristr($data['customer'][0]->DELIVERY_MODE, "Us")== 'Us Mail')
            {
                $us = $us . "^" . $adr;
                  $this->customer_model->update_send_invoice($adr);
            }
            //echo $message;
            //echo $data['customer'][0]->DELIVERY_MODE;
        endforeach;
        
        if (strlen($us) >= 3) {
            echo $us;
        } else {
            echo $k;
        }
    }

    /**
     *
     * @param unknown $invoice            
     */
    public function createCurrentDoc($invoice)
    {
        $this->invoice_pdf($invoice, $invoice);
    }

    /**
     * upadte the email text
     */
    public function updateEmailText()
    {
        $this->customer_model->update_email_text();
        echo '1';
    }
    // update diver commission
    public function updateDiverCommission()
    {
        $worknumber = $_POST['worknummber'];
        $zinccount = $_POST['zinccount'];
        $rate = $_POST['rate'];
        $commission = $_POST['commission'];
        $this->customer_model->update_diver_commission($zinccount, $rate, $commission, $worknumber);
        echo '1';
    }
    /*
     * process payment-Diver commission
     */
    public function processPayment()
    {
        $diver_id = $_POST['diver_id'];
        $deduction_amount = $_POST['deduction'];
        $check_date = $_POST['checkdate'];
        
        $this->customer_model->diver_process_payment($diver_id, $deduction_amount, $check_date);
        echo '1';
    }

    /**
     * update the invoice text
     */
    public function updateInvoiceText()
    {
        $this->customer_model->update_invoice_text();
        echo '1';
    }

    /**
     * INTERNAL SETUP ->ANODES
     * ADD/EDIT ANODES
     */
    public function searchAnodesEditing()
    {
        $qry = $_POST['query'];
        $data['anodes'] = $this->customer_model->search_anodes_editing($qry);
        
        $temp = '<table style="width:100%;text-align:left;font-size:10px;">';
        foreach ($data['anodes'] as $a) :
            $temp = $temp . '<tr style="cursor:pointer" onclick="displayAnodeList(' . $a->PK_ANODE . ')">
    <td>' . $a->DESCRIPTION . ' &nbsp;</td>
    </tr>';
        endforeach
        ;
        $temp = $temp . '</table>';
        echo $temp;
    }
	public function searchMwosEditing()
    {
        $qry = $_POST['query'];
        $data['anodes'] = $this->customer_model->search_mwos_editing($qry);
        
        $temp = '<table style="width:100%;text-align:left;font-size:10px;">';
        foreach ($data['anodes'] as $a) :
            $temp = $temp . '<tr style="cursor:pointer" onclick="displayMwoList(' . $a->PK_MWO . ')">
    <td>' . $a->DESCRIPTION . ' &nbsp;</td>
    </tr>';
        endforeach
        ;
        $temp = $temp . '</table>';
        echo $temp;
    }

    /**
     * INTERNAL SETUP ->ANODES
     * LIST DOWN THE ANODES
     */
    public function displayAnodeList()
    {
        $anode = $_POST['anode'];
        $data['anode'] = $this->customer_model->display_anode_list($anode);
        foreach ($data['anode'] as $a) :
            $temp = $a->PK_ANODE . '|' . $a->VESSEL_TYPE . '|' . $a->ANODE_TYPE . '|' . $a->DESCRIPTION . '|' . $a->RATE . '|' . $a->INSTALLATION . '|' . $a->SCHEDULE_CHANGE;
        endforeach
        ;
        echo $temp;
    }
	public function displayMwoList()
    {
        $anode = $_POST['anode'];
        $data['anode'] = $this->customer_model->display_mwo_list($anode);
        foreach ($data['anode'] as $a) :
            $temp = $a->PK_MWO . '|' . $a->VESSEL_TYPE . '|' . $a->MWO_TYPE . '|' . $a->DESCRIPTION . '|' . $a->RATE . '|' . $a->INSTALLATION . '|' . $a->SCHEDULE_CHANGE;
        endforeach
        ;
        echo $temp;
    }

    /**
     * INTERMAL SETUP->ANODES
     * SAVE THE CHANGES
     */
    public function modifyAnodeList()
    {
        $this->customer_model->modify_anode_list();
        echo '1';
    }
	public function modifyMwoList()
    {
        $this->customer_model->modify_mwo_list();
        echo '1';
    }

    /**
     * INTERMAL SETUP->ANODES
     * ADD NEW ANODES
     */
    public function addnewAnodeList()
    {
        $this->customer_model->addnew_anode_list();
        echo '1';
    }
	public function addnewMwoList()
    {
        $this->customer_model->addnew_mwo_list();
        echo '1';
    }

    /**
     * INTERNAL SETUP ->OPTIONS
     */
    public function updateCleaningOption()
    {
        $hullclean = $_POST['clean'];
        $data['cleaning'] = $this->customer_model->get_hullclean_data($hullclean);
        
        foreach ($data['cleaning'] as $c) :
            $temp = $c->SERVICE_NAME . '|' . $c->F_DESCRIPTION . '|' . $c->S_DESCRIPTION . '|' . $c->F_RATE . '|' . $c->S_RATE . '|' . $c->FREQUENCY;
        endforeach
        ;
        echo $temp;
    }

    /**
     * CLEANING SERVICES UPDATE
     */
    public function updateHullcleanOption()
    {
        $this->customer_model->update_hullclean_option();
        echo '1';
    }

    /**
     * CLEANING SERVICES CREATE
     */
    public function createHullcleanOption()
    {
        $this->customer_model->create_hullclean_option();
        echo "1";
    }

    /**
     * CLEANING SERVICES REMOVE
     */
    public function removeHullcleanOption()
    {
        $hull = $_POST['hull'];
        $this->customer_model->remove_hullclean_option($hull);
        echo "1";
    }

    /**
     * INTERNAL SETUP -> DIVERS
     */
    public function updateDiverForm()
    {
        $diver = $_POST['diver'];
        $data['diver'] = $this->customer_model->update_diver_form($diver);
        foreach ($data['diver'] as $d) :
            $temp = $d->PK_DIVER . '|' . $d->DIVER_ID . '|' . $d->DIVER_NAME . '|' . $d->ADDRESS . '|' . $d->ADDRESS1 . '|' . $d->CITY . '|' . $d->STATE . '|' . $d->ZIPCODE . '|' . $d->COUNTRY . '|' . $d->PHONE_NO . '|' . $d->FAX_NO . '|' . $d->EMAIL . '|' . $d->HULL_CLEAN_RATE . '|' . $d->ZINC_RATE . '|' . $d->HULL_TIME_RATE . '|' . $d->MECH_TIME_RATE . '|' . $d->ADDFIELD1 . '|' . $d->ADDFIELD2;
        endforeach
        ;
        echo $temp;
    }

    /**
     * INTERNAL SETUP -> DIVERS
     * CHANGE DIVER INFO
     */
    public function modifyDiverForm()
    {
        $this->customer_model->modify_diver_form();
        echo "1";
    }

    /**
     * INTERNAL SETUP -> DIVERS
     * CREATE DIVERS
     */
    public function createDiverForm()
    {
        $this->customer_model->create_diver_form();
        echo "1";
    }

    /**
     * INTERNAL SETUP -> OPTIONS
     */
    public function updatePurposeList()
    {
        $temp = '';
        $qry = $_POST['qry'];
        $data['purpose'] = $this->customer_model->update_purpose_list($qry);
        foreach ($data['purpose'] as $p) :
            $temp = $temp . '!' . $p->ORDER_BY . '|' . trim($p->OPTIONS) . '|' . $p->VALUE;
        endforeach
        ;
        echo $temp;
    }
    // Payment
    public function getPaymentList()
    {
        $temp = '';
        $qry = $_POST['qry'];
        $data['purpose'] = $this->customer_model->get_payment_list($qry);
		//$data['purpose'] = $this->getPaymentList_sorter($data['purpose']);
		foreach ($data['purpose'] as $p) :
            $temp = $temp . '!' . $p->cid . '|' . $p->account_no . '|' . $p->cust_name . '|' . $p->vessel_name . '|' . $p->location;
        endforeach
        ;
        echo $temp;
    }
	public function getPaymentList_sorter($arr1)
	{
		$arr = array();
		foreach($arr1 as $temp_array)
		{
			if(is_numeric($temp_array->invno)) $arr[] = $temp_array;
		}
		$size = count($arr);
		 for ($i=0; $i<$size; $i++) {
			for ($j=0; $j<$size-1-$i; $j++) {
				if ($arr[$j+1]->invno < $arr[$j]->invno) {
					swap($arr, $j, $j+1);
				}
			}
		}
		return(array_reverse($arr));
	}
    // payment Invoice
    public function getPaymentInvoiceList()
    {
        $temp = '';
        $qry = $_POST['qry'];
        
        $data['purpose'] = $this->customer_model->get_payment_invoice_list($qry);
		$data['purpose'] = $this->getPaymentList_sorter($data['purpose']);
		//print_r($data['purpose']);
        foreach ($data['purpose'] as $p) :
            $temp = $temp . '!' . $p->invno . '|' . $this->date_format_us($p->invdt) . '|' . $p->first_Name . '|' . $p->last_name . '|' . $p->billed . '|' . $p->received . '|' . $p->bal;
        endforeach
        ;
        echo $temp;
    }
    // paymnt save payment
    public function savePayment()
    {
        $tran_date = $this->date_format_db($_POST['tran_date']);
        $inv_no = $_POST['invoiceno'];
        $cust_id = $_POST['custid'];
        $check_no = $_POST['check_no'];
        $check_date = $this->date_format_db($_POST['check_date']);
        $credit = $_POST['credit'];
        $notes = $_POST['notes'];
        
        $this->customer_model->save_payment($cust_id, $tran_date, $inv_no, $check_no, $check_date, $credit, $notes);
    }
    // save credit payment
    public function saveCreditPayment()
    {
        $tran_date = $this->date_format_db($_POST['tran_date']);
        $cust_id = $_POST['custid'];
        $check_no = $_POST['check_no'];
        $check_date = $this->date_format_db($_POST['check_date']);
        $credit = $_POST['credit'];
        $notes = $_POST['notes'];
        $repair = $_POST['repair'];
        
        $data['last_invoice'] = $this->customer_model->save_credit_payment($repair, $cust_id, $tran_date, $check_no, $check_date, $credit, $notes);
        
        if ($repair != 0) {
            
            $this->invoice_pdf_here($data['last_invoice']);
        } else {
            echo $data['last_invoice'];
        }
    }

    public function release_work_orders_hold_manual()
    {
        $this->customer_model->release_work_order();
    }

    /**
     * INTERNAL SETUP -> OPTIONS
     * 
     * @return boolean UPDATE THE POSITION AND SLNO BY SORTING.
     */
    public function updateDataOption()
    {
        $rows = $_POST['rows'];
        $option = $_POST['option'];
        $data['total'] = $this->customer_model->total_option_purpose($option);
        $total = count($data['total']);
        for ($i = 0; $i < count($rows); $i ++) {
            if ($i < $total) // 0<11<1
{
                $this->customer_model->update_data_option_order($option, $i, trim($rows[$i][0]), $rows[$i][1]);
            } else {
                $this->customer_model->insert_data_option_order($option, $i, trim($rows[$i][0]), $rows[$i][1]);
            }
        }
        echo count($rows) . $total;
        return true;
    }

    /**
     * US MAIL INVOICES ARE DOWNLOAD BY BULK
     * 
     * @param unknown $us            
     */
    public function send_usmail_instead_bulk($us)
    {
        $invpdf = '';
        $us = urldecode($us);
        $mail = explode("^", $us);
        
        for ($i = 1; $i < count($mail); $i ++) {
            $invpdf = $invpdf . $this->invoice_pdf_bulk($mail[$i]);
        }
        
        pdf_create($invpdf, 'send_us_mail');
    }

    /**
     * REVERT VOIDED WORK ORDERS
     */
    public function activateWorkOrder()
    {
        $pkwork = $_POST['pkwork'];
        $this->customer_model->activate_void_work_order($pkwork);
        echo "Y";
    }

    /**
     * COMMISSION AMOUNT REPAIR HERE
     */
    public function repairCommission()
    {
        $wonumber = $_POST['wonumber'];
        $this->customer_model->repair_commission($wonumber);
    }

    /**
     * *****************************************************************************
     */
    /**
     * ***********************************NEW SECTION*******************************
     */
    /**
     * *****************************************************************************
     */
    
    // /html5 css3
    
    /**
     * diver login
     */
    public function diver_login()
    {
        $this->load->helper('cookie');
        $this->load->helper("url");
        $this->load->helper(array(
            'form'
        ));
        
        $data['errormsg'] = $this->session->flashdata('error');
        
        if (isset($_COOKIE['diver_logged_in'])) 

        {
            $session_data = $this->session->userdata('ses_diver_login');
            $data['dname'] = $session_data['dname'];
            $this->load->view('diver/diver_home', $data);
        } else {
            
            // If no session, redirect to Diver login page
            $this->load->view('diver/diver_login', $data);
        }
    }
    // diver login check
    public function dlogin_check()
    {
        $this->load->helper("url");
        $this->load->helper('cookie');
        $uname = $this->input->post('username');
        $pwd = $this->input->post('password');
        
        if (! $this->input->post('login_btn')) {
            
            redirect('customer/diver_login', 'refresh');
        }
        
        $result = $this->customer_model->check_diver_login($uname, $pwd);
        
        if ($result) {
            
            $sess_array = array();
            foreach ($result as $row) {
                // create the session
                $sess_array = array(
                    'd_id' => $row->pk_diver,
                    'email' => $row->email,
                    'password' => $row->addfield1,
                    'dname' => $row->diver_name
                );
                // set session with value from database
                $this->session->set_userdata('ses_diver_login', $sess_array);
            }
            if ($this->input->post('remember')) {
                
                $cookie = array(
                    'name' => 'diver_logged_in',
                    'value' => $uname,
                    'expire' => '184000'
                )
                ;
                
                $this->input->set_cookie($cookie);
            }
            
            $session_data = $this->session->userdata('ses_diver_login');
            $data['dname'] = $session_data['dname'];
            redirect('customer/diver_home', $data);
        } else {
            $this->session->set_flashdata('error', 'Invalid username/password');
            redirect('customer/diver_login', 'refresh');
        }
    }
    // Diver home page
    public function diver_home()
    {
        $this->load->helper('cookie');
        $this->load->helper("url");
        $this->load->helper(array(
            'form'
        ));
        $session_data = $this->session->userdata('ses_diver_login');
        $data['dname'] = $session_data['dname'];
        $this->CheckLogin('diver/diver_home', $data);
    }
    // diver logout
    function diver_logout()
    {
        $this->load->helper("url");
        $this->load->helper('cookie');
        $this->session->unset_userdata('ses_diver_login');
        $this->session->sess_destroy();
        delete_cookie("diver_logged_in");
        $data['errormsg'] = "";
        redirect('customer/diver_login', 'refresh');
    }
    // diver completed work orders
    function diver_completed_wo()
    {
        $this->load->helper("url");
        $this->load->library("pagination");
        $config = array();
        $session_data = $this->session->userdata('ses_diver_login');
        $diverid = $session_data['d_id'];
        
        $data['rowcount'] = $this->customer_model->get_totalrow_comp_wo();
        
        $data['total_comm'] = $this->customer_model->get_divertotal_commi();
        
        $totalRows = $data['rowcount'][0]->totalrows;
        
        $config["base_url"] = base_url() . "index.php/customer/diver_completed_wo";
        $config["total_rows"] = $totalRows;
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;
        $config['display_pages'] = FALSE;
        $config['first_link'] = 'FIRST';
        $config['prev_link'] = 'PREV';
        $config['next_link'] = 'NEXT';
        $config['last_link'] = 'LAST';
        $this->pagination->initialize($config);
        
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        $data["results"] = $this->customer_model->display_completed_wo($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        
        $this->CheckLogin('diver/completedWorkorders', $data);
    }

    public function total_commission_by_date()
    {
        $start = $this->date_format_db($_POST['s_date']);
        $end = $this->date_format_db($_POST['e_date']);
        $data['total'] = $this->customer_model->get_divertotal_commi($start, $end);
        $session_data = $this->session->userdata('ses_diver_login');
        $diverid = $session_data['d_id'];
        $data['materials'] = $this->customer_model->get_deduction_commission($diverid, $start, $end);
        
        $tcomm = 0;
        $deduction = 0;
        $tmp = 0;
        for ($i = 0; $i < count($data['total']); $i ++) {
            $tcomm = $tcomm + $data['total'][$i]->C_AMT;
        }
        
        foreach ($data['materials'] as $material) :
            $deduction = $material->deductions;
        endforeach
        ;
        
        $tmp = $tcomm - $deduction;
        if ($tmp > 0) {
            echo number_format(($tmp), 2);
        } else {
            echo "0.00";
        }
    }
    // diver view comp wo by date
    function diver_view_cwo_date()
    {
        $this->load->helper("url");
        $this->load->library("pagination");
        
        $session_data = $this->session->userdata('ses_diver_login');
        $diverid = $session_data['d_id'];
        $sch_date = $this->date_format_db($_POST['s_date']);
        $end_date = $this->date_format_db($_POST['e_date']);
        
        $data["results"] = $this->customer_model->display_cwo_date($sch_date, $end_date);
        
        if (count($data["results"]) > 0) {
            $temp = '<table style="width:100%;" id="t3"> <tr width="100%">
                                    <th style="table-layout: fixed;text-align: center;" class="tblhead">Type</th>
                                    <th style="width:19%;table-layout: fixed;text-align: center;" class="tblhead">Work&nbsp;Order&nbsp;#</th>
                                    <th style="width:18%;table-layout: fixed;text-align: center;" class="tblhead">Name</th>
                                    <th style="width:18%;table-layout: fixed;text-align: center;" class="tblhead">Boat Name</th>
                                    <th style="width:20%;table-layout: fixed;text-align: center;" class="tblhead">Location</th>
                                    <th style="width:15%;table-layout: fixed;text-align: center;" class="tblhead">Earning</th>
                                </tr>';
            foreach ($data['results'] as $result) :
                $temp = $temp . '
	<tr onclick="viewWOdetails(' . "'$result->PKWORKORDER'" . ')" style="cursor: pointer;">
	<td style="table-layout: fixed;text-align: left;">' . $result->W . '&nbsp;</td>
	<td style="width:19%;table-layout: fixed;text-align: left;">' . $result->R . '&nbsp;</td>
        <td style="width:18%;table-layout: fixed;text-align: left;">' . $result->F . " " . $result->L . '&nbsp;</td>
	<td style="width:18%;table-layout: fixed;text-align: left;">' . $result->V . '&nbsp;</td>
	<td style="width:20%;table-layout: fixed;text-align: left;">' . $result->O . " " . $result->SL . '&nbsp;</td>
	<td style="width:15%;table-layout: fixed;text-align:right;">' . $result->C_AMT . '&nbsp;</td>


	</tr></a>
	';
            endforeach
            ;
            echo $temp;
        } else {
            echo "<h4 align='center'>No Work Orders Found!<td></h4>";
        }
    }
    // view detials of completed work orders
    function view_wo_details($wo = null)
    {
        $this->load->helper('url');
        $session_data = $this->session->userdata('ses_diver_login');
        $data['diverid'] = $session_data['d_id'];
        $data['pkwork'] = $wo;
        $data['customers'] = $this->customer_model->get_customer_workorder_info($wo);
        $data['divers'] = $this->customer_model->get_diver_name();
        $this->load->view('templates/header');
        switch ($data['customers'][0]->Z) {
            case 'A':
                $data['cleanings'] = $this->customer_model->get_anode_work_order_info($wo);
                $data['commission_amt'] = $this->customer_model->get_divercomm_amt_cwo($wo);
                
                $this->CheckLogin('diver/diver_cwo_anode_details', $data);
                break;
            case 'C':
                $data['cleanings'] = $this->customer_model->get_cleaning_work_order_info($wo);
                
                $data['commission_amt'] = $this->customer_model->get_divercomm_amt_cwo($wo);
                
                $this->CheckLogin('diver/diver_cwo_cleaning_details', $data);
                break;
            case 'M':
                $data['cleanings'] = $this->customer_model->get_mechanical_work_order_info($wo);
                $data['commission_amt'] = $this->customer_model->get_divercomm_amt_cwo($wo);
                $this->CheckLogin('diver/diver_cwo_mech_details', $data);
                break;
            default:
                break;
        }
    }
    // mechanical wo flow
    public function mech_compWO($pkwo)
    {
        $this->load->helper("url");
        $data['pkwork'] = $pkwo;
        $this->CheckLogin('diver/diver_mech_cwo', $data);
    }
    
    // cleanin wo flow
    function clean_compWO($pkwo)
    {
        $data['pkwork'] = $pkwo;
        $this->load->helper("url");
        $data['pkwork'] = $pkwo;
        $this->load->helper("url");
        
        $this->CheckLogin('diver/diver_clean_cwo1', $data);
    }
    // clean why not flow
    function diver_clean_ynot($pkwo)
    {
        $data['pkwork'] = $pkwo;
        $this->load->helper("url");
        $data['cleanings'] = $this->customer_model->get_cleaning_work_order_info($pkwo);
        
        $this->CheckLogin('diver/diver_clean_ynot', $data);
    }

    function CheckLogin($redirectingurl, $data)
    {
        $this->load->helper("url");
        $data['errormsg'] = "";
        $session_data = $this->session->userdata('ses_diver_login');
        
        if ($session_data) {
            
            $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
            $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
            $this->output->set_header('Pragma: no-cache');
            
            $this->load->view($redirectingurl, $data);
        } else {
            
            $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
            $this->session->set_flashdata('error', 'Invalid username/password');
            redirect('customer/diver_login', 'refresh');
        }
    }
    
    // clean type flow 2
    function diver_cleantype_cwo($pkwo = '')
    {
        $this->load->helper("url");
        
        $data['pkwo'] = $pkwo;
        $data['cleanings'] = $this->customer_model->get_cleaning_work_order_info($pkwo);
        
        $this->CheckLogin('diver/diver_cleantype_cwo', $data);
    }
    // Diver Clean CWO Comments
    function diver_clean_fnsd($pkwo)
    {
        $this->load->helper("url");
        $data['pkwork'] = $pkwo;
        
        $data['cleanings'] = $this->customer_model->get_cleaning_work_order_info($pkwo);
        $this->CheckLogin('diver/diver_clean_cwo_comments', $data);
    }
    
    // Anode completed WO flow 1
    function anode_compWO($pkwo)
    {
        $data['pkwork'] = $pkwo;
        $this->load->helper("url");
        $data['pkwork'] = $pkwo;
        $this->load->helper("url");
        
        $this->CheckLogin('diver/diver_anode_cwo1', $data);
    }
    // Anode why not
    function diver_anode_ynot($pkwo)
    {
        $data['pkwork'] = $pkwo;
        $this->load->helper("url");
        $data['pkwork'] = $pkwo;
        $this->load->helper("url");
        $data['cleanings'] = $this->customer_model->get_cleaning_work_order_info($pkwo);
        
        $this->CheckLogin('diver/diver_clean_ynot', $data);
    }
    // anode cwo flow 2
    function diver_anode_cwo2($pkwork)
    {
        $data['pkwork'] = $pkwork;
        $this->load->helper("url");
        
        $data['customers'] = $this->customer_model->get_customer_workorder_info($pkwork);
        $custom = $data['customers'][0]->P;
        $data['totalanodes'] = $this->customer_model->get_total_anodes_info($custom);
        
        $data['anodes'] = $this->customer_model->get_anode_work_order_info($pkwork);
        
        $this->CheckLogin('diver/diver_anode_cwo2', $data);
    }
    // mech why not
    public function diver_mech_ynot($pkwo)
    {
        $this->load->helper("url");
        $data['pkwork'] = $pkwo;
        $data['cleanings'] = $this->customer_model->get_cleaning_work_order_info($pkwo);
        $this->CheckLogin('diver/diver_mech_ynot', $data);
    }
    // mech completed.
    public function diver_mech_fnsd($pkwo)
    {
        $this->load->helper("url");
        $data['pkwork'] = $pkwo;
        $data['cleanings'] = $this->customer_model->get_cleaning_work_order_info($pkwo);
        $this->CheckLogin('diver/diver_mech_fnsd', $data);
    }
    // diver comments update
    function update_diver_comments($flag = null)
    {
        $this->load->library('email');
        $this->load->helper('html');
        $this->load->helper('url');
        $config = array(
            'mailtype' => 'html',
            'charset' => 'utf-8'
        );
        $this->email->initialize($config);
        $this->email->clear();
        $this->email->clear(true);
        
        $comment = urlencode($_POST['newcomments']);
        $oldsms = urlencode($_POST['oldcomments']);
        $tmp = str_replace($oldsms, "", $comment);
        $newcmt = $tmp . $oldsms;
        $lastdate = $this->date_format_db($_POST['lastdate']);
        $pkwo = $_POST['pk_wo'];
        $status = $_POST['sts'];
        $this->customer_model->update_diver_comment($pkwo, $lastdate, $comment, $flag);
        
        $data['customer'] = $this->customer_model->get_customer_workorder_info($pkwo);
        
        // get details from db like emailid and name using pk_diver.
        
        $this->email->from('info@btwdive.com', 'info@btwdive.com');
        $this->email->reply_to('info@btwdive.com', 'Ian Roberts');
        
        // $this->email->to ('info@btwdive.com');
        $this->email->cc('subinpvasu@gmail.com');
        $this->email->bcc('subinpvasu@gmail.com');
        
        $this->email->subject('Diver Comments - ' . $data['customer'][0]->W);
        
        $message = "Hi Ian,</br>";
        $message .= '<div class="name">
		<span>Client Name :  ' . $data["customer"][0]->F . '&nbsp;' . $data["customer"][0]->L . '</span>

	</div>
	<div class="vessel">
	    <span style="display:block;">Emails : ' . $data["customer"][0]->EMAIL . ',' . $data["customer"][0]->ADDFIELD1 . ',' . $data["customer"][0]->ADDFIELD2 . '</span>
		<span style="display:block;">Vessel Name : ' . $data["customer"][0]->V . '</span>
		<span style="display:block;">Location : ' . $data["customer"][0]->O . '</span>
		<span style="display:block;">Slip #: ' . $data["customer"][0]->S . '</span>
	    <span style="display:block;">Work Order # : ' . $data["customer"][0]->W . ' </span></div>';
        
        $message .= '<h4
		style="float: left; width: 89%; text-align: left; display: inline-block;" id="number_work"><b style="text-decoration:underline;">New Comments :</b> ' . urldecode($tmp) . ' </h4>';
        
        $message .= '<br/><h4
            style="float: left; width: 89%; text-align: left; display: inline-block;" id="number_work"><b style="">Prior Comments :</b> ' . urldecode($oldsms) . ' </h4>';
        
        $message .= '<br/><br/><br/>';
        
        $this->email->message($message);
        
        if ($status == 1) {
            $this->email->send();
        }
        
        echo "success";
    }
    
    // mech why not
    
    /**
     * Anode Comp WO flow 3
     * 
     * @param type $pkwork            
     */
    function diver_anode_cwo3($pkwork, $flag = null)
    {
        $this->load->helper("url");
        $data['pkwork'] = $pkwork;
        if (! is_null($flag)) {
            $data['status'] = '/' . $flag;
        } else {
            $data['status'] = '';
        }
        $this->CheckLogin('diver/diver_anode_cwo3', $data);
    }

    /**
     * Anode Work Flow 4
     * 
     * @param type $pkwork            
     */
    function diver_anode_cwo4($pkwork, $flag = null)
    {
        // change here with existing work order.
        $data['pkwork'] = $pkwork;
        $this->load->helper("url");
        if (! is_null($flag)) {
            $data['status'] = '/' . $flag;
        } else {
            $data['status'] = '';
        }
        
        $data['customers'] = $this->customer_model->get_customer_workorder_info($pkwork);
        $custom = $data['customers'][0]->P;
        $data['totalanodes'] = $this->customer_model->get_total_anodes_info($custom);
        $data['anodes'] = $this->customer_model->get_other_anodes($pkwork, $flag);
        
        $this->CheckLogin('diver/diver_anode_cwo4', $data);
    }

    /**
     *
     * @param type $pkwork            
     */
    function diver_anode_cwo_comments($pkwo)
    {
        $data['pkwork'] = $pkwo;
        $this->load->helper("url");
        $data['pkwork'] = $pkwo;
        $this->load->helper("url");
        $data['cleanings'] = $this->customer_model->get_cleaning_work_order_info($pkwo);
        
        $this->CheckLogin('diver/diver_anode_cwo_comments', $data);
    }
    
    // diver incompleted workorders
    function diver_incompleted_wo()
    {
        $this->load->helper("url");
        $this->load->library("pagination");
        $config = array();
        $session_data = $this->session->userdata('ses_diver_login');
        $diverid = $session_data['d_id'];
        
        $data['rowcount'] = $this->customer_model->get_totalrow_incomp_wo();
        
        $totalRows = $data['rowcount'][0]->totalrows;
        
        $config["base_url"] = base_url() . "index.php/customer/diver_incompleted_wo";
        $config["total_rows"] = $totalRows;
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;
        $config['display_pages'] = FALSE;
        $config['first_link'] = 'FIRST';
        $config['prev_link'] = 'PREV';
        $config['next_link'] = 'NEXT';
        $config['last_link'] = 'LAST';
        $this->pagination->initialize($config);
        
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->customer_model->display_incompleted_wo($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        
        $this->CheckLogin('diver/incompletedWorkorders', $data);
    }
    
    /*
     * view for assign/allot work orders to divers for a given date range.also the details of the divers and work order.
     */
    public function manage_work_orders($now = null, $then = null, $basin = null)
    {
        $this->load->helper("url");
        $this->load->helper("html");
        $this->load->helper("form");
        
        if (is_null($now) || is_null($then)) {
            /*
             * $now = date('m/d/Y');
             * $days = 30;
             * $then = date ( 'm/d/Y', strtotime ( $now . ' - ' . $days . ' days' ) );
             */
            $k = date('m/d/Y', strtotime('next Sunday', strtotime(date('m/d/Y'))));
            $now = $k;
            $newdate = strtotime('-36 day', strtotime($k));
            $then = date('m/d/Y', $newdate);
            // $now = date('m/d/Y', strtotime('last Sunday', strtotime(date('m/d/Y'))));
        }
        $data['now'] = $this->date_format_us($now);
        $data['then'] = $this->date_format_us($then);
        
        if (is_null($basin)) {
            $basin = 'all';
        } else {
            $basin = urldecode($basin);
        }
        $data['basin'] = $basin;
        $now = $this->date_format_db($now);
        $then = $this->date_format_db($then);
        $data['divers'] = $this->customer_model->get_diver_work_details($now, $then, $basin);
        $data['work_orders'] = $this->customer_model->get_open_work_orders($now, $then, $basin);
        $data['alldivers'] = $this->customer_model->get_diver_name();
        $data['location'] = $this->customer_model->get_vessel_location();
        
        $data['past'] = $this->date_format_db($then);
        $data['fast'] = $this->date_format_db($now);
        
        $data['person'] = $this->session->userdata("person");
        /*
         * for filter the results
         */
        
        if ($this->input->post('days') == 'yes') {
            $now = $this->date_format_db($this->input->post("todate"));
            $then = $this->date_format_db($this->input->post("fromdate"));
            $basin = $this->input->post("basin");
            redirect('/customer/manage_work_orders/' . $now . '/' . $then . '/' . $basin, 'refresh');
        }
        
        if ($this->input->post("orders") == 'yes') {
            $now = $this->date_format_db($this->input->post("todated"));
            $then = $this->date_format_db($this->input->post("fromdated"));
            
            $work = $this->input->post("workorder");
            $diver = $this->input->post("diver");
            
            $this->customer_model->update_diver_work_order($work, $diver);
            redirect('/customer/manage_work_orders/' . $now . '/' . $then, 'refresh');
        }
        
        $this->load->view('templates/header');
        $this->load->view('manager/manage_work_orders', $data);
        $this->load->view('templates/footer');
    }

    public function getTotalWorkOrdersAllTime()
    {
        $who = $_POST['who'];
        $data['total'] = $this->customer_model->get_total_workorders_alltime($who);
        echo count($data['total']);
    }

    /**
     * PHASE -2 WORK DISTRIBUTION
     *
     * Assign work orders to divers
     */
    public function assignWorkDivers()
    {
        $work = $_POST['work'];
        $diver = $_POST['diver'];
        $this->customer_model->update_diver_work_order($work, $diver);
    }

    /**
     * Send alert to the divers that they got assigned some work orders
     * 
     * @param unknown $diver:primary
     *            key of diver
     */
    public function work_order_email_alert($diver)
    {
        $this->load->library('email');
        $this->load->helper('html');
        $this->load->helper('url');
        $config = array(
            'mailtype' => 'html',
            'charset' => 'utf-8'
        );
        $this->email->initialize($config);
        $this->email->clear();
        $this->email->clear(true);
        // get details from db like emailid and name using pk_diver.
        $data['diver'] = $this->customer_model->update_diver_form($diver);
        $data['messages'] = $this->customer_model->get_email_fillup();
        $data['company'] = $this->customer_model->get_company_details();
        
        $this->email->from('info@btwdive.com', 'info@btwdive.com');
        $this->email->reply_to('info@btwdive.com', 'Ian Roberts');
        
        // $this->email->to ( $data['diver'][0]->EMAIL);
        $this->email->cc('subinpvasu@gmail.com');
        // $this->email->bcc ( 'caarif123@gmail.com' );
        
        $this->email->subject('Work Order(s) Assigned to you on - ' . date('m/d/Y'));
        
        $message = $data['diver'][0]->DIVER_NAME . ",</br>";
        $message .= '<br/>You are assigned some work orders today.<br/>Please check your diver account <a href="http://btwdivedb.com/diver" target="_blank">here</a><br/><br/>';
        $message = $message . $data['messages'][0]->ENTRY_BY . "<br/>";
        $message = $message . "Owner<br/>";
        $message = $message . $data['company'][0]->BUSINESS_NAME . "<br/>";
        $message = $message . "310.918.5631";
        
        $this->email->message($message);
        
        $this->email->send();
    }

    /**
     * Add/Update Anode work order from divers end.
     */
    public function addAnodeWorkDiver()
    {
        $anodes = $_POST['anodes'];
        $pkwork = $_POST['work'];
        $data['customers'] = $this->customer_model->get_customer_workorder_info($pkwork);
        
        $today = date("mdy");
        $wocustomer = $data['customers'][0]->P;
        $wovessel = $data['customers'][0]->PKV;
        $wonum = $data['customers'][0]->ACN . " - " . $today;
        $woclass = 'A';
        $date = date('Y-m-d');
        $divers = 0;
        $comments = '';
        
        // check for exixting anode work order
        $data['old'] = $this->customer_model->check_for_anode_work($wocustomer);
        if (count($data['old']) > 0 && $data['old'][0]->PK_WO != $pkwork) {
            $workid = $data['old'][0]->PK_WO;
        } else {
            $workid = $this->customer_model->add_new_work_order($wocustomer, $wovessel, $wonum, $woclass, $date, $divers, $comments);
        }
        
        $anode = explode("|", $anodes);
        
        for ($i = 1; $i < count($anode); $i ++) {
            $data['vanode'] = $this->customer_model->get_anode_property_from_vessel($anode[$i]);
            
            $wkpk = $anode[$i];
            $wkclass = 'A';
            $wkname = 'Zinc / Anode Change';
            $wktype = $data['vanode'][0]->ANODE_TYPE;
            $wkprice = $data['vanode'][0]->LIST_PRICE;
            $wkdiscount = $data['vanode'][0]->DISCOUNT;
            $wkdisprice = $data['vanode'][0]->DISCOUNT_PRICE;
            $wkprocess = '3';
            $change = $data['vanode'][0]->SCHEDULE_CHANGE;
            $dates = $data['vanode'][0]->ADDFIELD1;
            $desc = $data['vanode'][0]->DESCRIPTION;
            
            $this->customer_model->add_new_work_order_parts($workid, $wkpk, $wkclass, $wkname, $wktype, $wkprice, $wkdiscount, $wkdisprice, $wkprocess, $change, $dates, $desc);
        }
        echo "Anode Work Order Created Successfully.";
    }

    public function displayOnholdWorkOrders()
    {
        $data['work_order'] = $this->customer_model->display_onhold_workorders();
        if (count($data['work_order']) > 0) {
            $temp = '
        <h2 style="width:1000px;text-align:center;">Work Orders on Hold </h2>
        <table style="width:100%;text-align: left;border-collapse: collapse;" class="holdtable">
 <tr style="text-align: center;height:40px">

<th style="background-color: black;color:white;width:14%;border:1px solid white;">Boat Name</th>
<th style="background-color: black;color:white;width:14%;border:1px solid white;">Boat Slip</th>
<th style="background-color: black;color:white;width:11%;border:1px solid white;">Customer Code</th>
<th style="background-color: black;color:white;width:14%;border:1px solid white;">Boat Size/Type</th>
<th style="background-color: black;color:white;width:14%;border:1px solid white;">Schedule Date</th>
<th style="background-color: black;color:white;width:21%;border:1px solid white;">Customer Name</th>
<th style="background-color: black;color:white;border:1px solid white;">Type</th>
<th style="background-color: black;color:transparent;border:1px solid white;"><span style="display:none">' . count($data['work_order']) . '</span></th></tr>';
            foreach ($data['work_order'] as $work) :
                
                if (strpos($work->LOCATION, 'Select') !== false) {
                    $location = '';
                } else {
                    $location = $work->LOCATION;
                }
                
                if (strpos($work->VESSEL_TYPE, 'Select') !== false) {
                    $vessel = '';
                } else {
                    $vessel = $work->VESSEL_TYPE;
                }
                $temp = $temp . '
        <tr id="workOrderId_'.$work->PK_WO.'" >
        <td style="border:1px solid black;height:40px;">' . $work->VESSEL_NAME . '</td>
        <td style="border:1px solid black;">' . $location . '&nbsp;' . $work->SLIP . '</td>
        <td style="border:1px solid black;">' . $work->ACCOUNT_NO . '</td>
        <td style="border:1px solid black;">' . $work->VESSEL_LENGTH . '/' . $vessel . '</td>
        <td style="border:1px solid black;">' . $work->SCHEDULE_DATE . '</td>
        <td style="border:1px solid black;">' . $work->FIRST_NAME . '&nbsp;' . $work->LAST_NAME . '</td>
        <td style="border:1px solid black;text-align:center">' . $work->WO_CLASS . '</td>
		<td style="text-align:center;border:1px solid black;"><input type="checkbox" value="' . $work->PK_WO . '" class="holdon"/></td>
        </tr>

        ';
            endforeach
            ;
            $temp = $temp . '</table>';
            echo $temp;
			
        } else {
            echo '<h2>No Work Orders Found.</h2>';
        }
    }

    public function releaseWorkOrders()
    {
        $workorder = $_POST['workorder'];
        $work = explode("|", $workorder);
        for ($i = 1; $i < count($work); $i ++) {
            $this->customer_model->release_work_order_hold($work[$i]);
        }
        echo 'Work Order(s) Released Successfully';
    }
	

    public function display_customer_logout()
    {
        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->helper('url');
        
        $data['customer'] = $this->customer_model->display_customer_outbalance();
        
        $this->load->view('templates/header');
        $this->load->view('customer/outstanding_customers', $data);
        $this->load->view('templates/footer');
    }

    public function displayLogDetails()
    {
        $customer = $_POST['who'];
        
        $data['log'] = $this->customer_model->display_customer_log_details($customer);
        $temp = '<div><ol>';
        foreach ($data['log'] as $log) :
            
            if ($log->STATUS < 70) {
                $temp = $temp . '<li><a style="text-decoration:none;" href="customer_account/' . $log->CUSTOMER . '" target="_blank"> ' . $log->ACCOUNT . ' : Payment of $' . $log->AMOUNT . ' was 6 weeks  overdue as on ' . $log->EXACT_DATE . '. Notification Time = ' . $log->EXACT_TIME . '</a></li>';
            } else {
                $temp = $temp . '<li style="color:red"><a style="text-decoration:none;color:red" href="customer_account/' . $log->CUSTOMER . '" target="_blank">' . $log->ACCOUNT . ' : Payment $' . $log->AMOUNT . ' is over 10 weeks past due. Demand letter sent on ' . $log->EXACT_TIME . '</a></li>';
            }
        endforeach
        ;
        $temp = $temp . '</ol></div>';
        echo $temp;
    }

    public function CheckSessionStatus()
    {
        $now = $_POST['now'];
        
        switch ($now) {
            case 'admin':
                if ($this->session->userdata('administrator') == 'admin') {
                    echo 'Y';
                } else {
                    if ($this->session->userdata('administrator') == 'user') {
                        echo 'N';
                    } else {
                        echo 'Y';
                    }
                }
                break;
            case 'diver':
                if ($this->session->userdata('administrator') == 'diver') {
                    echo 'Y';
                } else {
                    if ($this->session->userdata('administrator') == 'user') {
                        echo 'N';
                    } else {
                        echo 'Y';
                    }
                }
                break;
            default:
                break;
        }
    }

    public function newsletterprogram()
    {
        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->helper('url');
        
        // active customers
        $data['active'] = $this->customer_model->list_all_email_addresses(1);
        $data['inactive'] = $this->customer_model->list_all_email_addresses(0);
        
        $this->load->view('templates/header');
        $this->load->view('customer/news_letter_program', $data);
        $this->load->view('templates/footer');
    }
	
    public function RemoveSessionStatus()
    {
        $this->session->set_userdata('administrator', 'user');
        echo 'Y';
    }
	// Added by arif
	// Function to change onhold for six months to collection
	 public function update_onhold($customer_id = null)
    {
        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->helper('url');
       $update_on_hold = $this->customer_model->workorders_update_onhold_to_collection_default();
		exit;
    }
	// Function to display collections
	 public function collections()
    {
	
        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->helper('url');
        $data['collection'] = $this->customer_model->get_collections_all();
		$this->load->view('templates/header');
        $this->load->view('customer/collections', $data);
        $this->load->view('templates/footer');
    }
    public function changeOnholdtocollection()
    {
        if(isset($_POST['workorder'])) 
		{
		$workorder = $_POST['workorder'];
        $work = explode("|", $workorder);
        for ($i = 1; $i < count($work); $i ++) {        
			  $this->customer_model->workorders_update_onhold_to_collection_selected($work[$i]);
			}
		}
    }
	public function release_collections($workorder)
    {
		$this->load->helper('url');
        if(isset($workorder)) 
		{
			$this->customer_model->workorders_release_from_collection($workorder);
			//redirect('/customer/collections/', 'refresh');		
		}
		redirect('/customer/collections/');
		exit;
    }
	public function back_to_onhold($workorder)
    {
		$this->load->helper('url');
        if(isset($workorder)) 
		{
			$this->customer_model->workorders_back_to_onhold_from_collection($workorder);
			//redirect('/customer/collections/', 'refresh');		
		}
		redirect('/customer/collections/');
		exit;
    }
	function mwoChoicesSearchResults($string)
    {
        $temp = "";
        $string = urldecode($string);
        $data['results'] = $this->customer_model->get_mwo_choices_search_results($string);
        foreach ($data['results'] as $values) {
			if (empty($temp)) {
                $temp = $values->PK_MWO . "|" . $values->MWO_TYPE . "|" . $values->DESCRIPTION . "|" . $values->RATE . "|" . $values->SCHEDULE_CHANGE;
            } else {
                $temp = $temp . "!" . $values->PK_MWO . "|" . $values->MWO_TYPE . "|" . $values->DESCRIPTION . "|" . $values->RATE . "|" . $values->SCHEDULE_CHANGE;
            }
        }
        echo $temp;
    }
	function getmwoDetails($anode)
    {
        $data['anode_details'] = $this->customer_model->get_mwo_property($anode);
        foreach ($data['anode_details'] as $values) {
            $temp = $values->PK_MWO . "|" . $values->MWO_TYPE . "|" . $values->DESCRIPTION . "|" . $values->RATE . "|" . $values->SCHEDULE_CHANGE. "|" . $values->INSTALLATION;
        }
        echo $temp;
    }
}