<?php 
/* @var $this CustomersController */
/* @var $model Customers */
?>
<?php 
Yii::app()->getClientScript()->registerCoreScript('yii');
if(date('D') == 'Sun') $start_date = date('Y-m-d');
else $start_date = date('Y-m-d',strtotime('previous sunday'));
if(date('D') == 'Sat') $end_date = date('Y-m-d');
else $end_date = date('Y-m-d',strtotime('saturday this week')); 
$days = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
?>
<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				
				<div class="tabs">
				<div class="tab_top"><strong class="sub-ttl" style="color: #DA6C0B;
				    display: block;
				    font: 24px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
				    z-index: auto;width:100%;float:left;margin-left: 3%;margin-top: 0px;"><?php if($model->id != '') echo 'Schedule for '.$model->name; else echo 'Default Schedule';?> </strong></div>
				<div class="tabs-frame">		
					<strong class="sub-ttl" style="color: #0099FF;
					    display: block;
					    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
					    z-index: auto;width:100%;float:left;margin-left: 25px;"> Copy a playlist</strong>
				    <div class="rename_result"></div>
					<div class="rename_form">
						<?php echo CHtml::beginForm('index.php?r=playlists/copy'); ?>
						<div class="row">
							<label for="Jingles_path">Playlist</label>
							<?php echo CHtml::dropDownList('Jingles[customer_id]', 5, 
					              $play_list_id_name_array,
					              array('empty' => 'Select a playlist')); ?>
					              
					        <?php //echo $form->error($model,'customer_id'); ?>
					    </div>
					    <div class="part2">
						    <div class="row">
						    	<label for="Jingles_path">New name</label>
						    	<?php echo CHtml::textField('Jingles[name]'); ?>
							</div>
				   		<div id="butn_renm"> Save</div>
				   		</div>
					<?php echo CHtml::endForm(); ?>
					</div>
					<div class="sub-menu">	
					<?php 
					if($model->id != '')
					{
						$this->widget('zii.widgets.CMenu', array(
								'items'=>array(
										array('label'=>'Add New', 'url'=>array('create')),
										array('label'=>'View ', 'url'=>array('view&id='.$model->id)),
										array('label'=>'Edit ', 'url'=>array('update&id='.$model->id)),
										array('label'=>'Manage', 'url'=>array('admin'),
										),									
								),
						));
					}
					else {
						$this->widget('zii.widgets.CMenu', array(
								'items'=>array(
										array('label'=>'Add New', 'url'=>array('create')),
										array('label'=>'Manage', 'url'=>array('admin'),
										),
								),
						));
					}
					?>
					</div>
					<div class="divider"></div>
					<?php $form=$this->beginWidget('CActiveForm', array(
							'id'=>'chart_form',
							// Please note: When you enable ajax validation, make sure the corresponding
							// controller action is handling ajax validation correctly.
							// There is a call to performAjaxValidation() commented in generated controller code.
							// See class documentation of CActiveForm for details on this.
							'enableAjaxValidation'=>false,
					)); ?>
					<?php if($error_titte != '' || !empty($errors)) { ?>
					<div class="errorSummary"><p><?=$error_titte?></p>
						<ul>
							<?php foreach($errors as $error) echo '<li>'.$error.'</li>';?>
						</ul>
					</div>
					<?php } 
						elseif($success_msg != '')
						{
							echo '<div class="success">'.$success_msg.'</div>';
						}
						if($model->id != '')
						{
					?>
					
					 <div class="row2">
					 	<strong class="sub-ttl" style="color: #0099FF;
					    display: block;
					    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
					    z-index: auto;width:100%;float:left;">Number of Ads</strong>
						    <label for="Jingles_path">Select the number of different ads to be played in every commercial break.</label>
						    <input type="text" id="list_ad_no" name="list[ad_no]" value="<?=$model->ad_no?>">
						</div>
						<div class="row2">
							<strong class="sub-ttl" style="color: #0099FF;
						    display: block;
						    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
						    z-index: auto;width:100%;float:left;">Number of Tracks between Ads</strong>
						   	<label for="Jingles_path">Select the number of tracks to be played between advertising breaks.</label>
						   	<input type="text" id="list_ad_no" name="list[ad_gap]" value="<?=$model->ad_gap?>">
						   	
						</div>
						<div class="row2">
							<strong class="sub-ttl" style="color: #0099FF;
						    display: block;
						    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
						    z-index: auto;width:100%;float:left;">Number of Tracks between Jingles</strong>
						   	<label for="Jingles_path">Select the number of tracks to be played between the jingle.</label>
						   	<input type="text" id="list_ad_no" name="list[jingle_gap]" value="<?=$model->jingle_gap?>">
						   	
						</div>
						<div id="create_shedule_btn">
							
							<?php echo CHtml::link('Create Weekly Schedule',array('customers/return_playlist&id='.$model->id)); ?>
						</div>
						<?php } ?>
					<table class="chart">
					<?php /*?>
					<tr>
						<td></td>
						<?php
						for($i=0;$i<24;$i++) echo '<td>'.sprintf("%02s", $i).'</td>';
						?>	
						<td>Actions</td>
					</tr>
					<?php 
					foreach($days as $key=>$day)
					{
						
						echo '<tr>';
						if(date('D') == $day) 
						{
							echo '<td class="active date_row">'.$day.'</td>';
							for($i=0;$i<24;$i++) 
							{
								$index = $key.'_'.$i;
								
								if(!array_key_exists($index,$chart)) $chart[$index] = $defalt_playlist_arry[array_rand($defalt_playlist_arry)];
								echo '<td class="active"><input type="text" name="list[chart]['.$key.'_'.$i.']" class="day'.$key.'" id="'.$key.'_'.$i.'" value= "'.$chart[$index].'"></input></td>';
							}
						}
						else 
						{
							echo '<td class="date_row">'.$day.'</td>';
							for($i=0;$i<24;$i++)
							{
								$index = $key.'_'.$i;
								if(!array_key_exists($index,$chart)) $chart[$index] = $defalt_playlist_arry[array_rand($defalt_playlist_arry)];						
								echo '<td><input type="text" name="list[chart]['.$key.'_'.$i.']" id="'.$key.'_'.$i.'" class="day'.$key.'" value= "'.$chart[$index].'"></input></td>';
							}
						}
						if($key != 6)
						{ 
							echo '<td><div class="change" id="cpy_'.$key.'" >Copy to '.$days[$key+1].'</div><div id="empty_'.$key.'" class="empty">Empty '.$days[$key].'</div></td>';
						}
						else echo '<td><div class="change" id="cpy_'.$key.'" >Copy to Sun</div><div id="empty_'.$key.'" class="empty">Empty '.$days[$key].'</div></td>';
						echo '</tr>'; 
					}
					?>
					<?php */
					echo '<tr>';
					echo '<td>Time</td>';
					foreach($days as $key=>$day)
						{
							if(date('D') == $day) 
							{
								echo '<td class="active date_row">'.$day.'</td>';									
							}
							else 
							{
								echo '<td class="date_row">'.$day.'</td>';									
							}								
						}
					echo '</tr>';
					for($i=0;$i<24;$i++) 
					{
						echo '<tr>';
						echo '<td>'.$i.'</td>';
						 foreach($days as $key=>$day)
						{
							if(date('D') == $day) 
							{
								$index = $key.'_'.$i;
								
								if(!array_key_exists($index,$chart)) $chart[$index] = $defalt_playlist_arry[array_rand($defalt_playlist_arry)];
								echo '<td class="active"><input type="text" name="list[chart]['.$key.'_'.$i.']" class="day'.$key.'" id="'.$key.'_'.$i.'" value= "'.$chart[$index].'"></input></td>';									
							}
							else 
							{
								$index = $key.'_'.$i;
								
								if(!array_key_exists($index,$chart)) $chart[$index] = $defalt_playlist_arry[array_rand($defalt_playlist_arry)];
								echo '<td><input type="text" name="list[chart]['.$key.'_'.$i.']" class="day'.$key.'" id="'.$key.'_'.$i.'" value= "'.$chart[$index].'"></input></td>';									
							}					
						}
						 
						echo '</tr>';
					}
					echo '<tr>';
					echo '<td> </td>';
					foreach($days as $key=>$day)
						{
							
							if($key != 6)
							{ 
								echo '<td><div class="change" id="cpy_'.$key.'" >Copy to '.$days[$key+1].'</div><div id="empty_'.$key.'" class="empty">Empty '.$days[$key].'</div></td>';
							}
							else echo '<td><div class="change" id="cpy_'.$key.'" >Copy to Sun</div><div id="empty_'.$key.'" class="empty">Empty '.$days[$key].'</div></td>';
												
						}
					echo '</tr>';
					?>
					
					</table>
					<div class="submit_shedule"> 
						<?php echo CHtml::submitButton('Save'); ?>
					</div>
					<?php $this->endWidget(); ?>
				</div>
				
			</div>
			</div>
			<div class="clear"></div>
			<div id="login_overlay" style="display: block;">
					<div id="popup_setup">
						
							<strong class="sub-ttl" style="float: left;width: 100%;">Creating schedules</strong>
							<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" style="margin-left: 6%;margin-top: 3%;">
							
						</div>
		</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
	$('.empty').click(function(){
	id_name = $(this).attr('id');
	name_array = id_name.split('_');
	//alert(name_array[1]);
	$('.day'+name_array[1]).val(0);
	});
	$('.change').click(function(){
	id_name = $(this).attr('id');
	name_array = id_name.split('_');
	current_day = name_array[1];
	next_day = 0;
	if(current_day != 6) next_day = parseInt(current_day) + parseInt(1);	
	for(var i=0;i<24;i++)
	{
		//current_id = '#'+current_day+'_'+i;
		current_val = $('#'+current_day+'_'+i).val();
		$('#'+next_day+'_'+i).val(current_val);
		//alert(current_val);
	}
	//alert(next_day);
	//$('.day'+name_array[1]).val('');
	})
	});
