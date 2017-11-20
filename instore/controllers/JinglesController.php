<?php

class JinglesController extends Controller
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
		$customers = Customers::model()->findAll();
		$customerlist = array();
		foreach($customers as $customer)
		{
			$customerlist[$customer->id] = $customer->company;
		}
		$this->render('view',array(
			'model'=>$this->loadModel($id),'customers'=>$customerlist,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Jingles;
		$customers = Customers::model()->findAll();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Jingles']))
		{
			//print_r($_POST['Jingles']);
			$model->upload=CUploadedFile::getInstance($model,'upload');
			
			$model->attributes=$_POST['Jingles'];
			//$model->setScenario('hasUpload');
			if(!$model->validate())
			{
				$errores = $model->getErrors();
			}
			if(!$model->upload)
			{
				//$model->addError('upload', 'File cannot be blank.');
				$errores['upload'] = array('File cannot be blank');
				//$model->errors = $errores;
			}
			if(!empty($errores))
			{
				//print_r($model);
				$this->render('create', array('model'=>$model,'upload_errors' => $errores,'customers' => $customers));
				exit;
			}
			
			$song_name = $model->upload->name;
			$path = Yii::getPathOfAlias('webroot').'/ads-jingles';
			if (!file_exists($path)) {
				mkdir(Yii::getPathOfAlias('webroot').'/ads-jingles', 0777);
			}
			
			$extention_array = explode('.',$song_name);
			$extention = end($extention_array);
			$name = $model->customer_id.rand(1000,9999); // rand(1000,9999) optional
			$name = $name.'.'.$extention; //optional
			
			if($model->save())
			{
				$model->updateByPk($model->id,array('path' =>'jingle'.$name));
				$model->upload->saveAs($path .'/jingle'. $name);
				$this->redirect(array('update','id'=>$model->id));
			
				// redirect to success page
			}
			}
				
			//$model->attributes=$_POST['Jingles'];
			//CActiveForm::validate($model);
			//print_r($_FILES);
			//exit;
			//print_r($model->attributes);
			//exit;
			//if($model->save())
				//$this->redirect(array('view','id'=>$model->id));
		$this->render('create',array(
			'model'=>$model,
			'upload_errors' => '',
			'customers' => $customers,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$customers = Customers::model()->findAll();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Jingles']))
		{
			$model->attributes=$_POST['Jingles'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
			'upload_errors' => '',
			'customers' => $customers,
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
		$this->redirect(array('admin'));
		$dataProvider=new CActiveDataProvider('Jingles');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($popup= '')
	{
		$criteria=new CDbCriteria();
		$customers = Customers::model()->findAll();
		$customerlist = array();
		foreach($customers as $customer)
		{
			$customerlist[$customer->id] = $customer->company;
		}
		$model=new Jingles('search');
		$count=$model->count($criteria);
		$pages=new CPagination($count);
		// results per page
		$pages->pageSize=50;
		$pages->applyLimit($criteria);
		$models=$model->findAll($criteria);
		$this->render('admin', array(
				'models' => $models,
				'model' => $model,
				'pages' => $pages,
				'customers' => $customerlist,
				//'popup' => $popup
		));
		/*$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Jingles']))
			$model->attributes=$_GET['Jingles'];

		$this->render('admin',array(
			'model'=>$model,
		));*/
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Jingles the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Jingles::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Jingles $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='jingles-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
