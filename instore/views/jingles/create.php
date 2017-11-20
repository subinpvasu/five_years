
<?php
/* @var $this JinglesController */
/* @var $model Jingles */

$this->breadcrumbs=array(
	'Jingles'=>array('index'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List Jingles', 'url'=>array('index')),
	array('label'=>'Manage Jingles', 'url'=>array('admin')),
);*/
?>
<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				<strong class="sub-ttl" style="color: #DA6C0B;
			    display: block;
			    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
			    z-index: auto; margin-left: 19%;">Create Jingles</strong>
				<?php $this->renderPartial('_form', array('model'=>$model,'upload_errors' => $upload_errors,'customers' => $customers)); ?>
			</div>
		</div>
	</div>
</div>