<?php 
/* @var $this CustomersController */
/* @var $model Customers */
?>

<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				<strong class="sub-ttl" style="color: #DA6C0B;
			    display: block;
			    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
			    z-index: auto;">View	<?php echo ucfirst($model->company); ?></strong>
				<?php
				$this->breadcrumbs=array(
						'Customers'=>array('index'),
						ucfirst($model->company),
				);
				?>
				<?php //print_r($model);
				if($model->status == 1) $status = 'Active'; else $status = 'Suspended'
				?>

				<?php $this->widget('zii.widgets.CDetailView', array(
						'data'=>$model,
						'attributes'=>array(
								'uid',
								'company',
								'name',
								'city',
								'location',
								array('label' => 'Status','value'=>$status),
								'ip',
								'device',
								//'to',
						),
				)); ?>
				<div class="sub-menu">	
				<?php 
				$this->widget('zii.widgets.CMenu', array(
						'items'=>array(
								array('label'=>'Add New', 'url'=>array('create')),
								array('label'=>'Edit ', 'url'=>array('update&id='.$model->id)),
								array('label'=>'Manage', 'url'=>array('admin')),
								array('label'=>'Schedule ', 'url'=>array('chart','id'=>$model->id)),
						),
				));
				?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>