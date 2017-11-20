<?php

class CustomersController extends Controller
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
			$now_added = array();
			$now_added_song_time = array();
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
					//$time =
				}
			}
			$ads_and_jing = array('ad_gap' => $advt_gaps, 'jing_gap'=>$jing_gap, 'adds'=>$ads_list, 'jingles' => $jingle_list);
			$str_remove = array('{','}');
			$songs_ist = array();
			$all_songs = Songs::model()->findAll();
			foreach($all_songs as $songs)
			{
				$song_styles = explode(',',str_replace($str_remove,'',$songs->style));
				$song_name = str_replace( ',', '-', $songs->name );
				array_push($songs_ist,array('id'=>$songs->id,'name' => $song_name,'styles' =>$song_styles,'length'=> $songs->song_length, 'path' => $songs->path));
			}
			$yesterday_date = date("Y-m-d", strtotime("yesterday"));
			$condition = "`uid` = $id AND `played_date` >= '$yesterday_date'";
			$get_last_playlists = Playedsong::model()->findAll(array('condition'=> $condition));
			$last_played_songs = array();
			if(!empty($get_last_playlists))
			{
				foreach($get_last_playlists as $get_last_playlist)
				{
					if(!in_array($get_last_playlist->song,$last_played_songs)) $last_played_songs[] = $get_last_playlist->song;
				}
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
				if(!empty($now_added)) $last_played_songs = $now_added;
				$now_added = array();
				//print_r($last_played_songs);
				$tested_index++;
				if($tested_index == 1)
				{
					$command = Yii::app()->db->createCommand();
					$command->delete('tbl_playedsong', 'played_date=:played_date AND uid=:uid', array(':played_date'=>date('y-m-d'), ':uid'=>$id));
			
				}
				if($test_list >= 4)
				{
					break;
				}
				$test_list++;
				$filename = Yii::getPathOfAlias('webroot')."/songs/schedule/".$customer_model->uid."/".$days[$get_chart_list->day].".csv";
				if(file_exists($filename))
				{
					//chmod($filename, 0755);
					unlink(Yii::getPathOfAlias('webroot')."/songs/schedule/".$customer_model->uid."/".$days[$get_chart_list->day].".csv");
				}
				//echo $filename;
				$log .= 'File created for '.$days[$get_chart_list->day]."\r\n";
				$file = fopen($filename,"x+");
				$list = array('schedule', 'title', 'path', 'length','type','tag_id');
				fputcsv($file, $list);				
				$playlists = explode(',',str_replace($str_remove,'',$get_chart_list->playlists));
				//print_r($get_chart_list);
				$time_slot = 0;
				$none_silence = array();
				if(!empty($playlists))
				{
					$user_day_styles = array();
					foreach($playlists as $key3=>$playlist)
					{
						//echo $time_slot.'<br />';
						$condition = '`id` = '.$playlist;
						$get_playlist_details = Playlists::model()->findAll(array('condition'=> $condition));
						if(empty($get_playlist_details))
						{
							//$condition = '`id` = 18';
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
									$current_tag_song_temp = $tag_order[$temp_i]['style'][0];
									if(in_array($current_tag_song_temp,$single_song['styles']))
									{
										$temp_sorted_songs[$current_tag_song_temp][] = $single_song;
									}
									
								}
								//exit;
							
							}
							
							$songs_in_current_playlist = 0;
							foreach($temp_sorted_songs as $temp_sorted_songs_in_styles)
							{
								if(!empty($temp_sorted_songs_in_styles)) $songs_in_current_playlist = $songs_in_current_playlist + count($songs_in_current_playlist);
							}
							
							//$scheduled_songs = $this->print_schedule($id,$temp_sorted_songs,$now_added,$last_played_songs,0,0,$filename,$time_slot,$file,$now_added_song_time,$ads_and_jing,0,$tested_index);
							$scheduled_songs = $this->print_schedule_new($id,$temp_sorted_songs,$now_added,$last_played_songs,0,0,$filename,$time_slot,$file,$now_added_song_time,$ads_and_jing,0,$tested_index, $tag_order);
							//$now_added,$now_added_song_time,$time_played
							$now_added_song_time = $scheduled_songs[1];
							$time_played = $scheduled_songs[2];
							$now_added = $scheduled_songs[0];
							
						}						
						$time_slot++;
						
					}
					fclose($file);
					$now_added_song_time = array();
				
				}
								
			}
			
			$log_creation = New Createlog;
			$log  .= " Time : ".' - '.date("F j, Y, H:i:s ").PHP_EOL."\r\n".
			" Action : Created schedule using button".PHP_EOL."\r\n".
			" Customer ID : ".$customer_model->uid.PHP_EOL."\r\n".
			"-------------------------".PHP_EOL."\r\n";
			//exit;
			$log_creation->create_log_msg($log);
			//exit;
			$this->redirect(array('chart&id='.$id,'popup'=>'exit'));
			exit;
		}
		$this->redirect(array('admin','popup'=>'exit'));
		exit;
		
	}
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
						//print_r($songs_list);
						
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
	private function print_schedule($id,$songs_percentage_list,$now_added=array(),$last_played=array(),$repet_order = 0,$completed_time=0,$filename,$time_slot,$file,$now_added_song_time,$ads_and_jing,$song_played_count = 0,$tested_index)
	{
		echo $time_slot;
		//echo '<br /> Repet = '.$repet_order.'<br />';
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
		/*if($time_played < $maxim_time)
		{
			$repet_order = $repet_order+1;
			echo 'Repeted '.$repet_order;
			$this->print_schedule($id,$songs_percentage_list,$now_added,$last_played,$repet_order,$time_played,$filename,$time_slot,$file,$now_added_song_time,$ads_and_jing,$song_played_count,$tested_index);
			
		}		
		else*/
		return array($now_added,$now_added_song_time,$time_played,$maxim_time);		
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
					
				}
				$this->render('playlist');			
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
