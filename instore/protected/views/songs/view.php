<?php
/* @var $this SongsController */
/* @var $model Songs */

$this->breadcrumbs=array(
	'Songs'=>array('index'),
	$model->name,
);

/* $this->menu=array(
	array('label'=>'List Songs', 'url'=>array('index')),
	array('label'=>'Create Songs', 'url'=>array('create')),
	array('label'=>'Update Songs', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Songs', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Songs', 'url'=>array('admin')),
);*/
?>
<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				<strong class="sub-ttl" style="color: #DA6C0B;
			    display: block;
			    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
			    z-index: auto; margin-left: 19%;">View Song <?php echo $model->name; ?></strong>
			    <?php
			    $style_list = array('none');
			    $song_styles = array();
			    $str_remove = array('{','}');
			    foreach($styles as $style): 
					$style_list[$style->id] = $style->name;
				endforeach;
				
				$current_styles = explode(',',str_replace($str_remove,'',$model->style));
				foreach($current_styles as $current_style)
				{
					if(array_key_exists($current_style ,$style_list)) 
					$song_styles[$current_style] = $style_list[$current_style];
				}
				$style_tags = implode(', ',$song_styles);
				//print_r($song_styles);
				$play = '<a href="/instore_php/songs/'.$model->path.'" title="Delete" target="_blank">Click to play</a>';
			    ?>
				<?php $this->widget('zii.widgets.CDetailView', array(
					'data'=>$model,
					'attributes'=>array(
						'id',
						'name',
							array
							(
									'name'=>'styles',
									'htmlOptions'=>array('style'=>'text-align: center'),
									'value'=> "$style_tags",
							),
							array
							(
									'name'=>'Play',
									'type'=>'raw',
									'htmlOptions'=>array('style'=>'text-align: center'),
									'value'=> "$play",
							),
								
						//'style',
						'path',
					),
				)); ?>
				<div class="sub-menu">	
					<?php 
					$this->widget('zii.widgets.CMenu', array(
							'items'=>array(
									//array('label'=>'List Customers', 'url'=>array('index')),
									array('label'=>'Add New', 'url'=>array('create')),
									array('label'=>'Change Tags', 'url'=>array('update&id='.$model->id)),
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
<script type="text/javascript">
	$(document).ready(function() {
		fancybox.cancel();
	});
</script>
<style>
.sub-menu {
margin-top:0px;
}
</style>