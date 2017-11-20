<?php
/* @var $this StyleController */
/* @var $model Style */

$this->breadcrumbs=array(
	'Styles'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Style', 'url'=>array('index')),
	array('label'=>'Create Style', 'url'=>array('create')),
	array('label'=>'View Style', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Style', 'url'=>array('admin')),
);
?>
<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				
				<strong class="sub-ttl" style="color: #DA6C0B;
				    display: block;
				    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
				    z-index: auto; margin-left: 19%;">Update Style #<?php echo $model->name; ?></strong>
					<?php $this->renderPartial('_form', array('model'=>$model)); ?>
					<div class="sub-menu">	
						<?php 
						$this->widget('zii.widgets.CMenu', array(
								'items'=>array(
										//array('label'=>'List Style', 'url'=>array('index')),
										array('label'=>'Create Style', 'url'=>array('create')),
										array('label'=>'View Style', 'url'=>array('view', 'id'=>$model->id)),
										array('label'=>'Manage Style', 'url'=>array('admin')),
								),
						));
						?>	
				</div>
			</div>
		</div>
	</div>
</div>