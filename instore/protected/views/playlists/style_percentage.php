<?php
/* @var $this PlaylistsController */
/* @var $model Playlists */

$this->breadcrumbs=array(
	'Playlists'=>array('index'),
	$model->name,
);

?>
<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				<strong class="sub-ttl" style="color: #DA6C0B;
			    display: block;
			    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
			    z-index: auto; margin-left: 19%;">Change style percentage - <?php echo $model->name; ?></strong>
				<div class="form">
					<?php if($errors != '')
					{
						echo '<div class="errorSummary"><p>Please fix the following input errors:</p>
								<ul>
									<li>'.$errors.'</li>
								</ul>
							</div>';
					}
					?>
					<form method="post" action="/instore_php/index.php?r=playlists/add_style_persentage&id=<?php echo $model->id; ?>" id="playlists">
						<?php 
						$i = 0;
//print_r($styles_percentages);
						
						foreach($styles_percentages as $key => $styles_percentage)
						{
						?>						
							<div class="row">
								<label class="required" for="Playlists_name"><?= $styles[$styles_percentage['style']]?> (<?=$songs_count[$styles_percentage['style']]?>) <span class="required">*</span></label>									
								<input type="text" id="playlists_name_<?= $i?>" class="play_list_name" name="Playlists[style][<?= $key?>]" maxlength="5" size="60" value="<?=$styles_percentage['percentage']?>">			
							</div>
						<?php $i++; }?>
						<input type="hidden" class="length_class" name="last" value="<?=$i?>" >
						<div class="row buttons"> <input class="style_btn" type="submit" value="Save" name="yt0">	</div>					
					</form>
				</div>
				<div class="sub-menu">
				<?php 
				$this->widget('zii.widgets.CMenu', array(
						'items'=>array(
								array('label'=>'Add New', 'url'=>array('create')),
								array('label'=>'View', 'url'=>array('view&id='.$model->id)),
								array('label'=>'Edit', 'url'=>array('update&id='.$model->id)),
								array('label'=>'Manage', 'url'=>array('admin'),
								),									
						),
				));
				?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
<style>
input {
    border: 1px solid #33CCCC;
    padding: 10px;
    width: 45px;
}
.row {
margin-top: 10px;
float: left;
clear: left;
}
.form label {
width: 200px;
float: left;
}
</style>
<script type="text/javascript">
		$(document).ready(function() {
			$('.play_list_name').change(function(){
				length = $('.length_class').val();
				//alert(length);
				var total = 0;
				for(i=0; i< length; i++)
				{
					str1 = "#playlists_name_";
					id_style = str1.concat(i); 
					temp_val = $(id_style).val();
					if(temp_val == '') temp_val = 0;
					val_style = parseFloat(temp_val).toFixed(2);
					$(id_style).val(val_style);
					
					if(val_style == '') val_style = 0;
					if(i != length-1)
					{
						total = parseFloat(total) + parseFloat(val_style);
					}
				}	
				if(parseFloat(total) >= 100) alert('Sum of styles cannot exceed 100');
				else 
				{
					reminig = parseFloat(100) - parseFloat(total);
					$(id_style).val(reminig.toFixed(2)); 
				}							
			});
		});
</script>
