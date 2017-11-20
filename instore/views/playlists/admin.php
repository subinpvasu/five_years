<?php
/* @var $this PlaylistsController */
/* @var $model Playlists */

$this->breadcrumbs=array(
	'Playlists'=>array('index'),
	'Manage',
);
?>
<link href="/instore_php/assets/2a00851d/gridview/styles.css" type="text/css" rel="stylesheet">
<script src="/instore_php/assets/fe06d9da/jquery.ba-bbq.min.js" type="text/javascript"></script>
<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				<strong class="sub-ttl" style="color: #DA6C0B;
			    display: block;
			    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
			    z-index: auto; margin-left: 19%;">Manage Playlists</strong>
				<div class="search-form" style="">					
					<div class="wide form">
						<form id="yw0" action="/instore_php/index.php?r=playlists/admin" method="get">
							<div style=""><input type="hidden" value="playlists/admin" name="r"></div>
							<div class="row" style="width: 361px; float: left; line-height: 31px;">
								<label for="Customers_location" style="width: 100px;">Name</label>		
								<input name="Songs[name]" id="Customers_location" type="text" value="" style="margin-top: -6px;">
								
							</div>
							<div class="row buttons" style="float: left;width: auto;">
							<input type="submit" name="yt0" value="Search">	</div>

						</form>
					</div>
					<!-- search-form -->
				</div>
				<div class="grid-view" id="playlists-grid">
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

				
					<div class="summary"><?php $this->widget('CLinkPager', array('pages' => $pages,)) ?></div>
					<table class="items">
						<thead>
							<tr>
								<th id="playlists-grid_c1">Id</th>
								<th id="playlists-grid_c1">Name (Song Count)</th><th id="playlists-grid_c2">Styles (Compostion Percentage)</th>
								<th id="playlists-grid_c3" class="button-column">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
						<?php $style_list = array('none');
						$song_styles = array();
						$str_remove = array('{','}');
						foreach($styles as $style): 
							$style_list[$style->id] = $style->name;
						 endforeach; 
						 
						 $song_list_platlist = array();
						 //echo '<pre>';
						 foreach($models as $model)
						 {
							//echo 'Playlist = '.$model->name;
							$song_list_platlist[$model->id] = array();
						 	//print_r($model);
							 $song_styles = array();
							 $playlist_songs = array();
							 //$song_styles = $model->style;
							 $current_styles = explode(',',str_replace($str_remove,'',$model->style));
							 foreach($current_styles as $current_style)
							 {
							 	if(array_key_exists($current_style ,$style_list))
							 	if($style_list[$current_style] != 'none')
							 	{
							 		if(array_key_exists($model->id.'_'.$current_style,$style_percentages))
									$song_styles[$current_style] = $style_list[$current_style].'&nbsp;('.$style_percentages[$model->id.'_'.$current_style].'%)';
							 		else $song_styles[$current_style] = $style_list[$current_style].'&nbsp;(NA)';
							 	}
								else $song_styles[$current_style] = $style_list[$current_style];
							 }
							 foreach($current_styles as $current_style)
							 {
								if(array_key_exists($current_style ,$style_list))
								{
									if(array_key_exists('style_'.$current_style,$style_songs) && $current_style != 0)
									{									
										foreach($style_songs['style_'.$current_style] as $songs_in_style)
										{
											if(!in_array($songs_in_style,$song_list_platlist[$model->id]))
											{
												array_push($song_list_platlist[$model->id],$songs_in_style);
											}
										}
									}
								}
							 }
							 $number_of_songs = 0;
							 $number_of_songs = count($song_list_platlist[$model->id]);
							 //print_r();
							 ?>
							<tr class="odd">
								<td><?=$model->id?></td>
								<td><?=$model->name?> (<?=$number_of_songs?>)</td>
								<td><?=implode(', ',$song_styles)?></td>
								<td class="button-column">
									<a href="/instore_php/index.php?r=playlists/view&amp;id=<?=$model->id?>" title="View" class="view"><img alt="View" src="/instore_php/assets/d72ee74b/gridview/view.png"></a> 
									<a href="/instore_php/index.php?r=playlists/update&amp;id=<?=$model->id?>" title="Update" class="update"><img alt="Update" src="/instore_php/assets/d72ee74b/gridview/update.png"></a> 
									<a href="/instore_php/index.php?r=playlists/style&amp;id=<?=$model->id?>" title="Style Control" class="update"><img alt="Update" src="/instore_php/assets/2a00851d/gridview/profile.jpg"></a> 
									<?php if($model->id != 0) { ?><a href="/instore_php/index.php?r=playlists/delete&amp;id=<?=$model->id?>" title="Delete" class="delete"><img alt="Delete" src="/instore_php/assets/d72ee74b/gridview/delete.png"></a> <?php } ?>
								</td>
							</tr>
							<?php } 
					 ?>
						</tbody>
					</table>
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
				return confirm("Are you sure you want to delete this play list");
			});
			
		});
	</script>
