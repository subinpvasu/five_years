<?php

/*

 *
 * Service file for new additional features

 * To add new additional features for customer report with an image and title
 *

 */

require_once dirname(__FILE__) . '/../../includes/includes.php';

$title = $_REQUEST['title']; 
$img_folder = SITE_URL."customer_report/img/";

$acceptable = array(
        'image/jpeg',
        'image/jpg',
        'image/gif',
        'image/png'
    );

$error  = 0 ; $str = 0;

if(empty($title)){
    
   $str =  'Please give a valid title';
   $error = 1 ; 
    
}


else if (0 < $_FILES['file']['error']) {
    $str =  'Error: ' . $_FILES['file']['error'] . '<br>';
    $error = 1 ;
} 

else {
    
    $filename =  $_FILES['file']['name'] ;
    list($width, $height, $type, $attr) = getimagesize($_FILES["file"]['tmp_name']);
    
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    
    if(!in_array($_FILES['file']['type'], $acceptable) && (!empty($_FILES["file"]["type"]))) {
        $error = 1 ;
        $str = "Please upload image with type jpg, jpeg, png or gif";
    }
    elseif($_FILES['file']['size'] > 100000){
        $error = 1 ;
        $str = "Please upload image with size less than 100kb";
    }
    elseif ($width<>600) {
        $error = 1 ;
        $str = "Please upload image with width 600";
    }
    else{
        $name = "new_section_image_".time().'_'.substr(str_shuffle('abcdefghijklmanopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'),3,5);
        if (move_uploaded_file($_FILES['file']['tmp_name'], '../img/'.$name.'.'.$ext)) {

            $image = $img_folder.$name.'.'.$ext ;

            $str =' <div class="containerdiv newsections" style="display:block;"><b style="page-break-after: always;"></b>
                    <div class="classh1">	
                        <input type="checkbox" class="classcb" checked="checked" style="display: inline;"/>  
                        <p>'.$title.'</p></div>
                    <div class="classb1"><img src="'.$image.'"/></div>
                    <div class="classb2"></div>			
                </div>';
        } else {

            $error = 1 ;
            $str = "File Upload Failed";
        }
    }
}

$return = array('error' => $error ,'str' => $str );

print json_encode($return, JSON_NUMERIC_CHECK); exit;