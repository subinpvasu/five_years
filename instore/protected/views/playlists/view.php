<?php
/* @var $this PlaylistsController */
/* @var $model Playlists */

$this->breadcrumbs=array(
	'Playlists'=>array('index'),
	$model->name,
);

?>
<link rel="stylesheet" type="text/css" href="/instore_php/assets/3095fbb/detailview/styles.css">
<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				<strong class="sub-ttl" style="color: #DA6C0B;
			    display: block;
			    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
			    z-index: auto; margin-left: 19%;">View Playlist - <?php echo $model->name; ?></strong>

				<?php 
				$style_list = array('none');
				$song_styles = array();
				$str_remove = array('{','}');
				
				foreach($styles as $style): 
					$style_list[$style->id] = $style->name;
				endforeach;
				$current_styles = explode(',',str_replace($str_remove,'',$model->style));
				foreach($current_styles as $current_style)
				 {
				 	if(array_key_exists($current_style ,$style_list))
				 	if($style_list[$current_style] != 'none')
				 	{
				 		if(array_key_exists($model->id.'_'.$current_style,$style_percentages))
						$song_styles[$current_style] = $style_list[$current_style].' ('.$style_percentages[$model->id.'_'.$current_style].'%)';
				 		else $song_styles[$current_style] = $style_list[$current_style].' (NA)';
				 	}
					else $song_styles[$current_style] = $style_list[$current_style];
				 }
				 $sample_songs_list_array = array();
				 foreach($current_styles as $current_styles)
				 {
					if(array_key_exists($current_styles ,$style_list))
					{
						if(array_key_exists('style_'.$current_styles,$style_songs) && !empty($style_songs['style_'.$current_styles]))
						{
							foreach($style_songs['style_'.$current_styles] as $selected_song)
							{
								if(!in_array($selected_song,$sample_songs_list_array)) array_push($sample_songs_list_array,$selected_song);
							}
						}
					}		
				 }
				 $style_tags = implode(', ',$song_styles);
				 $number_of_songs = 0;
				 if($model->id != 0 && $style_tags != 'none')
				 {
					$number_of_songs = count($sample_songs_list_array);
				 }
				$tittle = "Styles (Compostion Percentage)";
				if($number_of_songs != 0 && $model->id != 0)
				{
					$tags = array();
					$tags_samp = explode(',',str_replace($str_remove,'',$model->style));
					foreach($tags_samp as $tem_tag)
					{
						if(array_key_exists($tem_tag ,$style_list)) $tags[] = $tem_tag;
					}
					
					$num = count($tags); 
					$max_compinations = array();
					//The total number of possible combinations 
					$total = pow(2, $num);

					//Loop through each possible combination  
					for ($i = 1; $i < $total; $i++) {  
						$temp_order = '';
						//For each combination check if each bit is set 
						for ($j = 0; $j < $num; $j++) { 
						   //Is bit $j set in $i? 
							if (pow(2, $j) & $i) $temp_order .= $tags[$j] . ' ';      
						} 
						 $max_compinations[] = $temp_order;
					}
					$tag_percentage = array();
					foreach($tags as $tag)
					{
						$condition = '`playlist` = '.$model->id.' AND `style`='.$tag;
						$get_playlist_details = Stylepercentage::model()->findAll(array('condition'=> $condition));
						$tag_percentage[$tag] = $get_playlist_details[0]->percentage;
					}
					$playlist_combinations = array();
					foreach($max_compinations as $selected_compination)
					{
						$compination_total = 0;
						$trimmed  = trim($selected_compination);
						$comp_arrays = explode(' ', $trimmed);
						foreach($comp_arrays as $comp_array)
						{
							$compination_total = $compination_total + $tag_percentage[$comp_array];
						}
						$playlist_combinations[] = array('style' => $comp_arrays, 'percentage' => $compination_total);
					}
					//arsort($playlist_combinations);
					for($i=0;$i<count($playlist_combinations);$i++)
					{
						for($j=0;$j<count($playlist_combinations);$j++)
						{
							$temp123 = $playlist_combinations[$i];
							if($playlist_combinations[$i]['percentage'] > $playlist_combinations[$j]['percentage']) 
							{
								$playlist_combinations[$i] = $playlist_combinations[$j];
								$playlist_combinations[$j] = $temp123;
							}
						}
					}
					$tag_order = array();
					foreach($playlist_combinations as $playlist_combination)
					{
						$tag_order[] = $playlist_combination;
					};
					$temp_sorted_songs = array();
					foreach($songs_ist as $single_song)
					{
						$temp_i = 0;
						$select_song_styles = explode(',',str_replace($str_remove,'',$single_song->style));//$single_song->style;
						for($temp_i=0;$temp_i<count($tag_order);$temp_i++)
						{
							$exist_dif = array_diff($tag_order[$temp_i]['style'], $select_song_styles);
							if(count($exist_dif) == 0)
							{
								$temp_sorted_songs[$temp_i][] = $single_song->id;
								break;
							}
						}
						//exit;
					
					}
					$songs_in_current_playlist = 0;
					foreach($temp_sorted_songs as $temp_sorted_songs_in_styles)
					{
						if(!empty($temp_sorted_songs_in_styles)) $songs_in_current_playlist = $songs_in_current_playlist + count($songs_in_current_playlist);
					}
					ksort($temp_sorted_songs);
				}
				?>
				<table class="detail-view" id="yw0"><tbody><tr class="odd"><th>ID</th><td><?=$model->id?></td></tr>
<tr class="even"><th>Name</th><td><?=$model->name?></td></tr>
<tr class="odd"><th>Styles (Compostion  Percentage)</th><td><?=$style_tags?></td></tr>
<tr class="even"><th>Total songs</th><td><?=$number_of_songs?></td></tr>
<tr class="odd"><th>Combinations</th><td>

<?php 
if($number_of_songs != 0 && $model->id != 0)
{
	echo '<table class="playlist_compination_view"><tbody>';
	echo '<tr><th>Combination</th><th>Total percentage</th><th>Number of songs</th></tr>';
		foreach($tag_order as $order_key => $avai_order)
		{
			//$style_list[$current_style];
			$combination_song_count = 0;
			if(array_key_exists($order_key,$temp_sorted_songs)) $combination_song_count = count($temp_sorted_songs[$order_key]);
			$temp_tag_name = array();
			foreach($avai_order['style'] as $tag_names) $temp_tag_name[] =  $style_list[$tag_names];
			$tags_temp = implode(', ' , $temp_tag_name);
			//echo 'Total '.$avai_order['percentage'].'% Tags: '.$tags_temp.' avail songs: = '.$combination_song_count.'<br />';
			echo '<tr><td>'.$tags_temp.'</td><td>'.$avai_order['percentage'].'</td><td>'.$combination_song_count.'</td></tr>';
		}
	echo '</tbody></table>';
}
?></td></tr>
</tbody></table>
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
		<div class="clear"></div>
	</div>
</div>
</div>
<style>
.sub-menu {
margin-top:0px;}
table.detail-view th, table.detail-view td {
font-size: 0.9em;
border: 1px white solid;
padding: 0.3em 0.6em;
vertical-align: middle;
}
</style>