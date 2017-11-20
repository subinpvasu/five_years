<?php 
/* @var $this CustomersController */
/* @var $model Customers */

?>
<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				<strong class="sub-ttl" style="color: #DA6C0B;
			    display: block;
			    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
			    z-index: auto; margin-left: 19%;">Update Customer
				<?php echo $model->uid; ?></strong>
				<?php
				
				$this->breadcrumbs=array(
						'Customers'=>array('index'),
						$model->id=>array('view','id'=>$model->id),
						'Update',
				);
				?>
				<?php $this->renderPartial('_form', array('model'=>$model)); ?>
				<div class="sub-menu">	
					<?php 
					$this->widget('zii.widgets.CMenu', array(
							'items'=>array(
									array('label'=>'Add New', 'url'=>array('create')),
									array('label'=>'View ', 'url'=>array('view', 'id'=>$model->id)),
									array('label'=>'Manage', 'url'=>array('admin')),
									array('label'=>'Schedule', 'url'=>array('chart','id'=>$model->id)),
																		
							),
					));
					?>	
				</div>					
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>