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
class dangerList extends Main {

	function dangerDetails($start,$end,$first,$last,$type){//$type=1, yearly
    $sql = "SELECT account_name,account_id,(SELECT SUM(a.conversions) FROM adwords_danger_list a WHERE a.dated>'".date('Y-m-d',
                                        strtotime($first))."' AND"
            . " a.dated<'".date('Y-m-d',strtotime($last))."' AND a.account_id=z.account_id) AS conversion_last, (SELECT SUM(b.conversions) FROM adwords_danger_list b WHERE"
            . " b.dated>'".date('Y-m-d',strtotime($start))."' AND b.dated<'".date('Y-m-d',strtotime($end))."' AND b.account_id=z.account_id) AS conversion_now,(SELECT SUM(c.cost/c.conversions)/1000000 FROM"
            . " adwords_danger_list c WHERE c.dated>'".date('Y-m-d',strtotime($first))."' AND c.dated<'".date('Y-m-d',strtotime($last))."' AND c.account_id=z.account_id ) AS CPA_last,(SELECT SUM(d.cost/d.conversions)/1000000 FROM"
            . " adwords_danger_list d WHERE d.dated>'".date('Y-m-d',strtotime($start))."' AND d.dated<'".date('Y-m-d',strtotime($end))."' AND d.account_id=z.account_id ) AS CPA FROM `adwords_danger_list` z group by z.account_id ";
		return  $this->getResults($sql);
	
	}
        function change_percent($max,$min)
        {
            return number_format((($max-$min)/$min*100),2);
        }
        function monthly_header($int)
        {
            $today = date('d-m-Y');
            $day = date('d');
            
            if($int==1)//year
            {
                if($day<10)
                {
                    date("Y-n-j", strtotime("first day of previous month"));
                    date("Y-n-j", strtotime("last day of previous month"));
                    
                    return 'Comparison Date Range: Jan 1, 2016 - Sep 10, 2016 vs Jan 1, 2015 - Sep 10, 2015';
                }
            }
            
            if($int==0)//month
            {
                
            }
        }
        function report_date($flag,$slag=false)
        {
            //monthly
            $startday1 = date('M 1, Y');
            $startday0 = date('M d, Y', strtotime("first day of previous month"));
            
            if(date('d')<9)
            {
                $startday1 = $startday0;
                $startday0 = date('M d,Y',strtotime("-1 month", strtotime($startday0)));
                
//                 $endday1 = date('M d,Y', strtotime("last day of previous month"));
//                $endday0 = date('M d,Y', strtotime("-1 month", strtotime($endday1)));
                $endday1 = date('M d, Y',strtotime("last day of this month", strtotime($startday1)));
                $endday0 = date('M d, Y',strtotime("last day of this month", strtotime($startday0)));
               
            }
            
            if(date('d')<19 && date('d')>9)
            {
                $endday1 = date('M d,Y', strtotime("+9 days", strtotime($startday1)));
                $endday0 = date('M d,Y', strtotime("+9 days", strtotime($startday0)));
            }
            if(date('d')<date('t') && date('d')>19)
            {
                $endday1 = date('M d,Y', strtotime("+19 days", strtotime($startday1)));
                $endday0 = date('M d,Y', strtotime("+19 days", strtotime($startday0)));
            }
            if(date('d')==date('t'))
            {
                $endday1 = date('M t,Y');
                $endday0 = date('M t,Y', strtotime("-1 month", strtotime($endday1)));
            }
            
            
            $month_no = date('m');
            $startday01 = date('M d, Y', strtotime("-".($month_no-1)." month", strtotime(date('M 1,Y'))));
            $startday00 = date('M d, Y', strtotime("-1 year", strtotime($startday01)));
//            $endday01   = date('M d, Y', strtotime("-1 year", strtotime($endday1)));
            $endday01   = $endday1;
            $endday00   = date('M d, Y', strtotime("-1 year", strtotime($endday01)));
            
            
            if($flag==1 && !$slag)
            {
                echo 'Comparison Date Range: <b>'.$startday1.' - '.$endday1.' vs '.$startday0.' - '.$endday0.'</b>';
            }
            if($flag==0 && !$slag)
            {
                echo 'Comparison Date Range: <b>'.$startday01.' - '.$endday01.' vs '.$startday00.' - '.$endday00.'</b>';
            }
            if($flag==100 && !$slag)
            {
                return array($startday1,$endday1,$startday0,$endday0);
            }
            if($flag==100 && $slag)
            {
                return array($startday01,$endday01,$startday00,$endday00);
            }
//            echo "<br/>".$startday1."|".$endday1."|".$startday0."|".$endday0;
//            echo "<br/>".$startday01."|".$endday01."|".$startday00."|".$endday00;
//            echo "<br/>".date('M d, Y',strtotime("last day of this month", strtotime($startday0)));
        }
	
	
	

}
