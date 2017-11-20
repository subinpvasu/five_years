<?
// Command for create daily schedule
class TestCommand extends CConsoleCommand { 
//public $layout='//layouts/plane';
	public function run($args) { // Main function, Innitiate scheduling
		$command = Yii::app()->db->createCommand();
		$command->delete('tbl_playedsong', 'played_date=:played_date', array(':played_date'=>date('y-m-d'))); // delete todys songs from lastplayed db
		$customer_models = Customers::model()->findAll(); // Select all customers
		$getID3 = new getID3; // Class to find ID3 tags of a song
		$log = ' Schedule cron stared'."\r\n";
		foreach($customer_models as $customer_model)
		{
			$now_added = array();
			$now_added_song_time = array();
			$path = Yii::getPathOfAlias('webroot')."/songs/schedule/".$customer_model->uid;
			// Create customer directory if not exist
			if (!file_exists($path)) { 
				mkdir(Yii::getPathOfAlias('webroot').'/songs/schedule/'.$customer_model->uid, 0777);
			}
			$id = $customer_model->id; // select id of customer
			$jingle_list = array();
			$ads_list = array();
			$no_of_advt = $customer_model->ad_no;
			$advt_gaps = $customer_model->ad_gap;
			$jing_gap = $customer_model->jingle_gap;
			$condition = '`customer_id` = '.$id.' AND `type` = 1';
			$jingles_array = Jingles::model()->findAll(array('condition'=> $condition));
			if(!empty($jingles_array)) // create jingle array
			{
				foreach($jingles_array as $jingle_array)
				{
					$f = Yii::getPathOfAlias('webroot').'/ads-jingles/'.$jingle_array->path;
					$a = $getID3->analyze($f);
					if(!empty($a) && array_key_exists('playtime_string',$a) && $a['playtime_string'] != '')
					{
						$time_length = $a['playtime_string'];
						$playlenth_array = explode(':',$a['playtime_string']);
						$time_length_sec = $playlenth_array[0] * 60 + $playlenth_array[1];
							
					}
					else 
					{
						$time_length = '0:30';
						$time_length_sec = 30;
					}
					$jing_array = array('title'=>$jingle_array->tittle, 'path'=>$jingle_array->path,'time'=>$time_length,'time_sec'=>$time_length_sec,'type'=>'jing');		
					array_push($jingle_list,$jing_array); 
				}
			}
			$condition = '`customer_id` = '.$id.' AND `type` = 0';
			$ads_array = Jingles::model()->findAll(array('condition'=> $condition));
			if(!empty($ads_array)) // create ads array
			{
				foreach($ads_array as $add_array)
				{
					$f = Yii::getPathOfAlias('webroot').'/ads-jingles/'.$add_array->path;
					$a = $getID3->analyze($f);
					if(!empty($a) && array_key_exists('playtime_string',$a) && $a['playtime_string'] != '')
					{
						$time_length = $a['playtime_string'];
						$playlenth_array = explode(':',$a['playtime_string']);
						$time_length_sec = $playlenth_array[0] * 60 + $playlenth_array[1];
							
					}
					else 
					{
						$time_length = '0:30';
						$time_length_sec = 30;
					}
					$jing_array = array('title'=>$add_array->tittle, 'path'=>$add_array->path,'time'=>$time_length,'time_sec'=>$time_length_sec, 'type'=>'ad');
					array_push($ads_list,$jing_array);
				}
			}
			$ads_and_jing = array('ad_gap' => $advt_gaps, 'jing_gap'=>$jing_gap, 'adds'=>$ads_list, 'jingles' => $jingle_list);
			$current_playlist_songs = array();
			$current_playlist_songs_dtls = array();
			$str_remove = array('{','}');
			$songs_ist = array();
			$all_songs = Songs::model()->findAll();
			foreach($all_songs as $songs)
			{
				$song_styles = explode(',',str_replace($str_remove,'',$songs->style));
				$song_name = str_replace( ',', '-', $songs->name );
				array_push($songs_ist,array('id'=>$songs->id,'name' => $song_name,'styles' =>$song_styles,'length'=> $songs->song_length, 'path' => $songs->path));
			}
			echo '<pre>';
			$yesterday_date = date("Y-m-d", strtotime("yesterday"));
			$condition = "`uid` = $id AND `played_date` >= '$yesterday_date'";
			$get_last_playlists = Playedsong::model()->findAll(array('condition'=> $condition));
			if($customer_model->uid == 1005) print_r($get_last_playlists);
			$last_played_songs = array();
			$last_played_songs_temp = array();
			//create array of songs played yesterday
			if(!empty($get_last_playlists))
			{
				foreach($get_last_playlists as $get_last_playlist)
				{
					if(!in_array($get_last_playlist->song,$last_played_songs_temp)) $last_played_songs_temp[] = $get_last_playlist->song;
				}
			}
			$days = array('sun','mon','tue','wed','thu','fri','sat');
			$days1 = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
			$today_index = array_search(date('D'), $days1);
			$condition = '`uid` = '.$id;
			$get_chart_lists = Charts::model()->findAll(array('condition'=> $condition));	// get chart list for the customer		
			if (empty($get_chart_lists))
			{
				$condition = '`uid` = 0 ';
				$get_chart_lists = Charts::model()->findAll(array('condition'=> $condition));
			}
			$test_list = 0;
			$tested_index = 0;
			foreach($get_chart_lists as $get_chart_list) // Chart for each day
			{
				if(!empty($now_added)) 
				{
					$last_played_songs = $now_added; // yester day played songs are set as current for next day
					
				}
				if($get_chart_list->day == $today_index) 
				{
					
					$last_played_songs = $last_played_songs_temp;// set last day played song from db as todays song
					$palylist_for_today = 1;
				}
				else $palylist_for_today = 0;
				$now_added = array();
				$filename = Yii::getPathOfAlias('webroot')."/songs/schedule/".$customer_model->uid."/".$days[$get_chart_list->day].".csv";
				if(file_exists($filename))
				{
					unlink(Yii::getPathOfAlias('webroot')."/songs/schedule/".$customer_model->uid."/".$days[$get_chart_list->day].".csv");
				}
				$log .= 'File created for '.$days[$get_chart_list->day]."\r\n";
				$file = fopen($filename,"x+");
				$list = array('schedule', 'title', 'path', 'length','type');
				fputcsv($file, $list);				
				$playlists = explode(',',str_replace($str_remove,'',$get_chart_list->playlists));
				$time_slot = 0;
				$none_silence = array();
				if(!empty($playlists))
				{
					$user_day_styles = array();
					foreach($playlists as $key3=>$playlist)
					{
						$condition = '`id` = '.$playlist;
						$get_playlist_details = Playlists::model()->findAll(array('condition'=> $condition));
						if(empty($get_playlist_details))
						{
							$get_playlist_details = Playlists::model()->findAll(array('select'=>'*, rand() as rand','limit'=>'3','order'=>'rand'));
						}
						
						$tags = explode(',',str_replace($str_remove,'',$get_playlist_details[0]->style));
						if(count($tags) == 1 && $tags[0] == 0)
						{
							$time_slot++;
							continue;
						}
						else 
						{
							$avail_tags = array();
							foreach($tags as $attached_tag)
							{
								$condition = '`id` = '.$attached_tag;
								$get_avail_tags = Style::model()->findAll(array('condition'=> $condition));
								//echo count($get_avail_tags);
								if(count($get_avail_tags) != 0) {$avail_tags[] = $attached_tag;}
							}
							$tags = $avail_tags;
							$num = count($tags); 
							$max_compinations = array();
							$max_compinations = $tags;
							$tag_percentage = array();
							foreach($tags as $tag)
							{
								$condition = '`playlist` = '.$playlist.' AND `style`='.$tag;
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
							}
							$temp_sorted_songs = array();
							foreach($songs_ist as $single_song)
							{
								$temp_i = 0;
								for($temp_i=0;$temp_i<count($tag_order);$temp_i++)
								{
									$exist_dif = array_diff($tag_order[$temp_i]['style'], $single_song['styles']);
									$current_tag_song_temp = $tag_order[$temp_i]['style'][0];
									//print_r($current_tag);
									if(count($exist_dif) == 0)
									{
										$temp_sorted_songs[$current_tag_song_temp][] = $single_song;
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
							$scheduled_songs = $this->print_schedule_new($id,$temp_sorted_songs,$now_added,$last_played_songs,0,0,$filename,$time_slot,$file,$now_added_song_time,$ads_and_jing,0,$tested_index, $tag_order);
							//$now_added,$now_added_song_time,$time_played
							$now_added_song_time = $scheduled_songs[1];
							$time_played = $scheduled_songs[2];
							$now_added = $scheduled_songs[0];
							
						}
						
						//print_r($scheduled_songs['added_songs_time']);
						$time_slot++;
						
					}
					//print_r($now_added_song_time);
					fclose($file);
					$now_added_song_time = array();
				
				}
			}
			$log .= ' Select customer ID '.$customer_model->uid."\r\n";		
			$log_creation = New Createlog;
			$log  .= "Time : ".' - '.date("F j, Y, H:i:s ").PHP_EOL."\r\n".
			"Action : Cronjob updated schedule".PHP_EOL."\r\n".
			"Customer : All \r\n".
			"-------------------------".PHP_EOL."\r\n";
			$log_creation->create_log_msg($log);
			shell_exec('chmod -R 777  /var/www/instore_php/songs/schedule');
			shell_exec('chmod -R 777  /var/www/instore_php/debug_log');
			shell_exec('~/.dropbox-dist/dropboxd');	
			//exit;
		} // Customer selection ends
	} // Main function ends
	
	//function to create schedule
	private function print_schedule_new($id,$songs_percentage_list,$now_added=array(),$last_played=array(),$repet_order = 0,$completed_time=0,$filename,$time_slot,$file,$now_added_song_time,$ads_and_jing,$song_played_count = 0,$tested_index,$tag_orders)
	{
		//print_r($now_added_song_time);
		$add_gap = $ads_and_jing['ad_gap'];
		$jing_gap = $ads_and_jing['jing_gap'];
		$adds_list = $ads_and_jing['adds'];
		$jing_list = $ads_and_jing['jingles'];
		//$maxim_time = 3900;
		$time_played = $completed_time;
		$time_slot_in_minute = 3600 * $time_slot;
		$files = $file;	
		$secheduled_songs_to_print = array();
		foreach($tag_orders as $tag_order)
		{
			$percentage = $tag_order['percentage'];
			$selected_style = $tag_order['style'][0];
			$songs_list = array();
			if(array_key_exists($selected_style,$songs_percentage_list)) 
			{
				$songs_list = $songs_percentage_list[$selected_style];			
			}
			$maxim_time = (3900 * $percentage )/100;
			$time_played = 0;			
			//echo $maxim_time.'<br />';
			if(is_array($songs_list)&& count($songs_list)!=0 && !empty($songs_list))
			{
				if($time_played <= $maxim_time)
				{
					if(is_array($songs_list) && !empty($songs_list))
					{					
						shuffle($songs_list);
						foreach($songs_list as $song_selected)
						{	
							if($time_played <= $maxim_time)
							{
								if(!in_array($song_selected['id'],$now_added) && !in_array($song_selected['id'],$last_played))
								{
									array_push($now_added,$song_selected['id']);
									$secheduled_songs_to_print[] = array($time_slot,$song_selected['name'],$song_selected['path'],gmdate("i:s", $song_selected['length']),'song',$selected_style);
									if($tested_index == 1)
									{
										$song_played_model = new Playedsong;
										$song_played_model->uid = $id;
										$song_played_model->played_date = date('Y-m-d');
										$song_played_model->time_slot = $time_slot;
										$song_played_model->song = $song_selected['id'];
										$song_played_model->save();
									}
									$time_played = $time_played + $song_selected['length'];
									$now_added_song_time[$song_selected['id']] = $time_slot_in_minute + $time_played;
									$song_played_count = $song_played_count + 1;
									
								}
							}
						}
						
						
					}
				}
				if($time_played <= $maxim_time)
				{
					//echo '2nd loop';
					
					
					if(is_array($songs_list) && !empty($songs_list))
					{					
						shuffle($songs_list);
						foreach($songs_list as $song_selected)
						{		
							if($time_played <= $maxim_time)
							{
								if(!in_array($song_selected['id'],$now_added))
								{
									array_push($now_added,$song_selected['id']);
									$secheduled_songs_to_print[] = array($time_slot,$song_selected['name'],$song_selected['path'],gmdate("i:s", $song_selected['length']),'song',$selected_style);
									if($tested_index == 1)
									{
										$song_played_model = new Playedsong;
										$song_played_model->uid = $id;
										$song_played_model->played_date = date('Y-m-d');
										$song_played_model->time_slot = $time_slot;
										$song_played_model->song = $song_selected['id'];
										$song_played_model->save();
									}
									$time_played = $time_played + $song_selected['length'];
									$now_added_song_time[$song_selected['id']] = $time_slot_in_minute + $time_played;
									$song_played_count = $song_played_count + 1;
									
								}
							}
						}					
					}
				}
				if($time_played <= $maxim_time)
				{	
					a:
					{
						if(is_array($songs_list) && !empty($songs_list))
						{					
							shuffle($songs_list);
							foreach($songs_list as $song_selected)
							{
								if($time_played <= $maxim_time)
								{
									if(!in_array($song_selected['id'],$now_added)) 
									{
										array_push($now_added,$song_selected['id']);
										$secheduled_songs_to_print[] = array($time_slot,$song_selected['name'],$song_selected['path'],gmdate("i:s", $song_selected['length']),'song',$selected_style);
										if($tested_index == 1)
										{
											$song_played_model = new Playedsong;
											$song_played_model->uid = $id;
											$song_played_model->played_date = date('Y-m-d');
											$song_played_model->time_slot = $time_slot;
											$song_played_model->song = $song_selected['id'];
											$song_played_model->save();
											
										}
										$time_played = $time_played + $song_selected['length'];
										$now_added_song_time[$song_selected['id']] = $time_slot_in_minute + $time_played;
										$song_played_count = $song_played_count + 1;
									}
									else
									{
										$current_songs_id = $song_selected['id'];
										
										$current_song_last_song_played_time = 0;
										$current_song_last_song_played_time = $now_added_song_time[$current_songs_id];
										$current_selected_time = $time_slot_in_minute + $time_played;
										if(count($songs_list) >= 20)
										{
											$temp_last_song_played_plus_hour = $current_song_last_song_played_time + 3600;
											if($temp_last_song_played_plus_hour <= $current_selected_time)
											{
												$secheduled_songs_to_print[] = array($time_slot,$song_selected['name'],$song_selected['path'],gmdate("i:s", $song_selected['length']),'song',$selected_style);
												if($tested_index == 1)
												{
													$song_played_model = new Playedsong;
													$song_played_model->uid = $id;
													$song_played_model->played_date = date('Y-m-d');
													$song_played_model->time_slot = $time_slot;
													$song_played_model->song = $song_selected['id'];
													$song_played_model->save();
													
												}
												$time_played = $time_played + $song_selected['length'];
												$now_added_song_time[$song_selected['id']] = $time_slot_in_minute + $time_played;
												$song_played_count = $song_played_count + 1;
											}
										}
										else 
										{
											$secheduled_songs_to_print[] = array($time_slot,$song_selected['name'],$song_selected['path'],gmdate("i:s", $song_selected['length']),'song',$selected_style);
											if($tested_index == 1)
											{
												$song_played_model = new Playedsong;
												$song_played_model->uid = $id;
												$song_played_model->played_date = date('Y-m-d');
												$song_played_model->time_slot = $time_slot;
												$song_played_model->song = $song_selected['id'];
												$song_played_model->save();
												
											}
											$time_played = $time_played + $song_selected['length'];
											$now_added_song_time[$song_selected['id']] = $time_slot_in_minute + $time_played;
											$song_played_count = $song_played_count + 1;
										}
													
									}
			
									
									
								}	
							}
							
							
						}
						if($time_played <= $maxim_time)
						{
							goto a;
						}
					}
				}
			}
			//exit;
		}
		if(!empty($secheduled_songs_to_print))
			{
				shuffle($secheduled_songs_to_print);
				foreach($secheduled_songs_to_print as $secheduled_song_to_print)
				{
					fputcsv($file, $secheduled_song_to_print);
					if($jing_gap != 0 && $song_played_count != 0 && ($song_played_count % $jing_gap) ==0 && !empty($jing_list))
					{
						//$selected_jingle_id = array_rand($jing_list, 1);
						$samp_count = count($jing_list) - 1;
						if($samp_count != 0)
							$select_rand = rand(0,$samp_count);
						else $select_rand = 0;									
						$selected_jing = $jing_list[$select_rand];
						fputcsv($file, array($time_slot,$selected_jing['title'],$selected_jing['path'],$selected_jing['time'],$selected_jing['type'],''));
						$time_played = $time_played+$selected_jing['time_sec'];
					}
					elseif($add_gap != 0 && $song_played_count != 0 && ($song_played_count % $add_gap) ==0 && !empty($adds_list))
					{
						$samp_count = count($adds_list) - 1;
						if($samp_count != 0)
							$select_rand = rand(0,$samp_count);
						else $select_rand = 0;									
						$selected_add = $adds_list[$select_rand];
						fputcsv($file, array($time_slot,$selected_add['title'],$selected_add['path'],$selected_add['time'],$selected_add['type'],''));
						$time_played = $time_played+$selected_add['time_sec'];
					}
				}
				
			}
		return array($now_added,$now_added_song_time,$time_played,$maxim_time);	
		//exit;
	}
	//// Old function to create schedule
	private function print_schedule($id,$songs_percentage_list,$now_added,$last_played,$repet_order = 0,$completed_time=0,$filename,$time_slot,$file,$now_added_song_time,$ads_and_jing,$song_played_count = 0,$tested_index)
	{
		//echo $time_slot;
		//print_r($ads_and_jing);
		$add_gap = $ads_and_jing['ad_gap'];
		$jing_gap = $ads_and_jing['jing_gap'];
		$adds_list = $ads_and_jing['adds'];
		$jing_list = $ads_and_jing['jingles'];
		$maxim_time = 3900;
		$time_played = $completed_time;
		$time_slot_in_minute = 3600 * $time_slot;
		$files = $file;
		
		if($repet_order == 0)
		{
			foreach($songs_percentage_list as $songs_list)
			{
				//print_r($songs_list);
				if($time_played <= $maxim_time)
				{
					if(is_array($songs_list) && !empty($songs_list))
					{					
						shuffle($songs_list);
						foreach($songs_list as $song_selected)
						{	
							if($time_played <= $maxim_time)
							{
								if(!in_array($song_selected['id'],$now_added) && !in_array($song_selected['id'],$last_played))
								{
									array_push($now_added,$song_selected['id']);
									//echo $song_selected;
									//print_r($song_selected);
									fputcsv($file, array($time_slot,$song_selected['name'],$song_selected['path'],gmdate("i:s", $song_selected['length']),'song'));
									if($tested_index == 1)
									{
										$song_played_model = new Playedsong;
										$song_played_model->uid = $id;
										$song_played_model->played_date = date('Y-m-d');
										$song_played_model->time_slot = $time_slot;
										$song_played_model->song = $song_selected['id'];
										$song_played_model->save();
									}
									$time_played = $time_played + $song_selected['length'];
									$now_added_song_time[$song_selected['id']] = $time_slot_in_minute + $time_played;
									$song_played_count = $song_played_count + 1;
									if($jing_gap != 0 && $song_played_count != 0 && ($song_played_count % $jing_gap) ==0 && !empty($jing_list))
									{
										//$selected_jingle_id = array_rand($jing_list, 1);
										$samp_count = count($jing_list) - 1;
										if($samp_count != 0)
											$select_rand = rand(0,$samp_count);
										else $select_rand = 0;									
										$selected_jing = $jing_list[$select_rand];
										fputcsv($file, array($time_slot,$selected_jing['title'],$selected_jing['path'],$selected_jing['time'],$selected_jing['type']));
										$time_played = $time_played+$selected_jing['time_sec'];
									}
									elseif($add_gap != 0 && $song_played_count != 0 && ($song_played_count % $add_gap) ==0 && !empty($adds_list))
									{
										$samp_count = count($adds_list) - 1;
										if($samp_count != 0)
											$select_rand = rand(0,$samp_count);
										else $select_rand = 0;									
										$selected_add = $adds_list[$select_rand];
										fputcsv($file, array($time_slot,$selected_add['title'],$selected_add['path'],$selected_add['time'],$selected_add['type']));
										$time_played = $time_played+$selected_add['time_sec'];
									}
								}
							}
						}
						
						
					}
				}
			}
		}
		elseif($repet_order == 1)
		{
			//echo 'Step2';
			foreach($songs_percentage_list as $songs_list)
			{
			
				if($time_played <= $maxim_time)
				{
					if(is_array($songs_list) && !empty($songs_list))
					{					
						shuffle($songs_list);
						foreach($songs_list as $song_selected)
						{	
							if($time_played <= $maxim_time)
							{
								if(!in_array($song_selected['id'],$now_added))
								{
									array_push($now_added,$song_selected['id']);
									//echo $song_selected;
									//print_r($song_selected);
									fputcsv($file, array($time_slot,$song_selected['name'],$song_selected['path'],gmdate("i:s", $song_selected['length']),'song'));
									if($tested_index == 1)
									{
										$song_played_model = new Playedsong;
										$song_played_model->uid = $id;
										$song_played_model->played_date = date('Y-m-d');
										$song_played_model->time_slot = $time_slot;
										$song_played_model->song = $song_selected['id'];
										$song_played_model->save();
									}
									$time_played = $time_played + $song_selected['length'];
									$now_added_song_time[$song_selected['id']] = $time_slot_in_minute + $time_played;
									$song_played_count = $song_played_count + 1;
									if($jing_gap != 0 && $song_played_count != 0 && ($song_played_count % $jing_gap) ==0 && !empty($jing_list))
									{
										//$selected_jingle_id = array_rand($jing_list, 1);
										$samp_count = count($jing_list) - 1;
										if($samp_count != 0)
											$select_rand = rand(0,$samp_count);
										else $select_rand = 0;									
										$selected_jing = $jing_list[$select_rand];
										fputcsv($file, array($time_slot,$selected_jing['title'],$selected_jing['path'],$selected_jing['time'],$selected_jing['type']));
										$time_played = $time_played+$selected_jing['time_sec'];
									}
									elseif($add_gap != 0 && $song_played_count != 0 && ($song_played_count % $add_gap) ==0 && !empty($adds_list))
									{
										$samp_count = count($adds_list) - 1;
										if($samp_count != 0)
											$select_rand = rand(0,$samp_count);
										else $select_rand = 0;									
										$selected_add = $adds_list[$select_rand];
										fputcsv($file, array($time_slot,$selected_add['title'],$selected_add['path'],$selected_add['time'],$selected_add['type']));
										$time_played = $time_played+$selected_add['time_sec'];
									}
								}
							}
						}
						
						
					}
				}
			}
			
		}
		else
		{	
			foreach($songs_percentage_list as $songs_list)
			{
				if($time_played <= $maxim_time)
				{
					if(is_array($songs_list) && !empty($songs_list))
					{					
						shuffle($songs_list);
						foreach($songs_list as $song_selected)
						{	
							if($time_played <= $maxim_time)
							{
								$song_id_temp = $song_selected['id'];
								if(!in_array($song_selected['id'],$now_added)) array_push($now_added,$song_selected['id']);
								fputcsv($file, array($time_slot,$song_selected['name'],$song_selected['path'],gmdate("i:s", $song_selected['length']),'song'));
								if($tested_index == 1)
								{
									$song_played_model = new Playedsong;
									$song_played_model->uid = $id;
									$song_played_model->played_date = date('Y-m-d');
									$song_played_model->time_slot = $time_slot;
									$song_played_model->song = $song_selected['id'];
									$song_played_model->save();
									
								}
								//echo 'Song length = '.$song_selected['length'].'<br />';
								$time_played = $time_played + $song_selected['length'];
								//echo $time_played.'<br />';
								//echo $time_played.'<'.$maxim_time;
								$now_added_song_time[$song_selected['id']] = $time_slot_in_minute + $time_played;
								$song_played_count = $song_played_count + 1;
								if($jing_gap != 0 && $song_played_count != 0 && ($song_played_count % $jing_gap) ==0 && !empty($jing_list))
								{
									//$selected_jingle_id = array_rand($jing_list, 1);
									$samp_count = count($jing_list) - 1;
									if($samp_count != 0)
										$select_rand = rand(0,$samp_count);
									else $select_rand = 0;									
									$selected_jing = $jing_list[$select_rand];
									fputcsv($file, array($time_slot,$selected_jing['title'],$selected_jing['path'],$selected_jing['time'],$selected_jing['type']));
									$time_played = $time_played+$selected_jing['time_sec'];
								}
								elseif($add_gap != 0 && $song_played_count != 0 && ($song_played_count % $add_gap) ==0 && !empty($adds_list))
								{
									$samp_count = count($adds_list) - 1;
									if($samp_count != 0)
										$select_rand = rand(0,$samp_count);
									else $select_rand = 0;									
									$selected_add = $adds_list[$select_rand];
									fputcsv($file, array($time_slot,$selected_add['title'],$selected_add['path'],$selected_add['time'],$selected_add['type']));
									$time_played = $time_played+$selected_add['time_sec'];
								}
							}	
						}
						
						
					}
				}
			}
		}
		return array($now_added,$now_added_song_time,$time_played,$maxim_time);		
	}
} // Command ends
?>