<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Leads
 *
 * @author bisjo
 */
class Leads {
    
    public $assigned_user_name;
    public $modified_by_name;
    public $created_by_name;
    public $id;
    public $name;
    public $date_entered;
    public $date_modified;
    public $modified_user_id;
    public $created_by;
    public $description;
    public $deleted;
    public $assigned_user_id;
    public $salutation;
    public $first_name;
    public $last_name;
    public $full_name;
    public $title;
    public $photo;
    public $department;
    public $do_not_call;
    public $phone_home;
    public $email;
    public $phone_mobile;
    public $phone_work;
    public $phone_other;
    public $phone_fax;
    public $email1;
    public $email2;
    public $invalid_email;
    public $email_opt_out;
    public $primary_address_street;
    public $primary_address_street2;
    public $primary_address_street3;
    public $primary_address_city;
    public $primary_address_state;
    public $primary_address_postalcode;
    public $primary_address_country;
    public $alt_address_street;
    public $alt_address_street2;
    public $alt_address_street3;
    public $alt_address_city;
    public $alt_address_state;
    public $alt_address_postalcode;
    public $alt_address_country;
    public $assistant;
    public $assistant_phone;
    public $email_addresses_non_primary;
    public $converted;
    public $refered_by;
    public $lead_source;
    public $lead_source_description;
    public $status;
    public $status_description;
    public $reports_to_id;
    public $report_to_name;
    public $account_name;
    public $account_description;
    public $contact_id;
    public $account_id;
    public $opportunity_id;
    public $opportunity_name;
    public $opportunity_amount;
    public $campaign_id;
    public $campaign_name;
    public $c_accept_status_fields;
    public $m_accept_status_fields;
    public $accept_status_id;
    public $accept_status_name;
    public $webtolead_email1;
    public $webtolead_email2;
    public $webtolead_email_opt_out;
    public $webtolead_invalid_email;
    public $birthdate;
    public $portal_name;
    public $portal_app;
    public $website;
    public $e_invite_status_fields;
    public $event_status_name;
    public $event_invite_id;
    public $e_accept_status_fields;
    public $event_accept_status;
    public $event_status_id;
    public $jjwg_maps_lat_c;
    public $jjwg_maps_geocode_status_c;
    public $cust1_site_visit_recorder_leads_name;
    public $jjwg_maps_address_c;
    public $jjwg_maps_lng_c;
    
    function getAssigned_user_name() {
        return $this->assigned_user_name;
    }

    function getModified_by_name() {
        return $this->modified_by_name;
    }

    function getCreated_by_name() {
        return $this->created_by_name;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getDate_entered() {
        return $this->date_entered;
    }

    function getDate_modified() {
        return $this->date_modified;
    }

    function getModified_user_id() {
        return $this->modified_user_id;
    }

    function getCreated_by() {
        return $this->created_by;
    }

    function getDescription() {
        return $this->description;
    }

    function getDeleted() {
        return $this->deleted;
    }

    function getAssigned_user_id() {
        return $this->assigned_user_id;
    }

    function getSalutation() {
        return $this->salutation;
    }

    function getFirst_name() {
        return $this->first_name;
    }

    function getLast_name() {
        return $this->last_name;
    }

    function getFull_name() {
        return $this->full_name;
    }

    function getTitle() {
        return $this->title;
    }

    function getPhoto() {
        return $this->photo;
    }

    function getDepartment() {
        return $this->department;
    }

    function getDo_not_call() {
        return $this->do_not_call;
    }

    function getPhone_home() {
        return $this->phone_home;
    }

    function getEmail() {
        return $this->email;
    }

    function getPhone_mobile() {
        return $this->phone_mobile;
    }

    function getPhone_work() {
        return $this->phone_work;
    }

    function getPhone_other() {
        return $this->phone_other;
    }

    function getPhone_fax() {
        return $this->phone_fax;
    }

    function getEmail1() {
        return $this->email1;
    }

    function getEmail2() {
        return $this->email2;
    }

    function getInvalid_email() {
        return $this->invalid_email;
    }

    function getEmail_opt_out() {
        return $this->email_opt_out;
    }

    function getPrimary_address_street() {
        return $this->primary_address_street;
    }

    function getPrimary_address_street2() {
        return $this->primary_address_street2;
    }

    function getPrimary_address_street3() {
        return $this->primary_address_street3;
    }

    function getPrimary_address_city() {
        return $this->primary_address_city;
    }

    function getPrimary_address_state() {
        return $this->primary_address_state;
    }

    function getPrimary_address_postalcode() {
        return $this->primary_address_postalcode;
    }

    function getPrimary_address_country() {
        return $this->primary_address_country;
    }

    function getAlt_address_street() {
        return $this->alt_address_street;
    }

    function getAlt_address_street2() {
        return $this->alt_address_street2;
    }

    function getAlt_address_street3() {
        return $this->alt_address_street3;
    }

    function getAlt_address_city() {
        return $this->alt_address_city;
    }

    function getAlt_address_state() {
        return $this->alt_address_state;
    }

    function getAlt_address_postalcode() {
        return $this->alt_address_postalcode;
    }

    function getAlt_address_country() {
        return $this->alt_address_country;
    }

    function getAssistant() {
        return $this->assistant;
    }

    function getAssistant_phone() {
        return $this->assistant_phone;
    }

    function getEmail_addresses_non_primary() {
        return $this->email_addresses_non_primary;
    }

    function getConverted() {
        return $this->converted;
    }

    function getRefered_by() {
        return $this->refered_by;
    }

    function getLead_source() {
        return $this->lead_source;
    }

    function getLead_source_description() {
        return $this->lead_source_description;
    }

    function getStatus() {
        return $this->status;
    }

    function getStatus_description() {
        return $this->status_description;
    }

    function getReports_to_id() {
        return $this->reports_to_id;
    }

    function getReport_to_name() {
        return $this->report_to_name;
    }

    function getAccount_name() {
        return $this->account_name;
    }

    function getAccount_description() {
        return $this->account_description;
    }

    function getContact_id() {
        return $this->contact_id;
    }

    function getAccount_id() {
        return $this->account_id;
    }

    function getOpportunity_id() {
        return $this->opportunity_id;
    }

    function getOpportunity_name() {
        return $this->opportunity_name;
    }

    function getOpportunity_amount() {
        return $this->opportunity_amount;
    }

    function getCampaign_id() {
        return $this->campaign_id;
    }

    function getCampaign_name() {
        return $this->campaign_name;
    }

    function getC_accept_status_fields() {
        return $this->c_accept_status_fields;
    }

    function getM_accept_status_fields() {
        return $this->m_accept_status_fields;
    }

    function getAccept_status_id() {
        return $this->accept_status_id;
    }

    function getAccept_status_name() {
        return $this->accept_status_name;
    }

    function getWebtolead_email1() {
        return $this->webtolead_email1;
    }

    function getWebtolead_email2() {
        return $this->webtolead_email2;
    }

    function getWebtolead_email_opt_out() {
        return $this->webtolead_email_opt_out;
    }

    function getWebtolead_invalid_email() {
        return $this->webtolead_invalid_email;
    }

    function getBirthdate() {
        return $this->birthdate;
    }

    function getPortal_name() {
        return $this->portal_name;
    }

    function getPortal_app() {
        return $this->portal_app;
    }

    function getWebsite() {
        return $this->website;
    }

    function getE_invite_status_fields() {
        return $this->e_invite_status_fields;
    }

    function getEvent_status_name() {
        return $this->event_status_name;
    }

    function getEvent_invite_id() {
        return $this->event_invite_id;
    }

    function getE_accept_status_fields() {
        return $this->e_accept_status_fields;
    }

    function getEvent_accept_status() {
        return $this->event_accept_status;
    }

    function getEvent_status_id() {
        return $this->event_status_id;
    }

    function getJjwg_maps_lat_c() {
        return $this->jjwg_maps_lat_c;
    }

    function getJjwg_maps_geocode_status_c() {
        return $this->jjwg_maps_geocode_status_c;
    }

    function getCust1_site_visit_recorder_leads_name() {
        return $this->cust1_site_visit_recorder_leads_name;
    }

    function getJjwg_maps_address_c() {
        return $this->jjwg_maps_address_c;
    }

    function getJjwg_maps_lng_c() {
        return $this->jjwg_maps_lng_c;
    }

    function setAssigned_user_name($assigned_user_name) {
        $this->assigned_user_name = $assigned_user_name;
    }

    function setModified_by_name($modified_by_name) {
        $this->modified_by_name = $modified_by_name;
    }

    function setCreated_by_name($created_by_name) {
        $this->created_by_name = $created_by_name;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setDate_entered($date_entered) {
        $this->date_entered = $date_entered;
    }

    function setDate_modified($date_modified) {
        $this->date_modified = $date_modified;
    }

    function setModified_user_id($modified_user_id) {
        $this->modified_user_id = $modified_user_id;
    }

    function setCreated_by($created_by) {
        $this->created_by = $created_by;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setDeleted($deleted) {
        $this->deleted = $deleted;
    }

    function setAssigned_user_id($assigned_user_id) {
        $this->assigned_user_id = $assigned_user_id;
    }

    function setSalutation($salutation) {
        $this->salutation = $salutation;
    }

    function setFirst_name($first_name) {
        $this->first_name = $first_name;
    }

    function setLast_name($last_name) {
        $this->last_name = $last_name;
    }

    function setFull_name($full_name) {
        $this->full_name = $full_name;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setPhoto($photo) {
        $this->photo = $photo;
    }

    function setDepartment($department) {
        $this->department = $department;
    }

    function setDo_not_call($do_not_call) {
        $this->do_not_call = $do_not_call;
    }

    function setPhone_home($phone_home) {
        $this->phone_home = $phone_home;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPhone_mobile($phone_mobile) {
        $this->phone_mobile = $phone_mobile;
    }

    function setPhone_work($phone_work) {
        $this->phone_work = $phone_work;
    }

    function setPhone_other($phone_other) {
        $this->phone_other = $phone_other;
    }

    function setPhone_fax($phone_fax) {
        $this->phone_fax = $phone_fax;
    }

    function setEmail1($email1) {
        $this->email1 = $email1;
    }

    function setEmail2($email2) {
        $this->email2 = $email2;
    }

    function setInvalid_email($invalid_email) {
        $this->invalid_email = $invalid_email;
    }

    function setEmail_opt_out($email_opt_out) {
        $this->email_opt_out = $email_opt_out;
    }

    function setPrimary_address_street($primary_address_street) {
        $this->primary_address_street = $primary_address_street;
    }

    function setPrimary_address_street2($primary_address_street2) {
        $this->primary_address_street2 = $primary_address_street2;
    }

    function setPrimary_address_street3($primary_address_street3) {
        $this->primary_address_street3 = $primary_address_street3;
    }

    function setPrimary_address_city($primary_address_city) {
        $this->primary_address_city = $primary_address_city;
    }

    function setPrimary_address_state($primary_address_state) {
        $this->primary_address_state = $primary_address_state;
    }

    function setPrimary_address_postalcode($primary_address_postalcode) {
        $this->primary_address_postalcode = $primary_address_postalcode;
    }

    function setPrimary_address_country($primary_address_country) {
        $this->primary_address_country = $primary_address_country;
    }

    function setAlt_address_street($alt_address_street) {
        $this->alt_address_street = $alt_address_street;
    }

    function setAlt_address_street2($alt_address_street2) {
        $this->alt_address_street2 = $alt_address_street2;
    }

    function setAlt_address_street3($alt_address_street3) {
        $this->alt_address_street3 = $alt_address_street3;
    }

    function setAlt_address_city($alt_address_city) {
        $this->alt_address_city = $alt_address_city;
    }

    function setAlt_address_state($alt_address_state) {
        $this->alt_address_state = $alt_address_state;
    }

    function setAlt_address_postalcode($alt_address_postalcode) {
        $this->alt_address_postalcode = $alt_address_postalcode;
    }

    function setAlt_address_country($alt_address_country) {
        $this->alt_address_country = $alt_address_country;
    }

    function setAssistant($assistant) {
        $this->assistant = $assistant;
    }

    function setAssistant_phone($assistant_phone) {
        $this->assistant_phone = $assistant_phone;
    }

    function setEmail_addresses_non_primary($email_addresses_non_primary) {
        $this->email_addresses_non_primary = $email_addresses_non_primary;
    }

    function setConverted($converted) {
        $this->converted = $converted;
    }

    function setRefered_by($refered_by) {
        $this->refered_by = $refered_by;
    }

    function setLead_source($lead_source) {
        $this->lead_source = $lead_source;
    }

    function setLead_source_description($lead_source_description) {
        $this->lead_source_description = $lead_source_description;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setStatus_description($status_description) {
        $this->status_description = $status_description;
    }

    function setReports_to_id($reports_to_id) {
        $this->reports_to_id = $reports_to_id;
    }

    function setReport_to_name($report_to_name) {
        $this->report_to_name = $report_to_name;
    }

    function setAccount_name($account_name) {
        $this->account_name = $account_name;
    }

    function setAccount_description($account_description) {
        $this->account_description = $account_description;
    }

    function setContact_id($contact_id) {
        $this->contact_id = $contact_id;
    }

    function setAccount_id($account_id) {
        $this->account_id = $account_id;
    }

    function setOpportunity_id($opportunity_id) {
        $this->opportunity_id = $opportunity_id;
    }

    function setOpportunity_name($opportunity_name) {
        $this->opportunity_name = $opportunity_name;
    }

    function setOpportunity_amount($opportunity_amount) {
        $this->opportunity_amount = $opportunity_amount;
    }

    function setCampaign_id($campaign_id) {
        $this->campaign_id = $campaign_id;
    }

    function setCampaign_name($campaign_name) {
        $this->campaign_name = $campaign_name;
    }

    function setC_accept_status_fields($c_accept_status_fields) {
        $this->c_accept_status_fields = $c_accept_status_fields;
    }

    function setM_accept_status_fields($m_accept_status_fields) {
        $this->m_accept_status_fields = $m_accept_status_fields;
    }

    function setAccept_status_id($accept_status_id) {
        $this->accept_status_id = $accept_status_id;
    }

    function setAccept_status_name($accept_status_name) {
        $this->accept_status_name = $accept_status_name;
    }

    function setWebtolead_email1($webtolead_email1) {
        $this->webtolead_email1 = $webtolead_email1;
    }

    function setWebtolead_email2($webtolead_email2) {
        $this->webtolead_email2 = $webtolead_email2;
    }

    function setWebtolead_email_opt_out($webtolead_email_opt_out) {
        $this->webtolead_email_opt_out = $webtolead_email_opt_out;
    }

    function setWebtolead_invalid_email($webtolead_invalid_email) {
        $this->webtolead_invalid_email = $webtolead_invalid_email;
    }

    function setBirthdate($birthdate) {
        $this->birthdate = $birthdate;
    }

    function setPortal_name($portal_name) {
        $this->portal_name = $portal_name;
    }

    function setPortal_app($portal_app) {
        $this->portal_app = $portal_app;
    }

    function setWebsite($website) {
        $this->website = $website;
    }

    function setE_invite_status_fields($e_invite_status_fields) {
        $this->e_invite_status_fields = $e_invite_status_fields;
    }

    function setEvent_status_name($event_status_name) {
        $this->event_status_name = $event_status_name;
    }

    function setEvent_invite_id($event_invite_id) {
        $this->event_invite_id = $event_invite_id;
    }

    function setE_accept_status_fields($e_accept_status_fields) {
        $this->e_accept_status_fields = $e_accept_status_fields;
    }

    function setEvent_accept_status($event_accept_status) {
        $this->event_accept_status = $event_accept_status;
    }

    function setEvent_status_id($event_status_id) {
        $this->event_status_id = $event_status_id;
    }

    function setJjwg_maps_lat_c($jjwg_maps_lat_c) {
        $this->jjwg_maps_lat_c = $jjwg_maps_lat_c;
    }

    function setJjwg_maps_geocode_status_c($jjwg_maps_geocode_status_c) {
        $this->jjwg_maps_geocode_status_c = $jjwg_maps_geocode_status_c;
    }

    function setCust1_site_visit_recorder_leads_name($cust1_site_visit_recorder_leads_name) {
        $this->cust1_site_visit_recorder_leads_name = $cust1_site_visit_recorder_leads_name;
    }

    function setJjwg_maps_address_c($jjwg_maps_address_c) {
        $this->jjwg_maps_address_c = $jjwg_maps_address_c;
    }

    function setJjwg_maps_lng_c($jjwg_maps_lng_c) {
        $this->jjwg_maps_lng_c = $jjwg_maps_lng_c;
    }


    
}
