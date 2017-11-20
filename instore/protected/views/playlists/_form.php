<?php
/* @var $this PlaylistsController */
/* @var $model Playlists */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'playlists-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	<?php 
	$song_styles = array();
	$str_remove = array('{','}');
	$current_styles = explode(',',str_replace($str_remove,'',$model->style));
	?>
	<div class="row">
		<?php echo $form->labelEx($model,'style'); ?>
		<div class="style_list">
		<table class="listing_table">
		<?php
		$rowcount = 0;
		$tropen = 0;
		foreach($styles as $style): 
		if($rowcount%3 == 0) {echo '<tr>';$tropen = 1;}
			?>
			
			<td><input type="checkbox" name="Playlists[styles][]" value="<?=$style->id?>" <?php if(in_array($style->id,$current_styles)) echo 'checked';?>><?=$style->name?><br></td>
			
			<?php 
		if($rowcount%3 == 2) {echo '</tr>';$tropen = 0;}
		$rowcount++;
		endforeach;
		if($rowcount == 1) { echo '</tr>';$tropen = 0;$rowcount =0;}
		?>
		</table>
		</div>
		<?php echo $form->error($model,'style'); ?>
	</div>
	<div class="row">
		
		<?php //echo $form->textField($model,'style',array('size'=>60,'maxlength'=>150)); ?>
		
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<style>
	.tags_checkbox {
    float: left;
    font-size: 16px;
    margin-bottom: 5px;
    width: 33%;
}
	.inner #main .page-ttl {
	border-bottom:none;
	}
	a {
    color: #DA6C0B;
    text-decoration: none;
	}
	
	.row {
		float: left;
		margin-top: 10px;
		width: 100%;
	}
	.style_list {
	width:85%;
	float:left;
	}
	.listing_table tr {
	height :40px;
	}
	.listing_table td {
	width: 200px;
	border: 1px solid #33CCCC;
	padding: 5px;
	}
	.buttons input {
	margin-left: 14%;
	}
</style>