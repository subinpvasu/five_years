
<?php
/* @var $this CustomersController */
/* @var $dataProvider CActiveDataProvider */
?>
<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				<strong class="sub-ttl" style="color: #DA6C0B;
			    display: block;
			    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
			    z-index: auto;">Customers</strong>
			
				<?php
				
				/*$this->breadcrumbs=array(
						'Customers',
				);
				//echo 'Sub menu';
				$this->menu=array(
						array('label'=>'Create Customers', 'url'=>array('create')),
						array('label'=>'Manage Customers', 'url'=>array('admin')),
				);*/
				?>	
				<?php $this->widget('zii.widgets.CListView', array(
						'dataProvider'=>$dataProvider,
						'itemView'=>'_view',
				)); ?>
				<div class="sub-menu">	
					<?php 
					$this->widget('zii.widgets.CMenu', array(
							'items'=>array(
									array('label'=>'Create Customers', 'url'=>array('create')),
									array('label'=>'Manage Customers', 'url'=>array('admin'),
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