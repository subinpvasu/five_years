<?php
/**
 * This is the connection page/model of the framework for the connection and work between the database.
 * @author ADMIN
 *
 */

class Customer_model extends CI_Model {

    /**
     * Inititlizes the model
     */
    public function __construct() {
        $this->load->database ();
    }
    /**
     * To change the format of the date to us-pacific
     * @param unknown $date : input date
     * @return string
     */
    public function date_format_us($date)
    {
        return $newDate = date("m/d/Y", strtotime($date));
    }
    /**
     * To change the format of the date to db
     * @param unknown $date : input date
     * @return string
     */
    public function date_format_db($date)
    {
        return $newDate = date("Y-m-d", strtotime($date));
    }
    /**
     * function for getting the table details
     */
    public function check_field_status()
    {

        $sql = "SHOW FIELDS FROM general_ledger";
        $query = $this->db->query($sql);
        $data['fields'] = $query->result();
        return $data['fields'][0]->Extra;

    }

    /**
     * a function for setting some initial properties to the db and the system, like AI of the table primary key.
     */
    public function set_database_auto_session()
    {
        $tables = array('anodes','customer_master','customer_vessel','diver_master','diver_transactions','general_ledger','hullclean','invoice','lookup','services',
	'vessel_anodes','vessel_services','work_order','work_order_parts');
        $table = array('PK_LEDGER'=>'general_ledger','PK_INVOICE'=>'invoice','PK_WO'=>'work_order','PK_WO_PARTS'=>'work_order_parts','PK_ANODE'=>'anodes','PK_HC'=>'hullclean','PK_DIVER'=>'diver_master','PK_GENERAL'=>'general_table','PK_DIVER_TRANS'=>'diver_transactions','PK_CUSTOMER'=>'customer_master','PK_VESSEL'=>'customer_vessel','PK_VESSEL_ANODE'=>'vessel_anodes','PK_VESSEL_SERVICE'=>'vessel_services');
        foreach ($table as $key=>$value):
        $sql = "SHOW FIELDS FROM $value";
        $query = $this->db->query($sql);
        $data['fields'] = $query->result();
        if($data['fields'][0]->Extra !='auto_increment')
        {
            $sql = "ALTER TABLE $value CHANGE $key $key INT( 11 ) NULL DEFAULT NULL AUTO_INCREMENT ";
             $this->db->query($sql);

        }
        endforeach;
        foreach($tables as $t):
        $nosql = "ALTER TABLE $t CHANGE ENTRY_BY ENTRY_BY TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ";
        $this->db->query($nosql);
        endforeach;
        $mysql = "UPDATE company_master SET CITY='Simi Valley' WHERE ACCOUNT_NO=1000";
        $this->db->query($mysql);
        $logsql = "CREATE TABLE IF NOT EXISTS outstanding_log
(
    LGID INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY(LGID), CUSTOMER VARCHAR(50),
	ACCOUNT VARCHAR(50),
            VESSEL VARCHAR(50),
            STATUS VARCHAR(50),
            INFO VARCHAR( 10 ) NOT NULL DEFAULT 'Y',
    AMOUNT VARCHAR(50),
    EXACT_TIME TIMESTAMP,
            KOUNT INT NOT NULL

)";
        $this->db->query($logsql);

    }
    /**
     * Returns the Basin names for the vessel
     */
    public function get_options_vessel() {
        $query = $this->db->query ( "SELECT OPTIONS FROM general_table WHERE PURPOSE='LOCATIONS' ORDER BY OPTIONS ASC" );
        return $query->result ();
    }
    /**
     * Return the vessel types of the vessel
     */
    public function get_vessel() {
        $query = $this->db->query ( "SELECT OPTIONS FROM general_table WHERE PURPOSE='VESSEL TYPE' ORDER BY OPTIONS ASC" );
        return $query->result ();
    }
    /**
     * Returns the bill modes applicable to the customer
     */
    public function get_options_billmode() {
        $query = $this->db->query ( "SELECT OPTIONS FROM general_table WHERE PURPOSE='DELIVERY MODE' ORDER BY OPTIONS ASC" );
        return $query->result ();
    }
    /**
     * Returns the Payment terms of th customers
     */
    public function get_options_terms() {
        $query = $this->db->query ( "SELECT OPTIONS FROM general_table WHERE PURPOSE='PAYMENT TERMS' ORDER BY OPTIONS ASC" );
        return $query->result ();
    }
    /**
     * Returns the Paint cycle of the vessel
     */
    public function get_options_paint() {
        $query = $this->db->query ( "SELECT * FROM general_table WHERE PURPOSE='PAINT CYCLE' ORDER BY VALUE ASC" );
        return $query->result ();
    }
    /**
     * returns of the cleaning service names to the customer
     */
    public function get_hull_clean_type() {
        $query = $this->db->query (
                                        "SELECT SERVICE_NAME, PK_HC FROM hullclean WHERE SERVICE_CLASS='HULL CLEANING' ORDER BY PK_HC ASC" );
        return $query->result ();
    }
    /**
     * Returns the Bow/AFt options
     */
    public function get_aft_rate() {
        $query = $this->db->query ( "SELECT VALUE FROM general_table WHERE OPTIONS='BOW/AFT' " );
        return $query->result ();
    }
    /**
     * returns bow rate
     */
    public function get_bow_rate() {
        $query = $this->db->query ( "SELECT VALUE FROM general_table WHERE OPTIONS='BOW' ORDER BY PK_GENERAL ASC LIMIT 1" );
        return $query->result ();
    }
    /**
     * Retruns the anode results according to the query given for search
     * @param unknown $string:search query
     */
    public function get_search_results($string) {
        $query = $this->db->query (
                                        "SELECT PK_ANODE,ANODE_TYPE,DESCRIPTION,RATE,SCHEDULE_CHANGE FROM anodes WHERE ANODE_TYPE LIKE '%$string%' ORDER BY PK_ANODE ASC " );
        return $query->result ();
    }
    /**
     * Returns the property of a single anode from the original anodes table
     * @param unknown $anode : primary key of the anode.
     */
    public function get_anode_property($anode) {
        $query = $this->db->query (
                                        "SELECT PK_ANODE,ANODE_TYPE,DESCRIPTION,RATE,SCHEDULE_CHANGE FROM anodes WHERE PK_ANODE=$anode " );
        return $query->result ();
    }
    /**
     * Returns the property of the anode which is listed in customer account
     * @param unknown $anode:priamry key of the anode
     */
    public function get_anode_property_from_vessel($anode) {
        $query = $this->db->query (
                                        "SELECT ANODE_TYPE,DESCRIPTION,SCHEDULE_CHANGE,DISCOUNT,LIST_PRICE,DISCOUNT_PRICE,ADDFIELD1 FROM vessel_anodes WHERE PK_VESSEL_ANODE='$anode' " );
        return $query->result ();
    }
    /**
     *
     * @param unknown $customer
     */
    public function get_customer_misc_details($customer) {
        $query = $this->db->query (
                                        "SELECT ZINC_REPLACEMENT,CLEANING,BILLING,SPECIAL,COMMENTS,ADDFIELD2 FROM customer_vessel WHERE PK_CUSTOMER='$customer' " );
        return $query->result ();
    }
    public function get_customer_account_number() {
        $query = $this->db->query ( "SELECT PK_CUSTOMER FROM customer_master ORDER BY PK_CUSTOMER DESC LIMIT 0,1" );
        return $query->result ();
    }
    public function get_vessel_primary_key() {
        $query = $this->db->query ( "SELECT PK_VESSEL FROM customer_vessel ORDER BY PK_VESSEL DESC LIMIT 0,1" );
        return $query->result ();
    }
    public function get_vessel_service_primary_key() {
        $query = $this->db->query ( "SELECT PK_VESSEL_SERVICE FROM vessel_services ORDER BY PK_VESSEL_SERVICE DESC LIMIT 0,1" );
        return $query->result ();
    }
    public function get_vessel_anode_primary_key() {
        $query = $this->db->query ( "SELECT PK_VESSEL_ANODE FROM vessel_anodes ORDER BY PK_VESSEL_ANODE DESC LIMIT 0,1" );
        return $query->result ();
    }
    /*
     * Read Data
     */
    /**
     * By sending the customer primary key retrieves the necessary  details of the customer and his/her vessel to the page/view customer_registration.
     *
     */
    public function get_customer_registration_details($customer) {
        $query = $this->db->query (
                                        "SELECT * FROM customer_master INNER JOIN customer_vessel ON customer_master.PK_CUSTOMER=customer_vessel.PK_CUSTOMER WHERE customer_master.PK_CUSTOMER='$customer' " );
        return $query->result ();
    }
    /**
     *
     * @param unknown_type $customer:primary key of the customer
     * returns the details of the customers vessel.
     */
    public function get_customer_vessel_details($customer) {
        $query = $this->db->query ( "SELECT * FROM customer_vessel WHERE PK_CUSTOMER='$customer' " );
        return $query->result ();
    }
    /**
     * Returns the cleaning service details of the customer.
     * @param unknown $customer:primary key of the customer
     */
    public function get_customer_service_details($customer) {
        $query = $this->db->query ( "SELECT *,DATE_FORMAT(ENTRY_DATE,  '%m/%d/%Y') AS ED,DATE_FORMAT(START_DATE,  '%m/%d/%Y') AS SD,DATE_FORMAT(END_DATE,  '%m/%d/%Y') AS DD FROM vessel_services WHERE PK_CUSTOMER='$customer' " );
        return $query->result ();
    }
    /**
     * Returns the anode details of the customer
     * @param unknown $customer : primary key of the customer
     */
    public function get_customer_anodes_details($customer) {
        $query = $this->db->query ( "SELECT * FROM vessel_anodes WHERE PK_CUSTOMER='$customer' ORDER BY PK_VESSEL_ANODE ASC" );
        return $query->result ();
    }
    /**
     * Returs the original anode primary key of the anode.
     * @param unknown $deta : search query
     */
    public function get_primary_key_from_table($deta) {
        $detaone = strtolower ( $deta );
        $detatwo = strtoupper ( $deta );

        $query = $this->db->query (
                                        "SELECT PK_ANODE FROM anodes WHERE DESCRIPTION LIKE '%$detaone%' OR DESCRIPTION LIKE '%$detatwo%' LIMIT 1 " );
        return $query->result ();
    }
    /**
     * unused function
     */
    public function get_details() {
        $query = $this->db->query ( "SELECT count(*) AS NUMBERS FROM `customer_master` WHERE ACCOUNT_NO LIKE 'SVAS%'" );
        return $query->result ();
    }
    /**
     * return the customer details with matching search query
     * @param unknown $string : search query
     * @param string $mode : ACTIVE|INACTIVE
     */
    public function get_customers_from_db($string, $mode = NULL) {
        if (! is_null ( $mode )) {
            if ($mode == 'ACTIVE') {
                $string = urldecode($string);
                $string = str_replace("^","/",$string);

                $query = $this->db->query (
                                                "SELECT customer_master.CUSTOMER_ID AS customer_id,customer_master.ACCOUNT_NO AS account,customer_master.FIRST_NAME AS firstname,customer_master.LAST_NAME AS lastname,
					customer_vessel.VESSEL_NAME AS vesselname,customer_vessel.LOCATION AS location,customer_vessel.SLIP AS slip FROM customer_master INNER JOIN customer_vessel
					ON customer_master.PK_CUSTOMER = customer_vessel.PK_CUSTOMER LEFT JOIN work_order ON customer_master.PK_CUSTOMER=work_order.PK_CUSTOMER  WHERE
                    customer_master.STATUS='$mode' AND ( customer_master.FIRST_NAME LIKE '%$string%' OR customer_master.LAST_NAME LIKE '%$string%' OR
                     customer_vessel.VESSEL_NAME
                                   LIKE '%$string%' OR customer_vessel.LOCATION LIKE '%$string%' OR   CONCAT_WS( ' ', FIRST_NAME, LAST_NAME ) LIKE '%$string%'
                                                OR   CONCAT_WS( ' ', customer_vessel.LOCATION, customer_vessel.SLIP ) LIKE '%$string%' OR   CONCAT(  customer_vessel.LOCATION, customer_vessel.SLIP ) LIKE '%$string%' OR customer_master.ACCOUNT_NO LIKE '%$string%' OR customer_vessel.SLIP LIKE '%$string%') GROUP BY customer_master.PK_CUSTOMER" );
            }
            if ($mode == 'INACTIVE') {
                 $string = urldecode($string);
                 $string = str_replace("^","/",$string);
                $query = $this->db->query (
                                                "SELECT customer_master.CUSTOMER_ID AS customer_id,customer_master.ACCOUNT_NO AS account,customer_master.FIRST_NAME AS firstname,customer_master.LAST_NAME AS lastname,
                                                customer_vessel.VESSEL_NAME AS vesselname,customer_vessel.LOCATION AS location,customer_vessel.SLIP AS slip FROM customer_master INNER JOIN customer_vessel
                                                ON customer_master.PK_CUSTOMER = customer_vessel.PK_CUSTOMER WHERE customer_master.STATUS='$mode' AND ( customer_master.FIRST_NAME LIKE '%$string%' OR customer_master.LAST_NAME LIKE '%$string%' OR
                     customer_vessel.VESSEL_NAME
                                   LIKE '%$string%' OR customer_vessel.LOCATION LIKE '%$string%' OR   CONCAT_WS( ' ', FIRST_NAME, LAST_NAME ) LIKE '%$string%'
                                                OR   CONCAT_WS( ' ', customer_vessel.LOCATION, customer_vessel.SLIP ) LIKE '%$string%' OR   CONCAT(  customer_vessel.LOCATION, customer_vessel.SLIP ) LIKE '%$string%' OR customer_master.ACCOUNT_NO LIKE '%$string%' OR customer_vessel.SLIP LIKE '%$string%') GROUP BY customer_master.PK_CUSTOMER" );
            }

        } else {
            $string = urldecode($string);
            $string = str_replace("^","/",$string);
            $query = $this->db->query (
                                            "SELECT customer_master.CUSTOMER_ID AS customer_id,customer_master.ACCOUNT_NO AS account,customer_master.FIRST_NAME AS firstname,customer_master.LAST_NAME AS lastname,
					customer_vessel.VESSEL_NAME AS vesselname,customer_vessel.LOCATION AS location,customer_vessel.SLIP AS slip FROM customer_master INNER JOIN customer_vessel
					ON customer_master.PK_CUSTOMER = customer_vessel.PK_CUSTOMER WHERE  (customer_master.FIRST_NAME LIKE '%$string%' OR customer_master.LAST_NAME LIKE '%$string%' OR   CONCAT_WS( ' ', customer_vessel.LOCATION, customer_vessel.SLIP ) LIKE '%$string%' OR CONCAT(  customer_vessel.LOCATION, customer_vessel.SLIP )
LIKE '%$string%' OR  CONCAT_WS( ' ', customer_master.FIRST_NAME, customer_master.LAST_NAME ) LIKE '%$string%' OR customer_master.ACCOUNT_NO LIKE '%$string%' OR customer_vessel.VESSEL_NAME LIKE '%$string%'  )" );
        }

        return $query->result ();

    }
    //get credits from db
    public function get_credits_from_db($string, $mode = NULL) {
    	if (! is_null ( $mode )) {
    		if ($mode == 'ACTIVE') {
    			$string = urldecode($string);
    			$string = str_replace("^","/",$string);

    			$query = $this->db->query (
    					"SELECT customer_master.CUSTOMER_ID AS customer_id, customer_master.ACCOUNT_NO AS account,customer_master.FIRST_NAME AS firstname,
customer_master.LAST_NAME AS lastname,
customer_vessel.VESSEL_NAME AS vesselname,
customer_vessel.LOCATION AS location,customer_vessel.SLIP AS slip
FROM customer_master
INNER JOIN customer_vessel
ON customer_master.PK_CUSTOMER = customer_vessel.PK_CUSTOMER
INNER JOIN work_order
ON customer_master.PK_CUSTOMER=work_order.PK_CUSTOMER
WHERE customer_master.STATUS='$mode' AND ( customer_master.FIRST_NAME LIKE '%$string%'
OR customer_master.LAST_NAME LIKE '%$string%'
OR customer_vessel.LOCATION LIKE '%$string%'
OR CONCAT_WS( ' ', FIRST_NAME, LAST_NAME ) LIKE '%$string%'
OR CONCAT_WS( ' ', customer_vessel.LOCATION, customer_vessel.SLIP ) LIKE '%$string%'
OR CONCAT(  customer_vessel.LOCATION, customer_vessel.SLIP )
LIKE '%$string%' OR customer_master.ACCOUNT_NO LIKE '%$string%'
OR customer_vessel.SLIP LIKE '%$string%' OR customer_vessel.VESSEL_NAME LIKE '%$string%') GROUP BY customer_master.PK_CUSTOMER
    order by customer_vessel.LOCATION
    					" );
    		}
    							if ($mode == 'INACTIVE') {
    									$string = urldecode($string);
    									$string = str_replace("^","/",$string);
    			$query = $this->db->query (
    			"SELECT customer_master.CUSTOMER_ID AS customer_id,customer_master.ACCOUNT_NO AS account,customer_master.FIRST_NAME AS firstname,customer_master.LAST_NAME AS lastname,
    			customer_vessel.VESSEL_NAME AS vesselname,customer_vessel.LOCATION AS location,customer_vessel.SLIP AS slip FROM customer_master INNER JOIN customer_vessel
    			ON customer_master.PK_CUSTOMER = customer_vessel.PK_CUSTOMER WHERE customer_master.STATUS!='ACTIVE' AND (customer_master.FIRST_NAME LIKE '%$string%' OR   CONCAT_WS( ' ', LOCATION, SLIP ) LIKE '%$string%' OR   CONCAT(  LOCATION, SLIP ) LIKE '%$string%'  OR customer_master.LAST_NAME LIKE '%$string%' OR  CONCAT_WS( ' ', customer_master.FIRST_NAME, customer_master.LAST_NAME ) LIKE '%$string%')" );
    			}

    			} else {
    			$string = urldecode($string);
    			$string = str_replace("^","/",$string);
    			$query = $this->db->query (
    			"SELECT customer_master.CUSTOMER_ID AS customer_id,customer_master.ACCOUNT_NO AS account,customer_master.FIRST_NAME AS firstname,customer_master.LAST_NAME AS lastname,
    			customer_vessel.VESSEL_NAME AS vesselname,customer_vessel.LOCATION AS location,customer_vessel.SLIP AS slip FROM customer_master INNER JOIN customer_vessel
    			ON customer_master.PK_CUSTOMER = customer_vessel.PK_CUSTOMER WHERE customer_master.STATUS='ACTIVE' AND   (customer_master.FIRST_NAME LIKE '%$string%' OR customer_master.LAST_NAME LIKE '%$string%' OR   CONCAT_WS( ' ', customer_vessel.LOCATION, customer_vessel.SLIP ) LIKE '%$string%' OR   CONCAT(  customer_vessel.LOCATION, customer_vessel.SLIP ) LIKE '%$string%' OR  CONCAT_WS( ' ', customer_master.FIRST_NAME, customer_master.LAST_NAME ) LIKE '%$string%' )" );
    			}

    			return $query->result ();

    			}
/**
 * Returns the invoice details from the db
 * @param unknown $customer : Primary key of the customer
 */
    public function get_customer_invoice_details($customer) {

        $query = $this->db->query (
                                        "SELECT customer_master.CUSTOMER_ID AS customer_id,general_ledger.INVOICE_NO AS invoice_no,DATE_FORMAT(general_ledger.TRANSACTION_DATE,  '%m/%d/%Y') AS invoice_date,
					general_ledger.PK_LEDGER AS ledgerid,DATE_FORMAT(general_ledger.TRANSACTION_DATE,  '%m/%d/%Y') AS transaction_date,general_ledger.CHECK_NO AS
					checkno,DATE_FORMAT(general_ledger.CHECK_DATE,  '%m/%d/%Y') AS check_date,general_ledger.DEBIT AS debit,general_ledger.CREDIT AS credit,
					general_ledger.NOTES AS notes FROM customer_master  INNER JOIN general_ledger ON customer_master.PK_CUSTOMER = general_ledger.pk_customer  WHERE customer_master.PK_CUSTOMER ='$customer' " );
        return $query->result ();
    }
/**
 * Returns the few  details from the db of the customer
 * @param unknown $customer : Priamry key of the customer
 */
    public function get_customer_invoice_info($customer) {
        $query = $this->db->query (
                                        "SELECT customer_master.CUSTOMER_ID AS customer_id,customer_master.FIRST_NAME AS firstname,customer_master.LAST_NAME AS lastname,
					customer_vessel.VESSEL_NAME AS vesselname,customer_vessel.LOCATION AS location,customer_vessel.SLIP AS slip FROM customer_master INNER JOIN customer_vessel ON customer_master.PK_CUSTOMER=customer_vessel.PK_CUSTOMER WHERE customer_master.PK_CUSTOMER='$customer'" );
        return $query->result ();
    }

    //credit billing details
    public function get_credit_billing_details($customer) {
    	$query = $this->db->query (
    			"SELECT  m.pk_customer cid, first_Name,
last_name, invoice_no invno, DATE_FORMAT(invoice_date,  '%m/%d/%Y')
    	                                AS invdt,
 sum(debit) billedc, sum(credit) received, sum(debit-credit) bal
  FROM customer_master m,  general_ledger g
  left outer join invoice i on i.pk_invoice=g.invoice_no
  where(m.pk_customer = g.pk_customer)
  and trans_type='S'
  and invoice_no not in (999,555)
  and m.pk_customer = '$customer'
  group by m.pk_customer,  first_Name, last_name, invoice_no, invoice_date ORDER BY `g`.`INVOICE_NO` DESC" );
    			return $query->result ();
    }
   // get cname in payment
     public function get_cname_in_payment($customer) {
    	$query = $this->db->query (
    			"SELECT concat(first_name,' ',last_name) as cust_name FROM customer_master where pk_customer='$customer'" );
    			return $query->result ();
    }
   //credits get_credits_amount_billed
    public function get_credits_amount_billed($customer) {
    	$query = $this->db->query (
    			" SELECT
 sum(debit) AS amount_billed
  FROM customer_master m,  general_ledger g
  left outer join invoice i on i.pk_invoice=g.invoice_no
  where(m.pk_customer = g.pk_customer)
  and trans_type='S'

  and m.pk_customer ='$customer'" );
    	return $query->result ();
    }
    //Payment billing Details
     public function get_payment_billing_details ($invoice) {
    	$query = $this->db->query (
    			"select customer_master.pk_customer,first_name,last_name from customer_master inner join invoice on customer_master.pk_customer=invoice.pk_customer where pk_invoice='$invoice'" );
    			return $query->result ();
     }
     //get cname if C in payment details
      public function get_cpay_bil_details ($cid) {
    	$query = $this->db->query (
    			"select pk_customer,first_name,last_name FROM customer_master where pk_customer='$cid'" );
    			return $query->result ();
     }
     //payments under payments
     public function get_payment_details_invoice ($invoice) {
    	$query = $this->db->query (
    			"select pk_ledger,check_no,check_date,credit from general_ledger where  invoice_no='$invoice' and trans_type='S' and credit>0" );
    			return $query->result ();
     }
     //credits under payment
      public function get_credit_payment_details ($customer) {
    	$query = $this->db->query (
    			"select pk_ledger,case when invoice_no =555 then 'Credit' else invoice_no end as invoice_no,
DATE_FORMAT(transaction_date,  '%m/%d/%Y') AS transaction_date,credit from general_ledger where  pk_customer='$customer' and credit>0 ORDER BY `general_ledger`.`PK_LEDGER` DESC" );
    			return $query->result ();
      }
    //payments under billing
     public function get_billing_details_invoice ($invoice) {
    	$query = $this->db->query (
    			"select wo_number,case wo_class
when 'C' then 'Cleaning Services'
when 'A' then 'Anode Services'
when 'M' then 'Mechanical'
else
wo_class
end as 'wo_class',schedule_date  from work_order where invoice_no='$invoice' order by wo_number");
    			return $query->result ();
     }
     //payments under billing if c get_c_billing_details(
      public function get_c_billing_details ($cid) {
    	$query = $this->db->query (
    			"SELECT 'C/F' as wo_number,transaction_date as wo_class, debit as schedule_date
 FROM general_ledger w where trans_type='S' and  invoice_no = 999 and pk_customer ='$cid'");
    			return $query->result ();
     }



     //work order no-payment
    public function  get_work_order_no($invoice)
    {
       // print_r($invoice);exit;
     $query = $this->db->query (
    			"select pk_wo from work_order where invoice_no='$invoice'" );
    			return $query->result ();
    }
    //get total discount from wo num-payment details


     public function  get_total_discount_wonum($wonum)
    {
       //  print_r($wonum);exit;
     $query = $this->db->query (
    			"select sum(discount_price) as discamt from work_order_parts where pk_wo='$wonum'" );
    			return $query->result ();
    }
    public function outstanding_standings($customer)
    {
        $sql = "SELECT * FROM outstanding_log WHERE CUSTOMER='$customer' ORDER BY outstanding_log.LGID DESC LIMIT 0 , 1";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
     //paymnet inser general ledger
      public function save_payment( $cust_id,$tran_date,$inv_no,$check_no,$check_date,$credit,$notes ){
          $today = date("Y-m-d");
        $data = array (
                                        'TRANS_TYPE'=>'S',
                                        'PK_CUSTOMER' => $cust_id,
                                        'TRANSACTION_DATE' => $tran_date,
                                        'INVOICE_NO' => $inv_no,
                                        'CHECK_NO' => $check_no,
                                        'CHECK_DATE' => $check_date,
                                        'CREDIT' =>$credit,
                                        'NOTES' => $notes ,
                                        'ENTRY_DATE' => $today
                );

        $this->db->insert ( 'general_ledger', $data );

        $data['outstanding'] = $this->outstanding_standings($cust_id);
        if(count($data['outstanding'])>0)
        {
            //  print_r($data['outstanding']);

            if($data['outstanding'][0]->KOUNT!=0)
            {
                $this->customer_hold_work_orders($cust_id);
            }
            else 
            {
                if($data['outstanding'][0]->INFO=='N')
                {
                    $this->customer_hold_work_orders($cust_id);
                }
            }
        }



        
      }
     
     //save credit payment
       public function save_credit_payment($repair, $cust_id,$tran_date,$check_no,$check_date,$credit,$notes ){
          $today = date("Y-m-d");
          if($repair==0)
          {
        $data = array (
                                        'TRANS_TYPE'=>'S',
                                        'PK_CUSTOMER' => $cust_id,
                                        'TRANSACTION_DATE' => $tran_date,
                                        'INVOICE_NO' => '555',
                                        'CHECK_NO' => $check_no,
                                        'CHECK_DATE' => $check_date,
                                        'CREDIT' =>$credit,
                                        'NOTES' => $notes ,
                                        'ENTRY_DATE' => $today
                );

        $this->db->insert ( 'general_ledger', $data );
           $data['outstanding'] = $this->outstanding_standings($cust_id);
        if(count($data['outstanding'])>0)
        {
            //print_r($data['outstanding']);

            if($data['outstanding'][0]->KOUNT!=0)
            {
                $this->customer_hold_work_orders($cust_id);
            }
            else
            {
                if($data['outstanding'][0]->INFO=='N')
                {
                    $this->customer_hold_work_orders($cust_id);
                }
            }
        }

          }
          else
          {

              $data['repaired'] = $this->last_invoice_from_customer($cust_id);
              $last_invoice = $data['repaired'][0]->PK_INVOICE;

              $data = array (
                                              'TRANS_TYPE'=>'S',
                                              'PK_CUSTOMER' => $cust_id,
                                              'TRANSACTION_DATE' => $tran_date,
                                              'INVOICE_NO' => $last_invoice,
                                              'CHECK_NO' => $check_no,
                                              'CHECK_DATE' => $check_date,
                                              'CREDIT' =>$credit,
                                              'NOTES' => $notes ,
                                              'ENTRY_DATE' => $today
              );

              $this->db->insert ( 'general_ledger', $data );

              $sql = "SELECT OUTSTANDING_BALANCE FROM invoice WHERE PK_INVOICE='$last_invoice' ";
              $query = $this->db->query($sql);
              $data['outbalance'] = $query->result();
              $outbal = $data['outbalance'][0]->OUTSTANDING_BALANCE;
              $credit_balance = $outbal-$credit;
              $mysql = "UPDATE invoice SET OUTSTANDING_BALANCE='$credit_balance' WHERE PK_INVOICE='$last_invoice'";
              $this->db->query($mysql);

              //check the hold work here
           $data['outstanding'] = $this->outstanding_standings($cust_id);
        if(count($data['outstanding'])>0)
        {

         //   print_r($data['outstanding']);

          if($data['outstanding'][0]->KOUNT!=0)
            {
                $this->customer_hold_work_orders($cust_id);
            }
            else
            {
                if($data['outstanding'][0]->INFO=='N')
                {
                    $this->customer_hold_work_orders($cust_id);
                }
            }
        }


              return $last_invoice;

          }
      }
/**
 * Returns the ledger details
 * @param unknown $ledger : Primary key of the ledger
 */
    public function get_ledger_from_db($ledger) {
        $query = $this->db->query ( "SELECT * FROM general_ledger WHERE PK_LEDGER='$ledger'" );
        return $query->result ();
    }
    /**
     * returns the customer work history
     * @param unknown $customer:priamry key of the customer
     */
    public function get_customer_work_history($customer) {
        $query = $this->db->query ("SELECT work_order.PK_WO AS workid, work_order.WO_NUMBER AS worknumber, work_order.WO_STATUS AS st, DATE_FORMAT( work_order.SCHEDULE_DATE, '%m/%d/%Y' ) AS schedule,work_order.SCHEDULE_DATE AS DATEORDER, work_order.WO_CLASS AS
type , work_order.INVOICE_NO AS invoice, work_order_parts.WORK_DESCRIPTION AS description
FROM work_order
INNER JOIN work_order_parts ON work_order.PK_WO = work_order_parts.PK_WO
LEFT JOIN invoice ON work_order.INVOICE_NO = invoice.PK_INVOICE
WHERE work_order.PK_CUSTOMER = '$customer' AND work_order.WO_CLASS!='A'
AND work_order_parts.WORK_VALUE != '0'

UNION

SELECT work_order.PK_WO AS workid, work_order.WO_NUMBER AS worknumber, work_order.WO_STATUS AS st, DATE_FORMAT( work_order.SCHEDULE_DATE, '%m/%d/%Y' ) AS schedule,work_order.SCHEDULE_DATE AS DATEORDER, work_order.WO_CLASS AS
type , work_order.INVOICE_NO AS invoice, work_order_parts.WORK_DESCRIPTION AS description
FROM work_order
INNER JOIN work_order_parts ON work_order.PK_WO = work_order_parts.PK_WO
LEFT JOIN invoice ON work_order.INVOICE_NO = invoice.PK_INVOICE
WHERE work_order.PK_CUSTOMER = '$customer' AND work_order.WO_CLASS='A'
AND work_order_parts.WORK_VALUE != '0'
GROUP BY work_order.PK_WO
ORDER BY DATEORDER DESC,workid DESC" );
        return $query->result ();
    }
    /**
     *
     * @param unknown $anode;Primary key of the anode
     */
    public function check_anode_available($anode) {
        $query = $this->db->query ( "SELECT COUNT(*) AS DUPAND FROM vessel_anodes WHERE PK_VESSEL_ANODE = '$anode'" );
        return $query->result ();
    }
    /**
     * Table vessel anode update sthe cahnegs occured to the anodes
     *
     * @param unknown $anode :Primary key for the vessel anode
     * @param unknown $anodelastdate : last changed datre for the anode
     * @param unknown $anodetype : Anode name
     * @param unknown $anodedescription : Anode description
     * @param unknown $anodediscount : discount applied for the customer
     * @param unknown $anodediscountprice : Discount price
     * @param unknown $anodelistprice : Actual Price
     * @param unknown $anodeschedule : period of expiration of anode
     * @return boolean
     */
    public function update_table_vessel_anode_edited(
        $anode,
        $anodelastdate,
        $anodetype,
        $anodedescription,
        $anodediscount,
        $anodediscountprice,
        $anodelistprice,
        $anodeschedule) {
        $datum = array (
                                        'ANODE_TYPE ' => $anodetype,
                                        'DESCRIPTION ' => $anodedescription,
                                        'DISCOUNT ' => $anodediscount,
                                        'LIST_PRICE' => $anodelistprice,
                                        'DISCOUNT_PRICE' => $anodediscountprice,
                                        'SCHEDULE_CHANGE' => $anodeschedule,
                                        'ADDFIELD1' => $anodelastdate );
        $this->db->where ( 'PK_VESSEL_ANODE', $anode );
        $this->db->update ( 'vessel_anodes', $datum );
        return true;

    }
    /**
     * Update the ledger table
     * @param unknown $ledgerkey : Priamry key of the Ledger entry
     * @param unknown $checkno : check no
     * @param unknown $checkdate : Check date
     * @param unknown $debit : total debit
     * @param unknown $credit : credit
     * @return boolean
     */
    public function update_general_ledger_account($ledgerkey, $checkno, $checkdate, $debit, $credit) {
        $datum = array ('CHECK_NO' => $checkno, 'CHECK_DATE' => $checkdate, 'DEBIT' => $debit, 'CREDIT' => $credit );
        $this->db->where ( 'PK_LEDGER', $ledgerkey );
        $this->db->update ( 'general_ledger', $datum );
        return true;

    }
    /**
     * Delete the row from the ldger
     * @param unknown $deleteid : Primary key of the ledger table
     * @return boolean
     */
    public function remove_account_row_from_general_ledger($deleteid) {
        $this->db->where ( 'PK_LEDGER', $deleteid );
        $this->db->delete ( 'general_ledger' );
        return true;
    }
    /**
     * Remove the anode from the customer profile
     * @param unknown $pk_vessel_anode:priamry key of the anode table
     * @return boolean
     */
    public function remove_added_anode($pk_vessel_anode) {
        $this->db->where ( 'PK_VESSEL_ANODE', $pk_vessel_anode );
        $this->db->delete ( 'vessel_anodes' );
        return true;
    }


    //list of invoice

    public function get_list_invoices_limit($from,$to) {

    	$mysql = "select CONCAT(c.first_name,' ',c.last_name)as CUSTOMER_NAME,i.PK_INVOICE ,DATE_FORMAT(i.INVOICE_DATE ,  '%m/%d/%Y') AS INVOICE_DATE,i.LP_AMOUNT_INVOICED,i.NET_AMOUNT_INVOICED from invoice i
INNER JOIN customer_master c
where i.pk_customer=c.customer_id  and i.invoice_date  between '$from' and '$to' ";
    	$query = $this->db->query ($mysql);
    	return $query->result ();
    }
    /**
     * Return the total amount of the invoices in period of the given dates
     * @param unknown $from : date
     * @param unknown $to :date
     */
    public function get_list_total_amount($from,$to)
    {
        $sql = "select sum(i.LP_AMOUNT_INVOICED) AS LP_AMOUNT,sum(i.NET_AMOUNT_INVOICED) AS NET_AMOUNT from invoice i

where  i.invoice_date  between '$from' and '$to'";
        $query = $this->db->query($sql);
        return $query->result();
    }
    /**
     * Returns the invoices for the given conditions
     * @param unknown $from : date
     * @param unknown $to : date
     * @param number $current : page number
     * @param number $perpage : per page
     * @param string $qry : search query
     */
    public function get_list_invoices_list($from,$to,$current = 0, $perpage = 32, $qry = null) {

    	if ($qry == null) {
            $asd="select CONCAT(c.first_name,' ',c.last_name)as CUSTOMER_NAME,i.PK_INVOICE ,DATE_FORMAT(i.INVOICE_DATE ,  '%m/%d/%Y') AS INVOICE_DATE
    	,i.LP_AMOUNT_INVOICED,i.NET_AMOUNT_INVOICED from invoice i
INNER JOIN customer_master c
where i.pk_customer=c.customer_id  and i.invoice_date  between '$from' and '$to' LIMIT $current,$perpage";
    		$query = $this->db->query ($asd );

    	} else {
    	    $qry =  urldecode($qry);
        		$query = $this->db->query (
    		"select CONCAT(c.first_name,' ',c.last_name)as CUSTOMER_NAME,i.PK_INVOICE ,DATE_FORMAT(i.INVOICE_DATE ,  '%m/%d/%Y') AS INVOICE_DATE,i.LP_AMOUNT_INVOICED,i.NET_AMOUNT_INVOICED from invoice i
INNER JOIN customer_master c
where CONCAT_WS( ' ', FIRST_NAME, LAST_NAME ) LIKE '%$qry%' AND i.pk_customer=c.customer_id  and i.invoice_date  between '$from' and '$to' LIMIT 0,$perpage" );
    		}
    		return $query->result ();
    		}
    		/**
    		 * Outstanding balance of the whole system
    		 */
    public function get_outstanding_balance_list_no_limit() {
        $query = $this->db->query (
                                        "SELECT ACCOUNT_NO, FIRST_NAME, LAST_NAME, VESSEL_NAME, sum( DEBIT ) AS DEBIT, sum( CREDIT ) AS CREDIT, SUM( DEBIT - CREDIT ) AS BALANCE
                                        FROM general_ledger
                                        INNER JOIN customer_master ON customer_master.PK_CUSTOMER = general_ledger.PK_CUSTOMER
                                        INNER JOIN customer_vessel ON customer_vessel.PK_CUSTOMER = customer_master.PK_CUSTOMER
                                        GROUP BY general_ledger.PK_CUSTOMER

                                        ORDER BY BALANCE DESC " );
        return $query->result ();
    }
    /**
     * Outstanding balnce if some conditions are applied
     * @param number $current : present page
     * @param number $perpage : perpage
     * @param string $qry : search query
     */
    public function get_outstanding_balance_list($current = 0, $perpage = 32, $qry = null) {
        if ($qry == null) {
            $query = $this->db->query (
                                            "SELECT ACCOUNT_NO, FIRST_NAME, LAST_NAME, VESSEL_NAME, sum( DEBIT ) AS DEBIT, sum( CREDIT ) AS CREDIT, SUM( DEBIT - CREDIT ) AS BALANCE
FROM general_ledger
INNER JOIN customer_master ON customer_master.PK_CUSTOMER = general_ledger.PK_CUSTOMER
INNER JOIN customer_vessel ON customer_vessel.PK_CUSTOMER = customer_master.PK_CUSTOMER
GROUP BY general_ledger.PK_CUSTOMER

ORDER BY BALANCE DESC LIMIT $current,$perpage" ); // LIMIT
                                                                                                  // $current,$perpage
        } else {$qry =  urldecode($qry);
            $query = $this->db->query (
                                            "SELECT ACCOUNT_NO, FIRST_NAME, LAST_NAME, VESSEL_NAME, sum( DEBIT ) AS DEBIT, sum( CREDIT ) AS CREDIT, SUM( DEBIT - CREDIT ) AS BALANCE
                                            FROM general_ledger
                                            INNER JOIN customer_master ON customer_master.PK_CUSTOMER = general_ledger.PK_CUSTOMER
                                            INNER JOIN customer_vessel ON customer_vessel.PK_CUSTOMER = customer_master.PK_CUSTOMER
                                            WHERE (FIRST_NAME LIKE '%$qry%' OR LAST_NAME LIKE '%$qry%' OR VESSEL_NAME LIKE '%$qry%' OR  CONCAT_WS( ' ', FIRST_NAME, LAST_NAME ) LIKE '%$qry%')
                                            GROUP BY general_ledger.PK_CUSTOMER
                                            ORDER BY BALANCE DESC LIMIT 0,$perpage" );
        }
        return $query->result ();
    }


    //Missing work order list

    public function get_missing_workorder_list() {

            $query = $this->db->query ("SELECT m.pk_customer as pk_customer , b.pk_vessel as pk_vessel , m.account_no,
concat(m.FIRST_NAME,' ', m.LAST_NAME) as cust_name,
  concat(b.LOCATION,'',b.SLIP) as location,  b.vessel_name,
(select max(schedule_date)  sd
          FROM work_order b
          where wo_class ='C'
          and pk_customer = m.pk_customer
          and pk_vessel =  b.pk_vessel) as schedule_date
        FROM customer_master m, customer_vessel b
        where m.pk_customer=b.pk_customer
        and status='ACTIVE'
        and Not exists (select * from work_order w where wo_status = 0
        and wo_class='C' and m.pk_customer=w.pk_customer)
        and exists (select * from work_order w1  where wo_status > 0
and wo_class='C' and m.pk_customer=w1.pk_customer) order by schedule_date  desc

                  ");
             return $query->result ();
    }





 //.......Monthly invoices................
//.......Monthly invoices................
    public function get_monthly_invoices_list($current = 0, $perpage = 32, $qry = null, $data) {
        $from = $data['from'];
        $to = $data['to'];
        if ($qry == null)
            {
$str="select
case work_order.wo_class
when 'C' then 'Hull Clean'
when 'A' then 'Anode Change'
when 'M' then 'Mech service'
else
work_order.wo_class
end as 'Class',
sum(list_PRICE) as list_price,sum(discount_price) as net_amnt,
date_format(invoice_date,'%M%Y') as 'month',
date_format(invoice_date,'%M') as 'mon' ,
date_format(invoice_date,'%Y') as 'year'
FROM work_order_parts
inner join work_order on
work_order_parts.pk_wo=work_order.pk_wo
where invoice_date between '$from' and '$to'
and
work_order.wo_class in('A','C','M')
group by date_format(invoice_date,'%Y '),date_format(invoice_date,'%m'),work_order.wo_class";

                $query = $this->db->query($str);
                $mydata = $query->result();

            }





         else {
            $qry = urldecode($qry);
            $query = $this->db->query();
        }


        return $mydata;
    }
    //monthwise monthly invoice

  public function get_monthwise_moninv_list($data) {
        $monYear = $data['mon_year'];

      $str="select
case work_order.wo_class
when 'C' then 'Hull Clean'
when 'A' then 'Anode Change'
when 'M' then 'Mech service'
else
work_order.wo_class
end as 'Class',
sum(list_PRICE) as list_price,sum(discount_price) as net_amnt,
date_format(invoice_date,'%M%Y') as 'month',
date_format(invoice_date,'%M') as 'mon' ,
date_format(invoice_date,'%Y') as 'year'
FROM work_order_parts
inner join work_order on
work_order_parts.pk_wo=work_order.pk_wo
where date_format(invoice_date,'%M%Y') ='$monYear'
and
work_order.wo_class in('A','C','M')
group by date_format(invoice_date,'%Y '),date_format(invoice_date,'%m'),work_order.wo_class";

                $query = $this->db->query($str);
                $mydata = $query->result();

        return $mydata;
    }


  //Amount recieved list momthly invoice
public function get_monthly_amountrecd_list($current = 0, $perpage = 32, $qry = null, $data) {
        $from = $data['from'];
        $to = $data['to'];
        if ($qry == null)
            {
$str="select sum(credit) as amt
from general_ledger
where
invoice_no<>555
and
transaction_date between '$from' and '$to'
group by date_format(transaction_date,'%Y'),date_format(transaction_date,'%m')";

                $query = $this->db->query($str);
                $mydata = $query->result();

            }





         else {
            $qry = urldecode($qry);
            $query = $this->db->query();
        }


        return $mydata;
    }
    		//month wise amt recd list
   public function get_monthwise_amtrecd_list($data) {
        $monYear = $data['mon_year'];

$str="select sum(credit) as amt
from general_ledger
where
date_format(transaction_date,'%M%Y') ='$monYear'
and invoice_no<>555
group by date_format(transaction_date,'%Y'),date_format(transaction_date,'%m')";

                $query = $this->db->query($str);
                $mydata = $query->result();

                return $mydata;
    }





/**
 * While searching the results are being filtered by thge given string
 * @param unknown $string : search query
 */

    public function get_cleaning_wo_from_db($string) {
        $string  = urldecode($string);
        $string = str_replace("^","/",$string);
        $query = $this->db->query (
                                        "SELECT customer_master.FIRST_NAME AS F, customer_master.LAST_NAME AS L, customer_vessel.VESSEL_NAME AS V,customer_vessel.SLIP AS SL, customer_vessel.LOCATION AS O,
                                   work_order.WO_CLASS AS W, work_order.WO_NUMBER AS R, work_order.PK_WO AS WK,work_order.INVOICE_SUB FROM customer_master INNER JOIN customer_vessel ON
                                   customer_master.PK_CUSTOMER = customer_vessel.PK_CUSTOMER INNER JOIN work_order  ON customer_master.PK_CUSTOMER = work_order.PK_CUSTOMER
                                   INNER JOIN work_order_parts ON work_order.PK_WO=work_order_parts.PK_WO
                                   WHERE ( customer_master.FIRST_NAME LIKE '%$string%' OR customer_master.LAST_NAME LIKE '%$string%' OR  customer_vessel.VESSEL_NAME
                                   LIKE '%$string%' OR customer_vessel.LOCATION LIKE '%$string%' OR work_order.WO_CLASS LIKE '%$string%' OR work_order.WO_NUMBER
                                   LIKE '%$string%' OR  CONCAT_WS( ' ', FIRST_NAME, LAST_NAME ) LIKE '%$string%' OR customer_master.ACCOUNT_NO LIKE '%$string%' OR
                                   customer_vessel.SLIP LIKE '%$string%' OR   CONCAT_WS( ' ', customer_vessel.LOCATION, customer_vessel.SLIP ) LIKE '%$string%' OR
                                   CONCAT(  customer_vessel.LOCATION, customer_vessel.SLIP ) LIKE '%$string%') AND work_order.WO_CLASS = 'C' AND work_order.WO_STATUS = '0'
                                   AND customer_master.STATUS='ACTIVE' AND work_order_parts.WORK_VALUE>0 GROUP BY work_order.PK_WO ORDER BY work_order.SCHEDULE_DATE ASC,work_order.PK_WO ASC " );
        return $query->result ();
    }

    /**
     * While searching the results are being filtered by thge given string
     * @param unknown $string : search query
     */
    public function get_anode_wo_from_db($string) {
        $string  = urldecode($string);
        $string  = str_replace("^","/",$string);
        $query = $this->db->query (
                                        "SELECT customer_master.FIRST_NAME AS F, customer_master.LAST_NAME AS L, customer_vessel.VESSEL_NAME AS V,customer_vessel.SLIP AS SL, customer_vessel.LOCATION AS O,
                                        work_order.WO_CLASS AS W, work_order.WO_NUMBER AS R, work_order.PK_WO AS WK FROM customer_master INNER JOIN customer_vessel ON
                                        customer_master.PK_CUSTOMER = customer_vessel.PK_CUSTOMER INNER JOIN work_order  ON customer_master.PK_CUSTOMER = work_order.PK_CUSTOMER
                                        INNER JOIN work_order_parts ON work_order.PK_WO=work_order_parts.PK_WO
                                        WHERE ( customer_master.FIRST_NAME LIKE '%$string%' OR customer_master.LAST_NAME LIKE '%$string%' OR  customer_vessel.VESSEL_NAME
                                   LIKE '%$string%' OR customer_vessel.LOCATION LIKE '%$string%' OR work_order.WO_CLASS LIKE '%$string%' OR work_order.WO_NUMBER
                                   LIKE '%$string%' OR  CONCAT_WS( ' ', FIRST_NAME, LAST_NAME ) LIKE '%$string%' OR customer_master.ACCOUNT_NO LIKE '%$string%' OR customer_vessel.SLIP LIKE '%$string%' OR   CONCAT_WS( ' ', customer_vessel.LOCATION, customer_vessel.SLIP ) LIKE '%$string%' OR   CONCAT(  customer_vessel.LOCATION, customer_vessel.SLIP ) LIKE '%$string%') AND work_order.WO_CLASS = 'A' AND work_order.WO_STATUS = '0' AND customer_master.STATUS='ACTIVE' AND work_order_parts.WORK_VALUE>0  GROUP BY work_order.PK_WO ORDER BY work_order.SCHEDULE_DATE ASC, work_order.PK_WO ASC" );
        return $query->result ();
    }

    /**
     * While searching the results are being filtered by thge given string
     * @param unknown $string : search query
     */
    public function get_mechanical_wo_from_db($string) {
        $string  = urldecode($string);
        $string = str_replace("^","/",$string);
        $query = $this->db->query (
                                        "SELECT customer_master.FIRST_NAME AS F, customer_master.LAST_NAME AS L, customer_vessel.VESSEL_NAME AS V,customer_vessel.SLIP AS SL, customer_vessel.LOCATION AS O,
                                        work_order.WO_CLASS AS W, work_order.WO_NUMBER AS R, work_order.PK_WO AS WK FROM customer_master INNER JOIN customer_vessel ON
                                        customer_master.PK_CUSTOMER = customer_vessel.PK_CUSTOMER INNER JOIN work_order  ON customer_master.PK_CUSTOMER = work_order.PK_CUSTOMER
                                        INNER JOIN work_order_parts ON work_order.PK_WO=work_order_parts.PK_WO
                                        WHERE ( customer_master.FIRST_NAME LIKE '%$string%' OR customer_master.LAST_NAME LIKE '%$string%' OR  customer_vessel.VESSEL_NAME
                                   LIKE '%$string%' OR customer_vessel.LOCATION LIKE '%$string%' OR work_order.WO_CLASS LIKE '%$string%' OR work_order.WO_NUMBER
                                   LIKE '%$string%' OR  CONCAT_WS( ' ', FIRST_NAME, LAST_NAME ) LIKE '%$string%' OR customer_master.ACCOUNT_NO LIKE '%$string%' OR customer_vessel.SLIP LIKE '%$string%' OR   CONCAT_WS( ' ', customer_vessel.LOCATION, customer_vessel.SLIP ) LIKE '%$string%' OR   CONCAT(  customer_vessel.LOCATION, customer_vessel.SLIP ) LIKE '%$string%') AND work_order.WO_CLASS = 'M' AND
                                         work_order.WO_STATUS = '0' AND customer_master.STATUS='ACTIVE'  GROUP BY work_order.PK_WO ORDER BY  work_order.SCHEDULE_DATE ASC,work_order.PK_WO ASC" );
        return $query->result ();
    }
    /**
     * While searching the results are being filtered by thge given string
     * @param unknown $string : search query
     */
    public function get_complete_wo_from_db($string) {
        $string  = urldecode($string);
        $string = str_replace("^","/",$string);
        $one = 1;
        $two = 2;
        $query = $this->db->query (
                                        "SELECT customer_master.FIRST_NAME AS F, customer_master.LAST_NAME AS L, customer_vessel.VESSEL_NAME AS V,customer_vessel.SLIP AS SL, customer_vessel.LOCATION AS O,
                                        work_order.WO_CLASS AS W, work_order.WO_NUMBER AS R, work_order.PK_WO AS WK FROM customer_master INNER JOIN customer_vessel ON
                                        customer_master.PK_CUSTOMER = customer_vessel.PK_CUSTOMER INNER JOIN work_order  ON customer_master.PK_CUSTOMER = work_order.PK_CUSTOMER
                                        INNER JOIN work_order_parts ON work_order.PK_WO=work_order_parts.PK_WO
                                        WHERE ( customer_master.FIRST_NAME LIKE '%$string%' OR customer_master.LAST_NAME LIKE '%$string%' OR  customer_vessel.VESSEL_NAME
                                   LIKE '%$string%' OR customer_vessel.LOCATION LIKE '%$string%' OR work_order.WO_CLASS LIKE '%$string%' OR work_order.WO_NUMBER
                                   LIKE '%$string%' OR  CONCAT_WS( ' ', FIRST_NAME, LAST_NAME ) LIKE '%$string%' OR   CONCAT_WS( ' ', customer_vessel.LOCATION, customer_vessel.SLIP ) LIKE '%$string%' OR
                                        CONCAT(  customer_vessel.LOCATION, customer_vessel.SLIP ) LIKE '%$string%' OR customer_master.ACCOUNT_NO LIKE '%$string%' OR customer_vessel.SLIP LIKE '%$string%') AND
                                         ( work_order.WO_STATUS=1 OR work_order.WO_STATUS=2) AND customer_master.STATUS='ACTIVE'  GROUP BY work_order.PK_WO ORDER BY work_order.SCHEDULE_DATE ASC,work_order.ENTRY_DATE ASC");
        return $query->result ();
    }
    /**
     * The top portion of the work order page are given from here like name,vessel,slip details
     * @param unknown $pkwork :primary key of the work order
     */
    public function get_customer_workorder_info($pkwork) {
        $query = $this->db->query (
                                        "SELECT customer_master.FIRST_NAME AS F,customer_master.LAST_NAME AS L,customer_vessel.VESSEL_NAME AS V,customer_vessel.SLIP AS S,
                                   customer_vessel.LOCATION AS O,customer_vessel.VESSEL_LENGTH AS LEN,customer_vessel.VESSEL_MAKE AS MAK,customer_vessel.VESSEL_TYPE AS TP,DATE_FORMAT( work_order.SCHEDULE_DATE, '%m/%d/%Y')
                                         AS SD,customer_vessel.PAINT_CYCLE AS PC,customer_master.PK_CUSTOMER AS P,work_order.WO_NUMBER AS W,work_order.WO_STATUS AS T,work_order.WO_CLASS AS Z,
                                   customer_vessel.PK_VESSEL AS PKV,customer_master.ACCOUNT_NO AS ACN,customer_vessel.COMMENTS AS COMMENTS,customer_master.EMAIL,customer_master.ADDFIELD1,customer_master.ADDFIELD2 FROM customer_master inner join customer_vessel on
                                   customer_master.PK_CUSTOMER=customer_vessel.PK_CUSTOMER INNER JOIN work_order on customer_master.PK_CUSTOMER=work_order.PK_CUSTOMER WHERE
                                   PK_WO='$pkwork'" );
        return $query->result ();
    }
    /*
     * Function for getting customer and vessel details to the add new work
     * order page.
     */
    public function get_customer_workorder_info_pk_customer($customer) {
        $query = $this->db->query (
                                        "SELECT customer_master.FIRST_NAME AS F,customer_master.LAST_NAME AS L,customer_master.ACCOUNT_NO AS A,customer_vessel.VESSEL_NAME AS V,
                                    customer_vessel.SLIP AS S,customer_vessel.LOCATION AS O,customer_master.PK_CUSTOMER AS P,customer_vessel.PK_VESSEL AS PV FROM customer_master inner join customer_vessel on
                                    customer_master.PK_CUSTOMER=customer_vessel.PK_CUSTOMER   WHERE  customer_master.PK_CUSTOMER='$customer'" );
        return $query->result ();
    }
    /*
     * Function for getting the last work order primary key
     */
    public function last_pk_from_work_order() {
        $query = $this->db->query ( "SELECT PK_WO FROM work_order ORDER BY PK_WO DESC LIMIT 0,1" );
        return $query->result ();
    }
    /*
     * Function for getting the work_order_parts primary key
     */
    public function last_pk_from_work_order_parts() {
        $query = $this->db->query ( "SELECT PK_WO_PARTS FROM work_order_parts ORDER BY PK_WO_PARTS DESC LIMIT 0,1" );
        return $query->result ();
    }
    public function check_last_exists($workpart)
    {
        $query = $this->db->query("SELECT PK_WO FROM work_order_parts WHERE PK_WO_PARTS='$workpart'");
        return $query->result();
    }
    /*
     * Function for saving new work order to work_order part 1
     */
    public function add_new_work_order( $wocustomer, $wovessel, $wonum, $woclass, $date, $divers, $comments) {
        $today = date ( "Y-m-d" );
        $data = array (

                                        'PK_CUSTOMER' => $wocustomer,
                                        'PK_VESSEL' => $wovessel,
                                        'WO_NUMBER' => $wonum,
                                        'WO_CLASS' => $woclass,
                                        'SCHEDULE_DATE' => $date,
                                        'PK_DIVER' => $divers,
                                        'COMMENTS' => $comments,
            'INVOICE_SUB'=>'1',
                                        'ENTRY_DATE' =>$today );
        $this->db->insert ( 'work_order', $data );
        //return $this->db->insert_id();
		echo $this->db->insert_id();
		exit;
    }
    /*
     * Function for saving work order details to work_order_parts
     */
    public function add_new_work_order_parts(

        $pkwork,
        $wkpk,
        $wkclass,
        $wkname,
        $wktype,
        $wkprice,
        $wkdiscount,
        $wkdisprice,
        $wkprocess,
                                    $change,
        $date,
        $desc) {
        $data = array (

                                        'PK_WO' => $pkwork,
                                        'PK_WORK' => $wkpk,
                                        'WO_CLASS' => $wkclass,
                                        'WORK_NAME' => $wkname,
                                        'WORK_TYPE' => $wktype,
                                        'WORK_VALUE' => $wkprocess,
                                        'WORK_DESCRIPTION' => $desc,
                                        'LIST_PRICE' => $wkprice,
                                        'DISCOUNT' => $wkdiscount,
                                        'DISCOUNT_PRICE' => $wkdisprice,
                                        'SCHEDULE_CHANGE'=>$change,
                                        'ADDFIELD1' => $date );
        $this->db->insert ( 'work_order_parts', $data );
    }
    /*
     * printing work order by class
     */
    public function clear_work_class($workno) {
        $query = $this->db->query ( "SELECT WO_CLASS FROM work_order WHERE PK_WO='$workno'" );
        return $query->result ();
    }
    /*
     * update db that the work order printed once.dsbhfbjdsnkfndjk
     */
    public function update_work_order_status_printed($pkwork) {
        $query = $this->db->query ( "UPDATE work_order SET CLEAN_STATUS=1 WHERE PK_WO='$pkwork'" );
        return true;
    }
    public function send_wo_invoice($status,$wonum)
    {
        /*
         * select work with the same wnum,check which are completed, select for invoicing.
         *
         */
        echo $wonum;
        $today = date ( "Y-m-d" );

        $sql = "SELECT PK_WO,WO_STATUS FROM work_order WHERE PK_CUSTOMER='$wonum' ";
        $query = $this->db->query($sql);
        $data['results'] = $query->result();
        echo $sql;
        print_r($data['results']);
        if($status==1):
        foreach ($data['results'] as $r):
        if($r->WO_STATUS==1):
        $this->db->query("UPDATE work_order SET WO_STATUS='2' WHERE PK_WO='$r->PK_WO'");

        endif;
        endforeach;
        endif;

        if($status==0):
        foreach ($data['results'] as $r):
        if($r->WO_STATUS==2):
        $this->db->query("UPDATE work_order SET WO_STATUS='1' WHERE PK_WO='$r->PK_WO'");

        endif;
        endforeach;
        endif;

    }
    /**
     * Get the cleaning work order details from both work_order and work_order_parts.
     * @param unknown $pkwork : primary key
     */
    public function get_cleaning_work_order_info($pkwork) {

		$sql = "SELECT *,DATE_FORMAT(SCHEDULE_DATE, '%m/%d/%Y') AS SCHEDULE_DATE FROM work_order_parts INNER
         JOIN work_order ON work_order_parts.PK_WO = work_order.PK_WO WHERE
         work_order.PK_WO='$pkwork'";
		 //echo $sql; 
		 //exit;
         $query = $this->db->query ( "SELECT *,DATE_FORMAT(SCHEDULE_DATE, '%m/%d/%Y') AS SCHEDULE_DATE FROM work_order_parts INNER
         JOIN work_order ON work_order_parts.PK_WO = work_order.PK_WO WHERE
         work_order.PK_WO='$pkwork'" ); return $query->result ();

    }
    /**
     * Get the  anode details for the customer details
     * @param unknown $pkwork : primary key
     */
    public function get_anode_work_order_info_pkcustomer($pkcustomer) {
        $query = $this->db->query ( "SELECT *,DATE_FORMAT( ADDFIELD1,  '%m/%d/%Y') AS ADDFIELD1
                                         FROM vessel_anodes WHERE PK_CUSTOMER='$pkcustomer' ORDER BY DESCRIPTION ASC" );
        return $query->result ();

    }
    /**
     * Get the vessel details from the db
     * @param unknown $pkcustomer:primary key of teh customer.
     */
    public function get_vessel_details_pkcustomer_comments($pkcustomer)
    {
        $sql = "SELECT * FROM customer_vessel WHERE PK_CUSTOMER='$pkcustomer'";
        $query = $this->db->query($sql);
        return $query->result();
    }
    /**
     * Select the correct seasonal services from the db by today as reference.
     * @param unknown $pkcustomer : priamry key of the customer table
     */
    public function get_clean_work_order_info_pkcustomer($pkcustomer,$season) {
        $sql = "SELECT * FROM vessel_services WHERE PK_CUSTOMER='$pkcustomer' AND SERVICE_SEASON IN ('$season','N')  ";






         $sql = $sql . ' AND FIRST_OR_SECOND <= 2 ORDER BY PK_VESSEL_SERVICE';
        $query = $this->db->query ($sql);
        return $query->result ();
    }
/**
 * Get the anode work order details from both the work_order and  work_order_parts table.
 * @param unknown $pkwork : priamry key
 */
    public function get_anode_work_order_info($pkwork) {
        $query = $this->db->query (
                                        "SELECT work_order_parts.PK_WO_PARTS AS P, work_order_parts.LIST_PRICE AS LIST_PRICE, work_order_parts.DISCOUNT AS DISCOUNT, work_order_parts.DISCOUNT_PRICE AS DISCOUNT_PRICE, work_order_parts.WORK_TYPE AS WORK_TYPE, work_order_parts.WORK_VALUE AS VALUE, DATE_FORMAT( vessel_anodes.ADDFIELD1, '%m/%d/%Y' ) AS CHANGED_DATE, DATE_FORMAT( work_order.SCHEDULE_DATE, '%m/%d/%Y' ) AS SCHEDULE_DATE, work_order.PK_DIVER AS PK_DIVER, work_order.COMMENTS AS COMMENTS, work_order_parts.SCHEDULE_CHANGE AS
CHANGED , work_order_parts.PK_WORK AS PKW, work_order.WO_STATUS
FROM work_order_parts
INNER JOIN work_order ON work_order_parts.PK_WO = work_order.PK_WO
LEFT JOIN vessel_anodes ON vessel_anodes.PK_VESSEL_ANODE = work_order_parts.PK_WORK  WHERE
                                   work_order.PK_WO='$pkwork' GROUP BY work_order_parts.PK_WO_PARTS ORDER BY WORK_VALUE DESC,WORK_TYPE ASC " );
        return $query->result ();
    }
    /**
     * List down the total anodes assigned  to a customer.
     * @param unknown $custom:customer primaruy key
     */
    public function get_total_anodes_info($custom)
    {
        $sql = "SELECT *,DATE_FORMAT( ADDFIELD1, '%m/%d/%Y') AS ADDFIELD1 FROM vessel_anodes WHERE PK_CUSTOMER='$custom' ORDER  BY DESCRIPTION ASC";
        $query =$this->db->query($sql);
        return $query->result();
    }
    /**
     * Get the cleaning service for th given date
     * @param unknown $custom: customer number
     * @param unknown $date : date input
     */
    public function get_total_services_info($custom,$date)
    {
        $sql = "SELECT * FROM vessel_services WHERE PK_CUSTOMER='$custom' ";
        $d = date_parse_from_format("Y-m-d", $date);
        if($d['month']>=4 && $d['month']<=10)
        {
            if($d['month']>=4 && $d['month']<10)
            {
                $sql = $sql . " AND SERVICE_SEASON IN ('S','N') ";
            }
            else if($d['month']==10 && $d['day']<17)
            {
                $sql = $sql . " AND SERVICE_SEASON IN ('S','N') ";
            }
            else {
                $sql = $sql . "  AND SERVICE_SEASON IN ('W','N') ";
            }

        }
        else
        {
            if($d['month']<3)
            {
            $sql = $sql . "  AND SERVICE_SEASON IN ('W','N') ";
            }
            if($d['month']>10)
            {
                $sql = $sql . "  AND SERVICE_SEASON IN ('W','N') ";
            }
            if($d['month']==3 && $d['day']<17)
            {
                $sql = $sql . "  AND SERVICE_SEASON IN ('W','N') ";
            }
            else
            {
                $sql = $sql . " AND SERVICE_SEASON IN ('S','N') ";
            }
        }
        $sql = $sql . ' AND FIRST_OR_SECOND <= 2 ORDER BY PK_VESSEL_SERVICE';
        $query =$this->db->query($sql);
        return $query->result();
    }
/**
 * Get the anodes details of the customer where the cleaning work order is given
 * @param unknown $pkwork
 */
    public function get_anodes_cleaning_work($pkwork){
        $sql = "SELECT PK_CUSTOMER FROM work_order WHERE PK_WO='$pkwork'";
        $query = $this->db->query($sql);
        $data['customer'] = $query->result();
        $customer = $data['customer'][0]->PK_CUSTOMER;
        $mysql = "SELECT ANODE_TYPE FROM vessel_anodes WHERE PK_CUSTOMER='$customer'";
        $qry = $this->db->query($mysql);
        return $qry->result();
    }
    /**
     * Daily work order works here wher e the date range is not given.
     * @param unknown $one : priamry filter
     * @param unknown $two : secondary filter
     * @param number $srt : sorting order
     */
    public function get_work_order_incomplete($one, $two,$srt=0) {

        $sql = "SELECT customer_master.FIRST_NAME AS FN, customer_master.LAST_NAME AS LN, customer_vessel.VESSEL_NAME AS VN, customer_vessel.LOCATION AS LO,
        work_order.WO_NUMBER AS WN, work_order.CLEAN_STATUS AS CS, work_order.WO_CLASS AS WC,work_order.PK_WO AS WO,work_order.PK_CUSTOMER,work_order.INVOICE_SUB FROM work_order INNER JOIN customer_master ON
        work_order.PK_CUSTOMER = customer_master.PK_CUSTOMER INNER JOIN customer_vessel ON customer_master.PK_CUSTOMER = customer_vessel.PK_CUSTOMER
        INNER JOIN work_order_parts ON work_order.PK_WO=work_order_parts.PK_WO
        WHERE WO_STATUS=0 AND work_order_parts.WORK_TYPE LIKE '%-MONTH%' AND work_order_parts.WORK_DESCRIPTION NOT LIKE '%EVERY TWO WEEKS%'";
// AND work_order_parts.WORK_TYPE LIKE '%-MONTH%' AND work_order_parts.WORK_DESCRIPTION NOT LIKE '%EVERY TWO WEEKS%'
        switch ($one) {
            case 1 :
                $today = date ( "Y-m-d" );
                $sql = $sql . " AND work_order.SCHEDULE_DATE='$today' ";
                break;
            case 2 :
                $t = mktime ( 0, 0, 0, date ( "m" ), date ( "d" ) + 1, date ( "Y" ) );
                $tomorrow = date ( "Y-m-d", $t );
                $sql = $sql . " AND work_order.SCHEDULE_DATE='$tomorrow' ";
                break;
            case 3 :
                $today = date ( "Y-m-d" );
                $t = mktime ( 0, 0, 0, date ( "m" ), date ( "d" ) + 7, date ( "Y" ) );
                $tomorrow = date ( "Y-m-d", $t );
                $sql = $sql . " AND work_order.SCHEDULE_DATE BETWEEN '$today' AND '$tomorrow' "; // between
                                                                                                 // '2011/02/25'
                                                                                                 // and
                                                                                                 // '2011/02/27'
                break;
            case 4 :
                $today = date ( "Y-m-d" );
                $t = mktime ( 0, 0, 0, date ( "m" ), date ( "d" ) + 15, date ( "Y" ) );
                $tomorrow = date ( "Y-m-d", $t );
                $sql = $sql . " AND work_order.SCHEDULE_DATE BETWEEN '$today' AND '$tomorrow' ";
                break;
            case 5 :
                $today = date ( "Y-m-d" );
                $sql = $sql . " AND work_order.SCHEDULE_DATE<'$today' ";
                break;
            default :
                break;
        }

        switch ($two) {
            case 1 :

                break;
            case 2 :
                $sql = $sql . " AND work_order.CLEAN_STATUS=1 ";
                break;
            case 3 :
                $sql = $sql . " AND work_order.CLEAN_STATUS=0 ";
                break;
            default :
                break;
        }
        $sql = $sql . " GROUP BY work_order.PK_WO ";

        switch($srt)
        {
            case 1:
                $sql = $sql . " ORDER BY work_order.WO_NUMBER ASC";
                 break;
            case 2:
                $sql = $sql . " ORDER BY work_order.WO_NUMBER DESC";
                break;
            case 3:
                $sql = $sql . " ORDER BY work_order.CLEAN_STATUS ASC";
                break;
            case 4:
                $sql = $sql . " ORDER BY work_order.CLEAN_STATUS DESC";
                break;
            case 5:
                $sql = $sql . " ORDER BY work_order.WO_CLASS ASC";
                break;
            case 6:
                $sql = $sql . " ORDER BY work_order.WO_CLASS DESC";
                break;
            case 7:
                $sql = $sql . " ORDER BY customer_master.FIRST_NAME ASC";
                break;
            case 8:
                $sql = $sql . " ORDER BY customer_master.FIRST_NAME DESC";
                break;
            case 9:
                $sql = $sql . " ORDER BY customer_vessel.VESSEL_NAME ASC";
                break;
            case 10:
                $sql = $sql . " ORDER BY customer_vessel.VESSEL_NAME DESC";
                break;
            case 11:
                $sql = $sql . " ORDER BY customer_vessel.LOCATION ASC";
                break;
            case 12:
                $sql = $sql . " ORDER BY customer_vessel.LOCATION DESC";
                break;
            default:
                $sql = $sql . " ORDER BY work_order.SCHEDULE_DATE ASC";
                break;
        }
        $query = $this->db->query ( $sql );

        return $query->result ();
    }
    /**
     * Daily wrkorder works from here but the date range is given
     * @param unknown $one : start date
     * @param unknown $two : end date
     * @param unknown $thr : printing status
     * @param number $srt  : sorting order.
     */
    public function get_work_order_incomplete_date($one, $two, $thr,$srt=0) {
        $sql = "SELECT customer_master.FIRST_NAME AS FN, customer_master.LAST_NAME AS LN, customer_vessel.VESSEL_NAME AS VN, customer_vessel.LOCATION AS LO,
        work_order.WO_NUMBER AS WN, work_order.CLEAN_STATUS AS CS, work_order.WO_CLASS AS WC,work_order.PK_WO AS WO,work_order.PK_CUSTOMER FROM work_order INNER JOIN customer_master ON
        work_order.PK_CUSTOMER = customer_master.PK_CUSTOMER INNER JOIN customer_vessel ON customer_master.PK_CUSTOMER = customer_vessel.PK_CUSTOMER
        INNER JOIN work_order_parts ON work_order.PK_WO=work_order_parts.PK_WO
        WHERE WO_STATUS=0 AND work_order.SCHEDULE_DATE BETWEEN '$one' AND '$two'  AND work_order_parts.WORK_TYPE LIKE '%-MONTH%' AND work_order_parts.WORK_DESCRIPTION NOT LIKE '%EVERY TWO WEEKS%' ";
        switch ($thr) {
            case 1 :

                break;
            case 2 :
                $sql = $sql . " AND work_order.CLEAN_STATUS=1 ";
                break;
            case 3 :
                $sql = $sql . " AND work_order.CLEAN_STATUS=0 ";
                break;
            default :
                break;
        }
        $sql = $sql . " GROUP BY work_order.PK_WO ";

        switch($srt)
        {
            case 1:
                $sql = $sql . " ORDER BY work_order.WO_NUMBER ASC";
                break;
            case 2:
                $sql = $sql . " ORDER BY work_order.WO_NUMBER DESC";
                break;
            case 3:
                $sql = $sql . " ORDER BY work_order.CLEAN_STATUS ASC";
                break;
            case 4:
                $sql = $sql . " ORDER BY work_order.CLEAN_STATUS DESC";
                break;
            case 5:
                $sql = $sql . " ORDER BY work_order.WO_CLASS ASC";
                break;
            case 6:
                $sql = $sql . " ORDER BY work_order.WO_CLASS DESC";
                break;
            case 7:
                $sql = $sql . " ORDER BY customer_master.FIRST_NAME ASC";
                break;
            case 8:
                $sql = $sql . " ORDER BY customer_master.FIRST_NAME DESC";
                break;
            case 9:
                $sql = $sql . " ORDER BY customer_vessel.VESSEL_NAME ASC";
                break;
            case 10:
                $sql = $sql . " ORDER BY customer_vessel.VESSEL_NAME DESC";
                break;
            case 11:
                $sql = $sql . " ORDER BY customer_vessel.LOCATION ASC";
                break;
            case 12:
                $sql = $sql . " ORDER BY customer_vessel.LOCATION DESC";
                break;
            default:
                $sql = $sql . " ORDER BY work_order.SCHEDULE_DATE ASC";
                break;
        }

        $query = $this->db->query ( $sql );
        return $query->result ();
    }
    /**
     * Get the mechanical work order details
     * @param unknown $pkwork : priamry key of the work order.
     */
    public function get_mechanical_work_order_info($pkwork) {
        $query = $this->db->query (
                                        "SELECT *,DATE_FORMAT(SCHEDULE_DATE ,  '%m/%d/%Y') AS SCHEDULE_DATE FROM  work_order_parts INNER JOIN work_order ON work_order_parts.PK_WO = work_order.PK_WO WHERE work_order.PK_WO='$pkwork'" );
        return $query->result ();
    }
    /**
     * Get the diver detials wher e the name is present.
     */
    public function get_diver_name() {
        $query = $this->db->query (
                                        "SELECT PK_DIVER , DIVER_ID , DIVER_NAME FROM diver_master  WHERE DIVER_NAME != '' ORDER BY PK_DIVER ASC " );
        return $query->result ();
    }
    /**
     * Make the work order to become void.
     * @param unknown $pkwork : work rder priamry key
     * @return boolean :true|false
     */
    public function void_work_order($pkwork) {

        $query = $this->db->query ( "UPDATE work_order SET WO_STATUS=4 WHERE PK_WO='$pkwork'" );
        return true;
    }
    /**
     * Deletre the given work order
     * @param unknown $pkwork : primary key oft heworkorder.
     * @return boolean
     */
    public function delete_work_order($pkwork) {
        $query = $this->db->query ( "DELETE FROM work_order WHERE PK_WO='$pkwork'" );
        return true;
    }
    /**
     * Calcualte the commision of the divers for completting a work order.it's done when the work order are being completed.
     * @param unknown $pkwork : primary key of the work order
     */
    public function update_diver_commission_extra($pkwork)
    {
        $sql = "SELECT work_order.WO_CLASS,work_order.PK_DIVER,work_order.WO_NUMBER,work_order_parts.DISCOUNT,work_order.SCHEDULE_DATE,SUM(work_order_parts.DISCOUNT_PRICE) AS INVRATE,
            SUM(work_order_parts.LIST_PRICE) AS LP,customer_vessel.VESSEL_NAME,customer_vessel.LOCATION,customer_vessel.SLIP,work_order_parts.WORK_TYPE FROM work_order
            INNER JOIN work_order_parts ON work_order.PK_WO=work_order_parts.PK_WO INNER JOIN customer_vessel ON work_order.PK_CUSTOMER=customer_vessel.PK_CUSTOMER WHERE
            work_order.PK_WO='$pkwork' AND work_order_parts.WORK_VALUE>0 AND work_order_parts.WORK_TYPE!='BOW' AND work_order_parts.WORK_TYPE!='BOW/AFT' AND work_order_parts.WORK_TYPE!='DINGHY' ";
        $query = $this->db->query($sql);
        $data['trans'] = $query->result();
        $dvr = $data['trans'][0]->PK_DIVER;
        $msql = "SELECT count(*) AS SCOUNT FROM work_order_parts WHERE PK_WO='$pkwork'  AND work_order_parts.WORK_VALUE>0";
        $mquery = $this->db->query($msql);
        $data['scount'] = $mquery->result();
        $cls = $data['trans'][0]->WO_CLASS;

        $rate = 0;
        $total = $data['trans'][0]->INVRATE;
        switch($cls)
        {
            case 'A':
                $ssql = "SELECT ZINC_RATE FROM diver_master WHERE PK_DIVER='$dvr'";
                $squery = $this->db->query($ssql);
                $data['calc'] =  $squery->result();
                //$rate = $data['calc'][0]->ZINC_RATE;
                $rate = 7;

                $amount = 7*($data['scount'][0]->SCOUNT);
                break;
            case 'C':
                $ssql = "SELECT HULL_CLEAN_RATE FROM diver_master WHERE PK_DIVER='$dvr'";
                $squery = $this->db->query($ssql);
                $data['calc'] =  $squery->result();
                $rate = $data['calc'][0]->HULL_CLEAN_RATE;
                $amount = 50*$total/100;
                break;
            case 'M':
                $ssql = "SELECT MECH_TIME_RATE FROM diver_master WHERE PK_DIVER='$dvr'";
                $squery = $this->db->query($ssql);
                $data['calc'] =  $squery->result();
                $rate = $data['calc'][0]->MECH_TIME_RATE;
                $amount = 50*$total/100;
                break;
            case 'Z':

                break;
            default:
                $rate = 0;
                break;
        }


        $today = date("Y-m-d");

        $value = array('PK_DIVER'=>$dvr,
'WO_CLASS'=>$data['trans'][0]->WO_CLASS,
'VESSEL_NAME'=>$data['trans'][0]->VESSEL_NAME,
'LOCATION'=>$data['trans'][0]->LOCATION.$data['trans'][0]->SLIP,
'WO_NUMBER'=>$data['trans'][0]->WO_NUMBER,
'SCHEDULE_DATE'=>$data['trans'][0]->SCHEDULE_DATE,
'INVOICED_RATE'=>$data['trans'][0]->INVRATE,
'SCOUNT'=>$data['scount'][0]->SCOUNT,
'COMMISSION_RATE'=>$rate,
'COMMISSION_AMOUNT'=>$amount,
'ENTRY_DATE'=>$today,
'LIST_PRICE'=>$data['trans'][0]->LP,
                                        'DISCOUNT'=>$data['trans'][0]->DISCOUNT);
       $this->db->insert ( 'diver_transactions', $value );

        $mzql = "SELECT count(*) AS DCOUNT FROM work_order_parts WHERE PK_WO='$pkwork'  AND WO_CLASS='C' AND (WORK_TYPE='BOW' OR WORK_TYPE='BOW/AFT' OR WORK_TYPE='DINGHY' )";
        $mzquery = $this->db->query($mzql);
        $data['dcount'] = $mzquery->result();
        if(($data['dcount'][0]->DCOUNT>0))
        {
            $pql = "SELECT work_order.WO_CLASS,work_order.PK_DIVER,work_order.WO_NUMBER,work_order_parts.DISCOUNT,work_order.SCHEDULE_DATE,SUM(work_order_parts.DISCOUNT_PRICE) AS INVRATE,
            SUM(work_order_parts.LIST_PRICE) AS LP,customer_vessel.VESSEL_NAME,customer_vessel.LOCATION,customer_vessel.SLIP,work_order_parts.WORK_TYPE FROM work_order
            INNER JOIN work_order_parts ON work_order.PK_WO=work_order_parts.PK_WO INNER JOIN customer_vessel ON work_order.PK_CUSTOMER=customer_vessel.PK_CUSTOMER WHERE
            work_order.PK_WO='$pkwork' AND work_order_parts.WORK_VALUE>0 AND (work_order_parts.WORK_TYPE='BOW' OR work_order_parts.WORK_TYPE='BOW/AFT' OR work_order_parts.WORK_TYPE='DINGHY') ";
            $pquery = $this->db->query($pql);
            $data['step'] = $pquery->result();
            if($data['step'][0]->INVRATE>0){
            $pdvr = $data['step'][0]->PK_DIVER;
            $prate = 0;
            $ptotal = $data['step'][0]->INVRATE;
            $pssql = "SELECT HULL_CLEAN_RATE FROM diver_master WHERE PK_DIVER='$pdvr'";
            $psquery = $this->db->query($pssql);
            $data['pcalc'] =  $psquery->result();
            $prate = $data['pcalc'][0]->HULL_CLEAN_RATE;
            $pamount = $prate*$ptotal/100;
            $today = date("Y-m-d");

            $pvalue = array('PK_DIVER'=>$pdvr,
                                            'WO_CLASS'=>$data['step'][0]->WO_CLASS,
                                            'VESSEL_NAME'=>$data['step'][0]->VESSEL_NAME,
                                            'LOCATION'=>$data['step'][0]->LOCATION.$data['step'][0]->SLIP,
                                            'WO_NUMBER'=>$data['step'][0]->WO_NUMBER,
                                            'SCHEDULE_DATE'=>$data['step'][0]->SCHEDULE_DATE,
                                            'INVOICED_RATE'=>$data['step'][0]->INVRATE,
                                            'SCOUNT'=>$data['scount'][0]->SCOUNT,
                                            'COMMISSION_RATE'=>$prate,
                                            'COMMISSION_AMOUNT'=>$pamount,
                                            'ENTRY_DATE'=>$today,
                                            'LIST_PRICE'=>$data['step'][0]->LP,
                                            'DISCOUNT'=>$data['step'][0]->DISCOUNT);
            $this->db->insert ( 'diver_transactions', $pvalue );
        }//ends here....
        }
        $this->complete_work_order($pkwork);
    }
    /**
     * Complete the work order
     * @param unknown $pkwork : priamry key of the work order.,
     * @return boolean
     */
    public function complete_work_order($pkwork) {

        $query = $this->db->query ( "UPDATE work_order SET WO_STATUS=1 WHERE PK_WO='$pkwork'" );
        echo 'Y';
    }
    /**
     * Work order parts are updated here , all the details are sent to here and update to db here
     * @param unknown $pk : priamry key of the workorder patrs
     * @param unknown $price : price of the work order
     * @param unknown $discount : discount
     * @param unknown $disprice : discounted price
     * @param unknown $process :status
     * @param unknown $lastdate : date
     * @param unknown $type :type of the work
     * @param unknown $description :description
     * @param unknown $flag :if completed it's 1 and then the anode work order updates with last changed date
     * @return boolean
     */
    public function update_work_order_parts($pk, $price, $discount, $disprice, $process, $lastdate,$type, $description,$flag) {
        $sql = "UPDATE work_order_parts SET LIST_PRICE='$price',DISCOUNT='$discount',DISCOUNT_PRICE='$disprice',WORK_TYPE='$type',WORK_DESCRIPTION='$description',WORK_VALUE='$process' WHERE PK_WO_PARTS='$pk'";
        $query = $this->db->query ($sql);
        if($flag==1)
        {
            $mysql = "SELECT PK_WORK,ADDFIELD1,WORK_VALUE FROM work_order_parts WHERE PK_WO_PARTS='$pk'";
            $query = $this->db->query($mysql);
            $data['result'] = $query->result();
            $pkanode = $data['result'][0]->PK_WORK;
            $datenow = $data['result'][0]->ADDFIELD1;
            $wvalue = $data['result'][0]->WORK_VALUE;
            if($wvalue>0)
            {
            $nosql = "UPDATE vessel_anodes SET ADDFIELD1='$lastdate' WHERE PK_VESSEL_ANODE='$pkanode'";
            $mosql = "UPDATE vessel_anodes SET ADDFIELD2='$datenow' WHERE PK_VESSEL_ANODE='$pkanode'";
            $psql = "UPDATE work_order_parts SET ADDFIELD1='$lastdate' WHERE PK_WO_PARTS='$pk'";
            $this->db->query($psql);
            $this->db->query($nosql);
            $this->db->query($mosql);
            }


        }
        return true;
    }
    /**
     *Update the work order details.
     * @param unknown $pkwork : work order primary key
     * @param unknown $worknum : work order number
     * @param unknown $dated : schedule date
     * @param unknown $diver : diver id if any,
     * @param unknown $comments : comments if any,
     * @return boolean
     */
    public function update_work_order($pkwork,$worknum, $dated, $diver, $comments) {
        $query = $this->db->query (
                                        "UPDATE work_order SET SCHEDULE_DATE='$dated',WO_NUMBER='$worknum',PK_DIVER='$diver',COMMENTS='$comments' WHERE PK_WO='$pkwork'" );
        return true;
    }
    /**
     * Getting other completed work orders of same vessel for suggesting  invoicing.
     * @param string $customer : customer primary key
     * @param string $diver : diver id
     * @param string $date :
     * @param string $dual :
     */
    public function get_complete_wo_for_invoice($customer=null,$diver=null,$date=null,$dual=null)
    {
        $sql = "SELECT customer_master.PK_CUSTOMER, PK_WO, WO_NUMBER, WO_CLASS, DATE_FORMAT(SCHEDULE_DATE,  '%m/%d/%Y') AS SCHEDULE_DATE
    , DELIVERY_MODE, FIRST_NAME, LAST_NAME, VESSEL_NAME,DIVER_NAME
        FROM customer_master
        INNER JOIN customer_vessel ON customer_master.PK_CUSTOMER = customer_vessel.PK_CUSTOMER
        INNER JOIN work_order ON customer_master.PK_CUSTOMER = work_order.PK_CUSTOMER INNER JOIN diver_master ON work_order.PK_DIVER=diver_master.PK_DIVER ";

        if(is_null($customer))
        {
        $sql .= "
WHERE work_order.WO_STATUS =2 AND customer_master.STATUS='ACTIVE'
ORDER BY customer_master.PK_CUSTOMER ASC ";
        }
       if(is_numeric($customer))
        {
            $sql .= "
            WHERE work_order.WO_STATUS =2 AND customer_master.STATUS='ACTIVE'  AND customer_master.PK_CUSTOMER= '$customer'
            ORDER BY customer_master.PK_CUSTOMER ASC ";
        }
        if($customer=='diver')
        {
            if(is_numeric($diver))
            {
                $sql .= "
                WHERE work_order.WO_STATUS =2 AND customer_master.STATUS='ACTIVE'  AND work_order.PK_DIVER= '$diver'
                ORDER BY customer_master.PK_CUSTOMER ASC ";
            }
            else
            {
                $sql .= "
                WHERE work_order.WO_STATUS =2  AND customer_master.STATUS='ACTIVE'
                ORDER BY customer_master.PK_CUSTOMER ASC ";
            }
        }
        if($customer=='date')
        {
            $sql .= "
            WHERE work_order.WO_STATUS =2 AND customer_master.STATUS='ACTIVE'  AND work_order.SCHEDULE_DATE BETWEEN '$diver' AND '$date'
            ORDER BY customer_master.PK_CUSTOMER ASC ";
        }
        if($customer=='dual')
        {
            if(is_numeric($diver))
            {
            $sql .= "
            WHERE work_order.WO_STATUS =2 AND customer_master.STATUS='ACTIVE'  AND work_order.SCHEDULE_DATE BETWEEN '$date' AND '$dual' AND work_order.PK_DIVER= '$diver'
            ORDER BY customer_master.PK_CUSTOMER ASC ";
            }
            else
            {
                $sql .= "
                WHERE work_order.WO_STATUS =2 AND customer_master.STATUS='ACTIVE'  AND work_order.SCHEDULE_DATE BETWEEN '$date' AND '$dual'
                ORDER BY customer_master.PK_CUSTOMER ASC ";
            }
        }
         $query = $this->db->query ($sql);
                                            return $query->result ();

    }
    /*
     * Save Data
     */

    /**
     * Saving customer registration data into db.
     * @return boolean
     */
    public function set_customer_data() {

        $this->load->helper ( 'url' );

        $customer_account = $this->input->post ( 'account_no' );
        if (is_null ( $customer_account ) || $customer_account = '' || empty ( $customer_account )) {
            $customer_account = strtoupper (
                                            substr ( $this->input->post ( 'first_name' ), 0, 1 ) . substr (
                                                                            $this->input->post ( 'last_name' ),
                                                                            0,
                                                                            3 ) );
            $query = $this->db->query (
                                            "SELECT count(*) AS NUMBERS FROM `customer_master` WHERE ACCOUNT_NO LIKE '$customer_account%'" );
            $data ['good'] = $query->result ();
            foreach ( $data ['good'] as $good ) {
                $num = $good->NUMBERS;
            }

            $num ++;
            if ($num <= 9) {
                $customer_account = $customer_account . "0";
            }
            $customer_account = $customer_account . $num;
            $this->session->set_userdata ( 'account_no', $customer_account );
        }
        if (($this->input->post ( 'bill_address' )) == '') {
            $bill_address = $this->input->post ( 'address' );
            $bill_address1 = $this->input->post ( 'address1' );
            $bill_city = $this->input->post ( 'city' );
            $bill_state = $this->input->post ( 'state' );
            $bill_zip = $this->input->post ( 'zip' );
            $bill_country = $this->input->post ( 'country' );
        } else {
            $bill_address = $this->input->post ( 'bill_address' );
            $bill_address1 = $this->input->post ( 'bill_address1' );
            $bill_city = $this->input->post ( 'bill_city' );
            $bill_state = $this->input->post ( 'bill_state' );
            $bill_zip = $this->input->post ( 'bill_zip' );
            $bill_country = $this->input->post ( 'bill_country' );
        }
        $PKC = $this->input->post ( 'customerid' );
        $data = array (
                                        'PK_CUSTOMER' => $this->input->post ( 'customerid' ),
                                        'CUSTOMER_ID' => $this->input->post ( 'customerid' ),
                                        'ACCOUNT_NO' => $customer_account,
                                        'FIRST_NAME' => $this->input->post ( 'first_name' ),
                                        'MIDDLE_NAME' => $this->input->post ( 'middle_name' ),
                                        'LAST_NAME' => $this->input->post ( 'last_name' ),
                                        'ADDRESS' => $this->input->post ( 'address' ),
                                        'ADDRESS1' => $this->input->post ( 'address1' ),
                                        'CITY' => $this->input->post ( 'city' ),
                                        'STATE' => $this->input->post ( 'state' ),
                                        'ZIPCODE' => $this->input->post ( 'zip' ),
                                        'COUNTRY' => $this->input->post ( 'country' ),
                                        'BILL_TO' => $this->input->post ( 'bill_to' ),
                                        'BILL_ADDRESS' => $bill_address,
                                        'BILL_ADDRESS1' => $bill_address1,
                                        'BILL_CITY' => $bill_city,
                                        'BILL_STATE' => $bill_state,
                                        'BILL_ZIPCODE' => $bill_zip,
                                        'BILL_COUNTRY' => $bill_country,
                                        'CELL_PHONE' => $this->input->post ( 'cell' ),
                                        'HOME_PHONE' => $this->input->post ( 'home_phone' ),
                                        'OFFICE_PHONE' => $this->input->post ( 'office_phone' ),
                                        'FAX_NO' => $this->input->post ( 'fax' ),
                                        'EMAIL' => $this->input->post ( 'email' ),
                                        'CONTACT' => $this->input->post ( 'contact' ),
                                        'ALT_CELL_PHONE' => $this->input->post ( 'referred_cell' ),
                                        'ALT_HOME_PHONE' => $this->input->post ( 'referred_home_phone' ),
                                        'ALT_OFFICE_PHONE' => $this->input->post ( 'referred_office_phone' ),
                                        'ALT_FAX_NO' => $this->input->post ( 'referred_fax' ),
                                        'ALT_CONTACT' => $this->input->post ( 'referred_contact' ),
                                        'STATUS' => $this->input->post ( 'status' ),
                                        'TERMS' => $this->input->post ( 'payment_terms' ),
                                        'DELIVERY_MODE' => $this->input->post ( 'bill_mode' ),
                                        'ADDFIELD1' => $this->input->post ( 'emailcc' ),
                                        'ADDFIELD2' => $this->input->post ( 'emailbcc' ) );

        $datum = array (
                                        'CUSTOMER_ID' => $this->input->post ( 'customerid' ),
                                        'FIRST_NAME' => $this->input->post ( 'first_name' ),
                                        'MIDDLE_NAME' => $this->input->post ( 'middle_name' ),
                                        'LAST_NAME' => $this->input->post ( 'last_name' ),
                                        'ADDRESS' => $this->input->post ( 'address' ),
                                        'ADDRESS1' => $this->input->post ( 'address1' ),
                                        'CITY' => $this->input->post ( 'city' ),
                                        'STATE' => $this->input->post ( 'state' ),
                                        'ZIPCODE' => $this->input->post ( 'zip' ),
                                        'COUNTRY' => $this->input->post ( 'country' ),
                                        'BILL_TO' => $this->input->post ( 'bill_to' ),
                                        'BILL_ADDRESS' => $bill_address,
                                        'BILL_ADDRESS1' => $bill_address1,
                                        'BILL_CITY' => $bill_city,
                                        'BILL_STATE' => $bill_state,
                                        'BILL_ZIPCODE' => $bill_zip,
                                        'BILL_COUNTRY' => $bill_country,
                                        'CELL_PHONE' => $this->input->post ( 'cell' ),
                                        'HOME_PHONE' => $this->input->post ( 'home_phone' ),
                                        'OFFICE_PHONE' => $this->input->post ( 'office_phone' ),
                                        'FAX_NO' => $this->input->post ( 'fax' ),
                                        'EMAIL' => $this->input->post ( 'email' ),
                                        'CONTACT' => $this->input->post ( 'contact' ),
                                        'ALT_CELL_PHONE' => $this->input->post ( 'referred_cell' ),
                                        'ALT_HOME_PHONE' => $this->input->post ( 'referred_home_phone' ),
                                        'ALT_OFFICE_PHONE' => $this->input->post ( 'referred_office_phone' ),
                                        'ALT_FAX_NO' => $this->input->post ( 'referred_fax' ),
                                        'ALT_CONTACT' => $this->input->post ( 'referred_contact' ),
                                        'STATUS' => $this->input->post ( 'status' ),
                                        'TERMS' => $this->input->post ( 'payment_terms' ),
                                        'DELIVERY_MODE' => $this->input->post ( 'bill_mode' ),
                                        'ADDFIELD1' => $this->input->post ( 'emailcc' ),
                                        'ADDFIELD2' => $this->input->post ( 'emailbcc' ) );

        $status = $this->db->query ( "SELECT COUNT(*) AS DUP FROM customer_master WHERE PK_CUSTOMER='$PKC' " );
        $datas ['dup'] = $status->result ();
        if ($datas ['dup'] [0]->DUP > 0) {
            $this->db->where ( 'PK_CUSTOMER', $PKC );
            $this->db->update ( 'customer_master', $datum );
            $this->session->set_userdata('return',true);
        } else {

            $this->db->insert ( 'customer_master', $data );
            $pkcustomer = $this->db->insert_id();
            $dada = array(
                'PK_CUSTOMER'=>$pkcustomer
            );
            $this->db->insert('customer_vessel',$dada);

        }
        return true;

    }
/**
 * Saving vessel details to db
 */
    public function set_vessel_data() {

        $pkvessel = $this->input->post ( 'vesselid' );
        $pkcustomer = $this->input->post ( 'customerid' );
        $location = $this->input->post ( 'location' );
        $slip = $this->input->post ( 'slip' );
        $vesselcf = $this->input->post ( 'cfno' );
        $vesselmake = $this->input->post ( 'make' );
        $vesselmodel = $this->input->post ( 'model' );
        $vessellength = $this->input->post ( 'length' );
        $vesselname = $this->input->post ( 'vessel_name' );
        $vesseltender = $this->input->post ( 'tender_dinghy' );
        $vesseldesc = $this->input->post ( 'vessel_description' );
        $vesseltype = $this->input->post ( 'type' );
        $paintcycle = $this->input->post ( 'paint_cycle' );
		
		$data = array (
                                        'PK_VESSEL' => $pkvessel,
                                        'PK_CUSTOMER' => $pkcustomer,
                                        'LOCATION' => $location,
                                        'SLIP' => $slip,
                                        'VESSEL_CF' => $vesselcf,
                                        'VESSEL_MAKE' => $vesselmake,
                                        'VESSEL_MODEL' => $vesselmodel,
                                        'VESSEL_LENGTH' => $vessellength,
                                        'VESSEL_NAME' => $vesselname,
                                        'VESSEL_TENDER' => $vesseltender,
                                        'VESSEL_DESC' => $vesseldesc,
                                        'VESSEL_TYPE' => $vesseltype,
                                        'PAINT_CYCLE' => $paintcycle );

        $datum = array (
                                        'PK_CUSTOMER' => $pkcustomer,
                                        'LOCATION' => $location,
                                        'SLIP' => $slip,
                                        'VESSEL_CF' => $vesselcf,
                                        'VESSEL_MAKE' => $vesselmake,
                                        'VESSEL_MODEL' => $vesselmodel,
                                        'VESSEL_LENGTH' => $vessellength,
                                        'VESSEL_NAME' => $vesselname,
                                        'VESSEL_TENDER' => $vesseltender,
                                        'VESSEL_DESC' => $vesseldesc,
                                        'VESSEL_TYPE' => $vesseltype,
                                        'PAINT_CYCLE' => $paintcycle );


            $this->session->set_userdata('return',true);
            $this->db->where ( 'PK_VESSEL', $pkvessel );
            $this->db->update ( 'customer_vessel', $datum );
			//return($vesselname);

    }
    /**
     * Cleaning service details are saved to db.
     * @return boolean
     */
    public function set_service_data() {

        $summer_first = $this->input->post ( 'summer_first' );
        $summer_second = $this->input->post ( 'summer_second' );
        $winter_first = $this->input->post ( 'winter_first' );
        $winter_second = $this->input->post ( 'winter_second' );
        $bowid = $this->input->post ( 'bowid' );
        $bothid = $this->input->post ( 'bothid' );
        $dinghyid = $this->input->post ( 'dinghyid' );
        $service_customer = $this->input->post ( 'service_customer' );
        $service_vessel = $this->input->post ( 'service_vessel' );

        $pkcustomer = $this->input->post ( 'customerid' );
        $pkvessel = $this->input->post ( 'vesselid' );
        $pkservice = $this->input->post ( 'serviceid' );

        $hullclean = $this->input->post ( 'hullclean' );
        $startdate = $this->date_format_db($this->input->post ( 'startdate' ));
        $discount = $this->input->post ( 'discount' );

        $summer = $this->input->post ( 'summer' );
        $summer_first_service = $this->input->post ( 'summer_first_service' );
        $summer_second_service = $this->input->post ( 'summer_second_service' );
        $summer_first_service_price = $this->input->post ( 'summer_first_service_price' );
        $summer_second_service_price = $this->input->post ( 'summer_second_service_price' );
        $summer_first_discount_price = $this->input->post ( 'summer_first_discount_price' );
        $summer_second_discount_price = $this->input->post ( 'summer_second_discount_price' );

        $winter = $this->input->post ( 'winter' );
        $winter_first_service = $this->input->post ( 'winter_first_service' );
        $winter_second_service = $this->input->post ( 'winter_second_service' );
        $winter_first_service_price = $this->input->post ( 'winter_first_service_price' );
        $winter_second_service_price = $this->input->post ( 'winter_second_service_price' );
        $winter_first_discount_price = $this->input->post ( 'winter_first_discount_price' );
        $winter_second_discount_price = $this->input->post ( 'winter_second_discount_price' );

        $bow = $this->input->post ( 'bow' );
        $bow_list_price = $this->input->post ( 'bow_list_price' );
        $bow_discount_price = $this->input->post ( 'bow_discount_price' );

        $both = $this->input->post ( 'both' );
        $both_list_price = $this->input->post ( 'both_list_price' );
        $both_discount_price = $this->input->post ( 'both_discount_price' );

        $lastdate = $this->date_format_db($this->input->post ( 'lastdate' ));

        $dinghy = $this->input->post ( 'dinghy' );
        $dinghy_list_price = $this->input->post ( 'dinghy_list_price' );
        $dinghy_discount_price = $this->input->post ( 'dinghy_discount_price' );

        // S
        if (! empty ( $summer )) {
            $data = array (

                                            'PK_VESSEL_SERVICE' => $pkservice,
                                            'PK_VESSEL' => $pkvessel,
                                            'PK_CUSTOMER' => $pkcustomer,
                                            'SERVICE_SEASON' => 'S',
                                            'FIRST_OR_SECOND' => '1',
                                            'SERVICE_CLASS' => 'HULL CLEANING',
                                            'SERVICE_TYPE' => $summer,
                                            'DESCRIPTION' => $summer_first_service,
                                            'DISCOUNT' => $discount,
                                            'LIST_PRICE' => $summer_first_service_price,
                                            'DISCOUNT_PRICE' => $summer_first_discount_price,
                                            'START_DATE' => $startdate );

            // 'PK_VESSEL_SERVICE' => $pkservice,
            $datum = array (

                                            'PK_VESSEL' => $pkvessel,
                                            'PK_CUSTOMER' => $pkcustomer,
                                            'SERVICE_SEASON' => 'S',
                                            'FIRST_OR_SECOND' => '1',
                                            'SERVICE_CLASS' => 'HULL CLEANING',
                                            'SERVICE_TYPE' => $summer,
                                            'DESCRIPTION' => $summer_first_service,
                                            'DISCOUNT' => $discount,
                                            'LIST_PRICE' => $summer_first_service_price,
                                            'DISCOUNT_PRICE' => $summer_first_discount_price,
                                            'START_DATE' => $startdate );

            if (is_numeric ( $summer_first )) {
                $this->session->set_userdata('return',true);$this->db->where ( 'PK_VESSEL_SERVICE', $summer_first );
                $this->db->update ( 'vessel_services', $datum );
            } else {

                $this->db->insert ( 'vessel_services', $data );
                $pkservice ++;
            }

        }
        if (! empty ( $summer )) {
            $data = array (
                                            'PK_VESSEL_SERVICE' => $pkservice,
                                            'PK_VESSEL' => $pkvessel,
                                            'PK_CUSTOMER' => $pkcustomer,
                                            'SERVICE_SEASON' => 'S',
                                            'FIRST_OR_SECOND' => '2',
                                            'SERVICE_CLASS' => 'HULL CLEANING',
                                            'SERVICE_TYPE' => $summer,
                                            'DESCRIPTION' => $summer_second_service,
                                            'DISCOUNT' => $discount,
                                            'LIST_PRICE' => $summer_second_service_price,
                                            'DISCOUNT_PRICE' => $summer_second_service_price,
                                            'START_DATE' => $startdate );
            // 'PK_VESSEL_SERVICE' => $pkservice,
            $datum = array (

                                            'PK_VESSEL' => $pkvessel,
                                            'PK_CUSTOMER' => $pkcustomer,
                                            'SERVICE_SEASON' => 'S',
                                            'FIRST_OR_SECOND' => '2',
                                            'SERVICE_CLASS' => 'HULL CLEANING',
                                            'SERVICE_TYPE' => $summer,
                                            'DESCRIPTION' => $summer_second_service,
                                            'DISCOUNT' => $discount,
                                            'LIST_PRICE' => $summer_second_service_price,
                                            'DISCOUNT_PRICE' => $summer_second_service_price,
                                            'START_DATE' => $startdate );
            if (($summer_second) != '') {
                $this->session->set_userdata('return',true);$this->db->where ( 'PK_VESSEL_SERVICE', $summer_second );
                $this->db->update ( 'vessel_services', $datum );
            } else {
if($summer_second_service_price>0)
{
                $this->db->insert ( 'vessel_services', $data );
                $pkservice ++;
}
            }
        }
        // W
        if (! empty ( $winter )) {
            $data = array (
                                            'PK_VESSEL_SERVICE' => $pkservice,
                                            'PK_VESSEL' => $pkvessel,
                                            'PK_CUSTOMER' => $pkcustomer,
                                            'SERVICE_SEASON' => 'W',
                                            'FIRST_OR_SECOND' => '1',
                                            'SERVICE_CLASS' => 'HULL CLEANING',
                                            'SERVICE_TYPE' => $winter,
                                            'DESCRIPTION' => $winter_first_service,
                                            'DISCOUNT' => $discount,
                                            'LIST_PRICE' => $winter_first_service_price,
                                            'DISCOUNT_PRICE' => $winter_first_service_price,
                                            'START_DATE' => $startdate );
            // 'PK_VESSEL_SERVICE' => $pkservice,
            $datum = array (

                                            'PK_VESSEL' => $pkvessel,
                                            'PK_CUSTOMER' => $pkcustomer,
                                            'SERVICE_SEASON' => 'W',
                                            'FIRST_OR_SECOND' => '1',
                                            'SERVICE_CLASS' => 'HULL CLEANING',
                                            'SERVICE_TYPE' => $winter,
                                            'DESCRIPTION' => $winter_first_service,
                                            'DISCOUNT' => $discount,
                                            'LIST_PRICE' => $winter_first_service_price,
                                            'DISCOUNT_PRICE' => $winter_first_service_price,
                                            'START_DATE' => $startdate );
            if (($winter_first) != '') {
                $this->session->set_userdata('return',true);$this->db->where ( 'PK_VESSEL_SERVICE', $winter_first );
                $this->db->update ( 'vessel_services', $datum );
            } else {

                $this->db->insert ( 'vessel_services', $data );
                $pkservice ++;
            }

        }
        if (! empty ( $winter )) {
            $data = array (
                                            'PK_VESSEL_SERVICE' => $pkservice,
                                            'PK_VESSEL' => $pkvessel,
                                            'PK_CUSTOMER' => $pkcustomer,
                                            'SERVICE_SEASON' => 'W',
                                            'FIRST_OR_SECOND' => '2',
                                            'SERVICE_CLASS' => 'HULL CLEANING',
                                            'SERVICE_TYPE' => $winter,
                                            'DESCRIPTION' => $winter_second_service,
                                            'DISCOUNT' => $discount,
                                            'LIST_PRICE' => $winter_second_service_price,
                                            'DISCOUNT_PRICE' => $winter_second_service_price,
                                            'START_DATE' => $startdate );
            // 'PK_VESSEL_SERVICE' => $pkservice,
            $datum = array (

                                            'PK_VESSEL' => $pkvessel,
                                            'PK_CUSTOMER' => $pkcustomer,
                                            'SERVICE_SEASON' => 'W',
                                            'FIRST_OR_SECOND' => '2',
                                            'SERVICE_CLASS' => 'HULL CLEANING',
                                            'SERVICE_TYPE' => $winter,
                                            'DESCRIPTION' => $winter_second_service,
                                            'DISCOUNT' => $discount,
                                            'LIST_PRICE' => $winter_second_service_price,
                                            'DISCOUNT_PRICE' => $winter_second_service_price,
                                            'START_DATE' => $startdate );
            if (($winter_second) != '') {
                $this->session->set_userdata('return',true);$this->db->where ( 'PK_VESSEL_SERVICE', $winter_second );
                $this->db->update ( 'vessel_services', $datum );
            } else {
if($winter_second_service_price>0)
{
                $this->db->insert ( 'vessel_services', $data );
                $pkservice ++;
}
            }
        }
        if (! empty ( $bow )) {
            $data = array (
                                            'PK_VESSEL_SERVICE' => $pkservice,
                                            'PK_VESSEL' => $pkvessel,
                                            'PK_CUSTOMER' => $pkcustomer,
                                            'SERVICE_SEASON' => 'N',
                                            'FIRST_OR_SECOND' => '0',
                                            'SERVICE_CLASS' => 'Bow (Aft) Thruster Hydro Blasting',
                                            'SERVICE_TYPE' => 'BOW',
                                            'DESCRIPTION' => '',
                                            'DISCOUNT' => $discount,
                                            'LIST_PRICE' => $bow_list_price,
                                            'DISCOUNT_PRICE' => $bow_discount_price,
                                            'START_DATE' => $startdate,
                                            'END_DATE' => $lastdate );
            // 'PK_VESSEL_SERVICE' => $pkservice,
            $datum = array (

                                            'PK_VESSEL' => $pkvessel,
                                            'PK_CUSTOMER' => $pkcustomer,
                                            'SERVICE_SEASON' => 'N',
                                            'FIRST_OR_SECOND' => '0',
                                            'SERVICE_CLASS' => 'Bow (Aft) Thruster Hydro Blasting',
                                            'SERVICE_TYPE' => 'BOW',
                                            'DESCRIPTION' => '',
                                            'DISCOUNT' => $discount,
                                            'LIST_PRICE' => $bow_list_price,
                                            'DISCOUNT_PRICE' => $bow_discount_price,
                                            'START_DATE' => $startdate,
                                            'END_DATE' => $lastdate );
            if (($bowid) != '') {
                $this->session->set_userdata('return',true);$this->db->where ( 'PK_VESSEL_SERVICE', $bowid );
                $this->db->update ( 'vessel_services', $datum );
            } else {

                $this->db->insert ( 'vessel_services', $data );
                $pkservice ++;
            }
        }
        if (! empty ( $both )) {
            $data = array (
                                            'PK_VESSEL_SERVICE' => $pkservice,
                                            'PK_VESSEL' => $pkvessel,
                                            'PK_CUSTOMER' => $pkcustomer,
                                            'SERVICE_SEASON' => 'N',
                                            'FIRST_OR_SECOND' => '0',
                                            'SERVICE_CLASS' => 'Bow (Aft) Thruster Hydro Blasting',
                                            'SERVICE_TYPE' => 'BOW/AFT',
                                            'DESCRIPTION' => '',
                                            'DISCOUNT' => $discount,
                                            'LIST_PRICE' => $both_list_price,
                                            'DISCOUNT_PRICE' => $both_discount_price,
                                            'START_DATE' => $startdate,
                                            'END_DATE' => $lastdate );
            // 'PK_VESSEL_SERVICE' => $pkservice,
            $datum = array (

                                            'PK_VESSEL' => $pkvessel,
                                            'PK_CUSTOMER' => $pkcustomer,
                                            'SERVICE_SEASON' => 'N',
                                            'FIRST_OR_SECOND' => '0',
                                            'SERVICE_CLASS' => 'Bow (Aft) Thruster Hydro Blasting',
                                            'SERVICE_TYPE' => 'BOW/AFT',
                                            'DESCRIPTION' => '',
                                            'DISCOUNT' => $discount,
                                            'LIST_PRICE' => $both_list_price,
                                            'DISCOUNT_PRICE' => $both_discount_price,
                                            'START_DATE' => $startdate,
                                            'END_DATE' => $lastdate );
            if (($bothid) != '') {
                $this->session->set_userdata('return',true);$this->db->where ( 'PK_VESSEL_SERVICE', $bothid );
                $this->db->update ( 'vessel_services', $datum );
            } else {

                $this->db->insert ( 'vessel_services', $data );
                $pkservice ++;
            }
        }
        if (! empty ( $dinghy )) {
            $data = array (
                                            'PK_VESSEL_SERVICE' => $pkservice,
                                            'PK_VESSEL' => $pkvessel,
                                            'PK_CUSTOMER' => $pkcustomer,
                                            'SERVICE_SEASON' => 'N',
                                            'FIRST_OR_SECOND' => '0',
                                            'SERVICE_CLASS' => 'DINGHY CLEANING',
                                            'SERVICE_TYPE' => 'DINGHY',
                                            'DESCRIPTION' => 'CLEANING OF DINGHY',
                                            'DISCOUNT' => $discount,
                                            'LIST_PRICE' => $dinghy_list_price,
                                            'DISCOUNT_PRICE' => $dinghy_discount_price,
                                            'START_DATE' => $startdate );
            // 'PK_VESSEL_SERVICE' => $pkservice,
            $datum = array (

                                            'PK_VESSEL' => $pkvessel,
                                            'PK_CUSTOMER' => $pkcustomer,
                                            'SERVICE_SEASON' => 'N',
                                            'FIRST_OR_SECOND' => '0',
                                            'SERVICE_CLASS' => 'DINGHY CLEANING',
                                            'SERVICE_TYPE' => 'DINGHY',
                                            'DESCRIPTION' => 'CLEANING OF DINGHY',
                                            'DISCOUNT' => $discount,
                                            'LIST_PRICE' => $dinghy_list_price,
                                            'DISCOUNT_PRICE' => $dinghy_discount_price,
                                            'START_DATE' => $startdate );
            if (($dinghyid) != '') {
                $this->session->set_userdata('return',true);$this->db->where ( 'PK_VESSEL_SERVICE', $dinghyid );
                $this->db->update ( 'vessel_services', $datum );
            } else {

                $this->db->insert ( 'vessel_services', $data );
                $pkservice ++;
            }
        }

        return true;

    }
    /**
     * Save the miscellaneous details to db.
     * @return boolean
     */
    public function set_misc_data() {

        $vessel = $this->input->post ( 'vesselid' );
        $clean = $this->input->post ( 'cleaning_instructions' );
        $anode = $this->input->post ( 'anode_instructions' );
        $mechanical = $this->input->post ( 'mechanical_instructions' );
        $comments = $this->input->post ( 'comments' );
        $notes = $this->input->post ( 'notes' );
		$ZincReplacement = $this->input->post ( 'ZincReplacement' );

        $data = array (
                                        'ZINC_REPLACEMENT' => $ZincReplacement,
										'CLEANING' => $clean,
                                        'BILLING' => $anode,
                                        'SPECIAL' => $mechanical,
                                        'COMMENTS' => $comments,
                                        'ADDFIELD2' => $notes );

        $this->session->set_userdata('return',true);
        $this->db->where ( 'PK_VESSEL', $vessel );
        $this->db->update ( 'customer_vessel', $data );

        return true;
    }

    /*
     * AjaxExecution
     */
/**
 * Get the details of the service by its primary key.
 * @param unknown $hullclean : primary key of the hull service.
 */
    public function get_hullclean_data($hullclean) {
        $query = $this->db->query (
                                        "SELECT SERVICE_NAME,F_DESCRIPTION,S_DESCRIPTION,F_RATE,S_RATE,FREQUENCY FROM hullclean WHERE PK_HC='" .
                                                                         $hullclean .
                                                                         "'" );
return $query->result ();
}
/**
 * Update teh table vessel anode
 * @param unknown $customer  : priamry key of the customer
 * @param unknown $vessel : primary key of the vessel
 * @param unknown $anodeid : anode primatry key
 * @param unknown $anodetype : type o df the anode
 * @param unknown $anodedescription : description of the anode
 * @param unknown $anodediscount : discount available for the customer.
 * @param unknown $anodediscountprice : price after the discount is appliered
 * @param unknown $anodelistprice : actual price of the anode.
 * @param unknown $anodelastdate : last changed date of the anode.
 * @param unknown $anodeschedule : schedule date of the work order.
 */
public function update_table_vessel_anode(
$customer,
$vessel,
$anodeid,
$anodetype,
$anodedescription,
$anodediscount,
$anodediscountprice,
$anodelistprice,
$anodelastdate,
$anodeschedule) {
$data = array (
        'PK_VESSEL_ANODE' => $anodeid,
        'PK_VESSEL ' => $vessel,
        'PK_CUSTOMER' => $customer,
        'ANODE_TYPE ' => $anodetype,
        'DESCRIPTION ' => $anodedescription,
        'DISCOUNT ' => $anodediscount,
        'LIST_PRICE' => $anodelistprice,
        'DISCOUNT_PRICE' => $anodediscountprice,
        'SCHEDULE_CHANGE' => $anodeschedule,
        'ADDFIELD1' => $anodelastdate );

return $this->db->insert ( 'vessel_anodes', $data );


}
/**
 * Get invoices based on the  delivery mode of the customer
 * @param string $mode : delivery mode
 */
public function get_invoices_not_send($mode=NULL)
{
    $sql ="SELECT PK_INVOICE, INVOICE_DATE, NET_AMOUNT_INVOICED, OUTSTANDING_BALANCE, FIRST_NAME, LAST_NAME, DELIVERY_MODE, VESSEL_NAME, NET_AMOUNT_INVOICED + OUTSTANDING_BALANCE AS BALANCE
FROM invoice
INNER JOIN customer_master ON invoice.pk_customer = customer_master.PK_CUSTOMER
INNER JOIN customer_vessel ON invoice.pk_customer = customer_vessel.PK_CUSTOMER
WHERE invoice.STATUS=1 ";

    switch ($mode)
    {
        case 1:
            $sql = $sql . " AND (DELIVERY_MODE='US MAIL' OR DELIVERY_MODE='US MAIL & EMAIL') ";
            break;
        case 2:
            $sql = $sql . " AND (DELIVERY_MODE='EMAIL' OR DELIVERY_MODE='US MAIL & EMAIL') ";
            break;
        case 3:
            $sql = $sql . " AND DELIVERY_MODE='FAX' ";
             break;
        case 4:
            $sql = $sql . " AND DELIVERY_MODE LIKE 'CREDIT CARD%' ";
             break;
        default:
            $sql;
             break;
    }

    $query = $this->db->query($sql);
    return $query->result();
}
//diver comm full list
public function get_diver_full_commission_list($diverid,$from,$to)
{

	$sql="select  pk_diver_trans,vessel_name,location,
case wo_class
when 'C' then 'Hull Cleaning'
when 'A' then 'Zinc Change'
when 'M' then 'Mechanical'
else
wo_class
end as 'work_type',
wo_number,DATE_FORMAT(schedule_date,  '%m/%d/%Y') AS schedule_date
,scount,commission_rate as commission_rate,
commission_amount as commission_amount,
case discount
when '0' then ' '
else 'D'
end as 'discount'
from diver_transactions where
wo_class <> 'Z' and pk_diver='$diverid' and
schedule_date between '$from' and '$to'     order by schedule_date asc,location asc";
	$query = $this->db->query($sql);
	return $query->result();
}
//diver commission listget_diver_name_fromid
public function get_diver_commission_list($diverid,$from,$to,$current = 0, $perpage = 45, $qry = null)
{
	if ($qry == null) {
	$sql="select  pk_diver_trans,vessel_name,location,
case wo_class
when 'C' then 'Hull Cleaning'
when 'A' then 'Zinc Change'
when 'M' then 'Mechanical'
else
wo_class
end as 'work_type',
wo_number,DATE_FORMAT(schedule_date,  '%m/%d/%Y') AS schedule_date
,scount,commission_rate as commission_rate,
commission_amount as commission_amount,
case discount
when '0' then ' '
else 'D'
end as 'discount'
from diver_transactions where
wo_class <> 'Z' and
pk_diver='$diverid' and
schedule_date between '$from' and '$to' order by schedule_date asc LIMIT $current,$perpage";
	$query = $this->db->query($sql);
	return $query->result();
}
else
{
	 $qry =  urldecode($qry);
	 $sql="select  pk_diver_trans,vessel_name,location,
case wo_class
when 'C' then 'Hull Cleaning'
when 'A' then 'Zinc Change'
when 'M' then 'Mechanical'
else
wo_class
end as 'work_type',
wo_number,schedule_date,scount,commission_rate  as commission_rate,
commission_amount as commission_amount,
case discount
when '0' then ' '
else 'D'
end as 'discount'
from diver_transactions where
wo_class <> 'Z' and vessel_name LIKE '%$qry%' and
pk_diver='$diverid' and
schedule_date between '$from' and '$to'  order by schedule_date asc  LIMIT 0,$perpage";
	$query = $this->db->query($sql);
	return $query->result();

}
}
//get_diver_name_fromid
public function get_diver_name_fromid($diverid)
{
	$sql="select diver_name from diver_master where pk_diver='$diverid'";
	$query = $this->db->query($sql);
	return $query->result();
}
//diver-Total commission
public function get_total_commission($diverid,$from,$to)
{
	$sql="select sum(commission_amount) as comtotal from diver_transactions where
pk_diver='$diverid' and
schedule_date between '$from' and '$to' order by entry_date";

	$query = $this->db->query($sql);
	return $query->result();
}
//deductions total
public function get_deduction_commission($diverid,$from,$to)
{
	$sql="select  sum(paid) as deductions  from diver_transactions where  pk_diver='$diverid' and paid >0 and
schedule_date between '$from' and '$to' order by entry_date";
	$query = $this->db->query($sql);
	return $query->result();
}
/*
 * Process Payment-Diver commission
 */
  public function diver_process_payment($diver_id,$deduction_amount,$check_date){
          $today = date("Y-m-d");
         $check_date=$this->date_format_db($check_date);
        $data = array (
                                        'PK_DIVER'=>$diver_id,
                                        'WO_CLASS' =>'Z',
                                        'SCHEDULE_DATE' => $check_date,
                                        'PAID' => $deduction_amount,
                                        'ADDFIELD1' => 'MATERIALS',
                                        'ENTRY_DATE' => $today
                );
        $this->db->insert ( 'diver_transactions', $data );
}

//commission details diver
public function get_diver_commission_details($workordernum)
{
	$sql="select vessel_name,location,wo_number,schedule_date,invoiced_rate,scount,
commission_rate,commission_amount from diver_transactions where wo_number='$workordernum'";
	$query = $this->db->query($sql);
	return $query->result();
}
/**
 * Delete the invoice and it's details from the DB.
 * @param unknown $invoice
 * @return boolean
 */
public function delete_invoice_db($invoice)
{



    $this->db->where ( 'PK_INVOICE', $invoice );
    $this->db->delete ( 'invoice' );
    $this->db->where ( 'INVOICE_NO', $invoice );
    $this->db->delete ( 'general_ledger' );


    return true;
}
//delete credit payments=======
public function delete_credit_payment($ledger)
{
    $this->db->where ( 'PK_LEDGER', $ledger);
    $this->db->delete ( 'general_ledger' );

    return true;
}
/**
 * Exempted portion
 * @param unknown $invoice
 * @return boolean
 */
public function void_invoice_db($invoice)
{
    $datum = array('STATUS'=>'4');
    $this->db->where ( 'PK_INVOICE', $invoice );
    $this->db->update ( 'invoice', $datum );
    return true;
}
/**
 * Get the invoice by the search
 * @param unknown $string : query
 */
public function get_individual_invoices_db($string)
{ $string = urldecode($string);

    $sql = "SELECT invoice.PK_INVOICE,customer_master.FIRST_NAME,customer_master.LAST_NAME,invoice.INVOICE_DATE,invoice.NET_AMOUNT_INVOICED,invoice.ENTRY_DATE FROM  invoice INNER JOIN customer_master on
            invoice.pk_customer=customer_master.PK_CUSTOMER  WHERE (invoice.PK_INVOICE LIKE '%$string%' OR customer_master.FIRST_NAME  LIKE '%$string%' OR customer_master.LAST_NAME LIKE '%$string%'
            OR CONCAT_WS(' ',customer_master.FIRST_NAME,customer_master.LAST_NAME) LIKE '%$string%' OR invoice.NET_AMOUNT_INVOICED LIKE '%$string%')";
    $query = $this->db->query($sql);
    return $query->result();

}
/**
 * Exempted portion
 * @param unknown $string
 */
public function get_restore_invoices_db($string)
{
    $sql = "SELECT PK_INVOICE,FIRST_NAME,LAST_NAME,INVOICE_DATE,NET_AMOUNT_INVOICED,invoice.ENTRY_DATE FROM  invoice INNER JOIN customer_master on
    invoice.pk_customer=customer_master.PK_CUSTOMER  WHERE (PK_INVOICE LIKE '%$string%' OR FIRST_NAME  LIKE '%$string%' OR LAST_NAME LIKE '%$string%') AND invoice.STATUS=4";
    $query = $this->db->query($sql);
    return $query->result();

}
/**
 * Exepted portion
 * @param unknown $string
 */
public function get_void_invoices_db($string)
{
    $sql = "SELECT PK_INVOICE,FIRST_NAME,LAST_NAME,INVOICE_DATE,NET_AMOUNT_INVOICED,invoice.ENTRY_DATE FROM  invoice INNER JOIN customer_master on
    invoice.pk_customer=customer_master.PK_CUSTOMER  WHERE (PK_INVOICE LIKE '%$string%' OR FIRST_NAME  LIKE '%$string%' OR LAST_NAME LIKE '%$string%') AND invoice.STATUS!=4";
    $query = $this->db->query($sql);
    return $query->result();

}

/*
 * INVOICE->DELETE INVOICE
 */
/**
 *Delete invoice and send the work orders back to un invoiced.
 * @param unknown_type $invoice : invoice primary key.
 */
public function delete_current_invoice($invoice)
{
    $sql = "SELECT PK_WO FROM work_order WHERE INVOICE_NO='$invoice'";
    $query = $this->db->query($sql);
    $data['work'] = $query->result();

    foreach($data['work'] as $d):
    $datum = array('WO_STATUS'=>'2','INVOICE_NO'=>'0');
    $this->db->where ( 'PK_WO', $d->PK_WO );
    $this->db->update ( 'work_order', $datum );
    endforeach;

    $this->db->where ( 'PK_INVOICE', $invoice );
    $this->db->delete ( 'invoice' );
    $this->db->where ( 'INVOICE_NO', $invoice );
    $this->db->delete ( 'general_ledger' );

    return true;
}
//diver commission delete
public function delete_diver_commission_db($worknum)
{
    $this->db->where ( 'WO_NUMBER', $worknum );
    $this->db->delete ( 'diver_transactions' );
    return true;
}
/**
 * Exempted portion.
 * @param unknown $invoice
 * @return boolean
 */
public function restore_current_invoice($invoice)
{
    $datum = array('STATUS'=>'1');
    $this->db->where ( 'PK_INVOICE', $invoice );
    $this->db->update ( 'invoice',$datum );
    return true;
}
/**
 * Exempted portion
 * @param unknown $invoice
 * @return boolean
 */
public function void_current_invoice($invoice)
{
    $datum = array('STATUS'=>'4');
    $this->db->where ( 'PK_INVOICE', $invoice );
    $this->db->update ( 'invoice',$datum );
    return true;
}
/**
 * Create invoice here
 */
public function create_invoice_from_work_order($invoice)
{

    $lpamount = 0;
    $netamount = 0;
    $customer = $this->db->query("SELECT PK_CUSTOMER,PK_VESSEL FROM work_order WHERE PK_WO='$invoice[0]' AND WO_STATUS=2");
    $data['customer'] = $customer->result();
    if (count($data['customer'])!=0)
    {
    $pkcustomer = $data['customer'][0]->PK_CUSTOMER;
    $pkvessel = $data['customer'][0]->PK_VESSEL;
    $balance  = $this->db->query("SELECT SUM( DEBIT - CREDIT ) AS BALANCE FROM general_ledger WHERE PK_CUSTOMER='$pkcustomer'");
    $data['balance'] = $balance->result();
    $outbalance = $data['balance'][0]->BALANCE;
    foreach ($invoice as $i){
    $amount = $this->db->query("SELECT SUM( LIST_PRICE ) AS LISTP , SUM( DISCOUNT_PRICE ) AS PRICE FROM work_order_parts WHERE PK_WO='$i' AND WORK_VALUE>0");
    $data['amount'] = $amount->result();

    $lpamount  = $lpamount + $data['amount'][0]->LISTP;
    $netamount = $netamount + $data['amount'][0]->PRICE;
    }





    $today = date("Y-m-d");

    $invoicedata = array(
                                    'pk_customer'=>$pkcustomer,
                                    'PK_VESSEL'=>$pkvessel,
                                    'INVOICE_DATE'=>$today,
                                    'LP_AMOUNT_INVOICED'=>$lpamount,
                                    'NET_AMOUNT_INVOICED'=>$netamount,
                                    'OUTSTANDING_BALANCE'=>$outbalance,
                                    'PAYMENT_DUE_ON'=>$today,
                                    'ENTRY_DATE'=>$today);
    $this->db->insert ( 'invoice', $invoicedata );
    //NEED INVOICE ID HERE
    $invoiceid = $this->db->insert_id('invoice');

    echo $invoiceid;
    $ledgerdata = array(
                                    'TRANS_TYPE'=>'S',
                                    'PK_CUSTOMER'=>$pkcustomer,
                                    'PK_VESSEL'=>$pkvessel,
                                    'TRANSACTION_DATE'=>$today,
                                    'INVOICE_NO'=>$invoiceid,
                                    'DEBIT'=>$netamount);
    $this->db->insert ( 'general_ledger', $ledgerdata );

    $datum = array('WO_STATUS'=>'3','INVOICE_NO'=>$invoiceid,'INVOICE_DATE'=>$today);
for($ij=0;$ij<count($invoice);$ij++){

$sql = "UPDATE work_order SET WO_STATUS=3,INVOICE_NO='$invoiceid',INVOICE_DATE='$today' WHERE PK_WO='$invoice[$ij]' AND WO_STATUS=2";


     $this->db->query($sql);


}


    return $invoiceid;
    }
    else
    {
        exit;
    }


}
/**
 * Get the company details to invoice document
 */
public function get_company_details()
{
    $sql = "SELECT BUSINESS_NAME,ADDRESS,CITY,STATE,ZIP_CODE FROM company_master ORDER BY ACCOUNT_NO ASC LIMIT 0,1";
    $query = $this->db->query($sql);
    return $query->result();
}
/**
 * Invoice custom messssages are providede here from db
 */
public function get_custom_message_invoice()
{
    $sql = "SELECT ddetail1,ddetail2,ddetail3 FROM display_master WHERE usedin='INVOICE'";
    $query = $this->db->query($sql);
    return $query->result();
}
/**
 * Details of the invoiced customer and boat for printing on invoice document.
 * @param unknown $invoice:primary key of the invoice
 */
public function get_invoice_details($invoice)
{
    $sql = "SELECT customer_master.FIRST_NAME,customer_master.LAST_NAME,customer_master.BILL_ADDRESS,customer_master.BILL_ADDRESS1,customer_master.BILL_CITY,customer_master.BILL_STATE,
            customer_master.BILL_ZIPCODE,customer_master.TERMS,customer_master.ACCOUNT_NO,customer_master.DELIVERY_MODE,customer_master.EMAIL,customer_master.ADDFIELD1,customer_master.ADDFIELD2,customer_vessel.VESSEL_NAME,customer_vessel.LOCATION,
            customer_vessel.PAINT_CYCLE,customer_vessel.SLIP,invoice.PK_INVOICE,invoice.INVOICE_DATE,invoice.NET_AMOUNT_INVOICED,invoice.OUTSTANDING_BALANCE,customer_vessel.COMMENTS FROM customer_master INNER JOIN invoice ON
            customer_master.PK_CUSTOMER=invoice.pk_customer INNER JOIN customer_vessel ON customer_master.PK_CUSTOMER=customer_vessel.PK_CUSTOMER WHERE
            invoice.PK_INVOICE='$invoice'";
    $query = $this->db->query($sql);
    return $query->result();
}
/**
 * Workorder details iof the invoice
 * @param unknown $invoice : invoice primary key
 */
public function get_work_order_invoice($invoice)
{
    $sql = "SELECT  WO.PK_WO,work_order_parts.PK_WO_PARTS,work_order_parts.WO_CLASS,work_order_parts.WORK_TYPE,work_order_parts.WORK_DESCRIPTION,work_order_parts.LIST_PRICE,
            work_order_parts.DISCOUNT_PRICE,work_order_parts.DISCOUNT,WO.SCHEDULE_DATE,
			(SELECT SCHEDULE_DATE FROM work_order INNER JOIN work_order_parts WP ON work_order.PK_WO=WP.PK_WO  WHERE WO_STATUS>1 AND WORK_VALUE>0 AND PK_CUSTOMER=WO.PK_CUSTOMER AND work_order.WO_CLASS='A' AND INVOICE_NO<'$invoice' AND WP.PK_WORK=work_order_parts.PK_WORK ORDER BY SCHEDULE_DATE DESC LIMIT 0,1)'ADFD',
			work_order_parts.WORK_VALUE,WO.ENTRY_DATE FROM work_order WO INNER JOIN  work_order_parts ON WO.PK_WO=work_order_parts.PK_WO  WHERE WO.INVOICE_NO='$invoice' AND work_order_parts.WORK_VALUE>0 order by WO.WO_CLASS DESC,work_order_parts.WORK_TYPE ASC";
    $query = $this->db->query($sql);
    return $query->result();
}
/**
 * Get the latest work order date of th e customer
 * @param unknown $customer : priamry  key of the customer
 * @param unknown $class : type of the work order
 */
public function get_customer_schedule_date($customer,$class)
{
    $sql = "SELECT work_order.PK_WO,work_order.PK_CUSTOMER, work_order.SCHEDULE_DATE, WORK_TYPE FROM work_order INNER JOIN work_order_parts ON work_order.PK_WO = work_order_parts.PK_WO
            WHERE  PK_CUSTOMER ='$customer' AND work_order.WO_CLASS = '$class' ORDER BY work_order.SCHEDULE_DATE DESC LIMIT 0 , 1";
   $query = $this->db->query($sql);
    return $query->result();
}
/**
 * Get the customer details of the completed work order.
 * @param unknown $pkwork : primaruy key of the customer work order.
 */
public function get_other_completed_work_order($pkwork)
{
    $sql = "SELECT PK_CUSTOMER FROM work_order WHERE PK_WO='$pkwork'";
    $query = $this->db->query($sql);
    return $query->result();
}
/**
 * Get other completedwork ordders so fthe customer
 * @param unknown $customer : primary key of the customer
 */
public function get_other_completed_work_order_customer($customer)
{
    $sql = "SELECT PK_WO FROM work_order WHERE PK_CUSTOMER='$customer' AND WO_STATUS=2 AND INVOICE_NO=0";
    $query = $this->db->query($sql);
    return $query->result();
}
/**
 * Email details (extra contents) are provided here
 */
public function get_email_fillup()
{
    $sql ="SELECT * FROM display_master WHERE displaykey=1";
    $query = $this->db->query($sql);
    return $query->result();
}
/**
 * Update whether invoice document send or not
 * @param unknown $adr : invoice primary key
 * @return unknown
 */
public function update_send_invoice($adr)
{
    $today = date ( "Y-m-d" );
    $sql ="UPDATE invoice SET STATUS='2',ENTRY_DATE='$today' WHERE PK_INVOICE='$adr' ";
    $query = $this->db->query($sql);
    return $query;
}
/**
 * Update the vessel comments.
 * @param unknown $vessel : vessel details
 * @param unknown $comment  : comments
 * @return boolean
 */
public function update_vessel_comment($vessel,$comment)
{
    $sql = "UPDATE customer_vessel SET COMMENTS='$comment' WHERE PK_VESSEL='$vessel'";
    $this->db->query($sql);
    return true;
}
/**
 * Email text is customized here......
 * @return boolean
 */
public function update_email_text()
{
    $data = array('dcode'=>$this->input->post('refer'),
                                    'dheader'=>$this->input->post('salute'),
                                    'ddetail1'=>$this->input->post('detaila'),
                                    'ddetail2'=>$this->input->post('detailb'),
                                    'ddetail3'=>$this->input->post('detailc'),
                                    'ddetail4'=>$this->input->post('detaild'));
    $this->db->where ( 'displaykey', 1 );
    $this->db->update ( 'display_master', $data );
    return true;
}
//update diver commission
public function update_diver_commission($zinccount,$rate,$commission,$worknumber)
{
    $sql = "UPDATE diver_transactions SET SCOUNT='$zinccount',COMMISSION_RATE='$rate',COMMISSION_AMOUNT='$commission' WHERE WO_NUMBER='$worknumber'";
    $this->db->query($sql);
    return true;
}
/**
 * update invoice custom messages
 * @return boolean
 */
public function update_invoice_text()
{
    $data = array('ddetail1'=>$this->input->post('detaila'),
                                    'ddetail2'=>$this->input->post('detailb'),
                                    'ddetail3'=>$this->input->post('detailc'));
    $this->db->where ( 'displaykey', 2 );
    $this->db->update ( 'display_master', $data );
    return true;
}
/**
 * display alla nodes for editing.
 * @param string $qry
 */
public function search_anodes_editing($qry=null)
{
    if(is_null($qry))
    {

    }
    else
    {
        $sql = "SELECT * FROM anodes WHERE DESCRIPTION LIKE '%$qry%' AND VESSEL_TYPE>=0 ORDER BY PK_ANODE ASC";
        $query = $this->db->query($sql);
        return $query->result();
    }
}
/**
 * display alla nodes for editing.
 * @param string $qry
 */
public function search_mwos_editing($qry=null)
{
    if(is_null($qry))
    {
	}
    else
    {
        $sql = "SELECT * FROM mechanical WHERE DESCRIPTION LIKE '%$qry%' AND VESSEL_TYPE>=0 ORDER BY PK_MWO ASC";
        $query = $this->db->query($sql);
        return $query->result();
    }
}


/**
 * display anode details by selection
 * @param unknown $anode
 */
public function display_anode_list($anode)
{
    $sql = "SELECT * FROM anodes WHERE PK_ANODE='$anode'";
    $query = $this->db->query($sql);
    return $query->result();
}

public function display_mwo_list($anode)
{
    $sql = "SELECT * FROM mechanical WHERE PK_MWO='$anode'";
    $query = $this->db->query($sql);
    return $query->result();
}

//..................Diver Commission........POP UP value..................................
function displayCommissionDetails($val){
$query=$this->db->query("select vessel_name,location,
    case wo_class
when 'C' then 'Hull Cleaning'
when 'A' then 'Zinc Change'
when 'M' then 'Mechanical'
else
wo_class
end as 'work_type',
wo_number,schedule_date,list_price,discount,invoiced_rate,scount,
commission_rate,commission_amount from diver_transactions where pk_diver_trans='".$val."'");
return $query->result();
}
//............................................................








/**
 * Save the changes happened to the anodes.
 * @return boolean
 */
public function modify_anode_list()
{
    $data = array(
			'VESSEL_TYPE'=>$this->input->post('vessel'),
			'ANODE_TYPE'=>$this->input->post('anode_type'),
			'DESCRIPTION'=>$this->input->post('description'),
			'RATE'=>$this->input->post('rate'),
			'INSTALLATION'=>$this->input->post('installation'),
			'SCHEDULE_CHANGE'=>$this->input->post('schedule'));
    $this->db->where ( 'PK_ANODE', $this->input->post('anode') );
    $this->db->update ( 'anodes', $data );
    return true;
}


public function modify_mwo_list()
{
    $data = array(
			'VESSEL_TYPE'=>$this->input->post('vessel'),
			'MWO_TYPE'=>$this->input->post('anode_type'),
			'DESCRIPTION'=>$this->input->post('description'),
			'RATE'=>$this->input->post('rate'),
			'INSTALLATION'=>$this->input->post('installation'),
			'SCHEDULE_CHANGE'=>$this->input->post('schedule'));
    $this->db->where ( 'PK_MWO', $this->input->post('anode') );
    $this->db->update ( 'mechanical', $data );
    return true;
}


/**
 * Save new anode to db
 * @return boolean
 */
public function addnew_anode_list()
{
    $data = array(
                                    'VESSEL_TYPE'=>$this->input->post('vessel'),
                                    'ANODE_TYPE'=>$this->input->post('anode_type'),
                                    'DESCRIPTION'=>$this->input->post('description'),
                                    'RATE'=>$this->input->post('rate'),
                                    'INSTALLATION'=>$this->input->post('installation'),
                                    'SCHEDULE_CHANGE'=>$this->input->post('schedule'));
    $this->db->insert ( 'anodes', $data );
    return true;
}


public function addnew_mwo_list()
{
    $data = array(
                                    'VESSEL_TYPE'=>$this->input->post('vessel'),
                                    'MWO_TYPE'=>$this->input->post('anode_type'),
                                    'DESCRIPTION'=>$this->input->post('description'),
                                    'RATE'=>$this->input->post('rate'),
                                    'INSTALLATION'=>$this->input->post('installation'),
                                    'SCHEDULE_CHANGE'=>$this->input->post('schedule'));
    $this->db->insert ( 'mechanical', $data );
    return true;
}

/**
 * list down the general options
 */
public function get_general_options()
{
    $sql = "SELECT DISTINCT PURPOSE FROM general_table ";
    $query = $this->db->query($sql);
    return $query->result();
}
//payment details-Report
public function get_payment_details()
{
    $sql = "SELECT DISTINCT PURPOSE FROM general_table ";
    $query = $this->db->query($sql);
    return $query->result();
}

//diver name
public function get_diver()
{
	$sql = "SELECT DIVER_NAME,PK_DIVER from diver_master";
	$query = $this->db->query($sql);
	return $query->result();
}
//get diver deduction
public function get_diver_deductions()
{
	$sql = "SELECT OPTIONS from general_table where purpose='DIVER DEDUCTIONS'";
	$query = $this->db->query($sql);
	return $query->result();
}
/**
 * Update the hull clean details
 * @return boolean
 */
public function update_hullclean_option()
{
    $data = array('SERVICE_NAME'=>$this->input->post('name'), 'F_DESCRIPTION'=>$this->input->post('descf'), 'S_DESCRIPTION'=>$this->input->post('descs'), 'F_RATE'=>$this->input->post('ratef'), 'S_RATE'=>$this->input->post('rates'),'FREQUENCY'=>$this->input->post('frequ'));
    $this->db->where ( 'PK_HC', $this->input->post('hull') );
    $this->db->update ( 'hullclean', $data );
    return true;
}
/**
 * create new hull clean service
 * @return boolean
 */
public function create_hullclean_option()
{
    $data = array('SERVICE_NAME'=>$this->input->post('name'),'SERVICE_CLASS'=>'HULL CLEANING','F_DESCRIPTION'=>$this->input->post('descf'), 'S_DESCRIPTION'=>$this->input->post('descs'), 'F_RATE'=>$this->input->post('ratef'), 'S_RATE'=>$this->input->post('rates'),'FREQUENCY'=>$this->input->post('frequ'));
    $this->db->insert ( 'hullclean', $data );
    return true;
}
/**
 * delete a hull clean service.
 * @param unknown $hull
 * @return boolean
 */
public function remove_hullclean_option($hull)
{
    $this->db->where('PK_HC', $hull);
    $this->db->delete('hullclean');
    return true;
}
/**
 * List all divers
 */
public function get_diver_details()
{
    $sql = "SELECT * FROM diver_master ORDER BY PK_DIVER ASC";
    $query = $this->db->query($sql);
    return $query->result();
}
/**
 * Save the changes made to the diver details
 * @param unknown $diver
 */
public function update_diver_form($diver)
{
    $sql = "SELECT * FROM diver_master WHERE PK_DIVER='$diver'";
    $query =$this->db->query($sql);
    return $query->result();
}
/**
 * Save the changes of the divers
 * @return boolean
 */
public function modify_diver_form()
{
    $data = array(
		'DIVER_ID'=>$this->input->post("diver_id"),
		'DIVER_NAME'=>$this->input->post("diver_name"),
		'ADDRESS'=>$this->input->post("address"),
		'ADDRESS1'=>$this->input->post("address1"),
		'CITY'=>$this->input->post("city"),
		'STATE'=>$this->input->post("state"),
		'ZIPCODE'=>$this->input->post("zip"),
		'COUNTRY'=>$this->input->post("country"),
		'PHONE_NO'=>$this->input->post("telephone"),
		'FAX_NO'=>$this->input->post("fax"),
		'EMAIL'=>$this->input->post("email"),
		'HULL_CLEAN_RATE'=>$this->input->post("cleanrate"),
		'ZINC_RATE'=>$this->input->post("anoderate"),
		'HULL_TIME_RATE'=>$this->input->post("hullrate"),
		'MECH_TIME_RATE'=>$this->input->post("mechrate"),
                                    'ADDFIELD1'=>$this->input->post("password"),
        'ADDFIELD2'=>$this->input->post("limited")
                                    );
    $this->db->where ( 'PK_DIVER', $this->input->post('pk_diver') );
    $this->db->update ( 'diver_master', $data );
    return true;

}
/**
 * create new diver entry
 * @return boolean
 */
public function create_diver_form()
{
    $data = array(
                                    'DIVER_ID'=>$this->input->post("diver_id"),
                                    'DIVER_NAME'=>$this->input->post("diver_name"),
                                    'ADDRESS'=>$this->input->post("address"),
                                    'ADDRESS1'=>$this->input->post("address1"),
                                    'CITY'=>$this->input->post("city"),
                                    'STATE'=>$this->input->post("state"),
                                    'ZIPCODE'=>$this->input->post("zip"),
                                    'COUNTRY'=>$this->input->post("country"),
                                    'PHONE_NO'=>$this->input->post("telephone"),
                                    'FAX_NO'=>$this->input->post("fax"),
                                    'EMAIL'=>$this->input->post("email"),
                                    'HULL_CLEAN_RATE'=>$this->input->post("cleanrate"),
                                    'ZINC_RATE'=>$this->input->post("anoderate"),
                                    'HULL_TIME_RATE'=>$this->input->post("hullrate"),
                                    'MECH_TIME_RATE'=>$this->input->post("mechrate"),
                                    'ADDFIELD1'=>$this->input->post("password"));
    $this->db->insert ( 'diver_master', $data );
    return true;
}
/**
 * poplate the genearal table entries
 * @param unknown $qry
 */
public function update_purpose_list($qry)
{
    $sql = "SELECT * FROM general_table WHERE PURPOSE='$qry' ORDER BY ORDER_BY ASC";
    $query = $this->db->query($sql);
    return $query->result();
}
//Payments-Reports
public function get_payment_list($qry)
{
	$sql = "SELECT  m.pk_customer cid, account_no,CONCAT(m.first_name,' ',m.last_name) as cust_name, vessel_name,
CONCAT(location,' ',slip) as location,
 sum(debit), sum(credit) FROM customer_master m, customer_vessel b , general_ledger g
 where m.pk_customer = b.pk_customer
  and g.pk_customer = m.pk_customer 
	    and m.status='ACTIVE'
  and( concat(first_name,' ',last_name) like '%".$qry."%'
or last_name like '%".$qry."%'
  or  account_no like '%".$qry."%'
   or vessel_name  like '%".$qry."%'
           or  concat(substring(Location, 6), slip) like '%".$qry."%'
           or  location like '%".$qry."%'
            or  slip like '%".$qry."%'
           or country  like '%".$qry."%'
 )
group by m.pk_customer, account_no, first_Name, last_name, vessel_NAME, location, slip
order by LAST_NAME";

	$query = $this->db->query($sql);
	return $query->result();
}
//payment invoice list
public function get_payment_invoice_list($qry)
{
	$sql = " (SELECT  m.pk_customer cid, first_Name, last_name, 'Credit' invno, transaction_date invdt,
  sum(debit) billed, sum(credit) received, sum(debit-credit) bal
  FROM customer_master m, general_ledger g
  where(m.pk_customer = g.pk_customer)
  and trans_type='S'
  and invoice_no=555
  and m.pk_customer = '".$qry."'
  group by m.pk_customer,  first_Name, last_name, invoice_no, transaction_date
  having(sum(debit) <> sum(credit)) 
  )
  UNION 
  (
  SELECT  m.pk_customer cid, first_Name, last_name, 'C/F' invno, transaction_date invdt,
sum(debit) billed, sum(credit) received, sum(debit-credit) bal
  FROM customer_master m, general_ledger g
  where(m.pk_customer = g.pk_customer)
  and trans_type='S'
  and invoice_no=999
  and m.pk_customer = '".$qry."'
  group by m.pk_customer,  first_Name, last_name, invoice_no, transaction_date
  having(sum(debit) <> sum(credit)) 
  )
  UNION ALL
  (
  SELECT  m.pk_customer cid, first_Name,
last_name, invoice_no invno, invoice_date invdt,
 sum(debit) billed, sum(credit) received, sum(debit-credit) bal
  FROM customer_master m,  general_ledger g
  left outer join invoice i on i.pk_invoice=g.invoice_no
  where(m.pk_customer = g.pk_customer)
  and trans_type='S'
  and invoice_no not in (999,555)
  and m.pk_customer = '".$qry."'
  group by m.pk_customer,  first_Name, last_name, invoice_no, invoice_date
  having(sum(debit) <> sum(credit)) 
  )";
  $query = $this->db->query($sql);
	return $query->result();
}
/**
 * list down the specified options
 */
public function total_option_purpose($option)
{
    $sql = "SELECT * FROM general_table WHERE PURPOSE='$option' ";
    $query = $this->db->query($sql);
    return $query->result();
}
/**
 * Update the options with order
 * @param unknown $purpose : type of options
 * @param unknown $order : order to be displayed.
 * @param unknown $option :  options name
 * @param unknown $value : value.
 */
public function update_data_option_order($purpose,$order, $option, $value)
{
    $order++;
    $option = trim($option);
    $sql = "UPDATE general_table SET OPTIONS='$option',VALUE='$value' WHERE PURPOSE='$purpose' AND ORDER_BY='$order'";
    $this->db->query($sql);
   echo $option.$value;
}
/**
 * Save new options
 * @param unknown $purpose
 * @param unknown $order
 * @param unknown $option
 * @param unknown $value
 */
public function insert_data_option_order($purpose,$order, $option, $value)
{
    $order++;
    $option = trim($option);
    $sql = "INSERT INTO general_table(TABLE_NAME, ORDER_BY, PURPOSE, OPTIONS, VALUE) VALUES ('GENERAL','$order','$purpose','$option','$value')";
    $this->db->query($sql);
    echo $option.$value;
}
/**
 * Exempted portions
 * @param unknown $string
 */
public function get_all_void_work_order( $string )
{
    $string = urldecode($string);
    $sql = " SELECT DISTINCT customer_master.FIRST_NAME AS F, customer_master.LAST_NAME AS L, customer_vessel.VESSEL_NAME AS V,customer_vessel.SLIP AS SL, customer_vessel.LOCATION AS O,
                                        work_order.WO_CLASS AS W, work_order.WO_NUMBER AS R, work_order.PK_WO AS WK FROM customer_master INNER JOIN customer_vessel ON
                                        customer_master.PK_CUSTOMER = customer_vessel.PK_CUSTOMER INNER JOIN work_order  ON customer_master.PK_CUSTOMER = work_order.PK_CUSTOMER
                                        INNER JOIN work_order_parts ON work_order.PK_WO=work_order_parts.PK_WO
                                        WHERE ( customer_master.FIRST_NAME LIKE '%$string%' OR customer_master.LAST_NAME LIKE '%$string%' OR  customer_vessel.VESSEL_NAME
                                   LIKE '%$string%' OR customer_vessel.LOCATION LIKE '%$string%' OR work_order.WO_CLASS LIKE '%$string%' OR work_order.WO_NUMBER
                                   LIKE '%$string%' OR  CONCAT_WS( ' ', FIRST_NAME, LAST_NAME ) LIKE '%$string%' OR customer_master.ACCOUNT_NO LIKE '%$string%' OR
                            customer_vessel.SLIP LIKE '%$string%' OR   CONCAT_WS( ' ', customer_vessel.LOCATION, customer_vessel.SLIP ) LIKE '%$string%' OR
                            CONCAT(  customer_vessel.LOCATION, customer_vessel.SLIP ) LIKE '%$string%') AND  work_order.WO_STATUS = '4'  ORDER BY work_order.PK_WO ASC";

    $query = $this->db->query($sql);
    return $query->result();
}
/**
 * Exempted portion
 * @param unknown $pkwork
 */
public function activate_void_work_order($pkwork)
{
    $sql = "UPDATE work_order SET WO_STATUS=0 WHERE PK_WO='$pkwork'";
    $this->db->query($sql);

}
/**
 * Customers with BOw/AFt will be displayed
 * @param number $current : pagen ummber
 * @param number $perpage : number of results per page
 * @param string $qry : query if any.
 */
public function get_customer_bowaft($current = 0, $perpage = 32, $qry = null)
{
    if(is_null($qry))
    {
    $sql = "SELECT customer_master.PK_CUSTOMER, FIRST_NAME, LAST_NAME, VESSEL_NAME, LOCATION, SLIP
    FROM customer_master
    INNER JOIN vessel_services ON customer_master.PK_CUSTOMER = vessel_services.PK_CUSTOMER
    INNER JOIN customer_vessel ON customer_vessel.PK_CUSTOMER = customer_master.PK_CUSTOMER
    WHERE SERVICE_TYPE LIKE '%BOW%'
    AND STATUS = 'ACTIVE'
    ORDER BY FIRST_NAME ASC , LAST_NAME ASC LIMIT $current,$perpage";
    }
    else
    {
        $qry = urldecode($qry);
        $sql = "SELECT customer_master.PK_CUSTOMER, FIRST_NAME, LAST_NAME, VESSEL_NAME, LOCATION, SLIP
    FROM customer_master
    INNER JOIN vessel_services ON customer_master.PK_CUSTOMER = vessel_services.PK_CUSTOMER
    INNER JOIN customer_vessel ON customer_vessel.PK_CUSTOMER = customer_master.PK_CUSTOMER
    WHERE SERVICE_TYPE LIKE '%BOW%' AND (FIRST_NAME LIKE '%$qry%' OR LAST_NAME LIKE '%$qry%' OR LOCATION LIKE '%$qry%' OR SLIP LIKE '%$qry%' OR VESSEL_NAME LIKE '%$qry%')
    AND STATUS = 'ACTIVE'
    ORDER BY FIRST_NAME ASC , LAST_NAME ASC LIMIT 0,$perpage";
    }
    $query = $this->db->query($sql);
    return $query->result();
}
/**
 * Total of the customers with BOw/aft
 */
public function get_customer_bowaft_nolimit()
{
    $sql = "SELECT customer_master.PK_CUSTOMER, FIRST_NAME, LAST_NAME, VESSEL_NAME, LOCATION, SLIP
FROM customer_master
INNER JOIN vessel_services ON customer_master.PK_CUSTOMER = vessel_services.PK_CUSTOMER
INNER JOIN customer_vessel ON customer_vessel.PK_CUSTOMER = customer_master.PK_CUSTOMER
WHERE SERVICE_TYPE LIKE '%BOW%'
AND STATUS = 'ACTIVE'
ORDER BY FIRST_NAME ASC , LAST_NAME ASC ";
    $query = $this->db->query($sql);
    return $query->result();
}
/**
 * Repair the commision by giving the work order number.
 * @param unknown $wonumber:work order number
 */
public function repair_commission($wonumber)
{
    $sql = "SELECT PK_DIVER_TRANS  FROM diver_transactions WHERE WO_NUMBER = '$wonumber'";
    $query = $this->db->query($sql);
    $data['diver'] = $query->result();
    if(count($data['diver'])>0)
    {
        foreach($data['diver'] as $d):
        $this->db->where ( 'PK_DIVER_TRANS', $d->PK_DIVER_TRANS );
        $this->db->delete ( 'diver_transactions' );
        endforeach;
        $sql = "SELECT PK_WO FROM work_order WHERE WO_NUMBER = '$wonumber'";
        $query = $this->db->query($sql);
        $data['commission'] = $query->result();
        foreach ($data['commission'] as $t):
        $this->update_diver_commission_extra($t->PK_WO);
        endforeach;
        echo 'Repair Completed';

    }
    else
    {
        echo 'Work Order '.$wonumber.'  Not Found';
    }

}
/**
 *
 * @param unknown $customer : primary key of the customer.
 */
public function last_invoice_from_customer($customer)
{
    $sql = "SELECT PK_INVOICE FROM invoice WHERE pk_customer='$customer' ORDER BY PK_INVOICE DESC LIMIT 0,1";
    $query = $this->db->query($sql);
    return $query->result();
}
/**
 * Work orders under the given invoice.
 * @param unknown $last_invoice
 */
public function list_all_work_orders($last_invoice)
{
 $sql = "SELECT PK_WO FROM work_order WHERE INVOICE_NO='$last_invoice'";
 $query = $this->db->query($sql);
 return $query->result();
}
//diver login details
public function check_diver_login($uname,$pwd)
{


   $this -> db -> select('pk_diver,diver_name,email, addfield1');
   $this -> db -> from('diver_master');
   $this -> db -> where('email', $uname);
   $this -> db -> where('addfield1', $pwd);
   $this -> db -> limit(1);

   $query = $this -> db -> get();

   if($query -> num_rows() == 1)
   {

 return $query->result();
   }
   else
   {

   return false;
   }


}
//get total rows of completed work order
public function get_totalrow_comp_wo()
{
    $k = date('m/d/Y', strtotime('last Sunday', strtotime(date('m/d/Y'))));
    $date = $k;
    $newdate = strtotime('-6 day', strtotime($date));
    $newdate = date('m/d/Y', $newdate);
    $start = $this->date_format_db($newdate);
    $end = $this->date_format_db($k);

      $session_data = $this->session->userdata('ses_login');
      $diverid = $session_data['d_id'];
     $sql="select count(*) as totalrows
from
(
SELECT COUNT(*) as trows
FROM customer_master
INNER JOIN customer_vessel ON customer_master.PK_CUSTOMER = customer_vessel.PK_CUSTOMER
INNER JOIN work_order ON customer_master.PK_CUSTOMER = work_order.PK_CUSTOMER
INNER JOIN work_order_parts ON work_order.PK_WO=work_order_parts.PK_WO
INNER JOIN diver_transactions on work_order.WO_NUMBER=diver_transactions.WO_NUMBER
where work_order.PK_DIVER='$diverid'
and (work_order.WO_STATUS=1 OR work_order.WO_STATUS=2)
and work_order_parts.WORK_VALUE=1 and customer_master.STATUS='ACTIVE' and work_order.SCHEDULE_DATE BETWEEN '$start' AND '$end'
group by work_order.PK_WO
)totalrowscompleted";
  $query = $this->db->query($sql);
  return $query->result();
}

//get diver total commission-completed work order
public function get_divertotal_commi($start=null,$end=null)
{
    $session_data = $this->session->userdata('ses_login');
      $diverid = $session_data['d_id'];

if(is_null($start) || is_null($end))
{
    $k = date('m/d/Y', strtotime('last Sunday', strtotime(date('m/d/Y'))));
    $date = $k;
    $newdate = strtotime('-6 day', strtotime($date));
    $newdate = date('m/d/Y', $newdate);
    $start = $this->date_format_db($newdate);
    $end = $this->date_format_db($k);

    $sql = "SELECT work_order.PK_WO AS PKWORKORDER,
case work_order.WO_CLASS
when 'C' then 'Clean'
when 'A' then 'Anode'
when 'M' then 'Mech'
else
work_order.WO_CLASS
end as 'W',customer_master.FIRST_NAME AS F, customer_master.LAST_NAME AS L,
customer_vessel.VESSEL_NAME AS V,
customer_vessel.SLIP AS SL, customer_vessel.LOCATION AS O,
work_order.WO_NUMBER AS R, work_order.PK_WO AS WK,work_order.WO_STATUS,
diver_transactions.COMMISSION_AMOUNT AS C_AMT,diver_transactions.PAID AS PD
FROM customer_master
INNER JOIN customer_vessel ON customer_master.PK_CUSTOMER = customer_vessel.PK_CUSTOMER
INNER JOIN work_order ON customer_master.PK_CUSTOMER = work_order.PK_CUSTOMER
INNER JOIN work_order_parts ON work_order.PK_WO=work_order_parts.PK_WO
INNER JOIN diver_transactions on work_order.WO_NUMBER=diver_transactions.WO_NUMBER
where work_order.PK_DIVER='$diverid' and work_order.SCHEDULE_DATE BETWEEN '$start' AND '$end' and customer_master.STATUS='ACTIVE' group by diver_transactions.PK_DIVER_TRANS";
}
else
{
    $sql = "SELECT work_order.PK_WO AS PKWORKORDER,
case work_order.WO_CLASS
when 'C' then 'Clean'
when 'A' then 'Anode'
when 'M' then 'Mech'
else
work_order.WO_CLASS
end as 'W',customer_master.FIRST_NAME AS F, customer_master.LAST_NAME AS L,
customer_vessel.VESSEL_NAME AS V,
customer_vessel.SLIP AS SL, customer_vessel.LOCATION AS O,
work_order.WO_NUMBER AS R, work_order.PK_WO AS WK,work_order.WO_STATUS,
diver_transactions.COMMISSION_AMOUNT AS C_AMT,diver_transactions.PAID AS PD
FROM customer_master
INNER JOIN customer_vessel ON customer_master.PK_CUSTOMER = customer_vessel.PK_CUSTOMER
INNER JOIN work_order ON customer_master.PK_CUSTOMER = work_order.PK_CUSTOMER
INNER JOIN work_order_parts ON work_order.PK_WO=work_order_parts.PK_WO
INNER JOIN diver_transactions on work_order.WO_NUMBER=diver_transactions.WO_NUMBER
where work_order.PK_DIVER='$diverid' and work_order.SCHEDULE_DATE BETWEEN '$start' AND '$end' and customer_master.STATUS='ACTIVE' group by diver_transactions.PK_DIVER_TRANS";
}
     $query = $this->db->query($sql);

  return $query->result();
}
//get total rows of incompleted wo

public function get_totalrow_incomp_wo()
{
    $session_data = $this->session->userdata('ses_login');
      $diverid = $session_data['d_id'];
     $sql="select count(*) as totalrows
from
(
SELECT count(*) as totalrows
FROM customer_master
INNER JOIN customer_vessel ON customer_master.PK_CUSTOMER = customer_vessel.PK_CUSTOMER
INNER JOIN work_order ON customer_master.PK_CUSTOMER = work_order.PK_CUSTOMER
INNER JOIN work_order_parts ON work_order.PK_WO=work_order_parts.PK_WO
where work_order.WO_STATUS=0 and work_order.PK_DIVER='$diverid' and work_order_parts.WORK_VALUE='1'
group by work_order.PK_WO
)totalrowsIncompleted";
$query = $this->db->query($sql);
  return $query->result();
}

//Display completed work orders
public function display_completed_wo($limit, $start)
{
    $k = date('m/d/Y', strtotime('last Sunday', strtotime(date('m/d/Y'))));
    $date = $k;
    $newdate = strtotime('-6 day', strtotime($date));
    $newdate = date('m/d/Y', $newdate);
    $starts = $this->date_format_db($newdate);
    $end = $this->date_format_db($k);
	    $session_data = $this->session->userdata('ses_login');
		$diverid = $session_data['d_id'];

$sql = "SELECT work_order.PK_WO AS PKWORKORDER,
case work_order.WO_CLASS
when 'C' then 'Clean'
when 'A' then 'Anode'
when 'M' then 'Mech'
else
work_order.WO_CLASS
end as 'W',customer_master.FIRST_NAME AS F, customer_master.LAST_NAME AS L,
customer_vessel.VESSEL_NAME AS V,
customer_vessel.SLIP AS SL, customer_vessel.LOCATION AS O,
work_order.WO_NUMBER AS R, work_order.PK_WO AS WK,work_order.WO_STATUS,
diver_transactions.COMMISSION_AMOUNT AS C_AMT
FROM customer_master
INNER JOIN customer_vessel ON customer_master.PK_CUSTOMER = customer_vessel.PK_CUSTOMER
INNER JOIN work_order ON customer_master.PK_CUSTOMER = work_order.PK_CUSTOMER
INNER JOIN work_order_parts ON work_order.PK_WO=work_order_parts.PK_WO
INNER JOIN diver_transactions on work_order.WO_NUMBER=diver_transactions.WO_NUMBER
where work_order.PK_DIVER='$diverid'
and (work_order.WO_STATUS=1 or work_order.WO_STATUS=2)
and work_order_parts.WORK_VALUE=1 and customer_master.STATUS='ACTIVE'  and work_order.SCHEDULE_DATE BETWEEN '$starts' AND '$end'
group by work_order.PK_WO  ORDER BY work_order.SCHEDULE_DATE ASC, customer_vessel.LOCATION ASC
limit $start,$limit ";

    $query = $this->db->query($sql);

    $query->result();
}
//display comp wo by date
public function display_cwo_date($sch_date,$end_date)
{
	    $session_data = $this->session->userdata('ses_login');
		$diverid = $session_data['d_id'];

$sql = "SELECT work_order.PK_WO AS PKWORKORDER,
case work_order.WO_CLASS
when 'C' then 'Clean'
when 'A' then 'Anode'
when 'M' then 'Mech'
else
work_order.WO_CLASS
end as 'W',customer_master.FIRST_NAME AS F, customer_master.LAST_NAME AS L,
customer_vessel.VESSEL_NAME AS V,
customer_vessel.SLIP AS SL, customer_vessel.LOCATION AS O,
work_order.WO_NUMBER AS R, work_order.PK_WO AS WK,work_order.WO_STATUS,
diver_transactions.COMMISSION_AMOUNT AS C_AMT
FROM customer_master
INNER JOIN customer_vessel ON customer_master.PK_CUSTOMER = customer_vessel.PK_CUSTOMER
INNER JOIN work_order ON customer_master.PK_CUSTOMER = work_order.PK_CUSTOMER
INNER JOIN work_order_parts ON work_order.PK_WO=work_order_parts.PK_WO
INNER JOIN diver_transactions on work_order.WO_NUMBER=diver_transactions.WO_NUMBER
where work_order.PK_DIVER='$diverid' AND work_order.WO_CLASS=diver_transactions.WO_CLASS and work_order.SCHEDULE_DATE BETWEEN '$sch_date' AND '$end_date' and customer_master.STATUS='ACTIVE' group by work_order.PK_WO ORDER BY work_order.SCHEDULE_DATE ASC, customer_vessel.LOCATION ASC";

    $query = $this->db->query($sql);
    return $query->result();

}

/**
 * display commission amout of comp wo by pkwo
 * @param type $param
 */
    public function get_divercomm_amt_cwo($pkwo) {

	        $session_data = $this->session->userdata('ses_login');
		$diverid = $session_data['d_id'];
        $sql="
        SELECT diver_transactions.COMMISSION_AMOUNT AS C_AMT
FROM work_order
INNER JOIN diver_transactions ON work_order.WO_NUMBER = diver_transactions.WO_NUMBER
WHERE diver_transactions.PK_DIVER = '$diverid'
AND work_order.WO_CLASS = diver_transactions.WO_CLASS
AND work_order.PK_WO ='$pkwo'";

           $query = $this->db->query($sql);
         return $query->result();
    }
//Display incompleted work order
public function display_incompleted_wo($limit, $start)
{
	 $session_data = $this->session->userdata('ses_login');
        $diverid = $session_data['d_id'];
$sql = "SELECT work_order.PK_WO AS PKWORKORDER,
case work_order.WO_CLASS
when 'C' then 'Clean'
when 'A' then 'Anode'
when 'M' then 'Mech'
else
work_order.WO_CLASS
end as 'W',customer_master.FIRST_NAME AS F, customer_master.LAST_NAME AS L,
customer_vessel.VESSEL_NAME AS V,
customer_vessel.SLIP AS SL, customer_vessel.LOCATION AS O,
work_order.WO_NUMBER AS R, work_order.PK_WO AS WK,work_order.WO_STATUS
FROM customer_master
INNER JOIN customer_vessel ON customer_master.PK_CUSTOMER = customer_vessel.PK_CUSTOMER
INNER JOIN work_order ON customer_master.PK_CUSTOMER = work_order.PK_CUSTOMER
INNER JOIN work_order_parts ON work_order.PK_WO=work_order_parts.PK_WO
where work_order.WO_STATUS=0 and work_order.PK_DIVER='$diverid' and work_order_parts.WORK_VALUE>0
group by work_order.PK_WO ORDER BY work_order.SCHEDULE_DATE ASC, customer_vessel.LOCATION ASC
limit $start,$limit";

    $query = $this->db->query($sql);

   if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
}
/*
 * return all open work orders from the db to a given date range.
 */
public function get_open_work_orders($now,$then,$basin=null)
{
    $sql = "SELECT  customer_vessel.VESSEL_NAME,customer_vessel.SLIP,customer_vessel.VESSEL_LENGTH,customer_vessel.LOCATION,customer_vessel.VESSEL_TYPE,customer_master.FIRST_NAME,customer_master.LAST_NAME,
    customer_master.ACCOUNT_NO,work_order.WO_NUMBER,work_order_parts.WORK_DESCRIPTION,work_order_parts.WORK_TYPE,work_order_parts.WORK_NAME,DATE_FORMAT(work_order.SCHEDULE_DATE,  '%m/%d/%Y') AS SCHEDULE_DATE
    ,work_order.COMMENTS,
    sum(work_order_parts.DISCOUNT_PRICE) AS SOME,work_order.WO_CLASS,work_order.PK_WO,work_order.PK_DIVER,work_order.WO_STATUS,work_order.INVOICE_SUB FROM customer_master   INNER JOIN customer_vessel   ON
    customer_master.PK_CUSTOMER=customer_vessel.PK_CUSTOMER INNER JOIN work_order   ON customer_master.PK_CUSTOMER=work_order.PK_CUSTOMER INNER JOIN work_order_parts  ON
    work_order.PK_WO=work_order_parts.PK_WO   WHERE  work_order.WO_STATUS=0 AND work_order_parts.WORK_VALUE>0 AND customer_master.STATUS='ACTIVE' ";

    $this->session->set_userdata("person","everyone");

    if($basin!='all')
    {
        $totals = explode("_",$basin);
        $bsn = $totals[0];
        $mrn = $totals[1];
        $ctg = $totals[2];

        $basins = explode("^",$bsn);
        $marina = explode("^",$mrn);
        $catego = explode("^",$ctg);


      if(is_numeric($basins[0]))
      {
          $sql .= " AND work_order.PK_DIVER='$basins[0]' ";
          $this->session->set_userdata("person",$basins[0]);

      }
      else
      {

          $sql .= " AND work_order.PK_DIVER=0 ";


      }
        if(count($basins)>1){
        $sql .= " AND ( ";
         for($i=1;$i<count($basins);$i++){
        $sql = $sql. "  customer_vessel.LOCATION='$basins[$i]' ";
        if($i+1 != count($basins))
        {
            $sql .= " OR ";
        }
        }
        $sql .= "  )  ";
        }

        if(count($marina)>1){
            $sql .= " AND ( ";
            for($j=1;$j<count($marina);$j++)
            {
                switch($marina[$j])
                {
                    case 'marina1':
                        $sql .= " customer_vessel.VESSEL_NAME LIKE '%V/H%' ";
                        break;
                    case 'marina2':
                        $sql .= " customer_vessel.VESSEL_NAME LIKE '%N/B%' ";
                        break;
                    case 'marina3':
                        $sql .= " customer_vessel.VESSEL_NAME LIKE '%MDR%' ";
                        break;
					case 'marina4':
                        $sql .= " customer_vessel.VESSEL_NAME LIKE '%W/V%' ";
                        break;
                    default:break;
                }

                if($j+1 != count($marina))
                {
                    $sql .= " OR ";
                }
            }
            $sql .= "  )  ";
        }

        /****************************************************/


        if(count($catego)>1){
            $sql .= " AND ( ";
            for($k=1;$k<count($catego);$k++)
            {
            switch($catego[$k])
                {
                    case 'category1':
                            $sql .= " work_order.WO_CLASS='C' ";
                            break;
                    case 'category2':
                            $sql .= " work_order.WO_CLASS='A' ";
                            break;
                    case 'category3':
                            $sql .= " work_order.WO_CLASS='M' ";
                            break;
                    default:break;
                }

                if($k+1 != count($catego))
                {
                $sql .= " OR ";
                }
            }
            $sql .= "  )  ";
        }

        if(count($basins)<2 && count($marina)<2 && count($catego)<2 && is_numeric($basins[0]))
        {
            $sql .= "  ";
        }
        else
        {
            $sql .= " AND  SCHEDULE_DATE BETWEEN '$then' AND '$now'  ";
        }

    }
    else
    {
        $sql .= " AND  SCHEDULE_DATE BETWEEN '$then' AND '$now' AND work_order.PK_DIVER=0 ";
    }

     $sql = $sql." GROUP BY  work_order.PK_WO ORDER BY work_order.SCHEDULE_DATE ASC,customer_vessel.LOCATION ASC,customer_vessel.SLIP ASC";

    $query = $this->db->query($sql);

    return $query->result();
}
/*
 * return all diver names and count of total assigned work for the given date range.
 */
public function get_diver_work_details($now,$then,$basin=null)
{
    $sql = "SELECT diver_master.PK_DIVER, diver_master.DIVER_NAME, COUNT( CASE WO_STATUS WHEN 0 THEN 1 ELSE NULL END ) AS T FROM diver_master LEFT JOIN work_order ON diver_master.PK_DIVER = work_order.PK_DIVER INNER JOIN customer_vessel ON work_order.PK_CUSTOMER=customer_vessel.PK_CUSTOMER
  WHERE work_order.PK_DIVER >0 AND diver_master.DIVER_NAME !=  '' AND  SCHEDULE_DATE BETWEEN '$then' AND '$now' ";

if($basin!='all')
    {
        $totals = explode("_",$basin);
        $bsn = $totals[0];
        $mrn = $totals[1];
        $ctg = $totals[2];

        $basins = explode("^",$bsn);
        $marina = explode("^",$mrn);
        $catego = explode("^",$ctg);


        if(count($basins)>1){
        $sql .= " AND ( ";
         for($i=1;$i<count($basins);$i++){
        $sql = $sql. "  customer_vessel.LOCATION='$basins[$i]' ";
        if($i+1 != count($basins))
        {
            $sql .= " OR ";
        }
        }
        $sql .= "  )  ";
        }

        if(count($marina)>1){
            $sql .= " AND ( ";
            for($j=1;$j<count($marina);$j++)
            {
                switch($marina[$j])
                {
                    case 'marina1':
                        $sql .= " customer_vessel.VESSEL_NAME LIKE '%V/H%' ";
                        break;
                    case 'marina2':
                        $sql .= " customer_vessel.VESSEL_NAME LIKE '%N/B%' ";
                        break;
                    case 'marina3':
                        $sql .= " customer_vessel.VESSEL_NAME LIKE '%MDR%' ";
                        break;
					case 'marina4':
                        $sql .= " customer_vessel.VESSEL_NAME LIKE '%W/V%' ";
                        break;
                    default:break;
                }

                if($j+1 != count($marina))
                {
                    $sql .= " OR ";
                }
            }
            $sql .= "  )  ";
        }

        /****************************************************/


        if(count($catego)>1){
            $sql .= " AND ( ";
            for($k=1;$k<count($catego);$k++)
            {
            switch($catego[$k])
                {
                    case 'category1':
                            $sql .= " work_order.WO_CLASS='C' ";
                            break;
                    case 'category2':
                            $sql .= " work_order.WO_CLASS='A' ";
                            break;
                    case 'category3':
                            $sql .= " work_order.WO_CLASS='M' ";
                            break;
                    default:break;
                }

                if($k+1 != count($catego))
                {
                $sql .= " OR ";
                }
            }
            $sql .= "  )  ";
        }

        /**
         *     if(count($basins)<2 && count($marina)<2 && count($catego)<2 && is_numeric($basins[0]))
        {
            $sql .= " AND SCHEDULE_DATE<'$now' ";
        }
        else
        {
            $sql .= " AND  SCHEDULE_DATE BETWEEN '$then' AND '$now'  ";
        }
         */

    }

    $sql =$sql . "  GROUP BY PK_DIVER ORDER BY diver_master.PK_DIVER ASC";
	$query = $this->db->query($sql);
	return $query->result();
}
public function get_total_workorders_alltime($who)
{
    $sql = "SELECT work_order.PK_WO FROM work_order INNER JOIN work_order_parts ON work_order.PK_WO = work_order_parts.PK_WO INNER JOIN customer_master ON work_order.PK_CUSTOMER=customer_master.PK_CUSTOMER
     WHERE PK_DIVER ='$who'  AND WO_STATUS =0 AND work_order_parts.WORK_VALUE>0 AND customer_master.STATUS='ACTIVE'
GROUP BY work_order.PK_WO ORDER BY work_order.PK_WO";

    $query = $this->db->query($sql);
    return $query->result();
}




/*
 * update diver to work order for performing the task.
 */
public function update_diver_work_order($work,$diver)
{

    $works = explode("^",$work);
    for($i=1;$i<count($works);$i++)
    {
    $sql = " UPDATE work_order SET PK_DIVER='$diver' WHERE PK_WO='$works[$i]' ";

    $this->db->query($sql);

    }

}
/**
 * Get the vessel locations from db
 */
public function get_vessel_location()
{
    $sql = "SELECT OPTIONS FROM general_table WHERE PURPOSE='LOCATIONS' ORDER BY OPTIONS ASC";
    $query = $this->db->query($sql);
    return $query->result();
}
/**
 * Update s the diver comments and completes th e work order by adding comments and date to the work order.
 * @param unknown $pkwo : work order primary key
 * @param unknown $lastdate : last date
 * @param unknown $comment : comments
 * @param string $flag : for sending emails.
 * @return boolean
 */
public function update_diver_comment($pkwo,$lastdate,$comment,$flag=null)
{
    $comment = urldecode($comment);
    //changeing wo number

    $newDate = date("mdy", strtotime($lastdate));
    if(is_null($flag))
    {
    $sql = "UPDATE work_order SET COMMENTS='$comment',SCHEDULE_DATE='$lastdate',WO_NUMBER=REPLACE(WO_NUMBER,SUBSTRING(WO_NUMBER,10), '$newDate') WHERE PK_WO='$pkwo'";
    $this->db->query($sql);
    }
    else
    {

        $mysql = "SELECT work_order.PK_CUSTOMER,work_order.WO_CLASS,work_order_parts.WORK_TYPE FROM work_order INNER JOIN work_order_parts ON work_order.PK_WO=work_order_parts.PK_WO
        WHERE work_order.PK_WO = '$pkwo'  GROUP BY work_order.PK_WO";
        $query = $this->db->query($mysql);
        $data['work'] = $query->result();

        switch($data['work'][0]->WO_CLASS)
        {
            case 'A':
                $sql = "UPDATE work_order SET COMMENTS='$comment',WO_STATUS='1',SCHEDULE_DATE='$lastdate',WO_NUMBER=REPLACE(WO_NUMBER,SUBSTRING(WO_NUMBER,10), '$newDate') WHERE PK_WO='$pkwo'";
                $this->db->query($sql);
                $this->update_diver_commission_extra($pkwo);
                break;
            case 'C':
                if(strpos($data['work'][0]->WORK_TYPE,'BI')!==false)
                {
                    $sql = "UPDATE work_order SET COMMENTS='$comment',WO_STATUS='1',SCHEDULE_DATE='$lastdate',WO_NUMBER=REPLACE(WO_NUMBER,SUBSTRING(WO_NUMBER,10), '$newDate') WHERE PK_WO='$pkwo'";
                    $this->db->query($sql);
                    $this->update_diver_commission_extra($pkwo);
                    $this->invoice_together_possible($data['work'][0]->PK_CUSTOMER,$pkwo);
                }
                else if($data['work'][0]->WORK_TYPE=='WEEKLY')
                {
                    $sql = "UPDATE work_order SET COMMENTS='$comment',WO_STATUS='1',SCHEDULE_DATE='$lastdate',WO_NUMBER=REPLACE(WO_NUMBER,SUBSTRING(WO_NUMBER,10), '$newDate') WHERE PK_WO='$pkwo'";
                    $this->db->query($sql);
                    $this->update_diver_commission_extra($pkwo);//DFDSFDSFSD
                    $this->invoice_together_possible($data['work'][0]->PK_CUSTOMER,$pkwo,1);
                }
                else
                {
                    $sql = "UPDATE work_order SET COMMENTS='$comment',WO_STATUS='2',SCHEDULE_DATE='$lastdate',WO_NUMBER=REPLACE(WO_NUMBER,SUBSTRING(WO_NUMBER,10), '$newDate') WHERE PK_WO='$pkwo'";
                    $this->db->query($sql);
                    $this->update_diver_commission_extra($pkwo);
                    $this->send_wo_invoice(1,$data['work'][0]->PK_CUSTOMER);
                }
                break;
            case 'M':
                $sql = "UPDATE work_order SET COMMENTS='$comment',WO_STATUS='1',SCHEDULE_DATE='$lastdate',WO_NUMBER=REPLACE(WO_NUMBER,SUBSTRING(WO_NUMBER,10), '$newDate') WHERE PK_WO='$pkwo'";
                $this->db->query($sql);
                $this->update_diver_commission_extra($pkwo);
                break;
            default:break;
        }






    }

    return true;
}
/**
 * Checking for invoice together is possible to other work order completed of the same customers
 * @param unknown $pkcustomer : primary key of the customer
 * @param unknown $pkwo : work order priamry key
 * @param string $flag
 */
public function invoice_together_possible($pkcustomer,$pkwo,$flag=null)
{
    if(is_null($flag))
    {
    $sql = " SELECT * FROM work_order WHERE PK_CUSTOMER='$pkcustomer' AND WO_STATUS='1' AND WO_CLASS='C' ORDER BY SCHEDULE_DATE DESC ";
    $query = $this->db->query($sql);
    $data['work'] = $query->result();

    $datediff=0;
    if(count($data['work'])>1)
    {
        $datediff = strtotime($data['work'][0]->SCHEDULE_DATE)-strtotime($data['work'][1]->SCHEDULE_DATE);
        $datediff = floor(abs($datediff)/(60*60*24));
        if($datediff>=1)
        {
            $this->send_wo_invoice(1,$pkcustomer);
        }
    }

    }
    else {
        $sql = " SELECT * FROM work_order WHERE PK_CUSTOMER='$pkcustomer' AND WO_STATUS='1'  AND WO_CLASS='C' ORDER BY SCHEDULE_DATE DESC";
        $query = $this->db->query($sql);
        $data['work'] = $query->result();

        $datediff=0;
        if(count($data['work'])>3)
        {
            $datediff = strtotime($data['work'][0]->SCHEDULE_DATE)-strtotime($data['work'][3]->SCHEDULE_DATE);
            $datediff = floor(abs($datediff)/(60*60*24));
            if($datediff>=21)
            {
                $this->send_wo_invoice(1,$pkcustomer);
            }
        }
    }
   echo $datediff."|".count($data['work']);
}
/**
 * list down the anodes which are not included in the workorder.
 * @param unknown $pkcustomer
 */
public function work_order_open_anode($pkcustomer)
{
    $sql = "SELECT work_order.PK_WO FROM work_order INNER JOIN work_order_parts ON work_order.PK_WO = work_order_parts.PK_WO
WHERE work_order.PK_CUSTOMER = '$pkcustomer' AND work_order.WO_CLASS = 'A' AND work_order.WO_STATUS =0";
    $query = $this->db->query($sql);
    return $query->result();
}
//public function get_diver_
public function get_other_anodes($pkwork,$flag=null)
{
    if(!is_null($flag))
    {
        $asql = "SELECT work_order.PK_CUSTOMER
        FROM work_order WHERE PK_WO='$pkwork'";
        $aquery = $this->db->query($asql);
        $data['old'] = $aquery->result();
        $apk = $data['old'][0]->PK_CUSTOMER;

        /*
         * change here for non-existing anode work orders for create new.
         */
        $bsql = "SELECT PK_WO FROM work_order WHERE WO_CLASS='A' AND PK_CUSTOMER='$apk' AND WO_STATUS=0 ";
        $bquery = $this->db->query($bsql);
        $data['older'] = $bquery->result();
        if(count($data['older'])>0)
        {
        $pkwork = $data['older'][0]->PK_WO;
        }
        else
        {
            $amysql = "SELECT * FROM vessel_anodes WHERE PK_CUSTOMER='$apk' ";
            $aqry = $this->db->query($amysql);
            return $aqry->result();
        }


    }
    $sql = "SELECT work_order.PK_CUSTOMER, PK_WORK
FROM work_order
INNER JOIN work_order_parts ON work_order.PK_WO = work_order_parts.PK_WO
INNER JOIN vessel_anodes ON work_order.PK_CUSTOMER = vessel_anodes.PK_CUSTOMER
WHERE work_order.PK_WO ='$pkwork'
AND WORK_VALUE >0 ";

    $query = $this->db->query($sql);
    $data['exist'] = $query->result();
    $pkc = $data['exist'][0]->PK_CUSTOMER;
    $mysql = "SELECT * FROM vessel_anodes WHERE PK_CUSTOMER='$pkc' ";

    for($i=0;$i<count($data['exist']);$i++)
    {
        $pkw = $data['exist'][$i]->PK_WORK;
        $mysql .= " AND PK_VESSEL_ANODE!='$pkw'  ";
    }

    $qry = $this->db->query($mysql);
    return $qry->result();
}
/**
 * checking for anode work order is existing.
 * @param unknown $wocustomer : primary key of the customer.
 */
public function check_for_anode_work($wocustomer)
{
    $sql = "SELECT PK_WO FROM work_order WHERE WO_CLASS='A' AND PK_CUSTOMER='$wocustomer' AND WO_STATUS=0 ";
    $query = $this->db->query($sql);
    return $query->result();
}

public function check_workorder_open($who)
{
    $sql = "SELECT PK_WO FROM work_order WHERE WO_STATUS=0 AND PK_CUSTOMER='$who' ";
    $query = $this->db->query($sql);
    return $query->result();
}
public function display_onhold_workorders()
{
    $sql = "SELECT *,DATE_FORMAT(SCHEDULE_DATE,  '%m/%d/%Y') AS SCHEDULE_DATE,case work_order.WO_CLASS
when 'C' then 'Hull Clean'
when 'A' then 'Anode Change'
when 'M' then 'Mech service'
else
work_order.WO_CLASS
end as 'WO_CLASS' FROM work_order INNER JOIN customer_master ON work_order.PK_CUSTOMER=customer_master.PK_CUSTOMER INNER JOIN customer_vessel ON customer_master.PK_CUSTOMER=customer_vessel.PK_CUSTOMER INNER JOIN work_order_parts ON work_order.PK_WO=work_order_parts.PK_WO WHERE  STATUS='ACTIVE' AND WO_STATUS='5' AND WORK_VALUE>0  GROUP BY work_order.PK_WO ORDER BY customer_master.PK_CUSTOMER ASC";
    $query = $this->db->query($sql);
    return $query->result();
}
public function release_work_order_hold($work)
{
    $sql = "UPDATE work_order SET WO_STATUS='0' WHERE PK_WO='$work' ";
    $this->db->query($sql);
}
public function customer_hold_work_orders($customer)
{

    $sql = "SELECT PK_WO FROM work_order WHERE PK_CUSTOMER='$customer' AND WO_STATUS='5' ";
    $query = $this->db->query($sql);
    $data['hold'] = $query->result();


        $actual_date = date('m/d/Y', strtotime('last Sunday', strtotime(date('m/d/Y'))));
        $last_date = date('Y-m-d',strtotime('-42 days',strtotime($actual_date)));
        $mysql = "SELECT customer_master.PK_CUSTOMER, PK_LEDGER, TRANSACTION_DATE, (

SELECT SUM( DEBIT - CREDIT )
FROM general_ledger
WHERE PK_LEDGER <= GL.PK_LEDGER
AND PK_CUSTOMER = '$customer'
) 'RUNNING', (

SELECT SUM( CREDIT )
FROM general_ledger
WHERE PK_CUSTOMER = '$customer'
) 'TC', (

SELECT SUM( DEBIT )
FROM general_ledger
WHERE PK_CUSTOMER = '$customer'
AND PK_LEDGER <= GL.PK_LEDGER
) 'TD', (
(

SELECT SUM( CREDIT )
FROM general_ledger
WHERE PK_CUSTOMER = '$customer'
) - (
SELECT SUM( DEBIT )
FROM general_ledger
WHERE PK_CUSTOMER = '$customer'
AND PK_LEDGER <= GL.PK_LEDGER )
) 'OUTBAL'
FROM general_ledger GL
INNER JOIN customer_master ON customer_master.PK_CUSTOMER = GL.PK_CUSTOMER
INNER JOIN customer_vessel ON customer_vessel.PK_CUSTOMER = customer_master.PK_CUSTOMER
WHERE customer_master.PK_CUSTOMER = '$customer'
AND TRANSACTION_DATE <= '$last_date' HAVING OUTBAL<0
ORDER BY PK_LEDGER DESC
LIMIT 0 , 1";

        $qry = $this->db->query($mysql);
        $data['balance'] = $qry->result();

        if(count($data['balance'])==0)
        {
            $psql = "UPDATE work_order SET WO_STATUS='0' WHERE PK_CUSTOMER='$customer' AND WO_STATUS='5'";
            $qsql = "UPDATE outstanding_log SET INFO='Y',KOUNT=0 WHERE LGID IN (SELECT LGID FROM (
SELECT LGID FROM outstanding_log WHERE CUSTOMER = '$customer' ORDER BY LGID DESC LIMIT 0 , 1 )TMP ) ";
            $this->db->query($psql);
            $this->db->query($qsql);
            echo '1';
        }
        else
        {
             echo '1';
        }






}
public function display_customer_outbalance()
{
    $sql = "SELECT CUSTOMER,ACCOUNT,VESSEL,(SELECT AMOUNT FROM outstanding_log WHERE CUSTOMER=OL.CUSTOMER ORDER BY LGID DESC LIMIT 0,1)'AMOUNT' FROM outstanding_log OL GROUP BY CUSTOMER ORDER BY LGID ASC";
    $query = $this->db->query($sql);
    return $query->result();
}
public function display_customer_log_details($customer)
{
    $sql = "SELECT *,DATE_FORMAT(EXACT_TIME,  '%m/%d/%Y %h:%i:%s') AS EXACT_TIME,DATE_FORMAT(EXACT_TIME,  '%m/%d/%Y') AS EXACT_DATE FROM outstanding_log WHERE CUSTOMER='$customer' ORDER BY LGID DESC ";
    $query = $this->db->query($sql);
    return $query->result();
}
/**
 * User hierarchy by login is set from here.
 * admin:username is info@btwdive.com.
 * else they are divers.
 * @param unknown $user :username ie email id
 * @param unknown $pass :password
 */
public function set_privilege_session($user,$pass)
{
    switch ($user)
    {
        case 'info@btwdive.com':

    if($pass=='Ian123')
    {
        $this->session->set_userdata('administrator','admin');
        return true;
    }
    else
    {
        $this->session->set_userdata('administrator','user');
        return false;
    }
            break;
        default:
            if(count($this->check_diver_access($user, $pass))>0)
            {
                $this->session->set_userdata('administrator','diver');
                return true;
            }
            else
            {
                $this->session->set_userdata('administrator','user');
                return false;
            }



            break;
    }
}
public function check_diver_access($username,$password)
{
    $sql = "SELECT * FROM diver_master WHERE EMAIL='$username' AND ADDFIELD1='$password' AND ADDFIELD2='1'";
    $query = $this->db->query($sql);
    return $query->result();
}
public function list_paid_customer()
{
    $sql = "SELECT CUSTOMER FROM outstanding_log";
    $query = $this->db->query($sql);
    return $query->result();

}
public function release_work_order()
{
    $data['customer'] = $this->list_paid_customer();
    foreach ($data['customer'] as $c)
    {
        $this->customer_hold_work_orders($c->CUSTOMER);
    }
}
public function check_delivery_mode($customer)
{
    $sql = "SELECT DELIVERY_MODE FROM customer_master WHERE PK_CUSTOMER='$customer'";
   $query = $this->db->query($sql);
    return $query->result();
}
public function list_all_email_addresses($flag)
{
    $sql = "SELECT PK_CUSTOMER,FIRST_NAME,LAST_NAME,EMAIL FROM customer_master WHERE ";

    if($flag==1)
    {
        $sql .= " STATUS='ACTIVE' AND EMAIL!='' ";

    }

    if($flag==0)
    {
        $sql .= " STATUS='INACTIVE' AND EMAIL!=''   ";

    }

    $sql .= " GROUP BY EMAIL ORDER BY PK_CUSTOMER ASC ";
    $query = $this->db->query($sql);
    return $query->result();


}
// Added by Arif
// Function will collect onhold which is greater than 6 months
// If customer ID is provided on who return result for selected customer
// If who is empty return results of all customers
public function workorders_get_onhold_to_change($who = null)
{
    $six_months_before_date = date("Y-m-d", strtotime("-6 months"));
	$condition = 'WHERE ';
	if($who != null) $condition .= "PK_CUSTOMER='$who' AND ";
	$condition .= "WO_STATUS='5' AND ONHOLD_DATE < '$six_months_before_date'";
	$sql = "SELECT * FROM work_order $condition ";
	$query = $this->db->query($sql);
	return $query->result();
}
public function workorders_update_onhold_to_collection_default()
{
    $six_months_before_date = date("Y-m-d", strtotime("-6 months"));
	$condition = 'WHERE ';
	$condition .= "WO_STATUS='5' AND ONHOLD_DATE < '$six_months_before_date'";
	$sql = "UPDATE `work_order` SET WO_STATUS = 6 $condition ";
	$query = $this->db->query($sql);
	//return $query->result();
}
public function workorders_update_onhold_to_collection_selected($woId)
{
    $condition = 'WHERE ';
	$condition .= "WO_STATUS='5' AND PK_WO = '$woId' ";
	$sql = "UPDATE `work_order` SET WO_STATUS = 6,COLLECTION_DATE='".date('Y-m-d')."' $condition ";
	$query = $this->db->query($sql);
	echo $sql;
	//return $query->result();
}
public function workorders_release_from_collection($woId)
{
    $condition = 'WHERE ';
	$condition .= "WO_STATUS='6' AND PK_WO = '$woId'";
	$sql = "UPDATE `work_order` SET WO_STATUS = 0 $condition ";
	$query = $this->db->query($sql);
	//return $query->result();
}
public function workorders_back_to_onhold_from_collection($woId)
{
    $condition = 'WHERE ';
	$condition .= "WO_STATUS='6' AND PK_WO = '$woId'";
	$sql = "UPDATE `work_order` SET WO_STATUS = 5 $condition ";
	$query = $this->db->query($sql);
	//return $query->result();
}

public function get_collections_all()
{
    $sql = "SELECT *,DATE_FORMAT(INVOICE_DATE,  '%m/%d/%Y') AS INVOICE_DATE,case work_order.WO_CLASS
when 'C' then 'Hull Clean'
when 'A' then 'Anode Change'
when 'M' then 'Mech service'
else
work_order.WO_CLASS
end as 'WO_CLASS' FROM work_order INNER JOIN customer_master ON work_order.PK_CUSTOMER=customer_master.PK_CUSTOMER INNER JOIN customer_vessel ON customer_master.PK_CUSTOMER=customer_vessel.PK_CUSTOMER INNER JOIN work_order_parts ON work_order.PK_WO=work_order_parts.PK_WO WHERE  STATUS='ACTIVE' AND WO_STATUS='6' AND WORK_VALUE>0  GROUP BY work_order.PK_WO ORDER BY customer_master.PK_CUSTOMER ASC";
	$query = $this->db->query($sql);
	return $query->result();
}
public function get_mwo_choices_search_results($string) {
	if($string != 'All')
	{
		$sql = "SELECT PK_MWO,MWO_TYPE,DESCRIPTION,RATE,SCHEDULE_CHANGE FROM mechanical WHERE MWO_TYPE LIKE '%$string%' ORDER BY PK_MWO ASC ";
	}
	else
	{
		$sql = "SELECT PK_MWO,MWO_TYPE,DESCRIPTION,RATE,SCHEDULE_CHANGE FROM mechanical ORDER BY PK_MWO ASC ";
	}
    $query = $this->db->query ($sql);
    return $query->result ();
}
public function get_mwo_property($mwo) {
	$query = $this->db->query ("SELECT PK_MWO,MWO_TYPE,DESCRIPTION,RATE,SCHEDULE_CHANGE,INSTALLATION FROM mechanical WHERE PK_MWO=$mwo " );
	return $query->result ();
}	
}
