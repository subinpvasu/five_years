<!--
Project     : BTW Dive
Author      : Arif
Title      : List collections
Description : List all collections
-->
<div id="screenid">
        <h2 style="width:100%;text-align:center;">Collections </h2>
		<a style="width:10%; float:right; margin-bottom:10px;" href="<?=base_url()?>index.php/customer/manage_work_orders/">
			<button id="onhold_collections" class="btn" style="width:100%;text-transform: uppercase;">BACK</button>
		</a>
		
        <table style="width:100%;text-align: left;border-collapse: collapse;" class="holdtable">
			<tbody>
				<tr style="text-align: center; height: 40px; color: rgb(0, 0, 0); background-color: rgb(255, 255, 255);">

				<th style="background-color: black;color:white;width:14%;border:1px solid white;">Boat Name</th>
				<th style="background-color: black;color:white;width:8%;border:1px solid white;">Boat Slip</th>
				<th style="background-color: black;color:white;width:11%;border:1px solid white;">Customer Code</th>
				<th style="background-color: black;color:white;width:14%;border:1px solid white;">Boat Size/Type</th>
				<th style="background-color: black;color:white;width:8%;border:1px solid white;">On Hold from</th>
				<th style="background-color: black;color:white;width:21%;border:1px solid white;">Customer Name</th>
				<th style="background-color: black;color:white;border:1px solid white;">Type</th>
				<th style="background-color: black;color:white;border:1px solid white;" title="Total <?php echo count($collection);?>">Action</th>
				</tr>
				<?php 
					foreach($collection as $selected_collection)
					{
					if($selected_collection->WO_CLASS == 'Hull Clean') $work_order_detail_url = "cleaning_work_order/";
					elseif($selected_collection->WO_CLASS == 'Anode Change') $work_order_detail_url = "anode_work_order/";
					else $work_order_detail_url = "mechanical_work_order/";
					?>
						<tr style="color: rgb(0, 0, 0); background-color: rgb(229, 229, 229);">
							<td style="border:1px solid black;height:40px;"><?=$selected_collection->VESSEL_NAME?></td>
							<td style="border:1px solid black;"><?=$selected_collection->SLIP?></td>
							<td style="border:1px solid black;"><?=$selected_collection->ACCOUNT_NO?></td>
							<td style="border:1px solid black;"><?=$selected_collection->VESSEL_LENGTH?>/<?=$selected_collection->VESSEL_TYPE?></td>
							<td style="border:1px solid black;"><?=date('m/d/Y',strtotime($selected_collection->ONHOLD_DATE))?></td>
							<td style="border:1px solid black;"><?=$selected_collection->FIRST_NAME?> <?=$selected_collection->MIDDLE_NAME?> <?=$selected_collection->LAST_NAME?></td>
							<td style="border:1px solid black;text-align:center"><?=$selected_collection->WO_CLASS?></td>
							<td style="border:1px solid black;text-align:center">
								<a href="<?=base_url()."index.php/customer/".$work_order_detail_url.$selected_collection->PK_WO?>">View</a> | 
								<a href="<?=base_url()."index.php/customer/release_collections/".$selected_collection->PK_WO?>" onClick="return confirm('Are you sure, you want release workorder?')">Release</a> | 
								<a href="<?=base_url()."index.php/customer/back_to_onhold/".$selected_collection->PK_WO?>" onClick="return confirm('Are you sure, you want move back workorder to onhold?')">Onhold</a></td>
						</tr>
					<?php 
					}
				?>

			</tbody>
		</table>
		<?php 
		if(empty($collection))
		{
			
			echo '<table style="width:100%;float:left;text-align: center;padding-left:0px;"><tbody><tr style="color: rgb(0, 0, 0);"><td style="text-align:center;font-weight:bold;background-color:white;" colspan="7">No Results Found.</td></tr></tbody></table>';
		}
		?>
		</div>

