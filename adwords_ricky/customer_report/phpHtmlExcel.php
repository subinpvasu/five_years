<?php
/*

*
* Download file for customer report
*

*/

require_once dirname(__FILE__) . '/../includes/includes.php';
require_once dirname(__FILE__) . '/includes/PHPExcel/PHPExcel.php';
//$_SESSION['ad_account_name'] = "Deepa Varma";
//$_SESSION['monthTxt'] = "April-2015";
$color_1="434343";
$color_2="FFFFFF";
$color_3="DDDDDD";
$color_4="EAEAEA";
$color_5="FF0000";
$color_6="00FFFF";

$fileName=str_ireplace(" ","_",$_SESSION['ad_account_name'])."_PPC_PUSH_REPORT_".$_SESSION['monthTxt'].".xls";

$thismonth = $_SESSION['thismonth'];
$lastmonth = $_SESSION['lastmonth'];

try{

$objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('0')->setWidth(15);

$objPHPExcel->getProperties()->setCreator("PUSH GROUP")
							 ->setTitle($_SESSION['ad_account_name']." ".PPC_PUSH_REPORT." ".$_SESSION['monthTxt'] )
							 ->setSubject("PPC PUSH REPORT");
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:B1')
                                    ->setCellValue('A1', $_SESSION['ad_account_name'])
									->mergeCells('C1:D1')
									->setCellValue('C1', $_SESSION['monthTxt']." ".PPC_PUSH_REPORT)
									->mergeCells('E1:J1')
									->setCellValue('E1', "Generated from Push™ Analyser");
$array_a = array();
$array_a[] = 'A1:E1';

									
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', CONVERSIONS_FULL )
									->setCellValue('B3', $thismonth )
									->setCellValue('C3', $lastmonth )									
									->setCellValue('E3', "Conversion Data")
									->setCellValue('F3', $thismonth)
									->setCellValue('G3', $lastmonth)									
									->setCellValue('I3', $thismonth)
									->setCellValue('J3', $lastmonth);	
									
cellColor('A3:J3', $color_6);


$type= $_SESSION['type'];
$mntConv= $_SESSION['mntConv'];
$lmntConv= $_SESSION['lmntConv'];
$mntData= $_SESSION['mntData'];
$lmntData= $_SESSION['lmntData'];


for($i=0; $i< count($type); $i++ ){

	$cel = $i+5;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$cel,$type[$i]);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$cel,$mntConv[$type[$i]]);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$cel,$lmntConv[$type[$i]]);

}


$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E5', "Conv")
									->setCellValue('F5', $mntData->ad_Conversions)
									->setCellValue('G5', $lmntData->ad_Conversions)									
									->setCellValue('H5', "Spent")									
									->setCellValue('I5', $_SESSION['ad_account_currencyCode'].$mntData->ad_Cost)
									->setCellValue('J5', $_SESSION['ad_account_currencyCode'].$lmntData->ad_Cost);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E6', "Conv Value")
									->setCellValue('F6', $mntData->ad_ConversionValue)
									->setCellValue('G6', $lmntData->ad_ConversionValue)									
									->setCellValue('H6', "CPC")									
									->setCellValue('I6', $_SESSION['ad_account_currencyCode'].$mntData->ad_AverageCpc)
									->setCellValue('J6', $_SESSION['ad_account_currencyCode'].$lmntData->ad_AverageCpc);									
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E7', "Cost / Conv (".$_SESSION['ad_account_currencyCode'].")")
									->setCellValue('F7', $_SESSION['ad_account_currencyCode'].$mntData->ad_CostPerConversion)
									->setCellValue('G7', $_SESSION['ad_account_currencyCode'].$lmntData->ad_CostPerConversion)									
									->setCellValue('H7', "Clicks")									
									->setCellValue('I7', number_format($mntData->ad_Clicks))
									->setCellValue('J7', number_format($lmntData->ad_Clicks));									
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E8', "Estimated Conv")
									->setCellValue('F8', $mntData->ad_EstimatedTotalConversions)
									->setCellValue('G8', $lmntData->ad_EstimatedTotalConversions)							
									->setCellValue('H8', "Conv Rate(%)")									
									->setCellValue('I8', $mntData->ad_ConversionRate."%")
									->setCellValue('J8', $lmntData->ad_ConversionRate."%");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E8', "Cost / Estimated Conv (".$_SESSION['ad_account_currencyCode'].")")
									->setCellValue('F8', $_SESSION['ad_account_currencyCode'].$mntData->ad_CostPerEstConv)
									->setCellValue('G8', $_SESSION['ad_account_currencyCode'].$lmntData->ad_CostPerEstConv)							
									->setCellValue('H8', "Impressions")									
									->setCellValue('I8', number_format($mntData->ad_Impressions))
									->setCellValue('J8', number_format($lmntData->ad_Impressions));									
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H9', "CTR")									
									->setCellValue('I9', $mntData->ad_Ctr."%")
									->setCellValue('J9', $lmntData->ad_Ctr."%");									

								

