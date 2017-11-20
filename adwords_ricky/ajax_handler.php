<?php
include_once("header.php");
if(isset($_POST['status']) && $_POST['status']==100)
{
    $side = $_POST['side'];
    $type = $_POST['types'];
    $description = urlencode($_POST['description']);


    $sql = " UPDATE adword_report_types SET ";

    switch ($side)
    {
        case '1': $sql .= " ad_report_type_left='$description' "; break;
        case '2': $sql .= " ad_report_type_right='$description' "; break;
        default:break;
    }
    $sql .= " WHERE report_type_field='$type' ";

//  mysql_query($sql) or die($sql ."----".mysql_error());


  $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  //echo $sql;
  if ($conn->query($sql) === TRUE) {
      echo '1';
  } else {
      //echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();





//     echo $result;


}
