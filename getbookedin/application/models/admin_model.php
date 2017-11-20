<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed.');

/**
 * Contains current user's methods.
 */
class Admin_Model extends CI_Model
{
    /**
     * Class Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function add($admin) {
        $this->validate($admin);

        if ($this->exists($admin) && !isset($admin['id'])) {
            $admin['id'] = $this->find_record_id($admin);
        }

        if (!isset($admin['id'])) {
            $admin['id'] = $this->insert($admin);
        } else {
            $admin['id'] = $this->update($admin);
        }

        return intval($admin['id']);
    }

    public function insert($admin) {
        $this->load->helper('general');

        // Get admin role id.
        $admin['id_roles'] = $this->get_admin_role_id();

        // Store provider settings and services (must not be present on the $provider array).
        //$services = $provider['services'];
        //unset($provider['services']);
        $settings = $admin['settings'];
        unset($admin['settings']);

        $admin['salt'] = generate_salt();
        $admin['password'] = hash_password($admin['salt'], $admin['password']);

        // Insert admin record and save settings.

        if (!$this->db->insert('ea_admin', $admin)) {
            throw new Exception('Could not insert admin into the database');
        }


        $admin['id'] = $this->db->insert_id();
        $this->save_settings($settings, $admin['id']);
        //$this->save_services($services, $provider['id']);

        // Return the new record id.
        return intval($admin['id']);
    }

    public function update($admin) {
        $this->load->helper('general');

        // Store service and settings (must not be present on the $provider array).
        //$services = $provider['services'];
        //unset($provider['services']);
        $settings = $admin['settings'];
        unset($admin['settings']);

        if (isset($admin['password'])) {
            $salt = $this->db->get_where('ea_admin', array('id' => $admin['id']))->row()->salt;
            $admin['password'] = hash_password($salt, $admin['password']);
        }

        // Update provider record.
        $this->db->where('id', $admin['id']);
        if (!$this->db->update('ea_admin', $admin)) {
            throw new Exception('Could not update admin record.');
        }

        //$this->save_services($services, $provider['id']);
        $this->save_settings($settings, $admin['id']);

        // Return record id.
        return intval($admin['id']);
    }

    public function exists($admin) {
        if (!isset($admin['email'])) {
            throw new Exception('Admin email is not provided :' . print_r($admin, TRUE));
        }

        // This method shouldn't depend on another method of this class.
        $num_rows = $this->db
            ->select('*')
            ->from('ea_admin')
            ->where('ea_admin.email', $admin['email'])
            ->get()->num_rows();

        return ($num_rows > 0) ? TRUE : FALSE;
    }

    public function find_record_id($admin) {
        if (!isset($admin['email'])) {
            throw new Exception('Admin email was not provided :' . print_r($admin, TRUE));
        }

        $result = $this->db
            ->select('ea_admin.id')
            ->from('ea_admin')
            ->where('ea_admin.email', $admin['email'])
            ->get();

        if ($result->num_rows() == 0) {
            throw new Exception('Could not find admin record id.');
        }

        return intval($result->row()->id);
    }

    private function save_settings($settings, $admin_id) {
        if (!is_numeric($admin_id)) {
            throw new Exception('Invalid $admin_id argument given :' . $admin_id);
        }

        if (count($settings) == 0 || !is_array($settings)) {
            throw new Exception('Invalid $settings argument given:' . print_r($settings, TRUE));
        }

        // Check if the setting record exists in db.
        if ($this->db->get_where('ea_admin_settings', array('id_admin' => $admin_id))
                ->num_rows() == 0) {
            $this->db->insert('ea_admin_settings', array('id_admin' => $admin_id));
        }

        foreach($settings as $name=>$value) {
            $this->set_setting($name, $value, $admin_id);
        }
    }

    public function save_profile_settings($admin) {
        $admin_settings = $admin['settings'];
        $admin_settings['id_admin'] = $admin['id'];
        $admin_header = $admin['header'];
        unset($admin['settings']);
        unset($admin['header']);


        // Prepare user password (hash).
        if (isset($admin['password'])) {
            $this->load->helper('general');
            $salt = $this->db->get_where('ea_admin', array('id' => $admin['id']))->row()->salt;
            $admin['password'] = hash_password($salt, $admin['password']);
        }

        if (!$this->db->update('ea_admin', $admin, array('id' => $admin['id']))) {
            return FALSE;
        }

        if (!$this->db->update('ea_admin_settings', $admin_settings, array('id_admin' => $admin['id']))) {
            return FALSE;
        }


//        $user = $this->db->get_where('ea_adminuser_header', array('id_admin' => $admin_header['id_admin']))->row();
//        if($user) {
//            if(!$this->db->update('ea_adminuser_header',$admin_header, array('id_admin' => $admin_header['id_admin']))) {
//                return FALSE;
//            }
//        } else {
//            if(!$this->db->insert('ea_adminuser_header',$admin_header)) {
//                return FALSE;
//            }
//        }

        return TRUE;
    }

    public function set_setting($setting_name, $value, $admin_id) {
        $this->db->where(array('id_admin' => $admin_id));
        return $this->db->update('ea_admin_settings', array($setting_name => $value));
    }

    public function get_admin_role_id() {
        return $this->db->get_where('ea_roles', array('slug' => DB_SLUG_ADMIN_USER))->row()->id;
    }

//    public function get_available_adminusers() {
//        // Get adminuser records from database.
//        $this->db->select('*');
//        $this->db->from('ea_admin');
//        $this->db->join('ea_roles', 'ea_roles.id = ea_admin.id_roles', 'inner');
//        $this->db->join('ea_subdomains', 'ea_subdomains.id_admin = ea_admin.id', 'inner');
//        $this->db->where('ea_roles.slug', DB_SLUG_ADMIN_USER);
//
//
//
//
//        /*   $sql = "SELECT * FROM ea_admin INNER JOIN ea_roles ON ea_roles.id = ea_admin.id_roles INNER JOIN ea_subdomains ON ea_subdomains.id_admin = ea_admin.id WHERE ea_roles.slug = 'adminuser' ";
//          mysql_query($sql); */
//        $adminusers = $this->db->get()->result_array();
//
//        // Include each provider services and settings.
//        foreach($adminusers as &$adminuser) {
//            // Services
//            $services = $this->db->get_where('ea_services_providers',
//                array('id_users' => $adminuser['id']))->result_array();
//            $adminuser['services'] = array();
//            foreach($services as $service) {
//                $adminuser['services'][] = $service['id_services'];
//            }
//
//            // Settings
//            $adminuser['settings'] = $this->db->get_where('ea_admin_settings',
//                array('id_admin' => $adminuser['id']))->row_array();
//            unset($adminuser['settings']['id_users']);
//        }
//
//        // Return provider records.
//        return $adminusers;
//    }

