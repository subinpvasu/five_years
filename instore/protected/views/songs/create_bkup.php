<?php
/* @var $this SongsController */
/* @var $model Songs */

$this->breadcrumbs=array(
	'Songs'=>array('index'),
	'Create',
);
?>
<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				<strong class="sub-ttl" style="color: #DA6C0B;
			    display: block;
			    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
			    z-index: auto; margin-left: 19%;">Add New Song</strong>
				<?php 
				$form = $this->beginWidget(
				    'CActiveForm',
				    array(
				        'id' => 'upload-form',
				        'enableAjaxValidation' => false,
				        'htmlOptions' => array('enctype' => 'multipart/form-data'),
				    )
				);
				// ...
				//echo $form->labelEx($model, 'song');
				echo $form->fileField($model, 'song',array('accept'=>'audio/*'));
				
				// ...
				echo '<div class="row buttons">';
		
				echo CHtml::submitButton('Submit');
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
		</div>
	</div>
</div>
<style>
<style>
label {
float:left;
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
</style></style>