$cellno = 9;
if($cel>$cellno){ $cellno = $cel;}
cellColor('A5:J'.$cellno, $color_3);

cellBorder('A1:J'.$cellno,"000000");

$nextcel =$cellno +2 ;

$a_wrap = array();
/*******
AD LABEL REPORT
*******/
$one = $nextcel;
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$nextcel.':B'.$nextcel)
									->setCellValue('A'.$nextcel, "Ad Label Report")
									->mergeCells('C'.$nextcel.':J'.$nextcel)
									->setCellValue('C'.$nextcel, "Using labels is the best way to monitor ad copy tests and see what ads are working best. We use these to continually optimise top ads and straplines and display the results in a quick and easy fashion across the entire account.");
$objPHPExcel->getActiveSheet()->getRowDimension($nextcel)->setRowHeight(50);
cellColor('A'.$nextcel.':J'.$nextcel, $color_6);
$nextcel++;
$nextcel++;

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$nextcel.':B'.$nextcel)
									->setCellValue('A'.$nextcel, "Report Notes By Account Manager")
									->mergeCells('C'.$nextcel.':J'.$nextcel)
									->setCellValue('C'.$nextcel, " ");
$array_a[] = 'A'.$nextcel.':J'.$nextcel;
$nextcel++;
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$nextcel.':J'.$nextcel);														
$array_a[] = 'A'.$nextcel.':J'.$nextcel;

$nextcel++;	
$nextcel++;								

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel, LABEL)
									->setCellValue('B'.$nextcel, CLICKS)
									->setCellValue('C'.$nextcel, IMPRESSIONS)									
									->setCellValue('D'.$nextcel, CTR_PERCENTAGE)									
									->setCellValue('E'.$nextcel, AVERAGE_CPC)
									->setCellValue('F'.$nextcel, "Cost(".$_SESSION['ad_account_currencyCode'].")")
									->setCellValue('G'.$nextcel, CONVERSIONS)									
									->setCellValue('H'.$nextcel, "Cost / Conv (".$_SESSION['ad_account_currencyCode'].")" )									
									->setCellValue('I'.$nextcel, "Cost / Conv Rate (".$_SESSION['ad_account_currencyCode'].")" )
									->setCellValue('J'.$nextcel, CONVERSION_RATE_PERCENTAGE);	
									
cellColor('A'.$nextcel.':J'.$nextcel, $color_4);



foreach($_SESSION['adlabel_results'] as $value){

	$nextcel++;	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel, $value->ad_Labels)
									->setCellValue('B'.$nextcel, $value->ad_clicks)
									->setCellValue('C'.$nextcel, $value->ad_impressions)									
									->setCellValue('D'.$nextcel, $value->ad_ctr)									
									->setCellValue('E'.$nextcel, $value->ad_avgCpc)
									->setCellValue('F'.$nextcel, $value->ad_cost)
									->setCellValue('G'.$nextcel, $value->ad_convrns)									
									->setCellValue('H'.$nextcel, $value->ad_CostPerConversion )								
									->setCellValue('I'.$nextcel, $value->ad_CstPConvR )
									->setCellValue('J'.$nextcel, $value->ad_convrate);	

	
	
}
cellBorder('A'.$one.':J'.$nextcel,"000000");
									
$nextcel++;									
$nextcel++;									


/*******
DEVICE REPORT
*******/
$one = $nextcel;
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$nextcel.':B'.$nextcel)
									->setCellValue('A'.$nextcel, "Device Performance Report")
									->mergeCells('C'.$nextcel.':J'.$nextcel)
									->setCellValue('C'.$nextcel, "Mobile and Tablet useage is changing everyday. See how clicks, conversions and cost per conversion have changed over the past 30 days compared to 90 days and whole year. Mobile useage could be up to 30% before the year end.");
