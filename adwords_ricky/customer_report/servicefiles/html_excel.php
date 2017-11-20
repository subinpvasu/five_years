<?php
/*

*
* Service file for putting html data to session to download
*

*/
require_once dirname(__FILE__) . '/../../includes/includes.php';
$img_folder = SITE_URL."customer_report/img/";

$html=$_REQUEST['html'];
$html1=$_REQUEST['html1'];

$graph1=trim($_REQUEST['graph1']);
if($graph1) {$graph1 = $img_folder."$graph1";
$html = str_ireplace($html1,'<img src="'.$graph1.'"/>',$html);}
$html2=$_REQUEST['html2'];
$graph2=trim($_REQUEST['graph2']);
if($graph2) {$graph2 = $img_folder."$graph2";
$html = str_ireplace($html2,'<img src="'.$graph2.'"/>',$html); }
$html3=$_REQUEST['html3'];
$graph3=trim($_REQUEST['graph3']);
if($graph3) {$graph3 = $img_folder."$graph3";
$html = str_ireplace($html3,'<img src="'.$graph3.'"/>',$html);}
$html4=$_REQUEST['html4'];
$graph4=trim($_REQUEST['graph4']);
if($graph4) {$graph4 = $img_folder."$graph4";
$html = str_ireplace($html4,'<img src="'.$graph4.'"/>',$html);}

$logo = SITE_IMAGES."push_logo.png";
$html = str_ireplace('<b style="page-break-after: always;"></b>','<b style="page-break-after: always;"></b><div class="logo_div"><img src="'.$logo.'"/></div>',$html);
$html = str_ireplace('<input type="checkbox" class="classcb" checked="checked" style="display: inline;"/>','',$html);



$_SESSION['html']=$html ;
echo 1;
?>