    public function get_available_adminusers() {
        // Get adminuser records from database.
        $this->db
            ->select('ea_admin.*')
            ->from('ea_admin')
            ->join('ea_roles', 'ea_roles.id = ea_admin.id_roles', 'inner')
            ->where('ea_roles.slug', DB_SLUG_ADMIN_USER);

        $adminusers = $this->db->get()->result_array();

        // Include each provider services and settings.
        foreach($adminusers as &$adminuser) {
            // Services
            $services = $this->db->get_where('ea_services_providers',
                array('id_users' => $adminuser['id']))->result_array();
            $adminuser['services'] = array();
            foreach($services as $service) {
                $adminuser['services'][] = $service['id_services'];
            }

            // Settings
            $adminuser['settings'] = $this->db->get_where('ea_admin_settings',
                array('id_admin' => $adminuser['id']))->row_array();
            unset($adminuser['settings']['id_users']);

            // Subdomain
            $adminuser['subdomain'] = $this->db->get_where('ea_subdomains',
                array('id_admin'  => $adminuser['id']))->row_array();
//            unset($adminuser['subdomains']['id']);
        }

        // Return provider records.
        return $adminusers;
    }

    public function get_row($adminuser_id) {
        if (!is_numeric($adminuser_id)) {
            throw new Exception('$adminuser_id argument is not a valid numeric value: ' . $adminuser_id);
        }

        // Check if selected record exists on database.
        if ($this->db->get_where('ea_admin', array('id' => $adminuser_id))->num_rows() == 0) {
            throw new Exception('Selected record does not exist in the database.');
        }

        // Get adminuser data.
        $adminuser = $this->db->get_where('ea_admin', array('id' => $adminuser_id))->row_array();


        // Include provider services.
//        $services = $this->db->get_where('ea_services_providers',
//            array('id_users' => $adminuser_id))->result_array();
//        $provider['services'] = array();
//        foreach($services as $service) {
//            $provider['services'][] = $service['id_services'];
//        }

        // Include provider settings.
        $adminuser['settings'] = $this->db->get_where('ea_admin_settings',
            array('id_admin' => $adminuser_id))->row_array();
        unset($adminuser['settings']['id_admin']);

        // Return adminuser data array.
        return $adminuser;
    }

    public function get_batch($where_clause = '') {
        // CI db class may confuse two where clauses made in the same time, so
        // get the role id first and then apply the get_batch() where clause.
        $role_id = $this->get_admin_role_id();

        if ($where_clause != '') {
            $this->db->where($where_clause);
        }

        $batch = $this->db->get_where('ea_admin',
            array('id_roles' => $role_id))->result_array();

        // Include each provider sevices and settings.
        foreach($batch as &$adminuser) {
            // Services
            //$services = $this->db->get_where('ea_services_providers',
            //    array('id_users' => $adminuser['id']))->result_array();
            //$adminuser['services'] = array();
            //foreach($services as $service) {
            //    $adminuser['services'][] = $service['id_services'];
            //}

            // Settings
            $adminuser['settings'] = $this->db->get_where('ea_admin_settings',
                array('id_admin' => $adminuser['id']))->row_array();
            unset($adminuser['settings']['id_admin']);
        }

        // Return provider records in an array.
        return $batch;
    }


