<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');

        // Set user's selected language.
        if ($this->session->userdata('language')) {
            $this->config->set_item('language', $this->session->userdata('language'));
            $this->lang->load('translations', $this->session->userdata('language'));
        } else {
            $this->lang->load('translations', $this->config->item('language')); // default
        }
        //upload
        $this->load->helper(array('form', 'url'));
    }

    public function index() {
//        header('Location: ' . $this->config->item('base_url') . '/index.php/admin/login');
        header('Location: ' . $this->config->item('base_url') . '/index.php/admin/home');
    }

    //mail tester
    public function testmail() {
//        require_once dirname(__FILE__) . '../libraries/external/class.phpmailer.php';

        $this->load->library('email');
        $config['protocol'] = 'sendmail';
//        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);

        $this->email->from('shijokj001@gmail.com', 'shijokj001');
        $this->email->to('shijo.vbridge@gmail.com');
//                $this->email->cc('another@another-example.com');
//                $this->email->bcc('them@their-example.com');

        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');

        if($this->email->send()) {
            echo $this->email->print_debugger();
            echo '<br>Send';
        }
        else
            echo "Not send";

    }

    public function home() {

        $this->load->model('settings_model');

        $view['base_url'] = $this->config->item('base_url');
        //$view['dest_url'] = $this->session->userdata('dest_url');
        $this->session->set_userdata('dest_url', $this->config->item('base_url') . '/index.php/adminuser');//custom added to change admin des_url
        $view['dest_url'] = $this->session->userdata('dest_url');

        if (!$view['dest_url']) {
            $view['dest_url'] = $view['base_url'] . '/index.php/adminuser';
        }

        $view['company_name'] = $this->settings_model->get_setting('company_name');

//        print_r($view);
//        exit();

//        $this->load->view('admin/home/header');
//        $this->load->view('admin/home/header_menu');
        $this->load->view('admin/home/index', $view);
//        $this->load->view('admin/home/footer');
//        $this->load->view('admin/login', $view);

    }

    public function login() {
        $this->load->model('settings_model');

        $view['base_url'] = $this->config->item('base_url');
        //$view['dest_url'] = $this->session->userdata('dest_url');
        $this->session->set_userdata('dest_url', $this->config->item('base_url') . '/index.php/adminuser');//custom added to change admin des_url
        $view['dest_url'] = $this->session->userdata('dest_url');

        if (!$view['dest_url']) {
            $view['dest_url'] = $view['base_url'] . '/index.php/adminuser';
        }

        $view['company_name'] = $this->settings_model->get_setting('company_name');

//        $this->load->view('admin/login', $view);
        $this->load->view('admin/home/login', $view);
    }

    public function logout() {
        $this->load->model('settings_model');

        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_email');
        $this->session->unset_userdata('role_slug');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('dest_url');

        $view['base_url'] = $this->config->item('base_url');
        $view['company_name'] = $this->settings_model->get_setting('company_name');
        $this->load->view('admin/logout', $view);
    }

    public function forgot_password() {
        $this->load->model('settings_model');
        $view['base_url'] = $this->config->item('base_url');
        $view['company_name'] = $this->settings_model->get_setting('company_name');
        $this->load->view('admin/home/forgot_password', $view);
    }

    public function registration() {
        $this->load->model('settings_model');
        $view['base_url'] = $this->config->item('base_url');
        $view['company_name'] = $this->settings_model->get_setting('company_name');
//        $this->load->view('admin/registration', $view);
        $this->load->view('admin/home/registration', $view);
    }

    public function subdomain() {
        if ($this->session->userdata('id') == "") {
            //header('Location: ' . $this->config->item('base_url') . '/index.php/admin/login');
        };

        $this->load->model('settings_model');
        $view['base_url'] = $this->config->item('base_url');
        $view['company_name'] = $this->settings_model->get_setting('company_name');
        $view['user_id'] = $this->session->userdata('id');
        $this->load->view('admin/subdomain', $view);
    }

    public function page() {
        if ($this->session->userdata('id') == "") {
            //header('Location: ' . $this->config->item('base_url') . '/index.php/admin/login');
        };

        $this->load->model('settings_model');
        $view['base_url'] = $this->config->item('base_url');
        $view['company_name'] = $this->settings_model->get_setting('company_name');
        $view['user_id'] = $this->session->userdata('id');
        $this->load->view('admin/page', $view);
    }

    public function no_subdomain() {
        $this->load->model('settings_model');
        $view['base_url'] = $this->config->item('base_url');
        $view['company_name'] = $this->settings_model->get_setting('company_name');
        $this->load->view('admin/no_subdomain', $view);
    }


    /**
     * [AJAX] Check whether the Admin has entered the correct login credentials.
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

            $this->load->model('admin_model');
            $admin_data = $this->admin_model->check_login($_POST['username'], $_POST['password']);

            if ($admin_data) {
                $this->session->set_userdata($admin_data); // Save data on user's session.
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

    public function ajax_forgot_password() {
        try {
            if (!isset($_POST['email'])) {
                throw new Exception('You must enter a valid email address in '
                    . 'order to get a new password!');
            }

            $this->load->model('admin_model');
            $this->load->model('settings_model');

            $new_password = $this->admin_model->regenerate_password($_POST['email']);

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

    public function ajax_validate_subdomain() {
        try{
            $this->load->model('subdomain_model');

            $subdomain = json_decode($_POST['subdomain'],true);

            $is_valid = $this->subdomain_model->validate_subdomain($subdomain);
            echo json_encode($is_valid);

        } catch (Exception $exc) {
            echo json_encode(array(
                'exceptions' => array(exceptionToJavaScript($exc))
            ));
        }
    }

    public function ajax_save_subdomain() {
        try {

            $this->load->model('subdomain_model');

            $domain = json_decode($_POST['subdomain'], true);
            $result = $this->subdomain_model->save_subdomain($domain);

            echo json_encode(array(
                'status' => $result
            ));

        } catch(Exception $exc) {
            echo json_encode(array(
                'exceptions' => array(exceptionToJavaScript($exc))
            ));
        }
    }

    public function ajax_save_page() {
        try {
            $this->load->model('header_model');

            $result = $this->header_model->save_settings(json_decode($_POST['page'], true));
            echo json_encode(array(
                'status' => $result
            ));

        } catch (Exception $exc) {
            echo json_encode(array(
                'exceptions' => array(exceptionToJavaScript($exc))
            ));
        }
    }

    public function ajax_save_header() {
        $page = array(
            'id_admin' =>  $this->input->post('admin-id'),
//            'logo' => $this->input->post('uploadFile'),
            'header_color' => $this->input->post('header_color'),
            'header_back_color' => $this->input->post('header_back_color'),
            'header_caption' =>  $this->input->post('header_caption'),
            'footer_back_color' => $this->input->post('footer_back_color')
        );

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']	= '2000';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';

        $this->load->library('upload', $config);
        $this->load->model('header_model');
        if ( ! $this->upload->do_upload()) {

            $result = $this->header_model->save_settings($page);

        }else {
            $data = array('upload_data' => $this->upload->data());
            $page['logo'] = $data['upload_data']['file_name'];
            $result = $this->header_model->save_settings($page);
        }
        header('Location: ' . $this->config->item('base_url') . '/index.php/admin/login');

    }
}