cellColor('A'.$nextcel.':J'.$nextcel, $color_6);
$objPHPExcel->getActiveSheet()->getRowDimension($nextcel)->setRowHeight(50);
$nextcel++;
$nextcel++;

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$nextcel.':B'.$nextcel)
									->setCellValue('A'.$nextcel, "Report Notes By Account Manager")
									->mergeCells('C'.$nextcel.':J'.$nextcel)
									->setCellValue('C'.$nextcel, " ");
$array_a[] = 'A'.$nextcel.':J'.$nextcel;
$nextcel++;
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$nextcel.':J'.$nextcel);														
$array_a[] = 'A'.$nextcel.':J'.$nextcel;
	

$nextcel++;	
$nextcel++;								

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel, DEVICE)
									->setCellValue('B'.$nextcel, IMPRESSIONS)
									->setCellValue('C'.$nextcel, CLICKS)									
									->setCellValue('D'.$nextcel, CTR_PERCENTAGE)									
									->setCellValue('E'.$nextcel, "Cost(".$_SESSION['ad_account_currencyCode'].")")
									->setCellValue('F'.$nextcel, "Cost / Click (".$_SESSION['ad_account_currencyCode'].")")
									->setCellValue('G'.$nextcel, CONVERSIONS)									
									->setCellValue('H'.$nextcel, CONVERSION_RATE_PERCENTAGE )									
									->setCellValue('I'.$nextcel, "Cost / Conv (".$_SESSION['ad_account_currencyCode'].")" )
									->setCellValue('J'.$nextcel, AVERAGE_POSITION);	
									
cellColor('A'.$nextcel.':J'.$nextcel, $color_4);

$results = $_SESSION['device_reports'] ;

foreach($_SESSION['device_reports'] as $value){

	$nextcel++;	
	$perc = round(($value -> ad_Conversions / $_SESSION['device_total_sales'])*100,2) ;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel, $value->ad_Device)
									->setCellValue('B'.$nextcel, $value->ad_Impressions)
									->setCellValue('C'.$nextcel, $value->ad_Clicks)									
									->setCellValue('D'.$nextcel, $value->ad_Ctr)									
									->setCellValue('E'.$nextcel, $value->ad_Cost)
									->setCellValue('F'.$nextcel, $value->ad_CostPerClick)
									->setCellValue('G'.$nextcel, $value->ad_Conversions."(".$perc."% )")									
									->setCellValue('H'.$nextcel, $value->ad_ConversionRate )								
									->setCellValue('I'.$nextcel, $value->ad_CostPerConversion )
									->setCellValue('J'.$nextcel, $value->ad_AveragePosition);	
	
}	
		
$nextcel++;	

$device_total = $_SESSION['device_total'];
 
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel, TOTAL)
									->setCellValue('B'.$nextcel, $device_total[0])
									->setCellValue('C'.$nextcel, $device_total[1])									
									->setCellValue('D'.$nextcel, $device_total[2])	
									->setCellValue('E'.$nextcel, $device_total[3])
									->setCellValue('F'.$nextcel, $device_total[4])
									->setCellValue('G'.$nextcel, $device_total[5])									
									->setCellValue('H'.$nextcel, $device_total[6])
									->setCellValue('I'.$nextcel, $device_total[7])
									->setCellValue('J'.$nextcel, $device_total[8]);	
$objPHPExcel->getActiveSheet()->getStyle('A'.$nextcel)->applyFromArray(array('font'  => array('bold'  => true )));									
cellBorder('A'.$one.':J'.$nextcel,"000000");
									
$nextcel++;									
$nextcel++;									

/*******
WASTAGE ANALYSIS
*******/
$one = $nextcel;
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$nextcel.':B'.$nextcel)
									->setCellValue('A'.$nextcel, "Wastage Analysis")
									->mergeCells('C'.$nextcel.':J'.$nextcel)
									->setCellValue('C'.$nextcel, "The column called query is the actual keyword and this is not in the account as a keywords or negative. By eliminating those consistently coming through and not leading to conversions or assisted conversions we can drive down the CPA and focus budget on what is working.");
									$objPHPExcel->getActiveSheet()->getRowDimension($nextcel)->setRowHeight(50);
cellColor('A'.$nextcel.':J'.$nextcel, $color_6);
$nextcel++;
$nextcel++;

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$nextcel.':B'.$nextcel)
									->setCellValue('A'.$nextcel, "Report Notes By Account Manager")
									->mergeCells('C'.$nextcel.':J'.$nextcel)
									->setCellValue('C'.$nextcel, " ");
