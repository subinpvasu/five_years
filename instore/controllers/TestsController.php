<?php

class TestsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column3';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
				'accessControl', // perform access control for CRUD operations
				'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
				array('allow',  // allow all users to perform 'index' and 'view' actions
						'actions'=>array('index','view', 'change_ip', 'return_playlist'),
						'users'=>array('*'),
				),
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions'=>array('create','update','chart','exportdb','playlist'),
						'users'=>array('@'),
				),
				array('allow', // allow admin user to perform 'admin' and 'delete' actions
						'actions'=>array('admin','delet','suspend','activate'),
						'users'=>array('admin'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id='')
	{
		if($id == '')
		{
			$this->redirect(array('site/notfound'));
		}
		$this->render('view',array(
				'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Customers;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Customers']))
		{
			$model->attributes=$_POST['Customers'];
			if($model->save())
			{
				$log_creation = New Createlog;
				$log  = "Time : ".' - '.date("F j, Y, H:i:s ").PHP_EOL."\r\n".
				"Action : New customer created".PHP_EOL."\r\n".
				"Customer ID : ".$model->uid.PHP_EOL."\r\n".
				"-------------------------".PHP_EOL."\r\n";
				$log_creation->create_log_msg($log);
				$this->redirect(array('chart','id'=>$model->id));
			}
		}

		$this->render('create',array(
				'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id = '')
	{
		if($id == '')
		{
			$this->redirect(array('site/notfound'));
		}
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Customers']))
		{
			$model->attributes=$_POST['Customers'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
				'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelet($id)
	{
		$model=$this->loadModel($id);
		$dir = Yii::getPathOfAlias('webroot')."/songs/schedule/".$model->uid;
		if(file_exists($dir))
		{
			//chmod($dir, 0755);
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					//chmod($dir.'/'.$object, 0755);
					if (filetype($dir."/".$object) == "dir") rmdir($dir."/".$object); else unlink($dir."/".$object);
				}
			}
			reset($objects);
			rmdir($dir);
			//rmdir(Yii::getPathOfAlias('webroot')."/songs/schedule/".$model->uid);
		}
		$this->loadModel($id)->delete();
		$condition = '`uid` = '.$id;
		Charts::model()->deleteAll(array('condition'=> $condition));
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	/* Function to suspend a purticular user */
	public function actionSuspend($id)
	{
		$model=$this->loadModel($id);
		if(isset($_GET['id']))
		{
			$model->updateByPk($model->id,array('status' => 0));
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		//if(!isset($_GET['ajax']))
			
	}
	public function actionActivate($id)
	{
		$model =$this->loadModel($id);
		if(isset($_GET['id']))
		{
			//$model->status=1;
			$model->updateByPk($model->id,array('status' => 1));
			//$model->save();
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		//if(!isset($_GET['ajax']))
			
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->redirect(array('admin'));
		$dataProvider=new CActiveDataProvider('Customers');
		$this->render('index',array(
				'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Customers('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Customers']))
			$model->attributes=$_GET['Customers'];

		$this->render('admin',array(
				'model'=>$model,
		));
	}
	public function actionChart($id='')
	{
		$error = array();
		$all_list = array();
		$error_tittle = '';
		$success_msg = '';
		$defalt_playlist_arry = array();
		$play_list_id_name_array = array();
		$days = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
		$str_remove = array('{','}');
		$uid = $id;
		if($uid == '') $uid = 0;
		$allplaylists = Playlists::model()->findAll();
		foreach($allplaylists as $single_playlist) 
		{
			array_push($defalt_playlist_arry,$single_playlist->id);
			$play_list_id_name_array[$single_playlist->id] = $single_playlist->id.' - '.$single_playlist->name;
		}
		$condition = '`uid` = '.$uid;
		$get_chart_lists = Charts::model()->findAll(array('condition'=> $condition));
		if (empty($get_chart_lists))
		{
			$condition = '`uid` = 0';
			$get_chart_lists = Charts::model()->findAll(array('condition'=> $condition));
		}
		if(!empty($get_chart_lists))
		{
			foreach($get_chart_lists as $get_chart_list)
			{
				//print_r($get_chart_list);
				$daychart_array = explode(',',str_replace($str_remove,'',$get_chart_list->playlists));
				foreach ($daychart_array as $key=>$timeslot)
				{
					$all_list[$get_chart_list->day.'_'.$key] = $timeslot;
				}
			}
		}
	if($id != '') 
		{
			$model =$this->loadModel($id);
			$customer_id_temp = $model->uid;
		}
		else 
		{
			$model = new Customers;
			$customer_id_temp = 'Default';
		}
		//exit;
		if(isset($_POST['list']))
		{
			$shedule = array();
			if($id != '')
			{
				$ad_no = $_POST['list']['ad_no'];
				$ad_gap = $_POST['list']['ad_gap'];
				$jingle_gap = $_POST['list']['jingle_gap'];
				if($ad_no == '')
				{
					$null_field_error = 'Number of Ads required<br />';
					//$null_field_error = 'Number of Ads must be number';
					array_push($error,$null_field_error);
				}
				elseif(!is_numeric($ad_no))
				{
					//$error_tittle .= '<br />';
					$null_field_error = 'Number of Ads must be number';
					array_push($error,$null_field_error);
				}
				if($ad_gap =='')
				{
					$null_field_error = 'Number of Tracks between Ads required<br />';
					//$null_field_error = 'Number of Ads must be number';
					array_push($error,$null_field_error);
				}
				elseif(!is_numeric($ad_gap))
				{
					$null_field_error = 'Number of Tracks between ads must be number<br />';
					array_push($error,$null_field_error);
				}
				if($jingle_gap =='')
				{
					$null_field_error = 'Number of Tracks between Jingles required<br />';
					array_push($error,$null_field_error);
				}
				elseif(!is_numeric($jingle_gap))
				{
					$null_field_error = 'Number of Tracks between Jingles must be number<br />';
					array_push($error,$null_field_error);
				}
			}
			$all_list = $_POST['list']['chart'];
			foreach($all_list as $key=>$single_list)
			{
				$key_array = explode('_',$key);
				$chart_day = $key_array[0];
				$chart_time = $key_array[1];
				//echo 'Day = '.$days[$chart_day].', Time = '.$chart_time.', Playlist = '.$single_list.'<br />';
				if($single_list == '')
				{ 	
					$null_field_error = $chart_time.' in '.$days[$chart_day].'  cannot be blank.';
					array_push($error,$null_field_error);
				}
				if(!in_array($single_list,$defalt_playlist_arry) && $single_list != '')
				{
					$null_field_error = 'Playlist '.$single_list.' on '.$chart_time.' '.$days[$chart_day].'  is not exist.';
					array_push($error,$null_field_error);
				}
				$curnt_vals[$chart_day][$chart_time] = $single_list;
			}
			if(empty($error))
			{
				if($id != '')
				{
					$model->updateByPk($id,array('ad_no' => $ad_no, 'ad_gap' => $ad_gap,'jingle_gap' => $jingle_gap));
				}
				
				foreach($curnt_vals as $key=>$curnt_val)
				{
						$play_list = '{'.implode(',',$curnt_val).'}';
						$condition = '`uid` = '.$uid.' AND `day` = '.$key;
						$list = Charts::model()->findAll(array('condition'=> $condition));
						if(empty($list))
						{						
							Charts::model()->setIsNewRecord(true);
							Charts::model()->id = null;
							Charts::model()->uid = $uid;
							Charts::model()->day = $key;
							Charts::model()->playlists = $play_list;
							Charts::model()->save();
							//echo 'Nothing';
						}
						else 
						{
							Charts::model()->updateByPk($list[0]->id,array('playlists' => $play_list));
						}						
				}
				$success_msg = 'Schedule updated successfully';
				if($id != '')
				{
					$model =$this->loadModel($id);
					$customer_id_temp = $model->uid;
				}
				else
				{
					$model = new Customers;
					$customer_id_temp = 'Default';
				}
				$log_creation = New Createlog;
				$log  = "Time : ".' - '.date("F j, Y, H:i:s ").PHP_EOL."\r\n".
				"Action : Schedule list updated".PHP_EOL."\r\n".
				"Customer : ".$customer_id_temp.PHP_EOL."\r\n".
				"-------------------------".PHP_EOL."\r\n";
				$log_creation->create_log_msg($log);
				shell_exec('~/.dropbox-dist/dropboxd');
				//$this->redirect(array('chart&id='.$id,'popup'=>'exit'));
				//$this->refresh();
			}
			else $error_tittle = 'Plese fix following error<br />';
		}
		
		$this->render('chart',array(
				'model'=>$model,
				'errors' => $error,
				'error_titte' => $error_tittle,
				'chart' => $all_list,
				'defalt_playlist_arry' => $defalt_playlist_arry,
				'success_msg' => $success_msg,
				'play_list_id_name_array' =>$play_list_id_name_array,
		));
	}
	public function actionChange_ip()
	{
		
		if(isset($_POST['ip']) && isset($_POST['uid']))
		{
			$model = new Customers;
			$condition = '`uid` = '.$_POST['uid'];
			$get_user = $model->findAll(array('condition'=> $condition));
			foreach($get_user as $user)
			{
				if($_POST['ip'] != $user->ip)
				{
					if($model->updateByPk($user->id,array('ip' => $_POST['ip'])))
					{
						$log_creation = New Createlog;
						$log  = "Time : ".' - '.date("F j, Y, H:i:s ").PHP_EOL."\r\n".
						"Action : Ip changed to ".$_POST['ip'].PHP_EOL."\r\n".
						"Customer ID : ".$user->uid.PHP_EOL."\r\n".
						"-------------------------".PHP_EOL."\r\n";
						$log_creation->create_log_msg($log);
						
						echo 'Updated';
					}
				}
				else echo 'Already exist';
			
			}
			
		}
		exit;
	}
public function actionReturn_playlist($id= '')
	{
	
	 	$log = '';
		if($id == '')
		{
			$this->redirect(array('admin'));
		}
		$condition = '`id` = '.$id;
		$customer_models = Customers::model()->findAll(array('condition'=> $condition));
		if(empty($customer_models))
		{
			$this->redirect(array('admin'));
		}
		$getID3 = new getID3;
		foreach($customer_models as $customer_model)
		{
			$path = Yii::getPathOfAlias('webroot')."/songs/schedule/".$customer_model->uid;
        	if (!file_exists($path)) {
        		mkdir(Yii::getPathOfAlias('webroot').'/songs/schedule/'.$customer_model->uid, 0777);
        	}
			$id = $customer_model->id;
			$jingle_list = array();
			$ads_list = array();
			$no_of_advt = $customer_model->ad_no;
			$advt_gaps = $customer_model->ad_gap;
			$jing_gap = $customer_model->jingle_gap;
			$condition = '`customer_id` = '.$id.' AND `type` = 1';
			$jingles_array = Jingles::model()->findAll(array('condition'=> $condition));
			if(!empty($jingles_array))
			{
				foreach($jingles_array as $jingle_array)
				{
					$f = Yii::getPathOfAlias('webroot').'/ads-jingles/'.$jingle_array->path;
					$a = $getID3->analyze($f);
					if(!empty($a) && array_key_exists('playtime_string',$a) && $a['playtime_string'] != '')
						$time_length = $a['playtime_string'];
					else $time_length = '0:30';
					$jing_array = array('title'=>$jingle_array->tittle, 'path'=>$jingle_array->path,'time'=>$time_length,'type'=>'jing');		
					array_push($jingle_list,$jing_array);
					//$time = 
				}
			}
			$condition = '`customer_id` = '.$id.' AND `type` = 0';
			$ads_array = Jingles::model()->findAll(array('condition'=> $condition));
			if(!empty($ads_array))
			{
				foreach($ads_array as $add_array)
				{
					$f = Yii::getPathOfAlias('webroot').'/ads-jingles/'.$add_array->path;
					$a = $getID3->analyze($f);
					if(!empty($a) && array_key_exists('playtime_string',$a) && $a['playtime_string'] != '')
						$time_length = $a['playtime_string'];
					else $time_length = '0:30';
					$jing_array = array('title'=>$add_array->tittle, 'path'=>$add_array->path,'time'=>$time_length,'type'=>'ad');
					array_push($ads_list,$jing_array);
					//$time =
				}
			}
			$played_advt = 0;
			$played_jing = 0;
			$current_playlist_songs = array();
			$current_playlist_songs_dtls = array();
			$lat_playedtime = strtotime("00:00:00");
			$str_remove = array('{','}');
			$songs_ist = array();
			$all_songs = Songs::model()->findAll();
			foreach($all_songs as $songs)
			{
				$song_styles = explode(',',str_replace($str_remove,'',$songs->style));
				if(!empty($song_styles))
				{
					foreach($song_styles as $song_style)
					{
						if(!array_key_exists($song_style,$songs_ist)) $songs_ist[$song_style] = array();
						array_push($songs_ist[$song_style],array('id'=>$songs->id,'name' => $songs->name,'length' => $songs->song_length, 'path' => $songs->path));
					}
				}
			}
			$str_remove = array('{','}');
			$condition = '`uid` = '.$id;
			$get_last_playlist = Lastplayed::model()->findAll(array('condition'=> $condition));
			if(!empty($get_last_playlist))
			{
				$last_plyed_songs = explode(',',str_replace($str_remove,'',$get_last_playlist[0]->songs));
			}
			else {
				$last_plyed_songs = array();
			}
			$days = array('sun','mon','tue','wed','thu','fri','sat');
			$days1 = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
			$today_index = array_search(date('D'), $days1);
			$condition = '`uid` = '.$id.' AND `day` >= '.$today_index;
			$get_chart_lists = Charts::model()->findAll(array('condition'=> $condition));
			
			if (empty($get_chart_lists))
			{
				$condition = '`uid` = 0 AND `day` >= '.$today_index;
				$get_chart_lists = Charts::model()->findAll(array('condition'=> $condition));
			}
			$test_list = 0;
			$tested_index = 0;
			foreach($get_chart_lists as $get_chart_list)
			{
			
				$tested_index++;
				if($tested_index == 1)
				{
					$command = Yii::app()->db->createCommand();
					$command->delete('tbl_playedsong', 'played_date=:played_date', array(':played_date'=>date('y-m-d')));
			
				}
				if($test_list >= 4)
				{
					break;
				}
				$test_list++;
				//echo $days[$get_chart_list->day];
				$filename = Yii::getPathOfAlias('webroot')."/songs/schedule/".$customer_model->uid."/".$days[$get_chart_list->day].".csv";
				if(file_exists($filename))
				{
					//chmod($filename, 0755);
					unlink(Yii::getPathOfAlias('webroot')."/songs/schedule/".$customer_model->uid."/".$days[$get_chart_list->day].".csv");
				}
				$log .= 'File created for '.$days[$get_chart_list->day]."\r\n";
				$file = fopen($filename,"x+");
				$list = array('schedule', 'title', 'path', 'length','type');
				fputcsv($file, $list);				
				$playlists = explode(',',str_replace($str_remove,'',$get_chart_list->playlists));
				if(!empty($playlists))
				{
					$user_day_styles = array();
					foreach($playlists as $key3=>$playlist)
					{
						$condition = '`id` = '.$playlist;
						$get_playlist_details = Playlists::model()->findAll(array('condition'=> $condition));
						if(empty($get_playlist_details))
						{
							//$condition = '`id` = 18';
							$get_playlist_details = Playlists::model()->findAll(array('select'=>'*, rand() as rand','limit'=>'3','order'=>'rand'));
						}
						
						$tags = explode(',',str_replace($str_remove,'',$get_playlist_details[0]->style));
						//print_r($tags);
						//exit;
						if(count($tags) == 1 && $tags[0] == 0)
						{
							continue;
						}
						//print_r($get_playlist_details);
						//exit;
						foreach($tags as $key2=>$tag)
						{
							$condition = '`playlist` = '.$playlist.' AND `style` = '.$tag;
							$style_percentages = Stylepercentage::model()->findAll(array('condition'=> $condition));
							if(empty($style_percentages) )
							{
								$percent = 100;
							}
							
							foreach($style_percentages as $style_percentages)
							$percent = $style_percentages->percentage;
							//echo $percent.'<br />';
							$mul = 60 * $percent;			
							$song_numbers = $mul / 100;
							if(array_key_exists($tag,$songs_ist)) 
							{
								foreach($songs_ist[$tag] as $key=>$songlist)
								{
									
									$f = Yii::getPathOfAlias('webroot').'/songs/'.$songlist['path'];
									$a = $getID3->analyze($f);
									if(!empty($a) && array_key_exists('playtime_string',$a) && $a['playtime_string'] != '')
									$songs_ist[$tag][$key]['length'] = '00:'.$a['playtime_string'];
									else $songs_ist[$tag][$key]['length'] = '00:2:00';
									$songs_ist[$tag][$key]['type'] = 'song';
								}
								
								$tags[$tag] = array();
								$tags[$tag]['list_of_songs']= $songs_ist[$tag];
								$tags[$tag]['no_of_songs'] = round($song_numbers);
							}
							else $tags[$tag] = 'no tag exist';
						}
						unset($tags[0]);
						$user_day_styles['time_'.$key3] = $tags;
						
					}
				
				}
				foreach ($user_day_styles as $key1=>$user_day_style)
				{				
					foreach ($user_day_style as $key=>$user_day_time)
					{ 
						if(is_array($user_day_time)) shuffle($user_day_time['list_of_songs']);
						$user_day_styles[$key1][$key] = $user_day_time;
					}
				}
				echo '<pre> maxo time';
						
				$user_day_song_list = array();
				$user_day_song_list_temp = array();
				$i=1;
				foreach($user_day_styles as $keys_all=>$user_day_style)
				{
					$maxtiome = strtotime("00:00:00");
					foreach($user_day_style as $user_day_tags)
					{	
						$total_time = strtotime("00:00:00");
						if(is_array ($user_day_tags))
						{
							if(array_key_exists('no_of_songs',$user_day_tags))
							{
								
								$pl_time = $user_day_tags['no_of_songs'];
								$maxtiome = strtotime( "00:00:00 +0 hours $pl_time minutes" );
								echo $maxtiome.'<br />';
							}
							
							if(is_array($user_day_tags['list_of_songs']))
							{
								$listsong_mixed_array = array();
								foreach($user_day_tags['list_of_songs'] as $user_day_songs)							
								{
									
									$inserted_into_array = 0;
									if($total_time < $maxtiome)
									{
										$key_temp = explode('_',$keys_all);
										$current_time_temp = str_pad($key_temp[1],2,"0",STR_PAD_LEFT);
										if(!in_array($user_day_songs['id'],$current_playlist_songs))
										{							
											if(!in_array($user_day_songs['id'],$last_plyed_songs))
											{
												$user_day_songs['last_played'] = strtotime("00:00:00");
												$user_day_songs['last_played_time'] = "00:00:00";
												$secs = strtotime($user_day_songs['length'])-strtotime("00:00:00");
												$total_time = $total_time+$secs;
												array_push($current_playlist_songs,$user_day_songs['id']);
												$lat_playedtime = $lat_playedtime + $secs;
												
												$current_playlist_songs_dtls[$user_day_songs['id']] = $lat_playedtime;
												//fputcsv($file, array($current_time_temp,$user_day_songs['name'],$user_day_songs['path'],date('i:s',$secs),$user_day_songs['type']));
												array_push($listsong_mixed_array,$user_day_songs);
												array_push($user_day_song_list_temp,$user_day_songs);
												
											}
										}
										
									}
								}
								echo '<pre>';
								print_r($listsong_mixed_array);
								exit;
								if($total_time < $maxtiome)
								{
									a:
									{
										$shuffile_song = 0;
										$new_sorted_songs_list = array();
										foreach($user_day_tags['list_of_songs'] as $user_played_songs)
										{
											$user_played_songs['last_played'] = $current_playlist_songs_dtls[$user_played_songs['id']];
											$user_played_songs['last_played_time'] = date('H:i:s',$current_playlist_songs_dtls[$user_played_songs['id']]);
											$new_sorted_songs_list[$user_played_songs['id']] = $user_played_songs;
										}
										$new_sorted_songs_list2 = $this->array_sort($new_sorted_songs_list,'last_played','SORT_DESC');
										//echo count($new_sorted_songs_list2);
										if(count($new_sorted_songs_list2) >= 10)
										{
											shuffle($new_sorted_songs_list2);
											$shuffile_song = 1;
										}
										//print_r($new_sorted_songs_list2);
										foreach($new_sorted_songs_list2 as $user_day_songs)
												
										{
											//print_r($user_day_songs);
											$samp_temp_time = strtotime('+30 minutes', $user_day_songs['last_played']);
											//echo date('H:i:s',$lat_playedtime).'<br />';
											if($shuffile_song == 1 && $samp_temp_time >= $lat_playedtime)
											continue;
												
											$inserted_into_array = 0;
											if($total_time <= $maxtiome)
											{
												$secs = strtotime($user_day_songs['length'])-strtotime("00:00:00");
												$total_time = $total_time+$secs;
												array_push($user_day_song_list_temp,$user_day_songs);
												$lat_playedtime = $lat_playedtime + $secs;
												$current_playlist_songs_dtls[$user_day_songs['id']] = $lat_playedtime;
												//fputcsv($file, array($current_time_temp,$user_day_songs['name'],$user_day_songs['path'],date('i:s',$secs),$user_day_songs['type']));
												$inserted_into_array = 1;
												array_push($listsong_mixed_array,$user_day_songs);
												
											
											}
										}
									
										if($total_time < $maxtiome)
										{
											goto a;
											//echo date('H:i:s',$total_time);
										}
										
										
									}
								}
								
								
							}
							
						}
						
					}
					//exit;
					echo '<pre>';
					shuffle($user_day_song_list_temp);
					echo '<br />'.$keys_all.'<br />';
					//print_r($user_day_song_list_temp);
					//echo '<pre>';
					if(!empty($user_day_song_list_temp))
					{
							
						$log .= 'Shuffled list for'.$days[$get_chart_list->day].$keys_all."\r\n";
					}
					$shuffld_song = 0;
					foreach($user_day_song_list_temp as $user_day_song_list_single_temp)
					{
						//print_r($user_day_song_list_single_temp);
						$secs = strtotime($user_day_song_list_single_temp['length'])-strtotime("00:00:00");
						fputcsv($file, array($current_time_temp,$user_day_song_list_single_temp['name'],$user_day_song_list_single_temp['path'],date('i:s',$secs),$user_day_song_list_single_temp['type']));
						if($tested_index == 1)
						{
							$song_played_model = new Playedsong;
							$song_played_model->uid = $id;
							$song_played_model->played_date = date('Y-m-d');
							$song_played_model->time_slot = $current_time_temp;
							$song_played_model->song = $user_day_song_list_single_temp['id'];
							$song_played_model->save();
						}
						$shuffld_song = 1;
						if($jing_gap != 0 && $i != 0 && ($i % $jing_gap) ==0 && !empty($jingle_list))
						{
							$selected_jingle_id = array_rand($jingle_list, 1);
							$selected_jing = $jingle_list[$selected_jingle_id];
							array_push($user_day_song_list_temp,$selected_jing);
							fputcsv($file, array($current_time_temp,$selected_jing['title'],$selected_jing['path'],$selected_jing['time'],$selected_jing['type']));
							$secs = strtotime("00:".$selected_jing['time'])-strtotime("00:00:00");												
							$total_time = $total_time+$secs;
						}
						elseif( $advt_gaps !=0 && $i != 0 && ($i % $advt_gaps) == 0 && $advt_gaps != 0 && !empty($ads_list))
						{
							//echo 'advt';
							$selected_jingle_id = array_rand($ads_list, 1);
							$selected_jing = $ads_list[$selected_jingle_id];
							array_push($user_day_song_list_temp,$selected_jing);
							fputcsv($file, array($current_time_temp,$selected_jing['title'],$selected_jing['path'],$selected_jing['time'],$selected_jing['type']));
							$secs = strtotime("00:".$selected_jing['time'])-strtotime("00:00:00");
							$total_time = $total_time+$secs;
								
						}
						//$i++;
						$i++;
					}
					if(!empty($user_day_song_list_temp))
					{
						if($shuffld_song == 1) $log .= 'Songs inserted in csv list for'.$days[$get_chart_list->day].$keys_all."\r\n";
						else $log .= 'Songs not inserted in'.$days[$get_chart_list->day].$keys_all."\r\n";
					}
					$user_day_song_list_temp = array();
					
				
					
				}
				fclose($file);
				
			}
			//exit;
			$log_creation = New Createlog;
			$log  .= " Time : ".' - '.date("F j, Y, H:i:s ").PHP_EOL."\r\n".
			" Action : Created schedule using button".PHP_EOL."\r\n".
			" Customer ID : ".$customer_model->uid.PHP_EOL."\r\n".
			"-------------------------".PHP_EOL."\r\n";
			$log_creation->create_log_msg($log);
			//exit;
			$this->redirect(array('chart&id='.$id,'popup'=>'exit'));
			exit;
		}
		$this->render('shedule',array(
		 ));
		//exit;
		//$this->redirect(array('admin','popup'=>'exit'));
		//exit;
		
	}
	private function array_sort($array, $on, $order=SORT_ASC)
	{
		$new_array = array();
		$sortable_array = array();
	
		if (count($array) > 0) {
			foreach ($array as $k => $v) {
				if (is_array($v)) {
					foreach ($v as $k2 => $v2) {
						if ($k2 == $on) {
							$sortable_array[$k] = $v2;
						}
					}
				} else {
					$sortable_array[$k] = $v;
				}
			}
	
			switch ($order) {
				case SORT_ASC:
					asort($sortable_array);
					break;
				case SORT_DESC:
					arsort($sortable_array);
					break;
			}
	
			foreach ($sortable_array as $k => $v) {
				$new_array[$k] = $array[$k];
			}
		}
	
		return $new_array;
	}
	public function actionExportdb()
	{
		$this->render('dbexport',array(
		 ));
	}
	public function actionPlaylist()
	{
		//echo 'Hiii';
		//$created_playlistmodel = new Createdplaylists;
		if(!Yii::app()->user->id)
		{
			$this->redirect(array('/customers/admin'));
		}
		$current_uer = Yii::app()->user->id;
		$condition2 = "`username` = '$current_uer'";
		$current_user_details = User::model()->findAll(array('condition'=> $condition2));
		if(empty($current_user_details))
		{
			$this->redirect(array('/customers/admin'));
		}
		$current_user_id = $current_user_details[0]->id;
		$today = date('y-m-d');
		$condition = "`created_date` = '$today'";
		$created_playlist = Createdplaylists::model()->findAll(array('condition'=> $condition));	
		$url = 'http://'.Yii::app()->request->getServerName().'/instore_php/dbexport/playlist/playlists_'.date('Y-m-d').".csv";
		if(!empty($created_playlist))
		{	
			if($created_playlist[0]->status == 1) 
			{
				$this->render('dowloading_playlist',array('download'=>$url));
				//$this->redirect($url);	
			}
			else 
			{
				$str_remove = array('{','}');
				$applied_uesr = $created_playlist[0]->uid;
				$current_id = $created_playlist[0]->id;
				$filtered_users = explode(',',str_replace($str_remove,'',$applied_uesr));
				if(!in_array($current_user_id, $filtered_users))
				{
					array_push($filtered_users,$current_user_id);
					$current_user_id = implode(',',$filtered_users);
					$current_user_id_isert = '{'.$current_user_id.'}';
					Createdplaylists::model()->updateByPk($current_id,array('uid' => $current_user_id_isert));
					$this->render('playlist');
				}
								
			}
		}
		else 
		{
		
			$current_user_id = '{'.$current_user_id.'}';
			$created_playlistmodel = new Createdplaylists;
			$created_playlistmodel->uid = $current_user_id;
			$created_playlistmodel->created_date = date('y-m-d');
			$created_playlistmodel->save();
			
			shell_exec('php /var/www/instore_php/cron.php createplaylist');
			$this->render('playlist');
			
			 
		}
		
			//echo $filename;
		
		
	}
		/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Customers the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Customers::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Customers $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='customers-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
