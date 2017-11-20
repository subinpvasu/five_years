<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed.');
/**
 *
 * Contains user header model
 */

Class Header_Model extends CI_Model {
    /**
     * Constructor class
     */
    public function __construct() {
        parent::__construct();
    }

    public function save_settings($admin_header) {
        //$header_settings = $header['settings'];
        //$header_settings['user_id'] = $header['user_id'];
        //unset($header['settings']);

        $user = $this->db->get_where('ea_adminuser_header', array('id_admin' => $admin_header['id_admin']))->row();
        if($user) {
            if(!$this->db->update('ea_adminuser_header',$admin_header, array('id_admin' => $admin_header['id_admin']))) {
                return FALSE;
            }
        } else {
            if(!$this->db->insert('ea_adminuser_header',$admin_header)) {
                return FALSE;
            }
        }
        return TRUE;

    }

}
