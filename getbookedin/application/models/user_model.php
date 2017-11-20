<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed.'); 

/**
 * Contains current user's methods.
 */
class User_Model extends CI_Model {
    /**
     * Class Constructor
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Returns the user settings from the database.
     * 
     * @param numeric $user_id User record id of which the settings will be returned.
     * @return array Returns an array with user settings.
     */
    public function get_settings($user_id) {
        $user = $this->db->get_where('ea_users', array('id' => $user_id))->row_array();
        $user['settings'] = $this->db->get_where('ea_user_settings', array('id_users' => $user_id))->row_array();
        unset($user['settings']['id_users']);
        return $user;
    }
    
    /**
     * This method saves the user settings into the database.
     * 
     * @param array $user Contains the current users settings.
     * @return bool Returns the operation result.
     */
    public function save_settings($user) {
        $user_settings = $user['settings'];
        $user_settings['id_users'] = $user['id'];
        unset($user['settings']);

        
        // Prepare user password (hash).
        if (isset($user_settings['password'])) {
            $this->load->helper('general');
            $salt = $this->db->get_where('ea_user_settings', array('id_users' => $user['id']))->row()->salt;
            $user_settings['password'] = hash_password($salt, $user_settings['password']);
        }
        
        if (!$this->db->update('ea_users', $user, array('id' => $user['id']))) {
            return FALSE;
        }
        
        if (!$this->db->update('ea_user_settings', $user_settings, array('id_users' => $user['id']))) {
            return FALSE;
        }
        
        return TRUE;
    }
    
    /**
     * Retrieve user's salt from database.
     * 
     * @param string $username This will be used to find the user record.
     * @return string Returns the salt db value.
     */
    public function get_salt($username) {
        $user =  $this->db->get_where('ea_user_settings', array('username' => $username))->row_array();
        return ($user) ? $user['salt'] : '';
    }
    
    /**
     * Performs the check of the given user credentials. 
     * 
     * @param string $username Given user's name. 
     * @param type $password Given user's password (not hashed yet).
     * @return array|null Returns the session data of the logged in user or null on 
     * failure.
     */
    public function check_login($username, $password) {
        $this->load->helper('general');
        $salt = $this->user_model->get_salt($username);
        $password = hash_password($salt, $password);
        
        $user_data = $this->db
                ->select('ea_users.id AS user_id, ea_users.email AS user_email, '
                        . 'ea_roles.slug AS role_slug, ea_user_settings.username')
                ->from('ea_users')
                ->join('ea_roles', 'ea_roles.id = ea_users.id_roles', 'inner')
                ->join('ea_user_settings', 'ea_user_settings.id_users = ea_users.id')
                ->where('ea_user_settings.username', $username)
                ->where('ea_user_settings.password', $password)
                ->get()->row_array();
        
        return ($user_data) ? $user_data : NULL;
    }
    
    /**
     * Get the given user's display name (first + last name).
     * 
     * @param numeric $user_id The given user record id.
     * @return string Returns the user display name.
     */
    public function get_user_display_name($user_id) {
        if (!is_numeric($user_id))
            throw new Exception ('Invalid argument given ($user_id = "' . $user_id . '").');
        $user = $this->db->get_where('ea_users', array('id' => $user_id))->row_array();
        return $user['first_name'] . ' ' . $user['last_name'];
    }
    
    /**
     * If the given arguments correspond to an existing user record, generate a new 
     * password and send it with an email.
     * 
     * @param string $username
     * @param string $email
     * @return string|bool Returns the new password on success or FALSE on failure.
     */
    public function regenerate_password($username, $email) {
        $this->load->helper('general');
        
        $result = $this->db
                ->select('ea_users.id')
                ->from('ea_users')
                ->join('ea_user_settings', 'ea_user_settings.id_users = ea_users.id', 'inner')
                ->where('ea_users.email', $email)
                ->where('ea_user_settings.username', $username)
                ->get();
        
        if ($result->num_rows() == 0) return FALSE;
        
        $user_id = $result->row()->id;
        
        // Create a new password and send it with an email to the given email address.
        $new_password = generate_random_string();
        $salt = $this->db->get_where('ea_user_settings', array('id_users' => $user_id))->row()->salt;
        $hash_password = hash_password($salt, $new_password);
        $this->db->update('ea_user_settings', array('password' => $hash_password), array('id_users' => $user_id));
        
        return $new_password;
    }



//    Subin user-model code integration
    public function add_user()
    {
        $data = array(
            'first_name'=>  $this->input->post('firstname'),
            'last_name'=>  $this->input->post('lastname'),
            'email'=>$this->input->post('email'),
            'mobile_number'=>$this->input->post('mobile'),

            'gender'=>$this->input->post('gender'),
            'password'=>  sha1($this->input->post('new_password')),
            'id_roles'=>'3',
            'preferred_communication_mode'=>  $this->input->post('preferred_communication_mode')
        );
        
        $this->db->insert('ea_users',$data);
        $this->session->set_userdata('who',  $this->db->insert_id());
//        $this->check_user($this->input->post('email'), sha1($this->input->post('new_password')));
        return true;
    }


    public function check_user($username,$password)
    {
        $data['result'] = $this->get_user($username, sha1($password));
        if(count($data['result'])>0)
        {
            $this->session->set_userdata('who',$data['result'][0]->id);
            $this->session->set_userdata('user_email',$data['result'][0]->email);
            $this->session->set_userdata('role_slug',$data['result'][0]->slug);
            return true;
        }
        else
        {
            return false;
        }
    }

    public function get_user_role($id) {
        $user = $this->db
            ->select('ea_roles.slug AS role_slug')
            ->from('ea_users')
            ->join('ea_roles', 'ea_roles.id = ea_users.id_roles', 'inner')
            ->where('ea_users.id', $id)
            ->get()->row_array();
        return ($user) ? $user['role_slug'] : '';

    }

    public function get_user($usernamne,$password)
    {
        $sql = "SELECT ea_users.id,ea_users.email,ea_roles.slug FROM ea_users INNER JOIN ea_roles ON ea_users.id_roles=ea_roles.id WHERE email='".$usernamne."' AND password='".$password."' LIMIT 0,1";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_user_data($userid)
    {
        $sql = "SELECT * FROM ea_users WHERE id=".$userid;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function update_profile($values)
    {
        $data = array(
            'first_name'=>  $values['first_name'],
            'last_name'=>  $values['last_name'],
            'mobile_number'=> $values['mobile'],
            'age'=>$values['age'],
            'gender'=>$values['gender'],
             'preferred_communication_mode'=>$values['preferred_communication_mode']
        );

        $this->db->where('id', $this->session->userdata('who'));
        $this->db->update('ea_users', $data);
        return true;
    }

    public function get_user_password($userid)
    {
        $sql = "SELECT * FROM ea_users WHERE id=".$userid;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function update_password($values)
    {
        $data = array(
            'password'=>  $values['password']
        );
        $this->db->where('id', $this->session->userdata('who'));
        $this->db->update('ea_users', $data);
        return true;
    }
    /**Subin user-model code ends here***/
    
    public function get_user_waiting_lists($userid){
        
        $sql = "SELECT ea_waiting_list.* , ea_waiting_period.wait_period_name FROM ea_waiting_list INNER JOIN ea_waiting_period on ea_waiting_list.wait_period_type_id_fk = ea_waiting_period.wait_period_id  WHERE user_id_fk = '$userid' AND waiting_list_status=0;";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */