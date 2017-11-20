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
			    z-index: auto; text-align:center;">Style Control - <?php echo $model->name; ?></strong>
				<?php 
				$average_songs_per_hour = 16;
				$days_pl = 7;
				$week_pl = 4;
				$style_list = array('none');
				$song_styles = array();
				$str_remove = array('{','}');
				$error = array();
				
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
						$song_styles[$current_style] = array('name' => $style_list[$current_style], 'percentage' => $style_percentages[$model->id.'_'.$current_style]);						
				 		else $song_styles[$current_style] = array('name' => $style_list[$current_style], 'percentage' => 0);;
				 	}
					else $song_styles[$current_style] = $style_list[$current_style];
				 } 
				 if(isset($_POST) && !empty($_POST))
				{
					//print_r($_POST);
					if(isset($_POST['avg_songs_per_hour']) && $_POST['avg_songs_per_hour'] != '')
					{
						if(is_numeric($_POST['avg_songs_per_hour'])) $average_songs_per_hour = $_POST['avg_songs_per_hour'];
					}
					else $error[] = 'Please enter a number on Average songs per hour';
					if(isset($_POST['days_pl']) && $_POST['days_pl'] != '')
					{
						if(is_numeric($_POST['days_pl'])) $days_pl = $_POST['days_pl'];
					}
					else $error[] = 'Please enter a number on Number of days';
					if(isset($_POST['week_pl']) && $_POST['week_pl'] != '')
					{
						if(is_numeric($_POST['week_pl'])) $week_pl = $_POST['week_pl'];
					}
					else $error[] = 'Please enter a number on Number of weeks';
					if(isset($_POST['style']) && !empty($_POST['style']))
					{
						foreach($song_styles as $style_id=>$style_details)
						{
							$song_styles[$style_id]['percentage'] = $_POST['style']['tag_'.$style_id];
						}
					}
				}
				 ?>
				<form method="post" action="/instore_php/index.php?r=playlists/style&id=<?php echo $model->id; ?>" id="playlists_sel">
					
					<div class="style_controll_main">
						<div class="style_inner_50" >Playlist ID : <?=$model->id?></div>
						<div class="style_inner_50">Playlist name : 
							<select id="playlists">
								<?php
								foreach($all_playlists as $selectd_playlist)
								{
									if($selectd_playlist['id'] != $model->id)
									{
										echo '<option value="'.$selectd_playlist['id'].'">'.$selectd_playlist['name'].'</option>';
									}
									else 
									{
										echo '<option value="'.$selectd_playlist['id'].'" selected="selected">'.$selectd_playlist['name'].'</option>';
									}
								}
								?>	
							</select>
						</div>	
							
						<div class="style_inner_40">Average songs per hour <input type="text" name="avg_songs_per_hour" value="<?=$average_songs_per_hour?>"></div>
						<div class="style_inner_30">Number of days <input type="text" name="days_pl" value="<?=$days_pl?>"></div>
						<div class="style_inner_30">Number of weeks <input type="text" name="week_pl" value="<?=$week_pl?>"></div>
						<div class="style_inner_100">
						<div class="style_inner_10">Style percentage</div>
							<div class="style_inner_90">
								<div class="style_inner_45"><div class="style_inner_15">Style Id</div><div class="style_inner_15">Style Name</div><div class="style_inner_15" style="width:35%;">Style %</div></div>
									<?php
									
									if(count($song_styles) >= 1) echo '<div class="style_inner_45"><div class="style_inner_15">Style Id</div><div class="style_inner_15">Style Name</div><div class="style_inner_15" style="width:35%;">Style %</div></div>';											
									$style_numbers = 0;
										foreach($song_styles as $style_id => $style_setails)
										{
											echo '<div class="style_inner_45"><div class="style_inner_15">'.$style_id.'</div><div class="style_inner_15">'.$style_setails['name'].'</div><div class="style_inner_15" style="width: 35%;border-right: 2px solid white; border-bottom: 2px solid white; height: 43px;padding-top: 1.5%; margin: auto;"><input type="text" class="play_list_name" style="padding=20px;" id="playlists_name_'.$style_numbers.'" name="style[tag_'.$style_id.']" value='.$style_setails['percentage'].'></div></div>';
											$style_numbers = $style_numbers+1;
										}
									?>
									<input type="hidden" class="length_class" name="last" value="<?=$style_numbers?>" >
								</div>
							</div>
							<div class="style_inner_100" style="border:none;"><input class="style_btn" type="submit" style="width: 100px;border-radius: 12px;" value="Check" name="yt0"></div>
						
						
					
					
				</form>
			
						<div class="style_inner_results">
						<div class="style_inner_30 style_type" style="border:none;width:5%;"><div style="width: 300px;">Day</div></div>
						<div class="style_inner_70">
						<?php
		
							$style_names_for_table = '';
							$style_percentages_for_table = '';
							$number_of_songs_for_table = '';
							echo '<table class="playlist_compination_view"><tbody>';
							
							foreach($song_styles as $style_id => $style_setails)
							{
							  $total_songs_in_style = 0;
								if(isset($style_songs['style_'.$style_id]) && !empty($style_songs['style_'.$style_id]))
								{
									$all_songs_in_playlist_style = $style_songs['style_'.$style_id];
									foreach($all_songs_in_playlist_style as $selected_songs_in_playlist_style)
									{
										$other_tag_exist = 0;
										foreach($song_styles as $style_id_check => $style_setails_check)
										{
											if(in_array($style_id_check,$selected_songs_in_playlist_style['styles']) && $style_id_check != $style_id) 
											{
												
												//print_r($selected_songs_in_playlist_style);
												$other_tag_exist = 1;
											}
											 
										}
										//echo $other_tag_exist;
										if($other_tag_exist == 0)
										{
											$total_songs_in_style = $total_songs_in_style + 1;
										}
									
									}
									
								}
								$song_styles[$style_id]['number_of_songs'] = $total_songs_in_style;
								$style_names_for_table .= '<td>'.$style_setails['name'].'</td>';
								$style_percentages_for_table .= '<td>'.$style_setails['percentage'].'</td>';
								$number_of_songs_for_table .= '<td>'.$total_songs_in_style.'</td>';
								
							}			
							echo '<tr><td><b>Styles</b></td>'.$style_names_for_table;
							echo '<tr><td><b>Percentage(%)</b></td>'.$style_percentages_for_table;
							echo '<tr style="background-color:#800000; color:#fff"><td><b>No of songs</b></td>'.$number_of_songs_for_table;
									
							echo '</tr>';
							for($i=1;$i<=24;$i++)
							{
								echo '<tr>';
									$cal_result = '';
									$repetation = '';
									foreach($song_styles as $style_id => $style_setails)
									{
										$repeted_cell = '';
										$equation_value = ($average_songs_per_hour * $style_setails['percentage']* $i)/100;
										if(isset($style_songs['style_'.$style_id]) && !empty($style_songs['style_'.$style_id]))
										{
											$total_tag_songs = $style_setails['number_of_songs'];
										}
										else $total_tag_songs = 0;
										if($total_tag_songs < ceil($equation_value))
										{
											$repetation = 'style="color:red;"';
											$repeted_cell = 'style="color:red;"';
										}
										$cal_result .= '<td '.$repeted_cell.'>'.$equation_value.'</td>';
									}	
									echo '<td '.$repetation.'><b>'.$i.'</b></td>';
									echo $cal_result;
								echo '</tr>';
							}
							echo '</tbody></table>';?>
						</div>
						</div>
						<div class="style_inner_results">
						<div class="style_inner_30 style_type" style="border:none;width:5%;"><div style="width: 300px;"> <?=$days_pl?> Days</div></div>
						<div class="style_inner_70">
						<?php
						
							$style_names_for_table = '';
							$style_percentages_for_table = '';
							$number_of_songs_for_table = '';
							echo '<table class="playlist_compination_view"><tbody>';
							
							foreach($song_styles as $style_id => $style_setails)
							{
								$style_names_for_table .= '<td>'.$style_setails['name'].'</td>';
								$style_percentages_for_table .= '<td>'.$style_setails['percentage'].'</td>';
								if(isset($style_songs['style_'.$style_id]) && !empty($style_songs['style_'.$style_id]))
								{
									$number_of_songs_for_table .= '<td>'.$style_setails['number_of_songs'].'</td>';
								}
								else $number_of_songs_for_table .= '<td> 0 </td>';
							}
							echo '<tr><td><b>Styles</b></td>'.$style_names_for_table;
							echo '<tr><td><b>Percentage(%)</b></td>'.$style_percentages_for_table;
							echo '<tr style="background-color:#800000; color:#fff"><td><b>No of songs</b></td>'.$number_of_songs_for_table;
									
							echo '</tr>';
							for($i=1;$i<=24;$i++)
							{
								echo '<tr>';
									$cal_result = '';
									$repetation = '';
									foreach($song_styles as $style_id => $style_setails)
									{
										$repeted_cell = '';
										$equation_value = ($average_songs_per_hour * $style_setails['percentage']* $i* $days_pl)/100;
										if(isset($style_songs['style_'.$style_id]) && !empty($style_songs['style_'.$style_id]))
										{
											$total_tag_songs = $style_setails['number_of_songs'];
										}
										else $total_tag_songs = 0;
										if($total_tag_songs < ceil($equation_value))
										{
											$repetation = 'style="color:red;"';
											$repeted_cell = 'style="color:red;"';
										}
										$cal_result .= '<td '.$repeted_cell.'>'.$equation_value.'</td>';
									}	
									echo '<td '.$repetation.'><b>'.$i*$days_pl.'</b></td>';
									echo $cal_result;
								echo '</tr>';
							}
							echo '</tbody></table>';?>
						</div>
						</div>
						<div class="style_inner_results">
						<div class="style_inner_30 style_type" style="border:none;width:5%;" ><div style="width: 300px;"><?=$week_pl?> Weeks</div></div>
						<div class="style_inner_70">
						<?php
						
							$style_names_for_table = '';
							$style_percentages_for_table = '';
							$number_of_songs_for_table = '';
							echo '<table class="playlist_compination_view"><tbody>';
							
							foreach($song_styles as $style_id => $style_setails)
							{
								$style_names_for_table .= '<td>'.$style_setails['name'].'</td>';
								$style_percentages_for_table .= '<td>'.$style_setails['percentage'].'</td>';
								if(isset($style_songs['style_'.$style_id]) && !empty($style_songs['style_'.$style_id]))
								{
									$number_of_songs_for_table .= '<td>'.$style_setails['number_of_songs'].'</td>';
								}
								else $number_of_songs_for_table .= '<td> 0 </td>';
							}
							echo '<tr><td><b>Styles</b></td>'.$style_names_for_table;
							echo '<tr><td><b>Percentage(%)</b></td>'.$style_percentages_for_table;
							echo '<tr style="background-color:#800000; color:#fff"><td><b>No of songs</b></td>'.$number_of_songs_for_table;
									
							echo '</tr>';
							for($i=1;$i<=24;$i++)
							{
								echo '<tr>';
									$cal_result = '';
									$repetation = '';
									foreach($song_styles as $style_id => $style_setails)
									{
										$repeted_cell = '';
										$equation_value = ($average_songs_per_hour * $style_setails['percentage']* $i * $week_pl * 7)/100;
										if(isset($style_songs['style_'.$style_id]) && !empty($style_songs['style_'.$style_id]))
										{
											$total_tag_songs = $style_setails['number_of_songs'];
										}
										else $total_tag_songs = 0;
										if($total_tag_songs < ceil($equation_value))
										{
											$repetation = 'style="color:red;"';
											$repeted_cell = 'style="color:red;"';
										}
										$cal_result .= '<td '.$repeted_cell.'>'.$equation_value.'</td>';
									}	
									echo '<td '.$repetation.'><b>'.($i*$week_pl* 7).'</b></td>';
									echo $cal_result;
								echo '</tr>';
							}
							echo '</tbody></table>';?>
						</div>
						</div>
					</div>	
					</div>
					</div>
					<?php 
				/*
				<div class="sub-menu">	
				$this->widget('zii.widgets.CMenu', array(
						'items'=>array(
								array('label'=>'Add New', 'url'=>array('create')),
								array('label'=>'Edit', 'url'=>array('update&id='.$model->id)),
								array('label'=>'Manage', 'url'=>array('admin'),
								),									
						),
				));
			</div>	*/
				?>		
				<div class="clear"></div>
		</div>
		
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
.style_controll_main {
width:100%;
float:left;
background-color:#ADD8E6;
}
.style_inner_100{
	width:99%;
	float:left;
	border: 2px solid white;
	margin:10px 3.5px 10px 3.5px;  
	text-align:center;
	line-height: 50px;
}
.style_inner_90{
	width:88%;
	float:left;
	border-left: 1px solid white;
	margin:0px 3.5px 0px 3.5px;  
	text-align:center;
	
}
.style_inner_50{
	width:49%;
	float:left;
	height: 50px;
    border: 1px solid white;
	margin:10px 3.5px 10px 3.5px;  
	text-align:center;
	line-height: 50px;
}
.style_inner_40{
	width:39%;
	float:left;
	height: 50px;
    border: 1px solid white;
	margin:10px 3.5px 10px 3.5px;  
	text-align:center;
	line-height: 50px;
}
.style_inner_45{
	width:50%;
	float:left;
	height: 50px;
    text-align:center;
	line-height: 50px;
}
.style_inner_30{
	width:29%;
	float:left;
	height: 50px;
    border: 1px solid white;
	margin:10px 3.5px 10px 3.5px;  
	text-align:center;
	line-height: 50px;
}
.style_inner_70{
	width: auto;
    max-width: 94%;
	float:left;
	border-left: 2px solid white;
	overflow-x: scroll;
	
}
.style_inner_results{
	width:99%;
	float:left;
	border: 2px solid white;
	margin:10px 3.5px 10px 3.5px;  	
}

