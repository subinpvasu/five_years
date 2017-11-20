<?php
/********************************************************************************************************
 * @Short Description of the File	: Includes page, holds all incliding files
 * @version 						: 0.1
 * @author 							: Prince Antony<prince@takyonline.com>
 * @project 						: LMS
 * @Created on 						: DECEMBER 19 2009
 * @Modified on 					: DECEMBER 19 2009 	
********************************************************************************************************/
	ini_set('max_execution_time','600');
	ini_set('memory_limit', '-1');	
	date_default_timezone_set('Europe/London');
	ob_start();
	session_start();

	include_once("config.php"); 
	include_once("classes/class.main.php");
	include_once("classes/class.datavalidator.php");
	include_once("classes/class.adwordsservices.php");
	include_once("classes/phpgraphlib.php");
	include_once("classes/class.member.php");
	include_once("classes/class.reports.php");
	include_once("classes/class.users.php");
	include_once("constant.php");
	include_once("adword_client_details.php");
	 
 	$main				= new Member();
	$validator 			= new DataValidator();
	$services 			= new Adwordservices();
	$reports 			= new Reports();
	$users  			= new Users();
	 
	if(isset($_SESSION['user_db'])) $main->select($_SESSION['user_db']);
	
	//$member->siteUrl = '';
	//$member->siteId  = '';
?>