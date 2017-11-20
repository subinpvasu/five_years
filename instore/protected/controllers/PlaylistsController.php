<?php

class PlaylistsController extends Controller
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
			//'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','add_style_persentage','copy','style'),
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
		$styles_percenages = Stylepercentage::model()->findAll();
		//echo '<pre>';
		$style_percentage_array = array();
		foreach($styles_percenages as $styles_percenage)
		{
			$style_percentage_array[$styles_percenage->playlist.'_'.$styles_percenage->style] = $styles_percenage->percentage;
		}
		$songs = Songs::model()->findAll();
		$song_style = array();
		$str_remove = array('{','}');
		$style_songs = array();
		foreach($songs as $song)
		{
			$current_song_styles = explode(',',str_replace($str_remove,'',$song->style));
			foreach($current_song_styles as $current_song_style)
			{
				if(array_key_exists('style_'.$current_song_style,$style_songs))
				{
					if(!in_array($song->id,$style_songs['style_'.$current_song_style]))
					{
						array_push($style_songs['style_'.$current_song_style],$song->id);
					}
				}
				else {
					$style_songs['style_'.$current_song_style] = array();
					array_push($style_songs['style_'.$current_song_style],$song->id);
				}
			}
			//$song_style[$song->id] = $current_song_styles;
		}
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'styles' => $styles,
			'style_percentages' => $style_percentage_array,
			'style_songs' => $style_songs,
			'songs_ist' => $songs
		));
	}
	public function actionStyle($id)
	{
		//$model=new Playlists;
		$styles = Style::model()->findAll();
		$all_playlists = Playlists::model()->findAll();
		$styles_percenages = Stylepercentage::model()->findAll();
		//echo '<pre>';
		$playlist_lists = array();
		foreach($all_playlists as $selected_playlists)
		{
			
			$playlist_lists[] = array('id' => $selected_playlists->id, 'name' => $selected_playlists->name);
			//print_r($selected_playlists);
		}
		//exit;
		$style_percentage_array = array();
		foreach($styles_percenages as $styles_percenage)
		{
			$style_percentage_array[$styles_percenage->playlist.'_'.$styles_percenage->style] = $styles_percenage->percentage;
		}
		$songs = Songs::model()->findAll();
		$song_style = array();
		$str_remove = array('{','}');
		$style_songs = array();
		foreach($songs as $song)
		{
			$current_song_styles = explode(',',str_replace($str_remove,'',$song->style));
			foreach($current_song_styles as $current_song_style)
			{
				if(array_key_exists('style_'.$current_song_style,$style_songs))
				{
					if(!in_array($song->id,$style_songs['style_'.$current_song_style]))
					{
						array_push($style_songs['style_'.$current_song_style],array('id'=>$song->id,'styles'=>$current_song_styles));
					}
				}
				else {
					$style_songs['style_'.$current_song_style] = array();
					array_push($style_songs['style_'.$current_song_style],array('id'=>$song->id,'styles'=>$current_song_styles));
				}
			}
			//$song_style[$song->id] = $current_song_styles;
		}
		$this->render('Style',array(
			'model'=>$this->loadModel($id),
			'styles' => $styles,
			'style_percentages' => $style_percentage_array,
			'style_songs' => $style_songs,
			'songs_ist' => $songs,
			'all_playlists' => $playlist_lists
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Playlists;
		$percentage = new Stylepercentage;
		$style = '{0}';
		$styles = Style::model()->findAll();
		$stle_lst = '';
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Playlists']))
		{
			
			if(!empty($_POST['Playlists']['styles'])) 
			{
				$stle_lst = $_POST['Playlists']['styles'];
				$style = '{'.implode(',',$_POST['Playlists']['styles']).'}';
				//else $style = '';
				$_POST['Playlists']['styles'] = $style;
			}
			$model->attributes=$_POST['Playlists'];
			$model->style = $style;
			if($model->save())
			{
				
				if(!empty($stle_lst))
				{ 
					$length = count($stle_lst);
					$defalt_percentage = floatval(100 / $length);
					$defalt_percentage = round($defalt_percentage,2);
					
					//echo round($defalt_percentage,2);
					//exit;
					//$stle_lst = $_POST['Playlists']['styles'];
					$i = 0;
					$total_percentage = 0;
					foreach( $stle_lst as $single_style)
					{
						$i++;
						if($i == $length)
						{
							$defalt_percentage = 100 - $total_percentage;
							
						}
						else $total_percentage = $total_percentage + $defalt_percentage;
						$percentage->setIsNewRecord(true);
                        $percentage->id = null;
						$percentage ->playlist = $model->id;
						$percentage ->percentage = $defalt_percentage;
						$percentage ->style = $single_style;
						//print_r($percentage);
						$percentage->save(); 
						//else exit;
												
					}
					//exit;
					$this->redirect(array('add_style_persentage','id'=>$model->id));
					//exit;
				}
				//exit;
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'styles' => $styles,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$stle_lst = '';
		$style = '{0}';
		$percentage = new Stylepercentage();
		$model=$this->loadModel($id);
		$styles = Style::model()->findAll();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Playlists']))
		{
			if(!empty($_POST['Playlists']['styles'])) 
			{
				$stle_lst = $_POST['Playlists']['styles'];
				$style = '{'.implode(',',$_POST['Playlists']['styles']).'}';
				//else $style = '';
				$_POST['Playlists']['styles'] = $style;
			}
			$model->attributes=$_POST['Playlists'];
			$model->style = $style;
			if($model->save())
			{
				if(!empty($stle_lst))
				{ 
					//$stle_lst = $_POST['Playlists']['styles'];
					foreach( $stle_lst as $single_style)
					{
						$condition = '`playlist` = '.$model->id.' AND `style` = '.$single_style;
						$list = $percentage->findAll(array('condition'=> $condition));
						if(empty($list))
						{
							$percentage->setIsNewRecord(true);
							$percentage->id = null;
							$percentage ->playlist = $model->id;
							$percentage ->percentage = 0;
							$percentage ->style = $single_style;
							$percentage->save(); 
						}
					}
					//exit;
					$this->redirect(array('add_style_persentage','id'=>$model->id));
				}				
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'styles' => $styles,
		));
	}
	public function actionAdd_style_persentage($id)
	{
		$percentage = new Stylepercentage();
		$error = '';
		$model=$this->loadModel($id);
		$str_remove = array('{','}');
		$playlist_style = explode(',',str_replace($str_remove,'',$model->style));
		//print_r($playlist_style);
		$songs = Songs::model()->findAll();
		$song_style = array();
		$str_remove = array('{','}');
		$style_songs = array();
		foreach($songs as $song)
		{
			$current_song_styles = explode(',',str_replace($str_remove,'',$song->style));
			foreach($current_song_styles as $current_song_style)
			{
				if(array_key_exists('style_'.$current_song_style,$style_songs))
				{
					if(!in_array($song->id,$style_songs['style_'.$current_song_style]))
					{
						array_push($style_songs['style_'.$current_song_style],$song->id);
					}
				}
				else {
					$style_songs['style_'.$current_song_style] = array();
					array_push($style_songs['style_'.$current_song_style],$song->id);
				}
			}
			//$song_style[$song->id] = $current_song_styles;
		}
		$count_array = array();
		foreach ($playlist_style as $sample_playlist)
		{
			//echo 'style_'.$sample_playlist;
			if(array_key_exists ('style_'.$sample_playlist,$style_songs))
			{
			
				if(!empty($style_songs['style_'.$sample_playlist]))
				{
					$songcount = count($style_songs['style_'.$sample_playlist]);
					$count_array[$sample_playlist] = $songcount;
				}
				else $count_array[$sample_playlist] = 0;
			}
			else $count_array[$sample_playlist] = 0;
			//echo $songcount;
		}
		$condition = '`playlist` = '.$id;
		$new_list = array();
		$lists = $percentage->findAll(array('condition'=> $condition));
		foreach($lists as $list)
		{
			if(in_array($list->style,$playlist_style))
			{
				$new_list[$list->id]['style'] = $list->style;
				$new_list[$list->id]['percentage'] = $list->percentage;
			}
		}
		
		$style_list = array();
		$styles = Style::model()->findAll();
		foreach($styles as $style)
		{
			$style_list[$style->id] = $style->name;
		}
		if(isset($_POST['Playlists']))
		{
			if(!empty($_POST['Playlists']['style']))
			{
				
				$style_total = 0;
				foreach($_POST['Playlists']['style'] as $style_value)
				{
					if($style_value == '') $style_value = 0;
					if(!is_numeric($style_value))
					{
						$error = 'Please enter a number.';
						
					}
					$style_total = floatval($style_total) + floatval($style_value);
					
				}
				if($style_total != 100) $error = 'Sum of styles must be 100.';
				
				if($error == '')
				{
					foreach($_POST['Playlists']['style'] as $key=>$style_value)
					{
						if($style_value == '') $style_value = 0;
						//echo 'Id = '.$key.'Value = '.$style_value;
						$percentage->updateByPk($key,array('percentage' => round($style_value,2)));
						
					}
					$this->redirect(array('view','id'=>$model->id));
				}
			}
			
		}
		//print_r($new_list);
		//exit;
		$this->render('style_percentage',array(
			'model'=>$this->loadModel($id),
			'styles' => $style_list,
			'styles_percentages' => $new_list,
			'songs_count' => $count_array,
			'errors' => $error,
		));
	}
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id = 0)
	{
		if($id != 0) 
		{
			
			$criteria=new CDbCriteria();
			$criteria->order =  'id DESC';
			$criteria->compare('playlists','{'.$id.'}',true,'OR');
			$criteria->compare('playlists','{'.$id.',',true,'OR');
			$criteria->compare('playlists',','.$id.',',true,'OR');
			$criteria->compare('playlists',','.$id.'}',true,'OR');
			$models = Charts::model()->findAll($criteria);
			$customer_id = array();
			foreach($models as $chart_list)
			{
				if(!in_array($chart_list->uid,$customer_id)) array_push($customer_id,$chart_list->uid);
			}
			$delte_error = '';
			echo '<pre>';
			if(!empty($customer_id))
			{
				$modify_message = 1;
				$modify_msg_cus_temp_array = array();
				foreach($customer_id as $cid)
				{
					if($cid != 0)
					{
						$condition = '`id` = '.$cid;
						$available_customer_details = $customer_details = Customers::model()->findAll(array('condition'=> $condition));
						if(!empty($available_customer_details)) 
						{
							array_push($modify_msg_cus_temp_array,$cid);
						}
					}
					else array_push($modify_msg_cus_temp_array,$cid);
				}
				$customer_id = $modify_msg_cus_temp_array;
				if(!empty($customer_id))
				{
					$default_message = '';
					
					if(count($customer_id) > 1)	$delte_error .= 'Cannot delete the seclected playlist as it is assigned to customers';
					elseif((count($customer_id)) == 1 && $customer_id[0] == 0) 
					{
						$delte_error .= 'Cannot delete the seclected playlist as it is assigned to default schedule';
						$modify_message = 0;
					}
					else $delte_error .= 'Cannot delete the selected playlist as it is assigned to customer ';
					if($modify_message == 1)
					{
						$cusomer_list_array = array();
						foreach($customer_id as $cid)
						{	
							if($cid == 0 ) $default_message = ' and Default Schedule';
							else
							{
								$condition = '`id` = '.$cid;
								$customer_details = Customers::model()->findAll(array('condition'=> $condition));
								$delte_error_temp = ' '.$customer_details[0]->uid.' ('.$customer_details[0]->name.')';
								array_push($cusomer_list_array,$delte_error_temp);
							}
						}
						$delte_error .= implode(',',$cusomer_list_array);
					}
					$delte_error .= $default_message;
				}
			}
			if($delte_error != '')
			{
				Yii::app()->user->setFlash('error',$delte_error);
				$this->redirect(array('admin'));
			}
			if($this->loadModel($id)->delete())
			{
				$command = Yii::app()->db->createCommand();
				$command->delete('tbl_stylepercentage', 'playlist=:playlist', array(':playlist'=>$id));
			}
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Playlists');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($popup = '')
	{
		$criteria=new CDbCriteria();
		$model=new Playlists('search');
		$count=$model->count($criteria);
		$pages=new CPagination($count);
		$styles = Style::model()->findAll();
		$styles_percenages = Stylepercentage::model()->findAll();
		//echo '<pre>';
		$style_percentage_array = array();
		foreach($styles_percenages as $styles_percenage)
		{
			$style_percentage_array[$styles_percenage->playlist.'_'.$styles_percenage->style] = $styles_percenage->percentage; 
		}
		//print_r($style_percentage_array);
		//exit;
		// results per page
		$pages->pageSize=50;
		if(isset($_GET['Songs']['name']) && $_GET['Songs']['name'] != '') 
		{
			$search_name = $_GET['Songs']['name'];
			$criteria->compare('name',$_GET['Songs']['name'],true,'AND');
		}
		$pages->applyLimit($criteria);
		$models=$model->findAll($criteria);
		$songs = Songs::model()->findAll();
		$song_style = array();
		$str_remove = array('{','}');
		$style_songs = array();
		foreach($songs as $song)
		{
			$current_song_styles = explode(',',str_replace($str_remove,'',$song->style));
			foreach($current_song_styles as $current_song_style)
			{
				if(array_key_exists('style_'.$current_song_style,$style_songs))
				{
					if(!in_array($song->id,$style_songs['style_'.$current_song_style]))
					{
						array_push($style_songs['style_'.$current_song_style],$song->id);
					}
				}
				else {
					$style_songs['style_'.$current_song_style] = array();
					array_push($style_songs['style_'.$current_song_style],$song->id);
				}
			}
			//$song_style[$song->id] = $current_song_styles;
		}
		$this->render('admin', array(
				'models' => $models,
				'pages' => $pages,
				'styles' => $styles,
				'popup' => $popup,
				'style_percentages' => $style_percentage_array,
				'style_songs' => $style_songs
		));
	}
	/**
	 * Create copy of a playlist
	 */
	public function actionCopy()
	{
		$error = '<div class="errorSummary">';
		if(isset($_POST['playlist']))
		{
			if($_POST['playlist'] == '') 	$error .= 'Please select a playlist<br />';
		}
		if(isset($_POST['name']))
		{
			if($_POST['name'] == '') 	$error .= 'Please enter a name<br />';
		}
		if($error != '<div class="errorSummary">')
		{
			echo $error.'</div>';
		}
		else 
		{
			$condition = '`id` = '.$_POST['playlist'];
			$model = Playlists::model()->findAll(array('condition'=> $condition));
			//$model= $this->loadModel($_POST['playlist']);
			if(!empty($model))
			{
				Playlists::model()->setIsNewRecord(true);
				Playlists::model()->id = null;
				Playlists::model()->name = $_POST['name'];
				Playlists::model()->style = $model[0]->style;
				//Playlists::model()->playlists = $play_list;
				Playlists::model()->save();
				echo '<div class="success">New playlist created</div>';
			}
			//$currentplaylist = 
			
		}
		exit;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Playlists the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Playlists::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Playlists $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='playlists-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
