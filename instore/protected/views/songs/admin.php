<?php
/* @var $this SongsController */
/* @var $model Songs */

$this->breadcrumbs=array(
	'Songs'=>array('index'),
	'Manage',
);
//include "D:\New folder\htdocs\mp3\mp3file.php";
?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.tokeninput.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/token-input.css" media="screen" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/2a00851d/gridview/styles.css" type="text/css" rel="stylesheet">
<script type="text/javascript">
        $(document).ready(function() {
            $("#demo-input-prevent-duplicates").tokenInput("http://ubi-sound.eu/instore_php/index.php?r=songs/get_style", {
                preventDuplicates: true
            });
			var pathname = $(location).attr('href');
				var defalt_url = '&check_sel=all';
				var result= pathname.split('&');
				lastEl = result[result.length-1];
				
			$("#check_all").click(function(){
								//alert(defalt_url);
				if('&'+lastEl == defalt_url)
				{
					result.pop();
					defalt_url = '';
				}
				var final_url = result.join('&');
				var last_url = final_url+defalt_url;
				window.location.replace(last_url);
				//alert(last_url);
			//alert (pathname);
					
				
			});
			
        });
</script>

<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				<strong class="sub-ttl" style="color: #DA6C0B;
			    display: block;
			    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
			    z-index: auto; margin-left: 19%;">Manage Songs</strong>
				<div class="search-form" style="">
					
				<div class="wide form">
					<form id="yw0" action="/instore_php/index.php?r=songs/admin" method="get">
						<div style=""><input type="hidden" value="songs/admin" name="r"></div>
						<div class="row">
							<label for="Customers_location">Name</label>		
							<input name="name" id="Customers_location" type="text" value="<?=$search_name?>">	
						</div>
						<br />
						<div class="row">
							<label for="Customers_location">Style</label>		
							<input type="text" id="demo-input-prevent-duplicates" name="style" />
							<!-- <input name="Songs[style][]" id="Customers_location" type="text" value="10"> -->
						</div>
						
						<div class="row buttons">
						<input type="submit" name="yt0" value="Search">	</div>

					</form>
				</div>
<!-- search-form -->
				</div>
				<?php // $value = 'hii'?>
				
				<div class="grid-view" id="songs-grid">
				<?php if(Yii::app()->user->hasFlash('error')):?>
					<div class="errorSummary" style="clear:left;">
						<p>Please fix the following input errors:</p>
						<ul>
							<li>
								<?php echo Yii::app()->user->getFlash('error'); ?>
							</li>
						</ul>
					</div>
				<?php endif; 
				$style_list = array('none');
					$song_numbers = $curnt_page
				?>
				List <?=$song_numbers?>-<?php echo $song_numbers+count($models)-1;?> out of <?=$total_count?>
					<div class="summary"><?php $this->widget('CLinkPager', array(
    'pages' => $pages,
)) ?></div>
					<form id="yw0" action="/instore_php/index.php?r=songs/selected_action" method="post">
					<table class="items">
					<thead>
					<tr>
					<th id="songs-grid_c2"><input type="checkbox" id="check_all" name="checkall" <?=$song_selection?>  value="checkall"></th>
					<th id="songs-grid_c0">No</th>
					<th id="songs-grid_c0">Name</th>
					<th id="songs-grid_c1">Style</th>
					<th id="songs-grid_c2">Path</th>
					<th id="songs-grid_c3" class="button-column">&nbsp;</th></tr>
					</thead>
					<tbody>
					<?php 
					$song_numbers = $curnt_page;
					$song_styles = array();
					$str_remove = array('{','}');
					foreach($styles as $style): 
						$style_list[$style->id] = $style->name;
					 endforeach; 
					 foreach($models as $model)
					 {
						 $song_styles = array();
						 //$song_styles = $model->style;						 
						 $current_styles = explode(',',str_replace($str_remove,'',$model->style));
						 foreach($current_styles as $current_style)
						 {
						 if(array_key_exists($current_style ,$style_list))
						 	$song_styles[$current_style] = $style_list[$current_style];
						 	
						 }
						 ?>
						<tr class="odd">
							<td><div id="checkone_<?=$model->id?>"><input type="checkbox" <?=$song_selection?> name="Songs[song_id][]"  class="single_song_list" value="<?=$model->id?>" onclick="myFunction()"></div></td>
							<td><?=$song_numbers?></td>
							<td><a href="/instore_php/songs/<?=$model->path?>" title="Play" target="_blank"><?=$model->name?></a></td>
							
							<td><?=implode(', ',$song_styles)?></td>
							<td><?=$model->path?></td>
							<td class="button-column">
								<a href="/instore_php/index.php?r=songs/view&amp;id=<?=$model->id?>" title="View" class="view">
									<img alt="View" src="/instore_php/assets/2a00851d/gridview/view.png">
								</a>
								<a  href="/instore_php/index.php?r=songs/update&amp;id=<?=$model->id?>" title="Change styles" class="update">
									<img alt="Update" src="/instore_php/assets/2a00851d/gridview/update.png">
								</a> 
								<a href="/instore_php/index.php?r=songs/delet&amp;id=<?=$model->id?>" title="Delete" class="delete">
									<img alt="Delete" src="/instore_php/assets/2a00851d/gridview/delete.png">
								</a>
							</td>
						</tr>						
					<?php 
					unset($a);
					$song_numbers++;
					 } 
					 ?>
					</tbody>
					</table>
					<input type="hidden" name="redirect_url" value="<?php echo Yii::app()->request->url; ?>">
					<div style="float: left;margin-right: 10px;"><input type="submit" name="Songs[action]" class="delete" value="Delete" style="border-radius: 7px;width: 105px;"></div>
					<div style="float: left;margin-right: 10px;"><input type="submit" name="Songs[action]" value="Change style" style="border-radius: 7px;width: 105px;"></div>
					</form>
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
			$.fancybox.close(true);
				$('.fancybox').fancybox();
				$('.delete').on("click", null, function(){
					return confirm("Are you sure you want to delete selected songs");
				});
			
		});
		
	</script>
	<style type="text/css">
		.fancybox-custom .fancybox-skin {
			box-shadow: 0 0 50px #222;
		}
		.button-column ul {
		float: left;
		}
		.button-column li {
		float: left;
	    margin-left: 14px;
	    margin-right: -34px;
	    text-decoration: none;
		}
		.sub-menu {
		margin-top: -34px;
		} 
		.search-form .row {
		float:left;
		clear: left;
		width:50%;
		}
		.search-form .buttons {
		float:left;
		width:20%;
		}
		
	</style>