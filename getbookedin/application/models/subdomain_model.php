<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed.');
/**
 *
 * Contains user header model
 */

Class Subdomain_Model extends CI_Model {
    /**
     * Constructor class
     */
    public function __construct() {
        parent::__construct();
    }

    public function validate_subdomain($subdomain) {

        $num_rows = $this->db->get_where('ea_subdomains',
            array('subdomain_name' => $subdomain['subdomain'], 'id_admin <> ' => $subdomain['user_id']))->num_rows();
        return ($num_rows > 0) ? FALSE : TRUE;
    }

    public function save_subdomain($subdomain) {

        $num_rows = $this->db->get_where('ea_subdomains',
            array('subdomain_name' => $subdomain['subdomain_name'], 'id_admin <> ' => $subdomain['id_admin']))->num_rows();
        if ($num_rows <= 0) {
            if(!$this->db->insert('ea_subdomains', $subdomain)) {
                //throw new Exception('Could not insert subdomain into the database');
                return FALSE;
            }
            return TRUE;
        }
        return FALSE;
    }

    public function get_domain_info($subdomain_name) {
        $result_array = $this->db->get_where('ea_subdomains', array('subdomain_name' => $subdomain_name))->row_array();
        if (count($result_array) > 0) {
            //unset($result_array['id']);

            return $result_array;

            //return TRUE;
        }
        return FALSE;

    }


}
