<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				<strong class="sub-ttl" style="color: #DA6C0B;
			    display: block;
			    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
			    z-index: auto; margin-left: 19%;">Add Customers</strong>
				<?php
				/* @var $this CustomersController */
				/* @var $model Customers */
				
				$this->breadcrumbs=array(
						'Customers'=>array('index'),
						'Create',
				);
				
				/*$this->menu=array(
						array('label'=>'List Customers', 'url'=>array('index')),
						array('label'=>'Manage Customers', 'url'=>array('admin')),
				);*/
				?>
				
								
				<?php $this->renderPartial('_form', array('model'=>$model)); ?>
				<div class="sub-menu">	
					<?php 
					$this->widget('zii.widgets.CMenu', array(
							'items'=>array(
									array('label'=>'Add New', 'url'=>array('create')),
									array('label'=>'Manage', 'url'=>array('admin'),
									array('label'=>'Schedule default', 'url'=>array('chart')),
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