<!--
Project     : BTW Dive
Author      : Subin
Title      : display clean type
Description : displays the clean types includeed in the workorder.
-->
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>BTW Dive</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<meta name="author" content="@toddmotto">
	<link href="<?php echo base_url();?>css/diver_style.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script type="text/javascript">
             function loadAJAX()
{
	if (window.XMLHttpRequest){
	  xmlhttp=new XMLHttpRequest();
	  }	else {
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  return xmlhttp;
}
            function completeWorkOrder(str)
{
    //Checking check box is checked
	if($(":checkbox").is(":checked"))
	{
          // alert('hai');
       //  window.open('<?php echo base_url();?>index.php/customer/diver_clean_fnsd/'+str,'_self',false);
         window.open('<?php echo base_url();?>index.php/customer/diver_anode_cwo3/'+str+'/2','_self',false);

      /*	var r = confirm("Are you sure you want to Complete this Work Order..?");

	if(r){
		loadAJAX().onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
			      //searchDistribution(xmlhttp.responseText);
		      if(xmlhttp.responseText=='Y')
		      {



		      }
		    }
		  };
		xmlhttp.open("POST","/btwdive/index.php/customer/completeWorkOrder/"+str,true);
		xmlhttp.send();
alert("Work Order Completed");
self.close();*/

            }
            else
        {
              alert("Please select a process");
        }//alert(str);
	}
            </script>
</head>

<body>

	<div class="wrapper">

		<div id="main" style="padding:50px 0 0 0;">

		<!-- Form -->
		<form id="respo-form" >
		<div id="headerbtns">
                        <table width="100%">
                            <td width="40%">
                            <button name="home"  onclick="window.location = '<?php echo base_url(); ?>index.php/customer/diver_home/'" type="button" id="homebtn">Home</button>
                            </td>
                            <td width="20%" style="background-color:#000000;"></td>
                            <td width="40%">
                            <button name="log_out"   onclick="window.location = '<?php echo base_url(); ?>index.php/customer/diver_logout/'" type="button" id="Log_out">Log Out</button>
                            </td>
                        </table>
                    </div>
                            <div>
                                &nbsp;
                            </div>
			<h2>Clean

		  </h2>
			<div>
            &nbsp;
            </div>

            <div>
            &nbsp;
            </div>
             <div>
                 <table style="width:100%">
	<?php
$workparts = '';
$comments = '';
$dates = '';
$diverz = '';
$used = '';
$kount = 1;
foreach ( $cleanings as $c ) :
                 if($c->WORK_VALUE>0)
{
    ?>
        <tr>
        <td style="width: 75%"><?php
              if (strpos($c->WORK_DESCRIPTION,'FULL') !== false) {
    echo 'Full Clean';
}
else  if (strpos($c->WORK_TYPE,'DINGHY') !== false) {
    echo 'Dinghy';
}  else if( strpos($c->WORK_TYPE,'BOW') !== false)
{
    echo 'BOW/AFT';
}
 else
{
   echo 'Half Clean';
}
       // echo $c->WORK_DESCRIPTION;

        ?> </td>


            <?php
           $c->WORK_VALUE == 0 ? print '<td style="background-color:#262626;text-align: center;width: 25%"><input type="checkbox" class="chkr"  id="process' . $c->PK_WO_PARTS . '" value="' . $c->WORK_VALUE . '"/></td>' : print
      '<td style="background-color:#262626;text-align: center;width: 25%"><input type="checkbox" checked id="process' . $c->PK_WO_PARTS . '" value="' . $c->WORK_VALUE . '" name="'.$c->PK_WORK.'"/></td>';
            ?>
        </tr>        <?php
}
endforeach;

        ?>
                 </table>
			</div>
            <div>
            &nbsp;
            </div>

            <div>
            &nbsp;
            </div>


			<div>
				 <button name="s" onclick="completeWorkOrder(<?php echo $pkwo;?>)" type="button" id="btn_next">Next</button>

			</div>
         <div>
                            <button name="s"  onclick="window.location='<?php echo base_url();?>index.php/customer/clean_compWO/<?php echo $pkwo;?>'" type="button" >Back</button>


                        </div>
		</form>
		<!-- /Form -->

		</div>




<div style="bottom: 0px; position: absolute; width: 93%; text-align: center;font-weight: bold;">BTW
		Dive © 2014</div>	  </div>
</body>
</html>