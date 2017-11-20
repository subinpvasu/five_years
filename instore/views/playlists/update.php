<?php
/* @var $this PlaylistsController */
/* @var $model Playlists */

$this->breadcrumbs=array(
	'Playlists'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
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
			    z-index: auto; margin-left: 19%;">Update Playlists - <?php echo $model->name; ?></strong>
				<?php $this->renderPartial('_form', array('model'=>$model,'styles' => $styles)); ?>
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
			<div class="clear"></div>
		</div>
	</div>
</div>
