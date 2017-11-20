<?php

class GsmController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','connect'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
		$model=new Gsm;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_GET['regId']))
		{
			$condition = '`uid` = '.$_GET['uid'];
			$get_user =  Customers::model()->findAll(array('condition'=> $condition));
			foreach($get_user as $user)
			{
				$user_id = $user->id;
			}
			$condition = '`cid` = '.$user_id;
			$get_last_added =  $model->findAll(array('condition'=> $condition));
			if(empty($get_last_added))
			{
				$model->registration_id = $_GET['regId'];
				$model->cid = $user_id;
				if($model->save()) echo 'Success';
				else echo 'Some error occured';
			}
			else
			{
				foreach($get_last_added as $last_added)
				{
					$last_added_id = $last_added->id;
				}
				$model_update=$this->loadModel($last_added_id);
				$model->registration_id = $_GET['regId'];
				$model->cid = $user_id;
				if($model->save()) echo 'Success';
				else echo 'Some error occured';
			}
		}
		
		exit;

	}
	public function actionConnect($id='')
	{
		$condition = '`id` = '.$id;
		$customer_details =  Customers::model()->findAll(array('condition'=> $condition)); 
		$condition = '`cid` = '.$id;
		$get_gsm =  Gsm::model()->findAll(array('condition'=> $condition));
		if(!empty($get_gsm))	
		{
			foreach($get_gsm as $single_gsm)
			{
				$reg_id = $single_gsm->registration_id;
			}
			$registration_id = array();
			$registration_id[] = $reg_id;
			 $url = 'https://android.googleapis.com/gcm/send';
   
		$message = array("Notice" => "unlock:com.teamviewer.quicksupport.market");
         $fields = array(
             'registration_ids' => $registration_id,
             'data' => $message,
         );
   
         $headers = array(
             'Authorization: key=AIzaSyAYxBEzLf-XGDzhHslcExYlA_91GXhQxiQ',
             'Content-Type: application/json'
         );
         // Open connection
         $ch = curl_init();
   
         // Set the url, number of POST vars, POST data
         curl_setopt($ch, CURLOPT_URL, $url);
   
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   
         // Disabling SSL Certificate support temporarly
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   
         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
   
         // Execute post
         $result = curl_exec($ch);
         if ($result === FALSE) {
             die('Curl failed: ' . curl_error($ch));
         }
   
         // Close connection
         curl_close($ch);
         //echo $result;
		 $this->render('connect',array(
				'message'=>$result,
				'id' => $id,
				'customer_details' => $customer_details,
			));
		}
		else 
		{
			Yii::app()->user->setFlash('error','Gsm details of selected customer is not available');
			$this->redirect(array('customers/admin'));
			exit;
		}
		
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Gsm']))
		{
			$model->attributes=$_POST['Gsm'];
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
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Gsm');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Gsm('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Gsm']))
			$model->attributes=$_GET['Gsm'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Gsm the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Gsm::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Gsm $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='gsm-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
