<?php
require_once dirname(__FILE__) . '/includes/includes.php';
require_once dirname(__FILE__) . '/customer_report/includes/PHPExcel/PHPExcel.php';
try {

	logToFile("Test Report","START");
		
	$fileName="PPC_PUSH_REPORT_TEST_".date('d-m-Y').".xls";
	
	$objPHPExcel = new PHPExcel();

	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
	
	
	$objPHPExcel->getProperties()->setCreator("PUSH GROUP")
							 ->setTitle("PPC_PUSH_REPORT_TEST_".date('d-m-Y') )
							 ->setSubject("PPC PUSH REPORT TEST");
							 
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:B1')
                                    ->setCellValue('A1',"Report Download test report")
									->mergeCells('C1:D1')
									->setCellValue('C1', "Dated ".date('d-m-Y'))
									->mergeCells('E1:J1')
									->setCellValue('E1', "Generated from Push™ Analyser");
									
	$nextcel = 3 ;
	
	/* Account Report */
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel, 'Account Report' )
										->setCellValue('B'.$nextcel, $res_mcc_select->customerId )
										->setCellValue('C'.$nextcel, $dbName );
	$nextcel++;

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel,'ad_account_adword_id' )
										->setCellValue('B'.$nextcel, 'ad_month' )
										->setCellValue('C'.$nextcel, 'total' ) ;
	
	$nextcel++;
	
	$res1 = $main -> getResults("select count(ad_report_id) as total,ad_account_adword_id ,ad_month from adword_monthly_report
			
	where ad_month > '".date("Y-m",strtotime(date('Y-m')." -4 months"))."'
	
	group by ad_account_adword_id,ad_month");
	
	foreach($res1 as $r1){
	
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel, $r1->ad_account_adword_id )
					->setCellValue('B'.$nextcel, $r1->ad_month )
					->setCellValue('C'.$nextcel, $r1->total ) ;
		$nextcel++;
	}
	
	$nextcel++;
	
	/* Conversion type Report */
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel, 'Conversion type Report' )
										->setCellValue('B'.$nextcel, $res_mcc_select->customerId )
										->setCellValue('C'.$nextcel, $dbName );
	$nextcel++;

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel,'ad_account_adword_id' )
										->setCellValue('B'.$nextcel, 'ad_month' )
										->setCellValue('C'.$nextcel, 'total' ) ;
	
	$nextcel++;		
	$res1 = $main -> getResults("select count(ad_report_id) as total,ad_account_adword_id ,ad_month from  adword_convtype_report
			
	where ad_month > '".date("Y-m",strtotime(date('Y-m')." -4 months"))."'
	
	group by ad_account_adword_id,ad_month");
	
	foreach($res1 as $r1){
	
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel, $r1->ad_account_adword_id )
					->setCellValue('B'.$nextcel, $r1->ad_month )
					->setCellValue('C'.$nextcel, $r1->total ) ;
		$nextcel++;
	}
	
	$nextcel++;	
	
	
	/* Campaign Report */
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel, 'Campaign Report' )
										->setCellValue('B'.$nextcel, $res_mcc_select->customerId )
										->setCellValue('C'.$nextcel, $dbName );
	$nextcel++;

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel,'ad_account_id' )
										->setCellValue('B'.$nextcel, 'ad_Date' )
										->setCellValue('C'.$nextcel, 'total' ) ;
	
	$nextcel++;		
	
	$res1 = $main -> getResults("select count(ad_report_id) as total,ad_account_id ,ad_Date from adword_campaign_reports
			
	where ad_date between '".date("Y-m-d",strtotime(date('Y-m-d')." -10 days"))."' and '".date("Y-m-d")."'
	
	group by ad_account_id,ad_Date");
	
	foreach($res1 as $r1){
	
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel, $r1->ad_account_id )
					->setCellValue('B'.$nextcel, $r1->ad_Date )
					->setCellValue('C'.$nextcel, $r1->total ) ;
		$nextcel++;
	}
	
	$nextcel++;	
	
	/* Keyword Report */
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel, 'Keyword Report' )
										->setCellValue('B'.$nextcel, $res_mcc_select->customerId )
										->setCellValue('C'.$nextcel, $dbName );
	$nextcel++;

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel,'ad_account_id' )
										->setCellValue('B'.$nextcel, 'ad_Date' )
										->setCellValue('C'.$nextcel, 'total' ) ;
	
	$nextcel++;		
	
	$res1 = $main -> getResults("select count(ad_report_id) as total,ad_account_id ,ad_Date from adword_keyword_report1
			
	where ad_date between '".date("Y-m-d",strtotime(date('Y-m-d')." -10 days"))."' and '".date("Y-m-d")."'
	
	group by ad_account_id,ad_Date");
	
	foreach($res1 as $r1){
	
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel, $r1->ad_account_id )
					->setCellValue('B'.$nextcel, $r1->ad_Date )
					->setCellValue('C'.$nextcel, $r1->total ) ;
		$nextcel++;
	}
	
	$nextcel++;

	/* S Q Report */
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel, 'S Q Report' )
										->setCellValue('B'.$nextcel, $res_mcc_select->customerId )
										->setCellValue('C'.$nextcel, $dbName );
	$nextcel++;

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel,'ad_account_id' )
										->setCellValue('B'.$nextcel, 'ad_Date' )
										->setCellValue('C'.$nextcel, 'total' ) ;
	
	$nextcel++;		
	
	$res1 = $main -> getResults("select count(ad_report_id) as total,ad_account_id ,ad_Date from adword_search_query_reports
			
	where ad_date between '".date("Y-m-d",strtotime(date('Y-m-d')." -10 days"))."' and '".date("Y-m-d")."'
	
	group by ad_account_id,ad_Date");
	
	foreach($res1 as $r1){
	
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel, $r1->ad_account_id )
					->setCellValue('B'.$nextcel, $r1->ad_Date )
					->setCellValue('C'.$nextcel, $r1->total ) ;
		$nextcel++;
	}
	
	$nextcel++;	
	
	
	/* Ad Report */
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel, 'Keyword Report' )
										->setCellValue('B'.$nextcel, $res_mcc_select->customerId )
										->setCellValue('C'.$nextcel, $dbName );
	$nextcel++;

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel,'ad_account_id' )
										->setCellValue('B'.$nextcel, 'ad_Date' )
										->setCellValue('C'.$nextcel, 'total' ) ;
	
	$nextcel++;		
	
	$res1 = $main -> getResults("select count(ad_report_id) as total,ad_account_id ,ad_Date from adword_ad_reports
			
	where ad_date between '".date("Y-m-d",strtotime(date('Y-m-d')." -10 days"))."' and '".date("Y-m-d")."'
	
	group by ad_account_id,ad_Date");
	
	foreach($res1 as $r1){
	
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel, $r1->ad_account_id )
					->setCellValue('B'.$nextcel, $r1->ad_Date )
					->setCellValue('C'.$nextcel, $r1->total ) ;
		$nextcel++;
	}
	
	$nextcel++;	
	
	
	/* /* /* /* /* /* /*    */
	
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename='.$fileName);
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	
}
catch(Exception $e){

	logToFile("Test Reports","ERROR",$e->getCode(),$e->getMessage());

}

// function to write log
function logToFile($arg1="", $arg2="",$arg3="",$arg4="",$arg5="",$arg6=""){

	$time = date("Y-m-d H:i:s");
	
	$date = date("Y-m-d");
	
	$str = " $time \t $arg1 \t $arg2 \t $arg3 \t $arg4 \t  $arg5 \t $arg6 \t \n"; 
	
	error_log("$str\n", 3, 'logs/testReports'.$date.'.log'); 

}