</script>
<style>
.sub-ttl {
color: #DA6C0B;
display: block;
font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
z-index: auto;
width: 100%;
float: left;
}
#popup_setup {
margin-left: 41%;
margin-top: 24%;
}
.chart {
    background: none repeat scroll 0 0 #F2F2F2;
    border-radius: 13px;
    float: left;
    font-size: 15px;
    margin-top: 20px;
    width: 95%;
    border: 1px dotted #fff;
}

.chart td {
    border: 1px dotted;
    text-align:center;
    padding: 3px;
}
.chart td input {
	background: none repeat scroll 0 0 #F2F2F2;
	width:75%;
	padding:0px;
   }
.active {
color:#0099FF;
}
.active input {
color:#0099FF;
}
.success {
	background: none repeat scroll 0 0 #e5eecc;
	border: 1px solid #8AC007;
	border-radius: 7%;
	color: #8AC007;
	font-size: 15px;
	font-weight: bold;
	height: 32px;
	margin-bottom: 10px;
	padding: 16px 5px 5px;
	text-align: center;
	width: 375px;
	margin-left:10px;
}
.submit_shedule {
    float: left;
    margin-top: 20px;
    width: 100%;
}

.submit_shedule input {
    border-radius: 11%;
    float: right;
    margin-right: 10%;
    width: 100px;
    font:'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
}
#chart_form {
    float: left;
    padding-left: 25px;
}