$array_a[] = 'A'.$nextcel.':J'.$nextcel;
$nextcel++;
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$nextcel.':J'.$nextcel);														
$array_a[] = 'A'.$nextcel.':J'.$nextcel;

$nextcel++;	
$nextcel++;								

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel, SEARCH_QUERY)
									->setCellValue('B'.$nextcel, CAMPAIGN_NAME)
									->setCellValue('C'.$nextcel, KEYWORD_TEXT)									
									->setCellValue('D'.$nextcel, MATCH_TYPE)									
									->setCellValue('E'.$nextcel, CLICKS)
									->setCellValue('F'.$nextcel, CONVERSIONS)
									->setCellValue('G'.$nextcel, "Cost (".$_SESSION['ad_account_currencyCode'].")")									
									->setCellValue('H'.$nextcel, "Cost / Conv (".$_SESSION['ad_account_currencyCode'].")" )									
									->setCellValue('I'.$nextcel, IMPRESSIONS )
									->setCellValue('J'.$nextcel, AVERAGE_POSITION);	
									
cellColor('A'.$nextcel.':J'.$nextcel, $color_4);



foreach($_SESSION['wastage_analysis'] as $value){

	$nextcel++;	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel, $value->ad_Query)
									->setCellValue('B'.$nextcel, $value->ad_CampaignName)
									->setCellValue('C'.$nextcel, $value->ad_KeywordTextMatchingQuery)									
									->setCellValue('D'.$nextcel, $value->ad_MatchType)									
									->setCellValue('E'.$nextcel, $value->ad_Clicks)
									->setCellValue('F'.$nextcel, $value->ad_Conversions)
									->setCellValue('G'.$nextcel, $value->ad_Cost /1000000)									
									->setCellValue('H'.$nextcel, $value->ad_CostPerConversion  /1000000)						
									->setCellValue('I'.$nextcel, $value->ad_Impressions )
									->setCellValue('J'.$nextcel, $value->ad_AveragePosition);	
}

	cellBorder('A'.$one.':J'.$nextcel,"000000");	
		
$nextcel++;	

$nextcel++;

	

/*******
KEYWORD DISCOVERY
*******/
$one = $nextcel;
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$nextcel.':B'.$nextcel)
									->setCellValue('A'.$nextcel, "Keyword Discovery")
									->mergeCells('C'.$nextcel.':J'.$nextcel)
									->setCellValue('C'.$nextcel, "The column called query is the actual keyword and this is not in the account as a keyword, coming through a phrase or broad match. By adding these and giving them their own ads and bids we can really focus on improving the CTR and generating more leads/sales.");
cellColor('A'.$nextcel.':J'.$nextcel, $color_6);
$objPHPExcel->getActiveSheet()->getRowDimension($nextcel)->setRowHeight(50);
$nextcel++;
$nextcel++;

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$nextcel.':B'.$nextcel)
									->setCellValue('A'.$nextcel, "Report Notes By Account Manager")
									->mergeCells('C'.$nextcel.':J'.$nextcel)
									->setCellValue('C'.$nextcel, " ");
$array_a[] = 'A'.$nextcel.':J'.$nextcel;
$nextcel++;
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$nextcel.':J'.$nextcel);												
$array_a[] = 'A'.$nextcel.':J'.$nextcel;
$nextcel++;	
$nextcel++;								

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel, SEARCH_QUERY)
									->setCellValue('B'.$nextcel, CAMPAIGN_NAME)
									->setCellValue('C'.$nextcel, KEYWORD_TEXT)									
									->setCellValue('D'.$nextcel, MATCH_TYPE)
									->setCellValue('E'.$nextcel, DEVICE)									
									->setCellValue('F'.$nextcel, CLICKS)
									->setCellValue('G'.$nextcel, CONVERSIONS)
									->setCellValue('H'.$nextcel, "Cost (".$_SESSION['ad_account_currencyCode'].")")									
									->setCellValue('I'.$nextcel, "Cost / Conv (".$_SESSION['ad_account_currencyCode'].")" )									
									->setCellValue('J'.$nextcel, IMPRESSIONS );
									
									
cellColor('A'.$nextcel.':J'.$nextcel, $color_4);



