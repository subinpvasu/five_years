<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function pdf_create($html, $filename='outstanding_balance', $stream=TRUE) 
{
    require_once("dompdf/dompdf_config.inc.php");

    $dompdf = new DOMPDF();
    
    $dompdf->load_html($html);
    $dompdf->render();
   // $dompdf->stream("outstanding_balance.pdf", array("Attachment" => 0));
     if ($stream) {
        $dompdf->stream($filename.".pdf");
    } else {
        return $dompdf->output();
    }
}
?>