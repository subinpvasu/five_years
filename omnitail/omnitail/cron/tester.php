<?php
error_reporting(0);
include_once '../../config/config.php';
$customer = 4329064370;
// $sql = "SELECT campaign_name,adgroup_name,bid,adgroupid FROM adgroup_data WHERE customerid=".$customer;
// $result = $conn->query($sql);
// $adgroup = array();
// while($row = $result->fetch_object())
// {
//     $adgroup_details[$row->adgroupid] = array('campaign_name'=>$row->campaign_name,'adgroup_name'=>$row->adgroup_name,'bid'=>$row->bid);
// }
$sql = "SELECT a.campaign_name, a.adgroup_name, c.crbid, c.crname,c.criterionid,a.adgroupid
FROM adgroup_data a
LEFT JOIN criterion_data c ON a.adgroupid = c.adgroupid
WHERE c.customerid=".$customer;
$result = $conn->query($sql);
$criterion_details = array();
while($row = $result->fetch_object())
{
    $criterion_details[$row->criterionid.'-'.$row->adgroupid] = array('campaign_name'=>$row->campaign_name,'adgroup_name'=>$row->adgroup_name,'crbid'=>$row->crbid,'crname'=>$row->crname,'crid'=>$row->criterionid);
}


echo 'Cmp Name : '.$criterion_details['83319832582-15602605331']['campaign_name'].'<pre>';
print_r($criterion_details);