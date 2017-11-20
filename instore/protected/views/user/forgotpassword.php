<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Forgot';
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
			    z-index: auto; margin-left: 19%;">Forgot password</strong>
				<div class="form">
					<?php $form=$this->beginWidget('CActiveForm', array(
							'id'=>'login-form',
							'enableClientValidation'=>true,
							'clientOptions'=>array(
									'validateOnSubmit'=>true,
							),
				)); ?>
					<div class="row">
						<?php echo $form->labelEx($model,'email'); ?>
						<?php echo $form->textField($model,'email'); 
						if(isset($error) && $error != '')
						{
							echo $error;
						} ?>
				
						<?php echo $form->error($model,'email'); ?>
					</div>
					<div class="row buttons">
						<?php echo CHtml::submitButton('Reset'); ?>
					</div>
				
					<?php $this->endWidget(); ?>
					<?php if(Yii::app()->user->hasFlash('success')):?>
					    <div class="info">
					        <?php echo Yii::app()->user->getFlash('success'); ?>
					    </div>
					<?php endif; ?>
				</div>
				<!-- form -->
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
<style>
.buttons input {
    border-radius: 5px;
    float: left;
    margin-left: 14%;
    padding: 5px 10px;
    width: auto;
}
.info {
color: #008000;
    float: left;
    margin-left: 14%;
    width: 93%;
}
</style>