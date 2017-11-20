<?php
/* @var $this JinglesController */
/* @var $model Jingles */

$this->breadcrumbs=array(
	'Jingles'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);
?>
<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				<strong class="sub-ttl" style="color: #DA6C0B;
			    display: block;
			    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
			    z-index: auto; margin-left: 19%;">Update Jingles <?php echo $model->id; ?></strong>
				<?php $this->renderPartial('_form', array('model'=>$model,'upload_errors' => $upload_errors,'customers' => $customers)); ?>
				<div class="sub-menu">	
				<?php 
				$this->widget('zii.widgets.CMenu', array(
						'items'=>array(
								array('label'=>'Add New', 'url'=>array('create')),
								array('label'=>'View', 'url'=>array('view&id='.$model->id)),
								array('label'=>'Manage', 'url'=>array('admin'),
								),									
						),
				));
				?>

			</div>
			</div>
		</div>
	</div>
</div>