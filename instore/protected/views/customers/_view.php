<?php
/* @var $this CustomersController */
/* @var $data Customers */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('uid')); ?>:</b>
	<?php echo CHtml::encode($data->uid); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('company')); ?>:</b>
	<?php echo CHtml::encode($data->company); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('city')); ?>:</b>
	<?php echo CHtml::encode($data->city); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('location')); ?>:</b>
	<?php echo CHtml::encode($data->location); ?>
	<br /> <b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php $status = CHtml::encode($data->status); 
	if($status == 1) echo 'Active'; else echo 'Suspended';
	?>
	<br />	
	<b><?php echo CHtml::encode($data->getAttributeLabel('device')); ?>:</b>
	<?php echo CHtml::encode($data->device); ?>
	<br />
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('to')); ?>:</b>
	<?php echo CHtml::encode($data->to); ?>
	<br />

	*/ ?>

</div>
