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
			    z-index: auto;">Manage Customers</strong>
				<?php if(Yii::app()->user->hasFlash('error')):?>
					<div class="errorSummary" style="clear:left;">
						<p>Please fix the following :</p>
						<ul>
							<li>
								<?php echo Yii::app()->user->getFlash('error'); ?>
							</li>
						</ul>
					</div>
				<?php endif; ?>
				<?php
				$this->breadcrumbs=array(
						'Customers'=>array('index'),
						'Manage',
				);
				
				
				Yii::app()->clientScript->registerScript('search', "
						$('.search-button').click(function(){
						$('.search-form').toggle();
						return false;
				});
						$('.search-form form').submit(function(){
						$('#customers-grid').yiiGridView('update', {
						data: $(this).serialize()
				});
						return false;
				});
						");
				?>
				
				<p style="width:75%;">
					You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>,
					<b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) at the
					beginning of each of your search values to specify how the comparison
					should be done.
				</p>
				
				<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
				<div class="search-form" style="display: none">
					<?php $this->renderPartial('_search',array(
							'model'=>$model,
				)); ?>
				</div>
				<!-- search-form -->
				<?php
				$this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'customers-grid',
						'dataProvider'=>$model->search(),
						'filter'=>$model,
						'columns'=>array(
								'uid',
								//'ip',
								'company',
								'name',
								'city',
								'location',								
								'device',
								//'to',
								array('class'=>'CButtonColumn',
										'template'=>'{view} {update} {shedule} {suspend} {active} {delete} {push}',
										'buttons'=>array (
												'delete'=> array(
														'label'=> 'Delete',
														'url'=>'Yii::app()->request->baseUrl."/index.php?r=customers/delet&id=$data->id"',
														'imageUrl'=>'/instore_php/assets/2a00851d/gridview/delete.png',
														
												),
												'shedule'=> array(
														'label'=> 'Schedule',
														'url'=>'Yii::app()->request->baseUrl."/index.php?r=customers/chart&id=$data->id"',
														'imageUrl'=>'/instore_php/assets/2a00851d/gridview/profile.jpg',
												
												),
												'suspend'=> array(
														'label'=> 'Suspend',
														'url'=>'Yii::app()->request->baseUrl."/index.php?r=customers/suspend&id=$data->id"',
														'imageUrl'=>'/instore_php/assets/2a00851d/gridview/suspend.jpg',
														'visible'=>'($data->status==0)?false:true;',
														'options'=>array( 'class'=>'icon-edit' ),
														'click'=>'function(){return(window.confirm("Are you sure you want to suspend this user"))}',
												),
												'active'=> array(
														'label'=> 'Activate',
														'url'=>'Yii::app()->request->baseUrl."/index.php?r=customers/activate&id=$data->id"',
														'imageUrl'=>'/instore_php/assets/2a00851d/gridview/activate.jpg',
														'visible'=>'($data->status==1)?false:true;',
														'options'=>array( 'class'=>'icon-edit1' ),
														'click'=>'function(){return(window.confirm("Are you sure you want to activate this user"))}',
												),
												'push'=> array(
														'label'=> 'Send push notification',
														'url'=>'Yii::app()->request->baseUrl."/index.php?r=gsm/connect&id=$data->id"',
														'imageUrl'=>'/instore_php/assets/fb3c15eb/gridview/push.jpg',
												
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
									array('label'=>'Default Schedule', 'url'=>array('chart')),
									),
					));
					?>	
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
