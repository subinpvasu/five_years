<?php 
/* @var $this CustomersController */
/* @var $model Customers */

?>
<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				<strong class="sub-ttl" style="color: #DA6C0B;
			    display: block;
			    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
			    z-index: auto;">Push notification details</strong>
				<div id="customers-grid" class="grid-view">
				<?php
				$result_object = json_decode($message);
				if($result_object->success == 1)
				{
					$result = $result_object->results;
					?>
					<table>
						<tr>
							<td>Status</td>
							<td>Success</td>
						</tr>
						<tr>
							<td>Multicast id</td>
							<td><?=$result_object->multicast_id?></td>
						</tr>
						<tr>
							<td>Message id</td>
							<td><?=$result[0]->message_id?></td>
						</tr>
						<tr>
							<td>TeamViewer id</td>
							<td><?=$customer_details[0]->team_viewer?></td>
						</tr>
					</table>
					<?php 
				}
				else echo 'status = Failed</br />';
				?>
				</div>
					
					<?php 
					/*
					echo '<div class="sub-menu">';
					$this->widget('zii.widgets.CMenu', array(
							'items'=>array(
									array('label'=>'Add New', 'url'=>array('create')),
									array('label'=>'Default Schedule', 'url'=>array('chart')),
									),
					));
					echo '</div>';
					*/
					?>	
				
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
<style>
td {
	min-width: 156px;
	border: 1px solid #0099FF;
	padding: 10px;
}
</style>
