<?php
/* @var $this StyleController */
/* @var $model Style */

$this->breadcrumbs=array(
	'Styles'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#style-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<style>
.grid-view .filters input, .grid-view .filters select {
width:75%;
}
</style>
<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				<strong class="sub-ttl" style="color: #DA6C0B;
			    display: block;
			    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
			    z-index: auto; margin-left: 19%;">Manage Styles</strong>
				<p>
				You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
				or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
				</p>
				
				<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
				<div class="search-form" style="display:none">
				<?php $this->renderPartial('_search',array(
					'model'=>$model,
				)); ?>
				</div><!-- search-form -->
				
				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'style-grid',
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					'columns'=>array(
						'id',
						'name',
						array(
							'class'=>'CButtonColumn',
							'template'=>'{view} {update} {delete} ',
										'buttons'=>array (
												'delete'=> array(
														'label'=> 'Delete',
														'url'=>'Yii::app()->request->baseUrl."/index.php?r=style/delete&id=$data->id"',
														'imageUrl'=>'/instore_php/assets/2a00851d/gridview/delete.png',
														'visible'=>'($data->name == "Royalty free")?false:true;',
														
												),
												
										),
						),
					),
				)); ?>
				<div class="sub-menu">	
					<?php 
					$this->widget('zii.widgets.CMenu', array(
							'items'=>array(
									array('label'=>'Add New', 'url'=>array('create')),
									),
					));
					?>	
				</div>	
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
