<?php
include_once './Classes/AppConstants.php';
include_once './Classes/HelperMethods.php';
include_once './Classes/DatabaseHelper.php';
require_once dirname(__FILE__) . '/Classes/PHPExcel/IOFactory.php';
require_once dirname(__FILE__) . '/adschedulingCampaignHelper.php';
require_once dirname(__FILE__) . '/addAudienceHelper.php';
if(!isset($_SESSION))
{
    session_start();
}
try{
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $objDb = new DbHelper();
        $accId = isset($_REQUEST['IHAccountId'])?$_REQUEST['IHAccountId']:'';
        $location = isset($_REQUEST['location'])?$_REQUEST['location']:1;
        $fname = explode('.', $_FILES['file']['name']);
        $uploadedFileName = dirname(__FILE__) .'/uploads/'.$fname[0].'_'.time().'.'.$fname[1];
        move_uploaded_file($_FILES['file']['tmp_name'], $uploadedFileName);
        $uploadedBy = isset($_SESSION['user_id'])?$_SESSION['user_id']:1;
        
//        PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
        $objPHPExcel = PHPExcel_IOFactory::load($uploadedFileName);
        $helperMethods = new HelperMethods();
        $ret = $helperMethods->getSpreadSheetValuesAsArray($objPHPExcel);
        $total = count($ret);
//        $objDb->addToTestTable("count = ".$total);

        $recordId = $objDb->startUpload($uploadedFileName, $uploadedBy, $accId,$location, $total);
        
        
        $i = 2;
        $insertString = "";
      //   $location = 4;
echo $location;
        if($location == 1){ 
            // creating string for inserting into status table
            foreach ($ret as $records){
                if($insertString!=''){
                    $insertString .= "),(";
                }else{
                    $insertString .= "(";
                }
                $insertString .= $recordId.",";
                $insertString .= $i.",";
                $insertString .= "'".AppConstants::$NOT_PROCESSED_STATUS."',";
                $innerString = "";
                foreach ($records as $key => $record){
                    if($innerString==''){
                        $innerString .= "'".  addslashes($record)."'";
                    }else{
                        if($key != AppConstants::$STATUS_NAME){
                            $innerString .= ",'".addslashes($record)."'";
                        }
                    }
                }
                $insertString .= $innerString;
                $i++;
            }
            $insertString .= ")";
            //echo $insertString;
            if($objDb->insertUploadedFileDetails($insertString)){
                $objDb->addToTestTable("Successfully written to db with record table id as $recordId");
            }  else {
                $objDb->addToTestTable(addslashes($insertString));
            }
        }else if ($location == 2){
            // insert to database goes here.
            
            $schedulingHelper = new adschedulingCampaignHelper(NULL, NULL);
            $scheduleHelperArrays = $schedulingHelper->splitCampaingNameScheduleAndId($ret);
            $campaignArray = $scheduleHelperArrays[0];
            $campaignNameArray = $scheduleHelperArrays[1];
            $scheduleArray = $scheduleHelperArrays[2];
            echo "<pre>";
            print_r($scheduleArray);
            
            
            $insertString = ""; $comma = 1; 
            
            foreach($campaignArray as $key => $campaign){
                
                $campaignName = $campaignNameArray[$key] ;
                
                foreach($scheduleArray as $schedule){                    
                    
                    if($comma == 0) $insertString .= ",";
                   
                    $insertString .= "('".$recordId."','".addslashes($campaignName)."','".$campaign."','".$schedule['bid']."','".$schedule['day']."','".$schedule['startHour']."','".$schedule['startMin']."','".$schedule['endHour']."','".$schedule['endMin']."')";                    
                   
                    $comma = 0 ;
                    
                }
                
 
            }
            //echo "asfjsdfkasfdk".$insertString;
          //  $result = $objDb->insertAdSchedulingStatus($insertString);
            
            if($objDb->insertAdSchedulingStatus($insertString)){
                $objDb->addToTestTable("Successfully written to adscheduling table with record table id as $recordId");
            }  else {
                $objDb->addToTestTable(addslashes($insertString));
            }
            
            exit;
        }
        else if($location==3)
        {
           // echo 'here';exit();
            $audienceHelper = new addAudienceHelper(NULL, NULL);
            $audienceHelperArrays = $audienceHelper->splitCampaingNameAudienceAndId($ret);
            $campaignArray = $audienceHelperArrays[0];
            $audienceArray = $audienceHelperArrays[1];
            
            echo "<pre>";
            print_r($campaignArray);
            print_r($audienceArray);
            
         $insertString = ""; $comma = 1; 
            
            foreach($campaignArray as $campaign){
                
                //$campaignName = $campaignNameArray[$key] ;
                
                foreach($audienceArray as $audience){                    
                    
                    if($comma == 0) $insertString .= ",";
                   
                    $insertString .= "('".$recordId."','".$campaign[0]."','".$campaign[1]."','".$campaign[2]."','".$campaign[3]."','".$audience[0]."','".$audience[1]."','".$audience[2]."','".$audience[3]."','".AppConstants::$NOT_PROCESSED_STATUS."',NOW())";                    
                   
                    $comma = 0 ;
                    
                }
                
 
            }
//             $insertString .= ")";
//             echo $insertString;
            if($objDb->insertAudienceSatus($insertString)){
                $objDb->addToTestTable("Successfully written to Audience DB with record table id as $recordId");
            }  else {
                $objDb->addToTestTable(addslashes($insertString));
            }
            
            
        }
        else if($location==4)
        {  // creating string for inserting into status table
            foreach ($ret as $records){
                if($insertString!=''){
                    $insertString .= "),(";
                }else{
                    $insertString .= "(";
                }
                $insertString .= $recordId.",";
                //$insertString .= $i.",";
                $insertString .= "'".AppConstants::$NOT_PROCESSED_STATUS."',";
                $insertString .= "NOW(),";
                $innerString = "";
                foreach ($records as $key => $record){
                    if($innerString==''){
                        $innerString .= "'".  addslashes($record)."'";
                    }else{
                        if($key != AppConstants::$STATUS_NAME){
                            $innerString .= ",'".addslashes($record)."'";
                        }
                    }
                }
                $insertString .= $innerString;
                $i++;
            }
            $insertString .= ")";
//             echo $insertString;
            if($objDb->insertETAdsFileDetails($insertString)){
                $objDb->addToTestTable("ETA Successfully written to db with record table id as $recordId");
            }  else {
                $objDb->addToTestTable(addslashes($insertString));
            }
        
        
        }
        
    }else{
        echo '<form method=post enctype="multipart/form-data" ><input type=file name=file /><input type="submit" /></form>';
    }
}  catch (Exception $ex){
    $objDb = new DbHelper();
    $objDb->addToTestTable($ex->getMessage());
}
