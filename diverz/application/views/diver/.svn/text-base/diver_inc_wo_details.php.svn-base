<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>BTW Dive</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<meta name="author" content="@toddmotto">
	<link href="<?php echo base_url();?>css/diver_style.css" rel="stylesheet">
   <script type="text/javascript">
   
function completeWorkOrder(str)
{ 
}
	   
   </script>
 
</head>

<body>
	
	<div class="wrapper">

		<div id="main" style="padding:50px 0 0 0;">
		
		<form id="respo-form" method="post">
			<?php
			foreach ( $customers as $customer ) :
			?>
			<div>
			Client: <?php  echo $customer->F.'&nbsp;'.$customer->L; ?>
					
			</div>
			<div>
            Vessel Name : <?php echo $customer->V;?>&nbsp;&nbsp;Location : <?php echo $customer->O;?>&nbsp;&nbsp;Slip #: <?php echo $customer->S;?>
            </div>
            
			<div>
			Work Order # : <?php  echo $customer->W; ?>
              
			</div>
       
			<?php
			endforeach;
			?>
			   <div>
		   <table width="100%" bgcolor="1">
           <tr width="100%">
           <th class="tblhead">Type</th>
           <th class="tblhead">Description</th>
           <th class="tblhead">Cost</th>
           </tr>
           <?php
           foreach ( $cleanings as $c ) :
           ?>
           <tr class="tblRowDisplay" >
           <td><?php echo  $c->WORK_TYPE; ?></td>
           <td><?php echo $c->WORK_DESCRIPTION; ?></td>
           <td><?php echo $c->DISCOUNT_PRICE; ?></td>
           </tr>
            <?php
            $dates = $c->SCHEDULE_DATE;
            $comments = $c->COMMENTS;
            endforeach;
            ?>
           </table>
			</div>
			<div>
				<label>
					<span>Comments</span>
					<textarea  class="txtareaComments" tabindex="15" style="height:100px;" readonly><?php echo $comments;?></textarea>
				</label>
			</div>
			<div>
				<label>
					<span>Schedule Date : <?php echo $dates;?></span>
					
				</label>
			</div>
			<div>
			<button onclick="completeWorkOrder(<?php echo $pkwork;?>)" type="button" >Work Order Completed</button>
			
			</div>
			 <div>
			<button name="s" onclick="window.location='<?php echo base_url();?>index.php/customer/diver_logout/'" type="button" id="Log_out">Log Out</button>
			</div>
		</form>
		<!-- /Form -->
		</div>
	</div>

	
<div style="bottom: 0px; position: absolute; width: 93%; text-align: center;font-weight: bold;">BTW
		Dive © 2014</div>	
</body>
</html>