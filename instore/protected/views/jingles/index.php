<?php
/* @var $this JinglesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Jingles',
);

$this->menu=array(
	array('label'=>'Create Jingles', 'url'=>array('create')),
	array('label'=>'Manage Jingles', 'url'=>array('admin')),
);
?>

<h1>Jingles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
