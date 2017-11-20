<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dangerList
 *
 * @author user
 */
class Statistics extends Main {

	function login_statistics($thirty,$sixty){ // AND date(n.logout_time) !='0000-00-00'   ---   AND date(k.logout_time)!='0000-00-00'
    $sql = "SELECT l.user_id,a.ad_person_name,(SELECT login_time FROM login_statistics m WHERE m.user_id=l.user_id ORDER BY m.id DESC limit 1) AS last_login,"
            . " (SELECT count(*) FROM login_statistics k WHERE k.user_id=l.user_id AND date(k.login_time)>'".$thirty."') AS thirty,(SELECT count(*) FROM login_statistics n WHERE"
            . " n.user_id=l.user_id AND date(n.login_time)>'".$sixty."') AS sixty FROM login_statistics l INNER JOIN adword_user a ON l.user_id=a.ad_user_id"
            . " GROUP BY l.user_id ORDER by thirty  ASC ";
		
//    echo $sql;
    return  $this->getResults($sql);
	
	}
        
        function prepare_dates($flag=0)
        {
            $today = date('Y-m-d');
            $thirty = date('Y-m-d',strtotime("-3 months", strtotime($today)));
            $sixty = date('Y-m-d',strtotime("-6 months", strtotime($today)));
            return $flag==1? $thirty:$sixty;
            
        }
        
        function user_statistics($user)
        {
            $sql = "SELECT * FROM login_statistics l INNER JOIN adword_user a ON l.user_id=a.ad_user_id WHERE l.user_id=".$user." ORDER BY id DESC ";
            return  $this->getResults($sql);
        }
    
	
	

}
