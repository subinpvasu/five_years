<?php
include ('config/config.php');
function get_account_details($account=null)
{
    global $conn,$master_account;
    if(is_null($account) || $account=='')
    {
        $account = $master_account;
    }
    $sql = "SELECT * FROM account_details WHERE mccid='$account' ";//a INNER JOIN timetable t ON a.account_number = t.customerid
//echo $master_account;
    $result = $conn->query($sql);
    $rows = array();
    while ($row = $result->fetch_object()) {
        $rows[] = $row;
    }
    return $rows;
}
function get_mcc_accounts($account=null)
{
    global $conn,$master_account;
  
    $sql = "SELECT * FROM prospect_credentials";
    $result = $conn->query($sql);
    $rows = array();
    while ($row = $result->fetch_object()) {
        $rows[] = $row;
    }
    return $rows;
}
function get_account_status($account)
{
    global $conn,$master_account;
    if(is_null($account) || $account=='')
    {
        $account = $master_account;
    }
    $sql = "SELECT account_status FROM prospect_credentials WHERE account_number='$account' ";
    $result = $conn->query($sql);
    $obj=mysqli_fetch_object($result);
    return $obj->account_status;
}
function delete_other_files($files, $keep)
{
    foreach (array_keys($files, $keep) as $key) {
        unset($files[$key]);
    }
    foreach ($files as $f) {
        unlink('saved/' . $f);
    }
}
function clean_files_folders($files)
{
    $tm = 100;
    $newfile = '';
    $data = array();
    for ($i = 0; $i < count($files); $i ++) {
        $tp = explode("_", $files[$i]);
        if ($tm < $tp[1]) {
            $tm = $tp[1];
        }
        if ($i == count($files) - 1) {
            $newfile = $tp[0] . '_' . $tp[1] . '_' . $tp[2];
            // echo $newfile."<br/>";
            $id = explode(".", $tp[2]);
            delete_other_files($files, $newfile);
            if ($newfile != '') {
                $data = array(
                    "notfound"=>0,
                    "id" => $id[0],
                    "file" => $newfile,
                    "tm" => $tm
                );
            }
        }
        // print_r($tp);
        // echo count($files)."<br/>";
    }
    return $data;
}


function getLatestUpload($account)
{
    $dir = 'saved';
    $files = scandir($dir);
    $json = array();
    $filename = array();
    foreach ($files as $file) {
        if (stristr($file, $account) == $account . ".csv") {
            $filename[] = $file;
        }
    }
    if(count($filename)>0)
    {   return clean_files_folders($filename);}
    else 
    {
        return array("notfound"=>1);
    }
}