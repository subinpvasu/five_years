<!--
Project     : BTW Dive
Author      : Subin
Title      : header of the project
Description : Page works as the header for all pages
-->
<?php
date_default_timezone_set('US/Pacific');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<title>BTW Dive</title>

<script
	src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?php echo base_url();?>jquery/calender.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>css/style.css" />
<link rel="stylesheet" href="<?php echo base_url();?>css/calender.css" />



<script>
var base_url = "<?php echo base_url();?>";
	function redirectPerfect(url)
	{
		window.location=url;
	}
	$(document).ready(function(){
$("#exit").click(function(){
	if(confirm("Are you sure want to Exit.?"))
	{
return true;
	}
	else
	{
return false;
	}
});
		});

$(document).ready(function(){
var present = $("#statussession").val();
	$.ajax({url: base_url+"index.php/customer/CheckSessionStatus/",
		type:"post",
		data:{
now:present
			},
			success: function(result) {
				if(result!='Y')
				{
					//alert(present);
					if(window.location!='<?php echo base_url();?>')
					{window.location='<?php echo base_url();?>';}
				}


            }

		});
	
});
setInterval(function(){ 
	var present = $("#statussession").val();
	$.ajax({url: base_url+"index.php/customer/CheckSessionStatus/",
		type:"post",
		data:{
now:present
			},
			success: function(result) {
				if(result!='Y')
				{
					//alert(present);
					window.location='<?php echo base_url();?>';
				}


            }

		});
}, 1800000);


	</script>
</head>
<body style="background-color: black;color:white;background-image:url(<?php echo base_url();?>/img/body_bg.jpg);">
<input type="hidden" id="statussession" value="<?php echo $this->session->userdata('administrator');?>">
<input type="hidden" id="refreshed" value="no">
<script type="text/javascript">
onload=function(){
var e=document.getElementById("refreshed");
if(e.value=="no")e.value="yes";
else{e.value="no";location.reload();}
}
</script>