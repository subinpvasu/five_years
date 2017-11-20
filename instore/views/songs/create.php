<?php
/* @var $this SongsController */
/* @var $model Songs */

$this->breadcrumbs=array(
	'Songs'=>array('index'),
	'Create',
);
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/multyfile/jquery.MultiFile.js" type="text/javascript" language="javascript"></script>
<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				<strong class="sub-ttl" style="color: #DA6C0B;
			    display: block;
			    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
			    z-index: auto; margin-left: 19%;">Add New Song</strong>
				<div class="error" style="width: 70%;margin-left: 4%;">
					<?php if(!empty($insert_error))
					{
						echo '<div class="errorSummary"><p>Some songs could not be upload:</p><ul>';
						//print_r($insert_error);
						foreach($insert_error as $single_error) echo '<li>'.$single_error.'<li>';
						echo '</ul></div>';
					}
					?>
				</div>
				
				<?php 
				$form = $this->beginWidget(
				    'CActiveForm',
				    array(
				        'id' => 'upload_form1',
				        'enableAjaxValidation' => false,
				        'htmlOptions' => array('enctype' => 'multipart/form-data'),
				    )
				);
				// ...
				//echo $form->labelEx($model, 'song');
				//echo $form->fileField($model, 'song',array('accept'=>'audio/*','multiple' => 'true'));
				echo '<input id="ytSongs_song" type="hidden" value="" name="Songs[song][]">';
				echo '<input type="file" id="Songs_song" name="song[]" multiple="multiple" accept="audio/*">';
				echo '<img src="/instore_php/images/ajax-loader.gif" id="uploading_image">';
				echo '<div class="tag_container">';
				foreach($styles as $style):
				// ...?>
				<div class="tags_checkbox">
					<input type="checkbox" name="styles[]" value="<?=$style->id?>" ><?=$style->name?><br>
				</div>

				<?php
				endforeach;
				echo '</div>';
				echo '<div class="row buttons" style="margin-left: 3%;" >';
		
				echo CHtml::submitButton('Submit',array('id' => 'upload_btn'));
				$this->endWidget();
				echo '</div>';
				echo $form->error($model, 'song');
				?>
				
				<div class="sub-menu">	
					<?php 
					$this->widget('zii.widgets.CMenu', array(
							'items'=>array(
									array('label'=>'Manage Songs', 'url'=>array('admin'),
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
#upload_form1 {
width:70%;
float:left;
}
.tag_container {
width: 100%;
float: left;
padding-left: 5%;
}
label {
    float: left;
    margin-left: 32px;
    width: 100px;
}
input {
margin-left:5%;
float: left;
}
.buttons input {
float:left;
} 
.row {
    float:left;
	clear:left;
	height: 30px;
}
.check1 {
float:left;
width:100px;
}
.errorMessage {
    color: #FF0000;
    float: left;
    margin-left: 5%;
    width: 70%;
}
.sub-menu {
float : right;
}
.tags_checkbox {
	float: left;
    width: 33%;
    font-size: 16px;
    margin-bottom: 10px;
	}
#uploading_image {
float: left;
margin-left: 33px;
display: none;
}
</style>
<script>
  
  // obtain input element through DOM 
  $('#upload_btn').click(function(){
	  	//var str = "The rain  in SPAIN stays mainly in the plain"; 
	  	$('.error').html('');
	  	file = document.getElementById('Songs_song').files;
		len = file.length;
		numberof_error = 0;
		files_with_comma = 0;
		if(file.length < 1)
		{
			$('.error').html('<div class="errorSummary"><p>Please fix the following input errors:</p><ul><li>Please select a song.</li></ul></div>');
			numberof_error = 1;
			return false;
		}
		if(file.length > 50)
		{
			$('.error').html('<div class="errorSummary"><p>Please fix the following input errors:</p><ul><li>Maximum upload limit is 50.</li></ul></div>');
			numberof_error = 1;
			return false;
		}
		for (i=0; i < len; i++) {
			file_name = file[i].name;
			var res = file_name.match(/,/);
			if(res != null)
			{
				$('.error').html('<div class="errorSummary"><p>Please fix the following input errors:</p><ul><li>Files with , in name not allowed.</li></ul></div>');
				numberof_error = 1;
				return false;
			}
			
		}
		if(numberof_error == 0) {
			$('#uploading_image').show();
			}
		
		//else if()
		
  });
  //var file = document.getElementById('file').files[0];
  
</script>