foreach($_SESSION['keyword_discovery'] as $value){

	$nextcel++;	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel, $value->ad_Query)
									->setCellValue('B'.$nextcel, $value->ad_CampaignName)
									->setCellValue('C'.$nextcel, $value->ad_KeywordTextMatchingQuery)									
									->setCellValue('D'.$nextcel, $value->ad_MatchType)									
									->setCellValue('E'.$nextcel, $value->ad_Device)									
									->setCellValue('F'.$nextcel, $value->ad_Clicks)
									->setCellValue('G'.$nextcel, $value->ad_Conversions)
									->setCellValue('H'.$nextcel, $value->ad_Cost /1000000)									
									->setCellValue('I'.$nextcel, $value->ad_CostPerConversion  /1000000)				
									->setCellValue('J'.$nextcel, $value->ad_Impressions );
									
}
cellBorder('A'.$one.':J'.$nextcel,"000000");		
$nextcel++;	

$nextcel++;									

/*******
Conversion Booster Report
*******/

$one = $nextcel;
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$nextcel.':B'.$nextcel)
									->setCellValue('A'.$nextcel, "Conversion Booster Reports")
									->mergeCells('C'.$nextcel.':O'.$nextcel)
									->setCellValue('C'.$nextcel, "These keywords are converting and a higher CTR will lead to more conversions. Focus on keywords with higher conversions and lower Cost per conversion.");
$objPHPExcel->getActiveSheet()->getRowDimension($nextcel)->setRowHeight(50);
cellColor('A'.$nextcel.':J'.$nextcel, $color_6);
$nextcel++;
$nextcel++;

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$nextcel.':B'.$nextcel)
									->setCellValue('A'.$nextcel, "Report Notes By Account Manager")
									->mergeCells('C'.$nextcel.':O'.$nextcel)
									->setCellValue('C'.$nextcel, " ");
$array_a[] = 'A'.$nextcel.':O'.$nextcel;
$nextcel++;
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$nextcel.':O'.$nextcel);												
$array_a[] = 'A'.$nextcel.':O'.$nextcel;
$nextcel++;	
$nextcel++;										
									
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel, 'Campain Name')
									->setCellValue('B'.$nextcel, 'Adgroup Name')
									->setCellValue('C'.$nextcel, KEYWORD_TEXT)									
									->setCellValue('D'.$nextcel, MATCH_TYPE)									
									->setCellValue('E'.$nextcel, STATUS)
									->setCellValue('F'.$nextcel, QUALITY_SCORE)
									->setCellValue('G'.$nextcel, CLICKS)									
									->setCellValue('H'.$nextcel, IMPRESSIONS )									
									->setCellValue('I'.$nextcel, "Cost (".$_SESSION['ad_account_currencyCode'].")" )
									->setCellValue('J'.$nextcel, CONVERSIONS )
									->setCellValue('K'.$nextcel, CONVERSION_RATE_PERCENTAGE )
									->setCellValue('L'.$nextcel, "Cost / Conv (".$_SESSION['ad_account_currencyCode'].")" )
									->setCellValue('M'.$nextcel, CTR_PERCENTAGE )
									->setCellValue('N'.$nextcel, AVERAGE_POSITION )
									->setCellValue('O'.$nextcel, TOP_PAGE_OF_CPC );
$redrow = $nextcel ;
									
cellColor('A'.$nextcel.':O'.$nextcel, $color_4);

foreach($_SESSION['cbr_reports'] as $value){
	$ad_TopOfPageCpc = round($result -> ad_TopOfPageCpc /1000000 , 2);
	$nextcel++;	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nextcel, $value->ad_CampaignName )
									->setCellValue('B'.$nextcel, $value->ad_AdGroupName )
									->setCellValue('C'.$nextcel, $value->ad_KeywordText )									
									->setCellValue('D'.$nextcel, $value->ad_KeywordMatchType )								
									->setCellValue('E'.$nextcel, $value->ad_keyword_adword_status )
									->setCellValue('F'.$nextcel, $value->ad_QualityScore )
									->setCellValue('G'.$nextcel, $value->ad_Clicks )									
									->setCellValue('H'.$nextcel, $value->ad_Impressions )				
									->setCellValue('I'.$nextcel, $value->ad_Cost )
									->setCellValue('J'.$nextcel, $value->ad_Conversions )
									->setCellValue('K'.$nextcel, $value->ad_ConversionRate )
									->setCellValue('L'.$nextcel, $value->ad_CostPerConversion )
									->setCellValue('M'.$nextcel, $value->ad_Ctr )
									->setCellValue('N'.$nextcel, $value->ad_AveragePosition )
									->setCellValue('O'.$nextcel, $ad_TopOfPageCpc );
									
}
	cellBorder('A'.$one.':O'.$nextcel,"000000");	
