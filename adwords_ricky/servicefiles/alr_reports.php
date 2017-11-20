<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once dirname(__FILE__) . '/../includes/includes.php';

$type = $main->FormatString($_POST['alr_type'], 1);

$error = array();


$alr_result = $_SESSION['alr_result'];


$sql = "SELECT DISTINCT(ad_Labels) labels FROM adword_ad_reports WHERE ad_Date='".date('Y-m-d',strtotime("-1 day"))."' AND AND ad_account_id = '".$id."'";

$result =  $main -> getResults($sql,'ARRAY_A');


$labels=array();

foreach($result as $key => $val){
    
    $labels[] = $val['labels'];
}


foreach($deviceResults as $key => $value){   

    if(in_array($value->ad_Labels, $labels) || $type == 1){

$str .="<tr>
	<td style='width:16%; text-align:left;'>" . $value->ad_Labels . "</td>
	<td style='width:10%'>" . $value->clicks . "</td>
	<td style='width:10%'>" . $value->impressions . "</td>
	<td style='width:7%'>" . $value->ctr . "</td>
	<td style='width:10%'>" . $value->ad_avgCpc . "</td>
	<td style='width:7%'>" . $value->cost . "</td>
	<td style='width:10%'>" . $value->convrns . "</td>
	<td style='width:10%'>" . $value->ad_CostPerConversion . "</td>
	<td style='width:10%'>" . $value->ad_CstPConvR . "</td>
	<td style='width:10%'>" . $value->convrate . "</td>
</tr>";

    }
}

echo $str ;