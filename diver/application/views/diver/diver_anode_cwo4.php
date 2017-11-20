<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>BTW Dive</title>
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="author" content="@toddmotto">
<link href="<?php echo base_url();?>css/diver_style.css"
	rel="stylesheet">
<script
	src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
            function completeWorkOrder(str,sbn)
            {

           	 var andid = 0;
                $(":checkbox").each(function(){
               
                if($(this).prop("checked"))
                {
		
                    andid = andid+"|"+$(this).val();
                }
                });
                if(andid.length>1){
                    $.ajax({url:"<?php echo base_url();?>index.php/customer/addAnodeWorkDiver/",
                        type:"post",
                        data: {
				    anodes:andid,
				    work:<?php echo $pkwork;?>
				    },
				    success:function(result)
				    {
					    alert(result);
					    switch(sbn){
					    case 1:
					    	window.open('<?php echo base_url(); ?>index.php/customer/diver_mech_fnsd/' + str, '_self', false);
						    break;
					    case 2:
					    	window.open('<?php echo base_url();?>index.php/customer/diver_clean_fnsd/'+str,'_self',false);
						    break;
					    default:
					    	window.open('<?php echo base_url(); ?>index.php/customer/diver_anode_cwo_comments/' + str, '_self', false);
						    break;
					    }
					    
					}

				    });
                }else
                {
               	 switch(sbn){
				    case 1:
				    	window.open('<?php echo base_url(); ?>index.php/customer/diver_mech_fnsd/' + str, '_self', false);
					    break;
				    case 2:
				    	window.open('<?php echo base_url();?>index.php/customer/diver_clean_fnsd/'+str,'_self',false);
					    break;
				    default:
				    	window.open('<?php echo base_url(); ?>index.php/customer/diver_anode_cwo_comments/' + str, '_self', false);
					    break;
				    }
                }
		// window.open('<?php echo base_url(); ?>index.php/customer/diver_anode_cwo_comments/' + str, '_self', false);
	





 
            }
        </script>
</head>

<body>

	<div class="wrapper">

		<div id="main" style="padding: 50px 0 0 0;">

			<!-- Form -->
			<form id="respo-form">
				<div id="headerbtns">
					<table width="100%">
						<td width="40%">
							<button name="home"
								onclick="window.location = '<?php echo base_url(); ?>index.php/customer/diver_home/'"
								type="button" id="homebtn">Home</button>
						</td>
						<td width="20%" style="background-color: #000000;"></td>
						<td width="40%">
							<button name="log_out"
								onclick="window.location = '<?php echo base_url(); ?>index.php/customer/diver_logout/'"
								type="button" id="Log_out">Log Out</button>
						</td>
					</table>
				</div>
				<div>&nbsp;</div>
				<h2>Which zincs need changing?</h2>
				<div>&nbsp;</div>

				<div>&nbsp;</div>
				<div>
					<table>			
	<?php
$workparts = '';
$comments = '';
$dates = '';
$diverz = '';
$used = '';
$workpartsand = '';
$kount = 1;
if(count($anodes)>0){
foreach ( $anodes as $anode ) :
    ?>
        <tr>
							<td><?php echo $anode->DESCRIPTION;?> </td>
        
        
            <?php
    
                    echo  '<td style="background-color:#262626;text-align: center;width: 40px"><input type="checkbox" class="chkbx" value="' . $anode->PK_VESSEL_ANODE . '"  id="change' . $anode->PK_VESSEL_ANODE . '"  /></td>';
?>
        </tr>        <?php
endforeach
;
}
else
{
    ?>
    <tr><td colspan="2"><h3 style="background-color: black;color:white;">No Zincs/Anodes Found.</h3></td></tr>
    <?php 
}
?>
                 </table>
				</div>
				<div>&nbsp;</div>

				<div>&nbsp;</div>


				<?php 
				switch ($status)
				{
				    case '/1':
				        ?>
				        <div>
					<button name="s"
						onclick="completeWorkOrder(<?php echo $pkwork; ?>,1)" type="button"
						id="btn_next">Next</button>

				</div>
				<div>
					<button name="s"
						onclick="window.location='<?php echo base_url();?>index.php/customer/diver_anode_cwo3/<?php echo $pkwork.$status;?>'"
						type="button">Back</button>


				</div>
				        <?php 
				        break;
				    case '/2':
				        ?>
				        <div>
					<button name="s"
						onclick="completeWorkOrder(<?php echo $pkwork; ?>,2)" type="button"
						id="btn_next">Next</button>

				</div>
				<div>
					<button name="s"
						onclick="window.location='<?php echo base_url();?>index.php/customer/diver_anode_cwo3/<?php echo $pkwork.$status;?>'"
						type="button">Back</button>


				</div>
				        <?php 
				        break;
				    default:
				        ?>
				        <div>
					<button name="s"
						onclick="completeWorkOrder(<?php echo $pkwork; ?>,0)" type="button"
						id="btn_next">Next</button>

				</div>
				<div>
					<button name="s"
						onclick="window.location='<?php echo base_url();?>index.php/customer/diver_anode_cwo3/<?php echo $pkwork;?>'"
						type="button">Back</button>


				</div>
				        <?php 
				        break;
				}
				
				?>
				
				
				
				
				
				

			</form>
			<!-- /Form -->

		</div>
	
	


	<div
		style="bottom: 0px; width: 93%; text-align: center; font-weight: bold;">BTW
		Dive © 2014</div></div>
</body>
</html>