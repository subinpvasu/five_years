<?php
require_once dirname(__FILE__) . '/includes/includes.php';
//$_SESSION['logout_user']
$main->Query("UPDATE login_statistics SET logout_time=NOW() WHERE id='".$_SESSION['logout_user']."'");

session_unset();
$_SESSION = array();
header("Location:index.php");

?>