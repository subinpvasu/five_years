<?php
/* @var $this JinglesController */
/* @var $model Jingles */

$this->breadcrumbs=array(
	'Jingles'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#jingles-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				<strong class="sub-ttl" style="color: #DA6C0B;
			    display: block;
			    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
			    z-index: auto; margin-left: 19%;">Manage Jingles</strong>
				<?php 
				$upload_type = array(0=>'Advt', 1=> 'Jingle');?>
				<div class="grid-view" id="jingles-grid">
					<table class="items">
						<thead>
							<tr>
								<th id="jingles-grid_c0">Title</th>
								<th id="jingles-grid_c1">File</th>
								<th id="jingles-grid_c2">Customer</th>
								<th id="jingles-grid_c2">Type</th>
								<th id="jingles-grid_c3" class="button-column">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($models as $model)
							{ 
							//print_r($model);
								?>
								<tr class="odd">
									<td><?=$model->tittle?></td>
									<td><?=$model->path?></td>
									<td>
										<?php 
										if(array_key_exists($model->customer_id ,$customers))
										echo $customers[$model->customer_id];
										else echo 'NA';
										?>
									</td>
									<td style="text-align: center"><?=$upload_type[$model->type]?></td>
									<td class="button-column">
										<a href="/instore_php/index.php?r=jingles/view&amp;id=<?=$model->id?>" title="View" class="view">
											<img alt="View" src="/instore_php/assets/2a00851d/gridview/view.png">
										</a> 
										<a href="/instore_php/index.php?r=jingles/update&amp;id=<?=$model->id?>" title="Update" class="update">
											<img alt="Update" src="/instore_php/assets/2a00851d/gridview/update.png">
										</a> 
										<a href="/instore_php/index.php?r=jingles/delete&amp;id=<?=$model->id?>" title="Delete" class="delete">
											<img alt="Delete" src="/instore_php/assets/2a00851d/gridview/delete.png">
										</a>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
					<?php $this->widget('CLinkPager', array(
					    'pages' => $pages,
					)) ?>
				</div>
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
<script type="text/javascript">
		$(document).ready(function() {
				$('.delete').on("click", null, function(){
					return confirm("Are you sure you want to delete this item");
				});
				
		});
	</script>
<link type="text/css" rel="stylesheet"
	href="<?php echo Yii::app()->request->baseUrl; ?>/assets/2a00851d/gridview/styles.css" />