.style_inner_15{
	width:30%;
	float:left;	
    border: 1px solid white;
	text-align:center;
	line-height: 50px;
}
.style_inner_10{
	width:9%;
	float:left;	
	margin:10px 3.5px 10px 3.5px;  
	text-align:center;
	
}
input {
    padding: 10px;
    width: 100px;
    border: 1px solid #33CCCC;
}
table.playlist_compination_view {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#333333;
	border-width: 1px;
	border-color: #fff;
	border-collapse: collapse;
}
table.playlist_compination_view th {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #fff;
	
}
table.playlist_compination_view td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #fff;
	
}
.style_type {
    margin-top: 40%;
    font-size: 30px;
    font-weight: bold;
-webkit-transform: rotate(270deg);
    -moz-transform: rotate(270deg);
    -o-transform: rotate(270deg);
    -ms-transform: rotate(270deg);
    transform: rotate(270deg);
}
</style>
<script>
$( document ).ready(function() {
	$( "#playlists" ).change(function() {
		var playlists_id = $('#playlists option:selected').val();
	     window.location.replace("/instore_php/index.php?r=playlists/style&id=" + playlists_id);
	});
});
</script>
<script type="text/javascript">
		$(window).resize(function(){
 
 // windowWidth & windowHeight are automatically updated when the browser size is modified
});
		$(document).ready(function() {
			var windowWidth = $(window).width();
 var windowHeight = $(window).height();
 //alert(windowWidth);
			$('.play_list_name').change(function(){
				length = $('.length_class').val();
				//alert(length);
				var total = 0;
				for(i=0; i< length; i++)
				{
					str1 = "#playlists_name_";
					id_style = str1.concat(i); 
					temp_val = $(id_style).val();
					if(temp_val == '') temp_val = 0;
					val_style = parseFloat(temp_val).toFixed(2);
					$(id_style).val(val_style);
					
					if(val_style == '') val_style = 0;
					if(i != length-1)
					{
						total = parseFloat(total) + parseFloat(val_style);
					}
				}	
				if(parseFloat(total) >= 100) alert('Sum of styles cannot exceed 100');
				else 
				{
					reminig = parseFloat(100) - parseFloat(total);
					$(id_style).val(reminig.toFixed(2)); 
				}							
			});
		});
</script>