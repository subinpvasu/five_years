<?php
/* @var $this StyleController */
/* @var $model Style */

$this->breadcrumbs=array(
	'Styles'=>array('index'),
	$model->name,
);
?>
<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				
				<strong class="sub-ttl" style="color: #DA6C0B;
				    display: block;
				    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
				    z-index: auto; margin-left: 19%;">View Style #<?php echo $model->name; ?></strong>
				    <?php $this->widget('zii.widgets.CDetailView', array(
					'data'=>$model,
					'attributes'=>array(
						'id',
						'name',
					),
				)); ?>
				<div class="sub-menu">	
						<?php 
						$this->widget('zii.widgets.CMenu', array(
								'items'=>array(
										array('label'=>'Create', 'url'=>array('create')),
										array('label'=>'Edit', 'url'=>array('update', 'id'=>$model->id)),
										array('label'=>'Manage', 'url'=>array('admin')),
								),
						));
						?>	
				</div>
			</div>
		</div>
	</div>
</div>
<style>
.last {
float:left;
width:20%;
}
</style>
