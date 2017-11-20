<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
		'Login',
);
?>
<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
			<strong class="sub-ttl" style="color: #DA6C0B;
    display: block;
    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
    z-index: auto;">New password</strong>

				<div class="form">
					<?php $form=$this->beginWidget('CActiveForm', array(
							'id'=>'login-form',
							'enableClientValidation'=>true,
							'clientOptions'=>array(
									'validateOnSubmit'=>true,
							),
				)); ?>
				
					<p class="note">
						Fields with <span class="required">*</span> are required.
					</p>
					<?php if(isset($error) && $error != '')
						{
							echo $error;
						} ?>
					<div class="row">
						<?php echo $form->labelEx($model,'password'); ?>
						<?php echo $form->passwordField($model,'password'); ?>
						<?php echo $form->error($model,'password'); ?>
					</div>
					<div class="row">
						<?php echo $form->labelEx($model,'confirm_password'); ?>
						<?php echo $form->passwordField($model,'confirm_password'); ?>
						<?php echo $form->error($model,'confirm_password'); ?>
					</div>
					<div class="row buttons">
						<?php echo CHtml::submitButton('Reset'); ?>
					</div>
				
					<?php $this->endWidget(); ?>
				</div>
				<!-- form -->
			</div>
		</div>
	</div>		
</div>
