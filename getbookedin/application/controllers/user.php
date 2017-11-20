<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        
        // Set user's selected language.
        if ($this->session->userdata('language')) {
        	$this->config->set_item('language', $this->session->userdata('language'));
        	$this->lang->load('translations', $this->session->userdata('language'));
        } else {
        	$this->lang->load('translations', $this->config->item('language')); // default
        }
    }
    
//    public function index() {
//        header('Location: ' . $this->config->item('base_url') . '/index.php/user/login');
//    }
    
    public function login() {
        $this->load->model('settings_model');
        
        $view['base_url'] = $this->config->item('base_url');
        $view['dest_url'] = $this->session->userdata('dest_url');
        
        if (!$view['dest_url']) {
            $view['dest_url'] = $view['base_url'] . '/index.php/adminuser/home';
        }
        
        $view['company_name'] = $this->settings_model->get_setting('company_name');
        $this->load->view('user/login', $view);
    }
    
//    public function logout() {
//        $this->load->model('settings_model');
//
//        $this->session->unset_userdata('user_id');
//        $this->session->unset_userdata('user_email');
//        $this->session->unset_userdata('role_slug');
//        $this->session->unset_userdata('username');
//        $this->session->unset_userdata('dest_url');
//
//        $view['base_url'] = $this->config->item('base_url');
//        $view['company_name'] = $this->settings_model->get_setting('company_name');
//        $this->load->view('user/logout', $view);
//    }
    
    public function forgot_password() {
        $this->load->model('settings_model');
        $view['base_url'] = $this->config->item('base_url');
        $view['company_name'] = $this->settings_model->get_setting('company_name');
        $this->load->view('user/forgot_password', $view);
    }

    // custom created function to load registration view
    public function registration() {
        $this->load->model('settings_model');
        $view['base_url'] = $this->config->item('base_url');
        $view['company_name'] = $this->settings_model->get_setting('company_name');
        $this->load->view('user/registration', $view);
    }
    
    public function no_privileges() {
        $this->load->model('settings_model');
        $view['base_url'] = $this->config->item('base_url');
        $view['company_name'] = $this->settings_model->get_setting('company_name');
        $this->load->view('user/no_privileges', $view);
    }
    
    /**
     * [AJAX] Check whether the user has entered the correct login credentials.
     * 
     * The session data of a logged in user are the following:
     *      'user_id'
     *      'user_email'
     *      'role_slug'
     *      'dest_url'
     */
    public function ajax_check_login() {
        try {
            if (!isset($_POST['username']) || !isset($_POST['password'])) {
                throw new Exception('Invalid credentials given!');
            }
            
            $this->load->model('user_model');
            $user_data = $this->user_model->check_login($_POST['username'], $_POST['password']);
            
            if ($user_data) {
                $this->session->set_userdata($user_data); // Save data on user's session.
                echo json_encode(AJAX_SUCCESS);
            } else {
                echo json_encode(AJAX_FAILURE);
            }
            
        } catch(Exception $exc) {
            echo json_encode(array(
                'exceptions' => array(exceptionToJavaScript($exc))
            ));
        }
    }
    
    /**
     * Regenerate a new password for the current user, only if the username and 
     * email address given corresond to an existing user in db.
     * 
     * @param string $_POST['username'] 
     * @param string $_POST['email']
     */
    public function ajax_forgot_password() {
        try {
            if (!isset($_POST['username']) || !isset($_POST['email'])) {
                throw new Exception('You must enter a valid username and email address in '
                        . 'order to get a new password!');
            }
            
            $this->load->model('user_model');
            $this->load->model('settings_model');
            
            $new_password = $this->user_model->regenerate_password($_POST['username'], $_POST['email']);
            
            if ($new_password != FALSE) {
                $this->load->library('notifications');
                $company_settings = array(
                    'company_name' => $this->settings_model->get_setting('company_name'),
                    'company_link' => $this->settings_model->get_setting('company_link'),
                    'company_email' => $this->settings_model->get_setting('company_email')
                );
                $this->notifications->send_password($new_password, $_POST['email'], $company_settings);
            }
            
            echo ($new_password != FALSE) ? json_encode(AJAX_SUCCESS) : json_encode(AJAX_FAILURE);
        } catch(Exception $exc) {
            echo json_encode(array(
                'exceptions' => array(exceptionToJavaScript($exc))
            ));
        }
    }

    //Subin code
    public function index()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->model('admin_model');

        $result = array();
        $subdomain_arr = explode('.', $_SERVER['HTTP_HOST']); //creates the various parts
        if (count($subdomain_arr) > 2) {
            $subdomain_name = $subdomain_arr[0];

            $this->load->model('subdomain_model');

            $result = $this->subdomain_model->get_domain_info($subdomain_name);
        }
        $view['subdomain'] = $result;
        $view['adminuser_header'] = $this->admin_model->get_header($result['id_admin']);

        $this->load->view('template/header');
        $this->load->view('template/header_menu', $view);
        $this->load->view('userview/index');
        $this->load->view('template/footer');

    }
    /**
     * ajax login is perfect, so the login is below....
     */
    public function ajaxLogin()
    {
        $this->load->helper('url');
        $this->load->model('user_model');
        $username = $_POST['username'];
        $password = $_POST['password'];


        $rest =  $this->user_model->check_user($username,$password);

        if($rest)
        {
            echo 'success';
        }
        else
        {
            echo 'Email & Password NOT Matching!';
        }
    }
    public function register()
    {

        $this->load->helper('form');
        $this->load->helper('url');

        $this->load->model('user_model');
        $this->load->model('providers_model');
        $this->load->model('services_model');
        $this->load->model('admin_model');



        if($this->input->post('save')=='Register')
        {
            $this->user_model->add_user();
        }

        if(is_numeric($this->session->userdata('who')))
        {
            /*  $this->load->view('template/header');
             $this->load->view('template/header_menu');
             $this->load->view('user/left_menu');
             $this->load->view('user/homepage');
             $this->load->view('template/footer'); */
            $result = array();
            $subdomain_arr = explode('.', $_SERVER['HTTP_HOST']); //creates the various parts
            if (count($subdomain_arr) > 2) {
                $subdomain_name = $subdomain_arr[0];

                $this->load->model('subdomain_model');

                $result = $this->subdomain_model->get_domain_info($subdomain_name);
            }
            $view['subdomain'] = $result;
            $view['adminuser_header'] = $this->admin_model->get_header($result['id_admin']);

            $view['available_providers'] = $this->providers_model->get_available_providers();
            $view['available_services'] = $this->services_model->get_available_services();
            $view['available_adminusers'] = $this->admin_model->get_available_adminusers();
            
            

            // print_r($this->admin_model->get_available_adminusers());
            $view['user'] = $this->user_model->get_user_data($this->session->userdata('who'));
            if(!$this->session->userdata('user_email') || !$this->session->userdata('role_slug')) {

                $role = $this->user_model->get_user_role($this->session->userdata('who'));
                $this->session->set_userdata('user_email',$view['user'][0]->email);
                $this->session->set_userdata('role_slug',$role);

            }
            $view['appointment_duration'] = $this->admin_model->get_settings_name('duration', $result['id_admin']);
            //$view['privileges'] = $this->roles_model->get_privileges($this->session->userdata('role_slug'));
//            echo '<pre>';
//            echo 'Sub Domain';
//print_r($view['subdomain']);
////print_r($view['adminuser_header']);
//echo 'Providers';
//print_r($view['available_providers']);
//echo 'Services';
//print_r($view['available_services']);
//echo 'Admin Users';
//print_r($view['available_adminusers']);
            
            // get waiting list
            
            $view['waiting_list'] = $this->user_model->get_user_waiting_lists($this->session->userdata('who'));
            
            
            $this->load->view('template/header');
            $this->load->view('template/header_menu', $view);
            $this->load->view('userview/left_menu',$view);
            $this->load->view('userview/calendar',$view);
            $this->load->view('template/footer');
        }
        else
        {
            header('Location: ' . $this->config->item('base_url') . '/index.php/user/index');
        }
    }
    public function homepage($appointment_hash = '')
    {

        $this->load->helper('form');
        $this->load->helper('url');
        // $this->session->set_userdata('dest_url', $this->config->item('base_url') . '/index.php/backend');
        //  if (!$this->hasPrivileges(PRIV_APPOINTMENTS)) return;
        //  $this->load->model('appointments_model');
        $this->load->model('providers_model');
        $this->load->model('services_model');
        $this->load->model('admin_model');
             //$this->load->model('customers_model');
             //$this->load->model('settings_model');
             //$this->load->model('roles_model');
             //$this->load->model('user_model');
             //$this->load->model('secretaries_model');

        $view['base_url'] = $this->config->item('base_url');

//             $view['user_display_name'] = $this->user_model->get_user_display_name(84);
//             $view['active_menu'] = PRIV_APPOINTMENTS;
        $view['book_advance_timeout'] = $this->settings_model->get_setting('book_advance_timeout');
//             $view['company_name'] = $this->settings_model->get_setting('company_name');
//              $view['available_providers'] = $this->providers_model->get_available_providers();
//              $view['available_services'] = $this->services_model->get_available_services();
        $view['customers'] = $this->customers_model->get_batch();
        // $this->setUserData($view);
        $view['available_adminusers'] = $this->admin_model->get_available_adminusers();
        $view['privileges'] = $this->roles_model->get_privileges($this->session->userdata('role_slug'));
        /*  if ($this->session->userdata('role_slug') == DB_SLUG_SECRETARY) {
             $secretary = $this->secretaries_model->get_row(84);
             $view['secretary_providers'] = $secretary['providers'];
         } else {
             $view['secretary_providers'] = array();
         }


         $results = $this->appointments_model->get_batch(array('hash' => $appointment_hash));
         if ($appointment_hash != '' && count($results) > 0) {
             $appointment = $results[0];
             $appointment['customer'] = $this->customers_model->get_row($appointment['id_users_customer']);
             $view['edit_appointment'] = $appointment; // This will display the appointment edit dialog on page load.
         } else {
             $view['edit_appointment'] = NULL;
         }
      */

//             $this->load->view('backend/header', $view);
//             $this->load->view('backend/calendar', $view);
//            // $this->load->view('backend/footer', $view);

        $this->load->view('template/header');
        $this->load->view('template/header_menu');
        $this->load->view('userview/left_menu');
        $this->load->view('userview/calendar',$view);
        $this->load->view('template/footer');

    }

    public function setUserData(&$view) {
        $this->load->model('roles_model');

        // Get privileges
        $view['user_id'] = $this->session->userdata('who');
        $view['user_email'] = $this->session->userdata('user_email');
        $view['role_slug'] = $this->session->userdata('role_slug');
        $view['privileges'] = $this->roles_model->get_privileges($this->session->userdata('role_slug'));
    }

    public function profile()
    {
        $this->load->model('admin_model');
        $this->load->model('user_model');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');

        $result = array();
        $subdomain_arr = explode('.', $_SERVER['HTTP_HOST']); //creates the various parts
        if (count($subdomain_arr) > 2) {
            $subdomain_name = $subdomain_arr[0];

            $this->load->model('subdomain_model');
            $result = $this->subdomain_model->get_domain_info($subdomain_name);
        }
        $data['subdomain'] = $result;
        $data['adminuser_header'] = $this->admin_model->get_header($result['id_admin']);

        $this->form_validation->set_rules('firstname', 'First Name', 'required');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $data['user'] = $this->user_model->get_user_data($this->session->userdata('who'));

            $this->load->view('template/header');
            $this->load->view('template/header_menu', $data);
            $this->load->view('userview/left_menu');
            $this->load->view('userview/profile',$data);
            $this->load->view('template/footer');
        }
        else
        {
            if($this->input->post('update')=='Update Profile')
            {
                $values = array(
                    'first_name'=>$this->input->post('firstname'),
                    'last_name'=>$this->input->post('lastname'),
                    'age'=>$this->input->post('age'),
                    'gender'=>$this->input->post('gender'),
                    'mobile'=>$this->input->post('mobile'),
                    'preferred_communication_mode'=>$this->input->post('preferred_communication_mode'),
                    
                );

                if($this->user_model->update_profile($values))
                {
                    $data['message'] = 'Profile Updated Successfully!!';
                    $data['user'] = $this->user_model->get_user_data($this->session->userdata('who'));

                    $this->load->view('template/header');
                    $this->load->view('template/header_menu', $data);
                    $this->load->view('userview/left_menu');
                    $this->load->view('userview/profile',$data);
                    $this->load->view('template/footer');
                }
            }
        }
    }

    public function change_password()
    {
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');

        $this->load->model('user_model');
        $this->load->model('admin_model');

        //Header data
        $result = array();
        $subdomain_arr = explode('.', $_SERVER['HTTP_HOST']); //creates the various parts
        if (count($subdomain_arr) > 2) {
            $subdomain_name = $subdomain_arr[0];

            $this->load->model('subdomain_model');

            $result = $this->subdomain_model->get_domain_info($subdomain_name);
        }
        $data['subdomain'] = $result;
        $data['adminuser_header'] = $this->admin_model->get_header($result['id_admin']);
        //End


        $data['user'] = $this->user_model->get_user_password($this->session->userdata('who'));

        $this->form_validation->set_rules('old_password', 'Current Password', 'required|callback_current_password');
        $this->form_validation->set_rules('new_password', 'New Password', 'required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|callback_password_check');


        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('template/header');
            $this->load->view('template/header_menu', $data);
            $this->load->view('userview/left_menu');
            $this->load->view('userview/change_password',$data);
            $this->load->view('template/footer');
        }
        else
        {
            if($this->input->post('update')=='Update Password')
            {
                $values = array(
                    'password'=>sha1($this->input->post('confirm_password'))
                );

                if($this->user_model->update_password($values))
                {
                    $data['message'] = 'Password Updated Successfully!!';
                }
            }
            $this->load->view('template/header');
            $this->load->view('template/header_menu', $data);
            $this->load->view('userview/left_menu');
            $this->load->view('userview/change_password',$data);
            $this->load->view('template/footer');
        }
    }

    public function current_password($password)
    {
        $data['password'] = $this->user_model->get_user_password($this->session->userdata('who'));
        $passone = sha1(trim($password));
        $passtwo = trim( $data ['password'] [0]->password);

        if(strcmp($passone, $passtwo)==0)
        {
            return true;
        }
        else
        {
            $this->form_validation->set_message('current_password', 'The %s is NOT matching!!');
            return false;
        }
    }

    public function password_check($confirm)
    {
        $password = $this->input->post('new_password');

        if(strcmp($confirm,$password)==0)
        {
            return true;
        }
        else
        {
            $this->form_validation->set_message('password_check', 'The %s is NOT matching!!');
            return false;
        }

    }

    public function logout()
    {
        $this->session->set_userdata('who',NULL);
        echo 'success';
    }
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */