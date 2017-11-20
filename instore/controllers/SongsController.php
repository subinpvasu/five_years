<?php

class SongsController extends Controller
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
		$this->layout = 'tag_popup';
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
				'actions'=>array('index','view','get_style','chnage_pastsongs'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','selected_action','change_multy_style','createsongsdb'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delet'),
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
	public function actionView($id)
	{
		$styles = Style::model()->findAll();
		$this->render('view',array(
			'model'=>$this->loadModel($id),
				'styles' => $styles,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
public function actionCreate()
	{
		$insert_pblm = array();
		$model=new Songs;
		$styles = Style::model()->findAll();
		$getID3 = new getID3;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST) && !empty($_POST['Songs']))
        {
        	
			if(!empty($_POST['styles'])) $style = '{'.implode(',',$_POST['styles']).'}';
			else $style = '{0}';
			//$royalty = $_POST['royalty'];
        	$file_post = &$_FILES['song'];
        	$file_arys = array();
		    $file_count = count($file_post['name']);
		    $file_keys = array_keys($file_post);
		
		    for ($i=0; $i<$file_count; $i++) {
		        foreach ($file_keys as $key) {
		            $file_arys[$i][$key] = $file_post[$key][$i];
		        }
		    }
			$inserted_id = array();
			$log = 'Songs uploaded';
		    foreach($file_arys as $file_ary)
		    {
				
				$singl_inseted_pblm = '';
	        	$file_name = $file_ary['name'];
	        	$path = Yii::getPathOfAlias('webroot')."/songs/on".date('y-m');
	        	if (!file_exists($path)) {
	        		mkdir(Yii::getPathOfAlias('webroot').'/songs/on'.date('y-m'), 0777);
	        	}
	        	$extention_array = explode('.',$file_name);
	        	$extention = end($extention_array);
	        	$name = time().rand(1000,9999);// optional
	        	$name = md5($name).'.'.$extention; //optional
	        	if(move_uploaded_file($file_ary["tmp_name"],$path .'/'. $name))
				{
					$artist_name = '';
					$album_label = '';
					$publisher_label = '';
					 $log  .= 'Song name:  '.$file_name."\r\n".
					//echo 'uploaded';
					
					$model->style = $style;
					$model->path = 'on'.date('y-m').'/'. $name;
					$temp_path = 'on'.date('y-m').'/'. $name;
					$f = Yii::getPathOfAlias('webroot').'/songs/'.$temp_path;
					$a = $getID3->analyze($f);
					if(!array_key_exists('tags',$a))
					{
						$singl_inseted_pblm = 'ID3 tags are not availble for '.$file_name;
						$insert_pblm[] = $singl_inseted_pblm;
						unlink($path .'/'. $name);
					}
					else
					{
						if(array_key_exists('id3v1',$a['tags']) && array_key_exists('title',$a['tags']['id3v1'])) $song_name = implode(',',$a['tags']['id3v1']['title']);
						elseif(array_key_exists('id3v2',$a['tags']) && array_key_exists('title',$a['tags']['id3v2'])) $song_name = implode(',',$a['tags']['id3v2']['title']);
						else {
							$singl_inseted_pblm = 'Song title not available in ID3 tag of '.$file_name;
							$insert_pblm[] = $singl_inseted_pblm;			
						}
						if(array_key_exists('id3v1',$a['tags']) && array_key_exists('artist',$a['tags']['id3v1'])) $artist_name = implode(',',$a['tags']['id3v1']['artist']);
						elseif(array_key_exists('id3v2',$a['tags']) && array_key_exists('artist',$a['tags']['id3v2'])) $artist_name = implode(',',$a['tags']['id3v2']['artist']);
						else {
							$singl_inseted_pblm = 'Artist name not available in ID3 tag of '.$file_name;
							$insert_pblm[] = $singl_inseted_pblm;			
						}
						if(array_key_exists('id3v1',$a['tags']) && array_key_exists('publisher',$a['tags']['id3v1'])) $publisher_label = implode(',',$a['tags']['id3v1']['publisher']);
						elseif(array_key_exists('id3v2',$a['tags']) && array_key_exists('publisher',$a['tags']['id3v2'])) $publisher_label = implode(',',$a['tags']['id3v2']['publisher']);
						else {
							$singl_inseted_pblm = 'Publisher name not available in ID3 tag of '.$file_name;
							$insert_pblm[] = $singl_inseted_pblm;			
						}
						if(array_key_exists('id3v1',$a['tags']) && array_key_exists('album',$a['tags']['id3v1'])) $album_label = implode(',',$a['tags']['id3v1']['album']);
						if(array_key_exists('id3v2',$a['tags']) && array_key_exists('album',$a['tags']['id3v2'])) $album_label = implode(',',$a['tags']['id3v2']['album']);
						if(!empty($a) && array_key_exists('playtime_string',$a) && $a['playtime_string'] != '')
						{
							$playlenth_array = explode(':',$a['playtime_string']);
							$time_length = $playlenth_array[0] * 60 + $playlenth_array[1];
							$model->song_length = $time_length;
							
						}
						else {
							$singl_inseted_pblm = 'Song length not available in ID3 tag of '.$file_name;
							$insert_pblm[] = $singl_inseted_pblm;			
						}
						
						$model->name = $song_name;
						$model->artist = $artist_name;
						$model->label = $album_label;
						$model->publisher = $publisher_label;
						//$model->royalty = $royalty;
						//echo $singl_inseted_pblm;
						if($singl_inseted_pblm == '')
						{
							if($model->save())
							{
								//echo 'saved';
							}
						}
						else
						{
							unlink($path .'/'. $name);
						}
					}
					$model=new Songs;
				}
				//echo 'uploaded';
		    }
			if(empty($insert_pblm)) $this->redirect(array('admin'));
			
		}
		
        $this->render('create', array('model'=>$model,'styles'=>$styles,'insert_error'=>$insert_pblm));
		
	}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{		
		///$this->layout = 'tag_popup';
		$model=$this->loadModel($id);
		$styles = Style::model()->findAll();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Songs']))
		{
			if(!empty($_POST['Songs']['styles'])) $style = '{'.implode(',',$_POST['Songs']['styles']).'}';
			else $style = '{0}';
			//echo $style;
			$model->updateByPk($model->id,array('style'=>$style));
				$this->redirect(array('admin','popup'=>'exit'));
		}

		$this->render('update',array(
			'model'=>$model,
			'styles' => $styles,
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
		$path = Yii::getPathOfAlias('webroot')."/songs/".$model->path;
		if (file_exists($path)) { unlink($path); }
		$model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	// Action for selected songs from admin listig
	public function actionChange_multy_style($song_list = '')
	{
		if($song_list != '')
		{
			$styles = Style::model()->findAll();
			$criteria=new CDbCriteria();
			$model=new Songs();
			$select_songs = explode('_',$song_list);
			$criteria->addInCondition('id',$select_songs,true,'OR');
			$songlists = $model->findAll($criteria);
			if(isset($_POST['Songs']))
			{
				if(!empty($_POST['Songs']['styles'])) $style = '{'.implode(',',$_POST['Songs']['styles']).'}';
				else $style = '{0}';
				//echo $style;
				foreach($songlists as $songlists)
				{
					$model->updateByPk($songlists->id,array('style'=>$style));					
				}
				$this->redirect(array('admin'));
			}
			//print_r($songlists);
			//exit;
			
		}
		else $this->redirect(array('admin'));
		$this->render('update_style',array(
			'model'=>$model,
			'styles' => $styles,
			'songlists'=>$songlists
		));
	}
	 public function actionSelected_action()
	{
		$return_url = $_POST['redirect_url'];
		echo $return_url.'<br />';
		if (strpos($return_url,'&check_sel=all')) {
			$str2 = explode("&", $return_url);
			array_pop($str2);
			$return_url = implode("&", $str2);
			}
		if(isset($_POST['Songs']) && !empty($_POST['Songs']['song_id']))
		{
			$song_list_url = implode('_',$_POST['Songs']['song_id']);			
			$criteria=new CDbCriteria();
			$model=new Songs();
			$criteria->addInCondition('id',$_POST['Songs']['song_id'],true,'OR');
			$songlists = $model->findAll($criteria);
			
			if(isset($_POST['Songs']['action']) && $_POST['Songs']['action'] == 'Delete')
			{
				foreach($songlists as $songlist)
				{
					$song_model=$this->loadModel($songlist->id);
					$path = $path = Yii::getPathOfAlias('webroot')."/songs/".$song_model->path;
					if(unlink($path)) $model->deleteByPk($songlist->id);
					//echo 'deleted'.$path.'<br />';
					
				}
				$this->redirect($return_url);
			}
			if(isset($_POST['Songs']['action']) && $_POST['Songs']['action'] == 'Change style')
			{
				$this->redirect(array('change_multy_style','song_list'=>$song_list_url));
			}
		}
		else 
		{
			 Yii::app()->user->setFlash('error','Please select some songs');
			$this->redirect($return_url);
		}
		
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Songs');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	public function actionGet_style($popup = '')
	{
		$style_name = '';
		if(isset($_GET["q"])) $style_name = $_GET["q"];
		$criteria=new CDbCriteria();
		$criteria->compare('name',$style_name,true,'AND');
		$styles = Style::model()->findAll($criteria);
		$style_array = array();
		$i=0;
		foreach($styles as $style)
		{
			$i++;
			$style_array[] = array('name'=>$style->name,'id' => $style->id);
		}
		$json_response = json_encode($style_array);
	
		# Optionally: Wrap the response in a callback function for JSONP cross-domain support
		if(isset($_GET["callback"])) {
			$json_response = $_GET["callback"] . "(" . $json_response . ")";
		}
	
		# Return the response
		echo $json_response;
		exit;
		}
	/**
	 * Manages all models.
	 */
	 public function actionChnage_pastsongs()
	{
		$lastid = 7;
		$time_length = 0;
		$getID3 = new getID3;
		$criteria=new CDbCriteria();
		//$criteria->compare('artist',"== ''");
		//$criteria->compare('artist','',true);
		$songs_list = Songs::model()->findAll($criteria);
		foreach($songs_list as $song_dtails)
		{
				$model=new Songs;
				$path = $song_dtails->path;
				$f = Yii::getPathOfAlias('webroot').'/songs/'.$path;
				$a = $getID3->analyze($f);
				echo '<pre>';
				
				//exit;
				if(array_key_exists('tags',$a))
				{
					echo $song_dtails->id.', ';
					if(array_key_exists('id3v1',$a['tags']) && array_key_exists('title',$a['tags']['id3v1'])) $song_name = implode(',',$a['tags']['id3v1']['title']);
					elseif(array_key_exists('id3v2',$a['tags']) && array_key_exists('title',$a['tags']['id3v2'])) $song_name = implode(',',$a['tags']['id3v2']['title']);
					if(array_key_exists('id3v1',$a['tags']) && array_key_exists('artist',$a['tags']['id3v1'])) $artist_name = implode(',',$a['tags']['id3v1']['artist']);
					elseif(array_key_exists('id3v2',$a['tags']) && array_key_exists('artist',$a['tags']['id3v2'])) $artist_name = implode(',',$a['tags']['id3v2']['artist']);
					if(array_key_exists('id3v1',$a['tags']) && array_key_exists('album',$a['tags']['id3v1'])) $album_label = implode(',',$a['tags']['id3v1']['album']);
					elseif(array_key_exists('id3v2',$a['tags']) && array_key_exists('album',$a['tags']['id3v2'])) $album_label = implode(',',$a['tags']['id3v2']['album']);
					if(!empty($a) && array_key_exists('playtime_string',$a) && $a['playtime_string'] != '')
					{
						$playlenth_array = explode(':',$a['playtime_string']);
						$time_length = $playlenth_array[0] * 60 + $playlenth_array[1];
						
					}
					if($model->updateByPk($song_dtails->id,array('name'=>$song_name, 'artist'=>$artist_name,'label'=>$album_label,'song_length'=>$time_length,'year'=>date('Y-m-d H:i:s'))))
					{
						echo 'saved';
					}
				}
				else
				{
					if($model->updateByPk($song_dtails->id,array('year'=>date('Y-m-d H:i:s'))))
					{
						echo 'saved';
					}
				}
				
				$model=new Songs;
				echo $path.'<br />';
			
		}
		exit;
	}
	public function actionAdmin($popup = '')
	{
		$styles = Style::model()->findAll();
		$style_array = array();
		$search_name = '';
		$search_style = '';
		foreach($styles as $style)
		{
			$style_array[$style->id] = $style->name;
		}
		$criteria=new CDbCriteria();
		$model=new Songs();
		$curnt_page = 1;
		$condition = '';
		$criteria->order =  'id DESC';
		if(isset($_GET['style']) && $_GET['style'] != '') 
			{
				$search_styles = explode (',',$_GET['style']);
				//$key_of_style = array_search($_GET['Songs']['style'], $style_array);
				if(is_array($search_styles) && !empty($search_styles))
				{
					foreach($search_styles as $search_style)
					{
						//echo 
						$criteria->compare('style','{'.$search_style.'}',true,'OR');
						$criteria->compare('style','{'.$search_style.',',true,'OR');
						$criteria->compare('style',','.$search_style.',',true,'OR');
						$criteria->compare('style',','.$search_style.'}',true,'OR');
					}
				}
				else 
				{
					$criteria->compare('style','{'.$search_style.'}',true,'OR');
						$criteria->compare('style','{'.$search_style.',',true,'OR');
						$criteria->compare('style',','.$search_style.',',true,'OR');
						$criteria->compare('style',','.$search_style.'}',true,'OR');

				}
			}
			if(isset($_GET['name']) && $_GET['name'] != '') 
			{
				$search_name = $_GET['name'];
				$criteria->compare('name',$_GET['name'],true,'AND'); 
			}
		
		if(isset($_GET['page'])) $curnt_page = $_GET['page'];
		if($curnt_page != 1) $curnt_page = 50*($curnt_page-1) + 1;
		$count=$model->count($criteria);
		$pages=new CPagination($count);
		
		// results per page
		$pages->pageSize=50;
		$pages->applyLimit($criteria);
		$models=$model->findAll($criteria);
		$select_all = '';
		if(isset($_GET['check_sel'] ) && $_GET['check_sel'] = 'all')
		{
			$select_all = 'checked="checked"';
		}
		//print_r($_GET);
		$array_url_count = count($_GET);
		$array_cnt_index = 0;
		$test_redirect = 0;
		$samp_url = '';
		foreach($_GET as $key=>$url_cnt)
		{
			$array_cnt_index++;
			//echo 'arry_cnt = '.$array_url_count.' array_curnt ='.$array_cnt_index;
			if($array_cnt_index != $array_url_count && $key == 'check_sel')
			{
				//echo $key;
				unset($_GET[$key]);
				
				$test_redirect = 1;
			}
			else $samp_url .= $key.'='.$url_cnt.'&';
		}
		
		if($test_redirect == 1)
		{
			$samp_url .= 'check_sel=all';
			$this->redirect('http://ubi-sound.eu/instore_php/index.php?'.$samp_url);
		}
		//exit;
		$this->render('admin', array(
				'models' => $models,
				'pages' => $pages,
				'styles' => $styles,
				'popup' => $popup,
				'search_style' => $search_style,
				'search_name' => $search_name,
				'curnt_page' => $curnt_page,
				'total_count' => $count,
				'song_selection' => $select_all
		));
	}
	public function actionCreatesongsdb()
	{
		
		$filename = Yii::getPathOfAlias('webroot')."/dbexport/songs/".date('Y-m-d').".csv";
		if(file_exists($filename)) unlink($filename);
		$file = fopen($filename,"x+");
		$list = array('Title', 'Artist', 'Label', 'Year');
		fputcsv($file, $list);
		//$condition = '`royalty` = 1 ';
		$songs_list = Songs::model()->findAll();
		foreach($songs_list as $selected_song)
		{
			$str_remove = array('{','}');			
			$tags = explode(',',str_replace($str_remove,'',$selected_song->style));
			if(!in_array(16,$tags)) 
			{
				fputcsv($file, array($selected_song->name, $selected_song->artist, $selected_song->label, date('Y',strtotime($selected_song->year))));
			}
		}
		fclose($file);
		$url = 'http://'.Yii::app()->request->getServerName().'/instore_php/dbexport/songs/'.date('Y-m-d').".csv";
		
		$this->redirect($url);
		//echo $filename;
		exit;
		
	}	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Songs the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Songs::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Songs $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='songs-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