$nextcel++;	
$nextcel++;	
/********
DAILY HOURLY REPORT
*********/

$reportDetails = $reports -> getReportDetails("DAILY & HOURLY REPORT");

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$nextcel.':B'.$nextcel)
									->setCellValue('A'.$nextcel, "Daily & Hourly Report")
									->mergeCells('C'.$nextcel.':J'.$nextcel)
									->setCellValue('C'.$nextcel, $reportDetails[0]->ad_report_type_left );
cellColor('A'.$nextcel.':J'.$nextcel, $color_6);
$nextcel++;
$nextcel++;

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$nextcel.':B'.$nextcel)
									->setCellValue('A'.$nextcel, "Report Notes By Account Manager")
									->mergeCells('C'.$nextcel.':J'.$nextcel)
									->setCellValue('C'.$nextcel, " ");
$array_a[] = 'A'.$nextcel.':J'.$nextcel;
$nextcel++;
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$nextcel.':J'.$nextcel);														
$array_a[] = 'A'.$nextcel.':J'.$nextcel;

	
	$styleArray = array('font' =>
			array(
			'color' =>
			array('rgb' => '808080'),
			'bold' => false,
			'size'  => 12,
			'name'  => 'Times New Roman'
			),
			
			'alignment' => array(
			'wrap'       => true,
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			);
	
	$objPHPExcel->getActiveSheet()->getStyle('A1:O'.$nextcel)->applyFromArray($styleArray);
	unset($styleArray);
	
	$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
$nextcel++;	
$nextcel++;								
								
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$nextcel.':E'.$nextcel)
									->setCellValue('A'.$nextcel, "Avg. by Day of Week")
									->mergeCells('F'.$nextcel.':J'.$nextcel)
									->setCellValue('F'.$nextcel, "Total by Hour of Day");
									
$styleArray = array(
	
    'font'  => array(
        'bold'  => true,
       'color' => array('rgb' => '808080'),
        'size'  => 18,
        'name'  => 'Times New Roman'
    ));
	$objPHPExcel->getActiveSheet()->getStyle('A'.$nextcel)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('F'.$nextcel)->applyFromArray($styleArray);
	unset($styleArray);									
									
$nextcel++;	
$nextcel++;	
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$nextcel.':E'.$nextcel);									
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Daily Report');
$objDrawing->setDescription('Avg. by Day of Week');									
$objDrawing->setPath('img/'.$_SESSION['dailyFileName']);
$objDrawing->setCoordinates('A'.$nextcel);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.$nextcel.':J'.$nextcel);									
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Hourly Report');
$objDrawing->setDescription('Total by Hour of Day');									
$objDrawing->setPath('img/'.$_SESSION['hourlyFileName']);
$objDrawing->setCoordinates('F'.$nextcel);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
									
darkCells($array_a);
redRow($redrow);

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$fileName);
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
	
}
catch(Exception $e){

print_r($e);


}	


function cellColor($cells,$color){
    global $objPHPExcel;

    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
function cellBorder($cells,$color){
    global $objPHPExcel;

	$styleArray = array(
	'borders' => array(
		'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN,
	  'color' => array('argb' => $color)
		)
	)
	);
    $objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray($styleArray);
	unset($styleArray);
}
function cellFonts($cells,$color){
    global $objPHPExcel;

$styleArray = array(
    'font'  => array(
        
        'color' => array('rgb' => $color),
        //'size'  => 12,
        //'name'  => 'Verdana'
    ));
	$objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray($styleArray);
	unset($styleArray);
	
	}
function darkCells($array_a){

 global $objPHPExcel;
 
 $styleArray = array('font' =>
			array(
			'color' =>
			array('rgb' => 'FFFFFF'),
			'bold' => false,
			'size'  => 12,
			'name'  => 'Times New Roman'
			),
			
			'alignment' => array(
			'wrap'       => true,
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
		'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN,
	  'color' => array('rgb' => 'CCCCCC')
		)
	)
			);
			
	foreach($array_a as $cells){
	$objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray($styleArray);
	 $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => '434343'
        )
    ));
	}
	unset($styleArray); 
}

function redRow($row){

	global $objPHPExcel;
	
	$styleArray = array('font' =>
			array(
			'color' =>
			array('rgb' => 'FF0000'),
			)
			);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('E'.$row)->applyFromArray($styleArray);
unset($styleArray);
}
?>