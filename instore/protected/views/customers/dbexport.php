<?php 
/* @var $this CustomersController */
/* @var $model Customers */
?>
<?php 
Yii::app()->getClientScript()->registerCoreScript('yii');
if(date('D') == 'Sun') $start_date = date('Y-m-d');
else $start_date = date('Y-m-d',strtotime('previous sunday'));
if(date('D') == 'Sat') $end_date = date('Y-m-d');
else $end_date = date('Y-m-d',strtotime('saturday this week')); 
$days = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
?>
<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				<strong class="sub-ttl" style="color: #DA6C0B;
			    display: block;
			    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
			    z-index: auto; margin-left: 19%;">Export Database</strong>
				<br />
				<br />
				<ol>
					<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=dbexport/songs">Export Songs Database</a> </li>
					<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=customers/playlist">Export Playlists Database</a> </li>
					<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=dbexport/customers">Export Customers Database</a> </li>
					
				</ol>
			</div>	
		</div>
	</div>
</div>
<style>
ol li {
margin-bottom: 10px;
}
ol li a {
text-decoration: none;
display: block;
}
ol li a:hover {
text-decoration: underline;
color: #0099FF;
    
}

}
</style>