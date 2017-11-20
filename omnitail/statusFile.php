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
    $record_details = $objDb->getRecordByUserId($accountId,1);
    if(is_array($record_details) && !empty($record_details)){
        $record_id = $record_details['id'];
        $fileNameArray = explode('/', $record_details['upload_name']);
        $uploadedFileName =  dirname(__FILE__)."/uploads/".$fileNameArray[count($fileNameArray)-1];
//        $objPHPExcel = PHPExcel_IOFactory::load($uploadedFileName);
        $objPHPExcel= new PHPExcel();
        $rows = $objDb->getSheetRows($record_id);
        if(count($rows)>0){
            foreach ($rows as $row){
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row->position_no, $row->target);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row->position_no, $row->target_data);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row->position_no, $row->brand);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row->position_no, $row->clo);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row->position_no, $row->campaign_name);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$row->position_no, $row->ad_group_name);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row->position_no, $row->bid);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row->position_no, $row->priority);
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$row->position_no, $row->merchant_id);
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$row->position_no, $row->budget);
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$row->position_no, $row->label);
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$row->position_no, $row->country);
                $objPHPExcel->getActiveSheet()->setCellValue('M'.$row->position_no, $row->processed_status);
            }
            $objPHPExcel->getActiveSheet()->setCellValue('A1', AppConstants::$TARGET_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue('B1', AppConstants::$TARGET_DATA_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue('C1', AppConstants::$BRAND_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue('D1', AppConstants::$CLO_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue('E1', AppConstants::$CAMPAIGN_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue('F1', AppConstants::$ADGROUP_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue('G1', AppConstants::$BID_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue('H1', AppConstants::$PRIORITY_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue('I1', AppConstants::$MERCHANTID_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue('J1', AppConstants::$BUDGET_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue('K1', AppConstants::$LABEL_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue('L1', AppConstants::$COUNTRY_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue('M1', AppConstants::$STATUS_NAME);
            $type = PHPExcel_IOFactory::identify($uploadedFileName);
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,$type);
            $optNameArray = explode('.', $uploadedFileName);
            $newName = $optNameArray[0].'_opt.'.$optNameArray[1];
            $objWriter->save($newName);

            header("Content-Disposition: attachment; filename=\"output." . $optNameArray[1] . "\"");
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
