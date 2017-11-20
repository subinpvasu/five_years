<?php
/* @var $this JinglesController */
/* @var $model Jingles */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'jingles-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php
	$customer_list = array();
	foreach($customers as $customer)
	{
		$customer_list[$customer['id']] = $customer['company'];
	}
	//print_r($customer_list);	
	if(isset($upload_errors) && $upload_errors != '')
	{
		echo '<div class="errorSummary"><p>Please fix the following input errors:</p>
		<ul>';
		foreach($upload_errors as $upload_error)
		{
			echo '<li>'.$upload_error[0].'</li>';
		}
		echo '</ul></div>';
		//print_r($upload_errors);
	}
	else echo $form->errorSummary($model);
	
	?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'tittle'); ?>
		<?php echo $form->textField($model,'tittle',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'tittle'); ?>
	</div>
	<div class="row">
	<?php if($model->isNewRecord) {?>
	
		<label for="Jingles_path">File <span class="required">*</span></label>		
		<input type="file" id="Jingles_path" name="Jingles[upload]" maxlength="100" size="60">
		 <?php echo $form->error($model,'upload'); ?>			
	
	<?php }
	else {
		echo '<label for="Jingles_path">File</label>';
		
		echo '<video height="40px" width ="350px" style="object-fit:initial;" controls="" autoplay="" name="media"><source src="'.Yii::app()->request->baseUrl.'/ads-jingles/'.$model->path.'" type="audio/mpeg"></video>';
	}

	?>
	</div>
	<div class="row">	
		<label for="Jingles_type">Type</label>
		<div class="rad"><div class="radioArea"></div><input type="radio" value="1" name="Jingles[type]" class="outtaHere" <?php if($model->type == 1) echo 'checked="checked"'; ?>>	Jingle</div>
		<div class="rad"><div class="radioArea"></div><input type="radio" value="0" name="Jingles[type]" class="outtaHere" <?php if($model->type == 0) echo 'checked="checked"'; ?>>Ads</div>
						
	</div>
	<div class="row">
		<label for="Jingles_path">Customer <span class="required">*</span></label>
		<?php echo CHtml::dropDownList('Jingles[customer_id]', $model->customer_id, 
              $customer_list,
              array('empty' => '(Select a Customer)')); ?>
        <?php echo $form->error($model,'customer_id'); ?>
    </div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<style>
.radioArea, .radioAreaChecked {
    background: none;
    float: left;
    height: 16px;
    margin: none;
    overflow: hidden;
    width: 14px !important;
}
.row .outtaHere {
float: left;
left: 0px;
position: inherit;
width: 17px;
}
.rad {
float:left;
}
input[type="radio"] {
    width: 0px;
    float: none;
}

.row {
    float: left;
    margin-top: 10px;
    width: 100%;
}
.row select {
border: 1px solid #33CCCC;
    padding: 10px;
    width: 242px;
}
.media {
margin-top: 36px;
}
</style>
