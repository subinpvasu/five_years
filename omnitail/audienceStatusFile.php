<?php
/**
 * This file will make the status output file
 */


try{
    include_once './Classes/AppConstants.php';
    include_once './Classes/HelperMethods.php';
    include_once './Classes/DatabaseHelper.php';
    require_once './Classes/PHPExcel/IOFactory.php';
    ini_set("memory_limit", "1024M");
//    PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
    $objDb = new DbHelper();
    $accountId = isset($_REQUEST['account'])?$_REQUEST['account']:'';
    $record_details = $objDb->getRecordByUserId($accountId,3);
    if(is_array($record_details) && !empty($record_details)){
        $record_id = $record_details['id'];
        $fileNameArray = explode('/', $record_details['upload_name']);
        $uploadedFileName =  dirname(__FILE__)."/uploads/".$fileNameArray[count($fileNameArray)-1];
//        $objPHPExcel = PHPExcel_IOFactory::load($uploadedFileName);
        $objPHPExcel= new PHPExcel();
        $rows = $objDb->selectAudiences($record_id);
        if(count($rows)>0){
            foreach ($rows as $key => $row){
                
                $position = $key + 2 ;
                
                //$audience = $row['audienceid']." ".$row['audience_name'].":".$row['bid_adjust']."-".$row['targeting_setting']; 
                
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$position, $row['campaignid']);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$position, $row['campaign_name']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$position, $row['adgroupid']);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$position, $row['adgroup_name']);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$position, $row['audienceid']);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$position, $row['audience_name']);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$position, $row['bid_adjust']);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$position, $row['targeting_setting']);
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$position, $row['status']);
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$position, $row['message']);
                
            }
            $objPHPExcel->getActiveSheet()->setCellValue('A1', AppConstants::$CAMPAIGN_ID);
            $objPHPExcel->getActiveSheet()->setCellValue('B1', AppConstants::$CAMPAIGN_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue('C1', AppConstants::$ADGROUP_ID);
            $objPHPExcel->getActiveSheet()->setCellValue('D1', AppConstants::$ADGROUP_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue('E1', AppConstants::$AUDIENCE_ID);
            $objPHPExcel->getActiveSheet()->setCellValue('F1', AppConstants::$AUDIENCE_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue('G1', AppConstants::$BID_ADJUST);
            $objPHPExcel->getActiveSheet()->setCellValue('H1', AppConstants::$TARGET_SETTING);
            $objPHPExcel->getActiveSheet()->setCellValue('I1', AppConstants::$STATUS_NAME);
            $type = PHPExcel_IOFactory::identify($uploadedFileName);
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,$type);
            $optNameArray = explode('.', $uploadedFileName);
            $newName = 'Audience_status_'.$accountId.'_'.time().'.'.$optNameArray[1];
            $objWriter->save($newName);

            header("Content-Disposition: attachment; filename=\"".$newName. "\"");
            header("Content-Type: application/force-download");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
            header("Content-Length: " . filesize($newName));
            header("Connection: close");
            header('Pragma: no-cache');
            readfile($newName);
        }else{
            echo '<h1>Not found</h1>';
        }
    }else{
        echo '<h1>Record not found</h1>';
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}