.rename_form {
    float: left;
    padding-left: 25px;
    width: 71%;
}
.rename_form .row {
width:100%;
float:left;
}
.rename_form label {
width:20%;
float:left;
}

#butn_renm {
    border: 1px solid #33CCCC;
    background-color: #d4d4d4;
    border-radius: 7px;
    float: left;
    height: 30px;
    margin-bottom: 5px;
    margin-left: 43%;
    margin-top: 7px;
    padding-top: 12px;
    text-align: center;
    width: 12%;
	cursor: pointer;
}
.rename_form #Jingles_customer_id {
    border: 1px solid #33CCCC;
    padding: 10px;
    width: 242px;
   
}
.rename_result {
width:100%;
float:left;
}

.divider {
    background: none repeat scroll 0 0 #DBDBDB;
    border-top: 27px solid #FFFFFF;
    float: left;
    height: 1px;
    margin: 0 40px 9px 20px;
    overflow: hidden;
    width: 94%;
}
.row2 {
float:left;
width:40%;
margin-right: 5%;
}
.row2 label {
float:left;
width:100%;
}
.errorSummary {
width:94%;
}
.change {
border-bottom: 1px dotted #000;
margin-bottom: 5px;
padding-bottom: 5px;
cursor: pointer;
}
.change:hover
{ 
	color:#33CCCC;
}
.empty {
cursor: pointer;
}
.empty:hover
{ 
	color:#33CCCC;
}
</style>
<script type="text/javascript">
		$(document).ready(function() {
			
			$('.part2').hide();
			$('#Jingles_customer_id').change(function(){
				if($('#Jingles_customer_id').val() == '') $('.part2').hide();
				else $('.part2').show();
				});
			$('#butn_renm').on("click", null, function(){
				validation_error = '';
				if($('#Jingles_customer_id').val() == '')
				{
					validation_error = validation_error + 'Please chose a playlist \n ';
				}
				if($('#Jingles_name').val() == '')
				{
					validation_error = validation_error + 'Please add new name \n ';
				}
				if(validation_error != '')
					alert(validation_error);
				else
				{
					$.post("index.php?r=playlists/copy", {playlist: ""+$('#Jingles_customer_id').val()+"" , name: ""+$('#Jingles_name').val()+""}, function(data){
						if(data.length >0) {
							$('.rename_result').html(data);							
						}
					});
				}
				
				});
			
		});
		$(document).ready(function(){
			$('#login_overlay').hide();
		    $('#create_shedule_btn').click(function(){
		    	$('#login_overlay').show();
		       // var search_term = $(this).attr('value');
		       // $.post('index.php?r=customers/return_playlist&id=34', {search_term:search_term}, function(data){
		        //    alert(data);
		        //    $('#login_overlay').hide();
		        //});
		    });
		 });
</script>
