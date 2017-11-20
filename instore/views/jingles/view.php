<?php
/* @var $this JinglesController */
/* @var $model Jingles */

$this->breadcrumbs=array(
	'Jingles'=>array('index'),
	$model->id,
);
?>
<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				<strong class="sub-ttl" style="color: #DA6C0B;
			    display: block;
			    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
			    z-index: auto; margin-left: 19%;"><?php echo $model->tittle; ?></strong>
				<?php 
				$upload_type = array(0=>'Advt', 1=> 'Jingle');
				if(array_key_exists($model->customer_id ,$customers))
				$customer =$customers[$model->customer_id];
				else $customer = 'NA';
				//$customer = $customers[$model->customer_id];
				$type = $upload_type[$model->type];
				$this->widget('zii.widgets.CDetailView', array(
					'data'=>$model,
					'attributes'=>array(
						//'id',
						'tittle',
						//'path',
						array
							(
									'name'=>'File',
									'type'=>'raw',
									'htmlOptions'=>array('style'=>'text-align: center'),
									//'value'=> "$type".'<object height="50" width="240px" data="'.Yii::app()->request->baseUrl.'/'.$model->path.'"></object>',
									'value'=>"$model->path".'<div style="width:100%;float:left;"><video height="40px" width ="350px" style="object-fit:initial;" controls="" autoplay="" name="media"><source src="'.Yii::app()->request->baseUrl.'/ads-jingles/'.$model->path.'" type="audio/mpeg"></video></div>',
							),
						array
							(
									'name'=>'type',
									'type'=>'raw',
									'htmlOptions'=>array('style'=>'text-align: center'),
									//'value'=> "$type".'<object height="50" width="240px" data="'.Yii::app()->request->baseUrl.'/'.$model->path.'"></object>',
									'value'=>"$type",
							),
						array
							(
									'name'=>'Customer',
									'htmlOptions'=>array('style'=>'text-align: center'),
									'value'=> "$customer",
							),
					),
				)); ?>
				<div class="sub-menu">	
				<?php 
				$this->widget('zii.widgets.CMenu', array(
						'items'=>array(
								array('label'=>'Add New', 'url'=>array('create')),
								array('label'=>'Edit', 'url'=>array('update&id='.$model->id)),
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
<script>
controls.setAttribute('style', 'padding-top: 32px;');
</script>