<?php
/* @var $this StyleController */
/* @var $model Style */

$this->breadcrumbs=array(
	'Styles'=>array('index'),
	'Create',
);
?>
<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				<strong class="sub-ttl" style="color: #DA6C0B;
			    display: block;
			    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
			    z-index: auto; margin-left: 19%;">Add Style</strong>
				<?php $this->renderPartial('_form', array('model'=>$model)); ?>
			
				<div class="sub-menu">	
						<?php 
						$this->widget('zii.widgets.CMenu', array(
								'items'=>array(
										//array('label'=>'List Style', 'url'=>array('index')),
										array('label'=>'Manage Styles', 'url'=>array('admin'),
										),									
								),
						));
						?>	
				</div>
			</div>
		</div>
	</div>
</div>