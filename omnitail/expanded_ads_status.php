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
    $record_details = $objDb->getRecordByUserId($accountId,4);
    if(is_array($record_details) && !empty($record_details)){
        $record_id = $record_details['id'];
        $fileNameArray = explode('/', $record_details['upload_name']);
        $uploadedFileName =  dirname(__FILE__)."/uploads/".$fileNameArray[count($fileNameArray)-1];
//        $objPHPExcel = PHPExcel_IOFactory::load($uploadedFileName);
        $objPHPExcel= new PHPExcel();
        $rows = $objDb->selectExpandedAds($record_id);
//         echo '<pre>';
//         print_r($rows);
//         exit();
        if(count($rows)>0){
            foreach ($rows as $key => $row){
                
                $position = $key + 2 ;
                
                //$audience = $row['audienceid']." ".$row['audience_name'].":".$row['bid_adjust']."-".$row['targeting_setting']; 
                
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$position, $row['headline1']);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$position, $row['headline2']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$position, $row['keyword1']);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$position, $row['keyword2']);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$position, $row['keyword3']);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$position, $row['keyword4']);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$position, $row['finalurl']);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$position, $row['description']);
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$position, $row['path1']);
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$position, $row['path2']);
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$position, $row['availability']);
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$position, $row['campaign_name']);
                $objPHPExcel->getActiveSheet()->setCellValue('M'.$position, $row['adgroup_name']);
                $objPHPExcel->getActiveSheet()->setCellValue('N'.$position, $row['bid']);
                $objPHPExcel->getActiveSheet()->setCellValue('O'.$position, $row['budget']);
                $objPHPExcel->getActiveSheet()->setCellValue('P'.$position, $row['status']);
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$position, $row['message']);
//                 echo $position.'<br/>';
                
            }
//             exit();
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Headline1');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Headline2');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Keyword1');
            $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Keyword2');
            $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Keyword3');
            $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Keyword4');
            $objPHPExcel->getActiveSheet()->setCellValue('G1', 'FinalUrl');
            $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Description');
            $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Path1');
            $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Path2');
            $objPHPExcel->getActiveSheet()->setCellValue('K1', 'Availability');
            $objPHPExcel->getActiveSheet()->setCellValue('L1', 'Campaign Name');
            $objPHPExcel->getActiveSheet()->setCellValue('M1', 'Adgroup Name');
            $objPHPExcel->getActiveSheet()->setCellValue('N1', 'Bid');
            $objPHPExcel->getActiveSheet()->setCellValue('O1', 'Budget');
            $objPHPExcel->getActiveSheet()->setCellValue('P1', 'Status');
            $objPHPExcel->getActiveSheet()->setCellValue('Q1', 'Message');
            $type = PHPExcel_IOFactory::identify($uploadedFileName);
//             echo $type;exit();
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,$type);
            $optNameArray = explode('.', $uploadedFileName);
            $newName = 'Expanded_ads_status_'.$accountId.'_'.time().'.'.$optNameArray[1];
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
