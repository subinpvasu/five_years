<?php
try{
require_once dirname(__FILE__) . '/../includes/includes.php';
require_once("includes/dompdf-master/dompdf_config.inc.php");

// We check wether the user is accessing the demo locally
/* $local = array("::1", "127.0.0.1");
$is_local = in_array($_SERVER['REMOTE_ADDR'], $local); */



if ( isset( $_SESSION['html'] )) {

	$html = $_SESSION['html'] ;
	
	
	$file = str_ireplace(' ','',$_SESSION['ad_account_name']) ;
	
	$file = $file."_".$_SESSION['ad_account_adword_id']."_".$_SESSION['monthTxt'].".pdf" ;
	

  if ( get_magic_quotes_gpc() )
    $html = stripslashes($html);
  
  $dompdf = new DOMPDF();
  $dompdf->set_option('enable_remote', TRUE);
  $dompdf->load_html($html);
  $dompdf->set_paper('a4','landscape');
  $dompdf->render();

  $dompdf->stream($file, array("Attachment" => true));

  exit(0);
}
else{
	echo "ADASDASD";
}

}
catch(Exception $e){
	
	echo $e->getCode() .":::::" .$e->getMessage();
	
}
?>