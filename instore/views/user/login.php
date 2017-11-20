<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>
<style>
	#footer {
	margin-top : 0px;
	}
</style>
<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
			<strong class="sub-ttl" style="color: #DA6C0B;
    display: block;
    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
    z-index: auto;">My Instore Radio</strong>
				<div class="page-ttl"><h1>Login</h1></div>
				<div class="clear"></div>
				<div style="padding:10px" class="txt">				
					<div class="form">
						<?php $form=$this->beginWidget('CActiveForm', array(
						'id'=>'login-form',
						'enableClientValidation'=>true,
						'clientOptions'=>array(
						'validateOnSubmit'=>true,
						),
						)); ?>
							<p class="note">Fields with <span class="required">*</span> are required.</p>
							<div class="row">
								<?php echo $form->labelEx($model,'username'); ?>
								<?php echo $form->textField($model,'username',array('id'=>'user_login','class'=>'input')); ?>
								<?php echo $form->error($model,'username'); ?>
							</div>
							<div class="row">
								<?php echo $form->labelEx($model,'password'); ?>
								<?php echo $form->passwordField($model,'password',array('id'=>'user_login','class'=>'input')); ?>
								<?php echo $form->error($model,'password'); ?>
							</div>
							
							<div class="row rememberMe">
								<?php echo $form->checkBox($model,'rememberMe'); ?>
								<?php echo $form->label($model,'rememberMe'); ?>
								<?php echo $form->error($model,'rememberMe'); ?>
							</div>
							<div class="row buttons" style="float: left;padding-left: 15%; width: 100%;">
								<?php echo CHtml::submitButton('Login'); ?>
							</div>
							<?php echo CHtml::link('Forgot password',array('user/forgotpassword')); ?>
						<?php $this->endWidget(); ?>
					</div>
			</div>
		</div>
	</div>		
</div>
<style>
.buttons input {
margin-left:0px;
}						
</style>