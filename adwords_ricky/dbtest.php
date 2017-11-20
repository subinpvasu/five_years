<?php 


$connect = new mysqli('localhost','hostpush_adwords','pu5h%mur41i$','hostpush_adwords_ricky');

$select = $connect-> select_db('hostpush_adwords_ricky');

echo $select ; exit;

$connect-> query("INSERT INTO adword_entity_workflows (ad_account_id ,ad_download_status,updated_time,ad_mcc_id ) select ad_account_adword_id , 0, NOW(),'3410453340' from adword_accounts a left join adword_entity_workflows b on a.`ad_account_adword_id`=b.`ad_account_id` where a.`ad_mcc_id` = '3410453340' and a.ad_account_status = 1 and b.`ad_account_id` IS NULL ;");
		
exit;

?>