    /**
     * Retrieve Admin's salt from database.
     *
     * @param string $username This will be used to find the user record.
     * @return string Returns the salt db value.
     */
    public function get_salt($username) {
        $user =  $this->db->get_where('ea_admin', array('email' => $username))->row_array();
        return ($user) ? $user['salt'] : '';
    }

    public function get_admin_display_name($admin_id) {
        if (!is_numeric($admin_id))
            throw new Exception ('Invalid argument given ($admin_id = "' . $admin_id . '").');
        $admin = $this->db->get_where('ea_admin', array('id' => $admin_id))->row_array();
        return $admin['first_name'] . ' ' . $admin['last_name'];
    }

    public function get_settings($admin_id) {
        $admin = $this->db->get_where('ea_admin', array('id' => $admin_id))->row_array();
        $admin['settings'] = $this->db->get_where('ea_admin_settings', array('id_admin' => $admin_id))->row_array();
        unset($admin['settings']['id_admin']);
        return $admin;
    }

    public function get_settings_name($setting_name, $admin_id) {
        //$admin = $this->db->get_where('ea_admin', array('id' => $admin_id))->row_array();
        $admin_settings = $this->db->get_where('ea_admin_settings', array('id_admin' => $admin_id))->row_array();
//        unset($admin_settings[$setting_name]);
        return $admin_settings[$setting_name];
    }

    public function get_header($admin_id) {
        $admin = $this->db->get_where('ea_adminuser_header', array('id_admin' => $admin_id))->row_array();
        //$admin['header'] = $this->db->get_where('ea_admin_settings', array('id_admin' => $admin_id))->row_array();
        unset($admin['id_admin']);
        return $admin;
    }

    /**
     * Performs the check of the given Admin credentials.
     *
     * @param string $username Given user's email.
     * @param type $password Given user's password (not hashed yet).
     * @return array|null Returns the session data of the logged in admin or null on
     * failure.
     */
    public function check_login($username, $password) {
        $this->load->helper('general');
        $salt = $this->admin_model->get_salt($username);
        $password = hash_password($salt, $password);

        $admin_data = $this->db
            ->select('ea_admin.id AS user_id, ea_admin.email AS user_email, '
                . 'ea_roles.slug AS role_slug, ea_admin.email')
            ->from('ea_admin')
            ->join('ea_roles', 'ea_roles.id = ea_admin.id_roles', 'inner')
            ->where('ea_admin.email', $username)
            ->where('ea_admin.password', $password)
            ->get()->row_array();

        return ($admin_data) ? $admin_data : NULL;
    }


    /**
     * @param $admin
     * @return bool
     * @throws Exception
     */
    public function validate($admin) {
        $this->load->helper('data_validation');

        // If a admin id is present, check whether the record exist in the database.
        if (isset($admin['id'])) {
            $num_rows = $this->db->get_where('ea_admin',
                array('id' => $admin['id']))->num_rows();
            if ($num_rows == 0) {
                throw new Exception('Admin record id does not exist in the database.');
            }
        }

        // Validate required fields.
        if (!isset($admin['first_name'])
            || !isset($admin['email'])
            || !isset($admin['phone_number'])) {
            throw new Exception('Not all required fields are provided : ' . print_r($admin, TRUE));
        }

        // Validate admin email address.
        if (!filter_var($admin['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email address provided : ' . $admin['email']);
        }

        // Validate admin settings.
        if (!isset($admin['settings']) || count($admin['settings']) == 0
            || !is_array($admin['settings'])) {
            throw new Exception('Invalid admin settings given: ' . print_r($admin, TRUE));
        }


        // Validate admin password
        if (isset($admin['password'])) {
            if (strlen($admin['password']) < MIN_PASSWORD_LENGTH) {
                throw new Exception('The admin password must be at least '
                    . MIN_PASSWORD_LENGTH . ' characters long.');
            }
        }

        // When inserting a record the email address must be unique.
        $admin_id = (isset($admin['id'])) ? $admin['id'] : '';

        $num_rows = $this->db
            ->select('*')
            ->from('ea_admin')
            ->where('ea_admin.email', $admin['email'])
            ->where('ea_admin.id <>', $admin_id)
            ->get()
            ->num_rows();

        if ($num_rows > 0) {
            throw new Exception('Given email address belongs to another admin record. '
                . 'Please use a different email.');
        }

        return TRUE;
    }

    public function regenerate_password($email) {
        $this->load->helper('general');

        $result = $this->db
            ->select('ea_admin.id')
            ->from('ea_admin')
            ->where('ea_admin.email', $email)
            ->get();

        if ($result->num_rows() == 0) return FALSE;

        $admin_id = $result->row()->id;

        // Create a new password and send it with an email to the given email address.
        $new_password = generate_random_string();
        $salt = $this->db->get_where('ea_admin', array('id' => $admin_id))->row()->salt;
        $hash_password = hash_password($salt, $new_password);
        $this->db->update('ea_admin', array('password' => $hash_password), array('id' => $admin_id));

        return $new_password;
    }

    public function validate_useremail($username, $user_id) {
        $num_rows = $this->db->get_where('ea_admin',
            array('email' => $username, 'id <> ' => $user_id))->num_rows();
        return ($num_rows > 0) ? FALSE : TRUE;
    }
}