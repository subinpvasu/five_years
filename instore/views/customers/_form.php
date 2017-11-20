<?php
/* @var $this CustomersController */
/* @var $model Customers */
/* @var $form CActiveForm */
?>

<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'customers-form',
			// Please note: When you enable ajax validation, make sure the corresponding
			// controller action is handling ajax validation correctly.
			// There is a call to performAjaxValidation() commented in generated controller code.
			// See class documentation of CActiveForm for details on this.
			'enableAjaxValidation'=>false,
	)); ?>

	<p class="note">
		Fields with <span class="required">*</span> are required.
	</p>

	<?php echo $form->errorSummary($model); ?>
	<?php //print_r($model);?>
	<div class="row">
		<?php echo $form->labelEx($model,'company'); ?>
		<?php echo $form->textField($model,'company',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'company'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'vat'); ?>
		<?php echo $form->textField($model,'vat',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'vat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'shop_type'); ?>
		<?php echo $form->textField($model,'shop_type',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'shop_type'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'addresses'); ?>
		<?php echo $form->textField($model,'addresses',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'addresses'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city'); ?>
		<?php echo $form->textField($model,'city',array('size'=>60,'maxlength'=>75)); ?>
		<?php echo $form->error($model,'city'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'zip'); ?>
		<?php echo $form->textField($model,'zip',array('size'=>60,'maxlength'=>75)); ?>
		<?php echo $form->error($model,'zip'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'location'); ?>
		<?php echo $form->textField($model,'location',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'location'); ?>
	</div>
	<div class="row">
		<?php if($model->start_date == '0000-00-00') $model->start_date = ''; ?>
		<?php echo $form->labelEx($model,'start_date'); ?>
		<?php echo $form->textField($model,'start_date'); ?>
		<?php echo $form->error($model,'start_date'); ?>
	</div>
	<div class="row">
		<?php if($model->end_date == '0000-00-00') $model->end_date = ''; ?>
		<?php echo $form->labelEx($model,'end_date'); ?>
		<?php echo $form->textField($model,'end_date'); ?>
		<?php echo $form->error($model,'end_date'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<input type="radio" value="1" id="Customers_status"
			name="Customers[status]"
			<?php if($model->status == 1) echo 'checked="checked"';?>>Active <input
			type="radio" value="0" id="Customers_status" name="Customers[status]"
			<?php if($model->status == 0) echo 'checked="checked"';?>>Suspend
		<?php //echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'device'); ?>
		<?php echo $form->textField($model,'device'); ?>
		<?php echo $form->error($model,'device'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'team_viewer'); ?>
		<?php echo $form->textField($model,'team_viewer'); ?>
		<?php echo $form->error($model,'team_viewer'); ?>
	</div>
<?php /*
	<div class="row">
		<?php echo $form->labelEx($model,'to'); ?>
		<?php echo $form->textField($model,'to'); ?>
		<?php echo $form->error($model,'to'); ?>
	</div>
 */ ?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div>
<!-- form -->
<link
	rel="stylesheet" type="text/css"
	href="<?php echo Yii::app()->request->baseUrl; ?>/css/datepicker.css" />
<script
	type="text/javascript"
	src="<?php echo Yii::app()->request->baseUrl.'/js/datepick/jquery.js'; ?>"></script>
<script
	type="text/javascript"
	src="<?php echo Yii::app()->request->baseUrl.'/js/datepick/'; ?>datepicker.js"></script>
<script
	type="text/javascript"
	src="<?php echo Yii::app()->request->baseUrl.'/js/datepick/'; ?>eye.js"></script>
<script
	type="text/javascript"
	src="<?php echo Yii::app()->request->baseUrl.'/js/datepick/'; ?>layout.js?ver=1.0.2"></script>

<script>
	$('#Customers_start_date').DatePicker({
	format:'Y-m-d',
	date: $('#Customers_start_date').val(),
	starts: 1,
	position: 'r',
	onBeforeShow: function(){
		new_date = $('#Customers_start_date').val();
		//alert(new_date);
		$('#Customers_start_date').DatePickerSetDate($('#Customers_start_date').val(), false);
	},
	onChange: function(formated, dates){
		$('#Customers_start_date').val(formated);
			$('#Customers_start_date').DatePickerHide();
	}
});
$('#Customers_end_date').DatePicker({
	format:'Y-m-d',
	date: $('#Customers_end_date').val(),
	starts: 1,
	position: 'r',
	onBeforeShow: function(){
		$('#Customers_end_date').DatePickerSetDate($('#Customers_end_date').val(), false);
	},
	onChange: function(formated, dates){
		$('#Customers_end_date').val(formated);
			$('#Customers_end_date').DatePickerHide();
	}
});
</script>
