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
    $record_details = $objDb->getRecordByUserId($accountId,2);
    if(is_array($record_details) && !empty($record_details)){
        $record_id = $record_details['id'];
        $fileNameArray = explode('/', $record_details['upload_name']);
        $uploadedFileName =  dirname(__FILE__)."/uploads/".$fileNameArray[count($fileNameArray)-1];
//        $objPHPExcel = PHPExcel_IOFactory::load($uploadedFileName);
        $objPHPExcel= new PHPExcel();
        $rows = $objDb->selectAdSchedules($record_id);
        if(count($rows)>0){
            foreach ($rows as $key => $row){
                
                $position = $key + 2 ;
                
                $schedule = $row['day']." ".$row['startHour'].":".$row['startMin']."-".$row['endHour'].":".$row['endMin'] ; 
                
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$position, $row['campaign']);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$position, $row['campaignName']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$position, $schedule);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$position, $row['status']);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$position, $row['message']);
                
            }
            $objPHPExcel->getActiveSheet()->setCellValue('A1', AppConstants::$CAMPAIGN_ID);
            $objPHPExcel->getActiveSheet()->setCellValue('B1', AppConstants::$CAMPAIGN_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue('C1', AppConstants::$SCHEDULE_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue('D1', AppConstants::$STATUS_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue('E1', AppConstants::$ERROR_MESSAGE);
            $type = PHPExcel_IOFactory::identify($uploadedFileName);
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,$type);
            $optNameArray = explode('.', $uploadedFileName);
            $newName = 'AdSchedule_status_'.$accountId.'_'.time().'.'.$optNameArray[1];
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
