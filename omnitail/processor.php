<?php
include('config/config.php');
if(isset($_POST['submit']) && $_POST['submit']=='Login')
{
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	
	$sql = "SELECT id,name,email,user_type FROM users WHERE email='$username' AND password='".md5($password)."' AND del_status=0";
	
        $result = $conn->query($sql);
               
	$rowcount=mysqli_num_rows($result);
	
	if($rowcount>0)
	{
		$obj=mysqli_fetch_object($result);
		$_SESSION['status']='loggedin';
		$_SESSION['user']=$obj->name;
		$_SESSION['user_id']=$obj->id;
                $_SESSION['user_type']=$obj->user_type;
		//print_r($obj);
                $conn -> query("update users set last_login =NOW() where id='".$obj->id."'");
		header('location:account.php');
		
	}
	else 
	{
		header('location:index.php?msg=error');
	}
	
	
}

if(isset($_POST['status']) && $_POST['status']=='yes')
{
	$account = $_POST['account'];
	$check = explode("|", $_SESSION['index']);
	$arr = array();
	if($check[0]==$account)
	{
		$filenamea = 'omnitail/cron/tmp/Bid_Strategy_Generated_'.$check[1].'_'.$check[0].'.csv';
		$filenameb = 'omnitail/cron/tmp/Bid_Strategy_Shopping_'.$check[1].'_'.$check[0].'.csv';
		if(file_exists($filenamea))
		{
			
			$arr[] = array('result'=>$_SESSION['bid_statusa'],'url'=>'omnitail/cron/tmp/Bid_Strategy_Generated_'.$check[1].'_'.$check[0].'.csv','datestring'=>$check[2],'shop'=>0);
			
			
			
		}
		else
		{
			$arr[] = array('result'=>$_SESSION['bid_statusa'],'NOTFOUND'=>1);
		}
		if(file_exists($filenameb))
		{
				
			$arr[] = array('result'=>$_SESSION['bid_statusb'],'url'=>'omnitail/cron/tmp/Bid_Strategy_Shopping_'.$check[1].'_'.$check[0].'.csv','datestring'=>$check[2],'shop'=>1);
		}
		else
		{
			$arr[] = array('result'=>$_SESSION['bid_statusb'],'NOTFOUND'=>1);
		}
		
		echo json_encode($arr);
		
	}
}
if(isset($_POST['account_status']) && $_POST['account_status']==1)
{
    $sql = "UPDATE prospect_credentials SET account_status=".$_POST['active']." WHERE account_number=".$_POST['account'];
    echo $conn->query($sql);
    
    
}

function clean_files_folders($files)
{
	$tm = 100;
	$newfile='';
	$data = array();
	
	for($i=0;$i<count($files);$i++)
	{
		$tp = explode("_",$files[$i]);
		
		if($tm<$tp[3])
		{
			$tm=$tp[3];
		}
		
		if($i==count($files)-1)
		{
			$newfile = $tp[0].'_'.$tp[1].'_'.$tp[2].'_'.$tm.'_'.$tp[4];
			//echo $newfile."<br/>";
			$id = explode(".",$tp[4]);
			delete_other_files($files,$newfile);
			if($newfile!='')
			{
			$data = array("id"=>$id[0],"file"=>$newfile,"tm"=>$tm,"shop"=>0);
			}
		}
		//print_r($tp);
		//echo count($files)."<br/>";
	}
	
	return $data;
	
}
function clean_files_folders_shop($files)
{
	$tm = 100;
	$newfile='';
	$data = array();

	for($i=0;$i<count($files);$i++)
	{
		$tp = explode("_",$files[$i]);

		if($tm<$tp[3])
		{
			$tm=$tp[3];
		}

		if($i==count($files)-1)
		{
			$newfile = $tp[0].'_'.$tp[1].'_'.$tp[2].'_'.$tm.'_'.$tp[4];
			//echo $newfile."<br/>";
			$id = explode(".",$tp[4]);
			
			delete_other_files($files,$newfile);
			
			if($newfile!='')
			{
				$data = array("id"=>$id[0],"file"=>$newfile,"tm"=>$tm,"shop"=>1);
			}
		}
		//print_r($tp);
		//echo count($files)."<br/>";
	}

	return $data;

}
function delete_other_files($files,$keep)
{
	foreach (array_keys($files, $keep) as $key) {
		unset($files[$key]);
	}
	
	foreach($files as $f)
	{
		unlink('omnitail/cron/tmp/'.$f);
	}
}
if(isset($_POST['previous']) && $_POST['previous']==1)
{
	$dir    = 'omnitail/cron/tmp';
	$files = scandir($dir);
	$sql = " SELECT * FROM account_details ";
	
	$json = array();
	
	$result = $conn->query($sql);
	
	while($row = $result->fetch_object()) {
		$filenamea = array();
		$filenameb = array();
		for($i=2;$i<count($files);$i++)
		{
			if(strpos($files[$i], $row->account_number) !== false)
			{
				if(strpos($files[$i], 'Generated') !== false)
				{
					$filenamea[] = $files[$i];
				}
				else 
				{
					$filenameb[] = $files[$i];
				}
				
			}
		}
	if(count($filenamea)>0)
	{
		$json[]=clean_files_folders($filenamea);
	//	print_r($json);
	}
	if(count($filenameb)>0)
	{
		$json[]=clean_files_folders_shop($filenameb);
	//	print_r($json);
	}
	
		
		
		}
	
	echo json_encode($json);
	
}