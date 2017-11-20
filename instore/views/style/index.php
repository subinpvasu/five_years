<?php
/* @var $this StyleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Styles',
);
?>
<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				<strong class="sub-ttl" style="color: #DA6C0B;
			    display: block;
			    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
			    z-index: auto; margin-left: 19%;">Styles</strong>
				<?php $this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$dataProvider,
					'itemView'=>'_view',
				)); ?>
				<div class="sub-menu">	
					<?php 
					$this->widget('zii.widgets.CMenu', array(
							'items'=>array(
									array('label'=>'Create Style', 'url'=>array('create')),
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
