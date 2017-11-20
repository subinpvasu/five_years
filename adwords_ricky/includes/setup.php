<?php
/********************************************************************************************************
 * @Short Description of the File	: Commonly used product object is declared here
 * @version 						: 0.1
 * @author 							: Prince Antony<prince@takyonline.com>
 * @project 						: LMS
 * @Created on 						: DECEMBER 19 2009
 * @Modified on 					: DECEMBER 19 2009  	
********************************************************************************************************/
	define(PRIVATE_KEY,'a5p7LE');
	define(SALT,10);
	define("THUMBNAIL_WIDTH",100);
	define("THUMBNAIL_HEIGHT",100);
	define("MAX_LOGIN_COUNT","5");

	/*Editor related configs BELOW*/
	
	
	$rootpath	=	EDITOR_ROOT_PATH;
	$hostname	=	ADMIN_URL."editor/";
	$imagelimitedext 	= array(".gif",".jpg",".jpeg",".png",".bmp");
	$flashlimitedext 	= array(".swf",".fla");
	$userimagefile_size = "250000";
	$userflashfile_size = "250000";
	
	
	//// Code for clearing inventory session
		$d=parse_url($_SERVER['PHP_SELF']);
		$filename= $_SERVER['PHP_SELF'];
		
		 if(!strstr($filename, 'inventory.php'))
		 {
			unset($_SESSION['topCat']);
			unset($_SESSION['newCats']);
			
		 }
	
	///
	
	include_once("language.php");
	include_once("class.datavalidator.php");
	include_once("class.main.php");
	if(!isset($disPHPMailer))
	{	
		include_once("class.phpmailer.php");
	}	
	include_once("class.user.php");
	
	function DateConvert($params, $content="")
  	{
		$dateFormat1 = $params['dateFormat1'];
		$dateFormat2 = $params['dateFormat2'];
		$dateStr = $params['dateStr'];
		$baseStruc     = split('[:/.\ \-]', $dateFormat1);
		$dateStrParts  = split('[:/.\ \-]', $dateStr );
		//echo $dateFormat1;
		//exit;
		$dateElements = array();
		
		$pKeys = array_keys( $baseStruc );
		foreach ( $pKeys as $pKey )
		{
		  if ( !empty( $dateStrParts[$pKey] ))
		  {
			  $dateElements[$baseStruc[$pKey]] = $dateStrParts[$pKey];
		  }
		  else
		  {
			  return false;
		  }
		}
		
		
		if (array_key_exists('M', $dateElements)) 
		{
		$mToM	= array(
				  "Jan"=>"01",
				  "Feb"=>"02",
				  "Mar"=>"03",
				  "Apr"=>"04",
				  "May"=>"05",
				  "Jun"=>"06",
				  "Jul"=>"07",
				  "Aug"=>"08",
				  "Sep"=>"09",
				  "Oct"=>"10",
				  "Nov"=>"11",
				  "Dec"=>"12",
					);
		$dateElements['m']=$mToM[$dateElements['M']];
		}
		
		$dummyTs = mktime(
		$dateElements['H'],
		$dateElements['i'],
		$dateElements['s'],
		$dateElements['m'],
		$dateElements['d'],
		$dateElements['Y']
		);
		
		return date( $dateFormat2, $dummyTs );
  }
  function MakeURL($params="", $content="")
  {
  	$url = $content;
  	if(ENCRYPT_GET==true)
	{
		$url="sess=".base64_encode($url);
		return $url;
	}
	else
	{
		return $url;
	}
  }
  function insert_getLogin()
  {
		return "Cookie".$_COOKIE['userName'];
		//return array("userName"=>$_COOKIE['userName'],"password"=>$_COOKIE['password']);
  }
  
  /* function formats string. ie strips slash and trim spaces*/
  function FormatString($params,$content)
  {		
		//&$str,$stripslash=1,$paramReplace="",$paramReplaceWith=""
		
		$str   		= $content;
		$stripslash = $params['stripslash'];
		$paramReplace = $params['paramReplace'];
		$paramReplaceWith = $params['paramReplaceWith'];
		
		if($paramReplace != "")
		{
			$paramReplace= trim($paramReplace,"\\");
			$str = str_replace($paramReplace,$paramReplaceWith,$str);
		}
		$str = trim($str);
		if($stripslash)
		{
			$str = stripslashes($str);
		}	
		return $str;
  }

	/* Returns product image. If i/p image does not exist then default image is returned*/  
  function GetProductImage($params,$content="")
  {	
		$content = "admin/inventory/image/";
		$fileFullPath = $content.$params['fileName'];
 
		if(is_file($fileFullPath))
		{
			return $params['fileName'];
		}
		else
		{
			return $params['defaultImage'];
		}
  }
  
  	/****************************************************************/
  	/* Returns product image height and width				     	*/
  	/* Following function in used in product details page			*/
  	/* Default width and height specified is for popup window		*/
  	/****************************************************************/  
  function GetProductImageDetails($params,$content="")
  {		
		if(function_exists(getimagesize))
		{
			$content = "admin/inventory/image/";
			$fileFullPath 		= $content.$params['fileName'];
			$defImageFullPath	= $content.$params['defaultImage'];
			if(is_file($fileFullPath))
			{
				$imgDetails = getimagesize($fileFullPath);
				$imageDetails['width']  = $imgDetails[0];
				$imageDetails['height'] = $imgDetails[1];
			}
			elseif(is_file($defImageFullPath))
			{	
				$imgDetails = getimagesize($defImageFullPath);
				$imageDetails['width']  = $imgDetails[0];
				$imageDetails['height'] = $imgDetails[1];
				
			}
			else
			{
				$imageDetails['width']  = "300";
				$imageDetails['height'] = "300";
			}
		}
		else
		{
			$imageDetails['width']  = "300";
			$imageDetails['height'] = "300";
		}	
		return $imageDetails;
		
  }
  
?>
