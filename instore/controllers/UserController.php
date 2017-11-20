<?php

class UserController extends Controller
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
						'actions'=>array('index','view','activate','forgotpassword','new_pass','error_mail','send_error'),
						'users'=>array('*'),
				),
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions'=>array('create','update'),
						'users'=>array('*'),
				),
				array('allow', // allow user to login
						'actions'=>array('login'),
						'users'=>array('*'),
				),
				array('allow', // allow admin user to perform 'admin' and 'delete' actions
						'actions'=>array('admin','delete'),
						'users'=>array('arif'),
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
	public function actionSend_error()
	{
		$model=new User;
		$this->render('send_error',array(
				'model'=>$model,
		));
	}
	public function actionError_mail()
	{
		$error = '';
		$model=new User;
		$pst = $_REQUEST;
		//$contnt = '';
		$customer_id = $crashed_date = $message = $crash_details = $custom_data = '';
		//$crash_details = '2014-04-25T13:22:16.000+02:00 ';
		if(isset($_POST['CUSTOM_DATA'])) $custom_data = substr_replace($_POST['CUSTOM_DATA'], "", -1);//trim($_POST['CUSTOM_DATA']," ");
		if(isset($_POST['USER_CRASH_DATE'])) $crashed_date = $_POST['USER_CRASH_DATE'];
		if(isset($_POST['STACK_TRACE'])) $crash_details = substr_replace($_POST['STACK_TRACE'], "", -1);//$_POST['STACK_TRACE'];
		$expl_crsh_date = explode(".",$crashed_date);
		$temp  ='';
		$sep_custom_data = explode("ID",$custom_data);
		if(is_array($sep_custom_data) && count($sep_custom_data) > 1)
		{
			$sampl_data = substr_replace($sep_custom_data[0], "", -1);
			if($sampl_data != '' && $sampl_data != ' ') $message = 'Crash '.$sampl_data.'.<br>';
			$customer_id = $sep_custom_data[1];
		}
		else if(is_array($sep_custom_data)) {
			$customer_id = $sep_custom_data[0];
		}
		else $customer_id = $sep_custom_data;
		if(is_array($_POST['CUSTOM_DATA']))
		{
			foreach($_POST['CUSTOM_DATA'] as $key=>$data)
			{
				$temp .= $key.'='.$data.'<br />';
			}
		}
		$user_email = 'geojose1990@gmail.com';
		$msg = '<body width="700px">
				<a href="http://ubi-sound.eu'.Yii::app()->request->baseUrl.'"><img width="700px" src="http://ubi-sound.eu'.Yii::app()->request->baseUrl.'/images/header.png" alt="Header image"></a><br><br>
				Hi Instore admin, <br><br>
					
				A crash message reported for customer ID '.$customer_id.'. Crash details are: <br>
				Customer ID '.$customer_id.'. <br>
				'.$message.'
				Crashed date/time = '.$expl_crsh_date[0].'. <br>
				Crash details = '.$crash_details.'.<br><br>
				
					
		Thank you,<br>
		Ubi Sound<br>
		<a target="_blank" href="http://ubi-sound.eu'.Yii::app()->request->baseUrl.'">Ubi Sound</a>
		</div>
		<a href="http://ubi-sound.eu'.Yii::app()->request->baseUrl.'"><img width="700px" src="http://ubi-sound.eu'.Yii::app()->request->baseUrl.'/images/footer.png" alt="Footer image"></a>
		</body>';
		$name='=?UTF-8?B?'.base64_encode('Instore').'?=';
		$subject='=?UTF-8?B?'.base64_encode('Crash report').'?=';
		$headers="From: Ubi Sound <info@ubi-sound.it>\r\n".
			"MIME-Version: 1.0\r\n".
			"Content-type: text/html; charset=iso-8859-1" . "\r\n".
			"CC:  info@ubi-sound.it";
			if(mail($user_email,$subject,$msg,$headers)) echo 'Success';
		exit;
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$user_details = $_POST['User'];
			//$user_details['activation_code'] = rand(1000,10000);
			//print_r($user_details);
			$model->attributes = $user_details;
			//print_r($model->attributes);
			//$model->attributes['activation_code'] = rand(1000,10000);
			//print_r($_POST['User']);
			//echo '<br />';
			//print_r($model->attributes);
			//exit;
			if($model->save())
			{
				$to = $_POST['User']['email'];
				$from = 'caarif123@gmail.com';
				$subject = 'Complete your registration';
				$msg = 'Please activate your accont by click here :'.Yii::app()->request->baseUrl.'/index.php/?r=user/activate&id='.$model->activation_code;
				echo $msg;
				exit;
				$this->redirect(array('view','id'=>$model->id));

			}
		}

		$this->render('create',array(
				'model'=>$model,
		));
	}
	public function actionLogin()
	{
		if(Yii::app()->user->id)
		{
			$this->redirect(array('/customers/admin'));
		}
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
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

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
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
	public function actionActivate($id='')
	{
		if(!$id != '')
		{
			$this->render('activate',array(
					'error'=>'Invalid url',
			));
		}
		$model=new User;
		$user = $model->findByAttributes(array('activation_code'=>$id));
		if(!$user)
		{
			$this->render('activate',array(
					'error'=>'Canot find user',
			));
		}
		elseif($user['active'] == 1)
		{
			$this->render('activate',array(
					'error'=>'Your account is already activated',
			));
		}
		else {
			$model->id = $user['id'];
			$model->username = $user['username'];
			$model->password = $user['password'];
			$model->email = $user['email'];
			$model->activation_code = $user['activation_code'];
			$model->active = 1;
			//print_r($model->attributes);
			$model->updateByPk($model->id,array('active' => 1 ,'activation_code' => '0'));
			$this->render('activate',array(
					'msg'=>'Account activated',
			));

		}
	}
	public function actionForgotpassword()
	{
		$error = '';
		$model=new User;
		if(isset($_POST['User']))
		{
			//print_r($_POST['User']);
			$user_email = $_POST['User']['email'];
			if(!$user_email || $user_email == '')
			{
				$error = '<div style="margin-left:14%;" id="User_email_em_" class="errorMessage">Email cannot be blank.</div>';
			}
			if ($user_email != '' && !filter_var($user_email, FILTER_VALIDATE_EMAIL))
			{
				$error = '<div style="margin-left:14%;" id="User_email_em_" class="errorMessage">Please enter a valid email address.</div>';
			}
			$user = $model->findByAttributes(array('email'=>$user_email));
			if($error == '' && !$user)
			{
				$error = '<div style="margin-left:14%;" id="User_email_em_" class="errorMessage">We cannot find Email Id in our database.</div>';

			}
			if($error == '' && $user)
			{
				$reset_code_act = $user['id'].date('ymdhs').rand(1000,10000);
				//echo $reset_code_act;
				$model->updateByPk($user['id'],array('password_reset' => 1 ,'password_conformation_code' =>"$reset_code_act"));
				//$msg = 'Please click here to reset your passsword : http://ubi-sound.eu'.Yii::app()->request->baseUrl.'/index.php/?r=user/new_pass&id='.$reset_code_act;
				//print_r($user);
				//exit;
				$msg = '<body width="700px">
						<a href="http://ubi-sound.eu'.Yii::app()->request->baseUrl.'"><img width="700px" src="http://ubi-sound.eu/instore_php/images/header.png" alt="Header image"></a><br><br>
						Hi '.$user['username'].' <br><br><br>
						To reset your password, follow this link : http://ubi-sound.eu'.Yii::app()->request->baseUrl.'/index.php/?r=user/new_pass&id='.$reset_code_act.'<br>
						<br>
					
						Thank You<br><br>
					
						--<br>
						Ubi Sound<br>
						<a target="_blank" href="http://ubi-sound.eu'.Yii::app()->request->baseUrl.'">Ubi Sound</a>
						</div>
					<a href="http://ubi-sound.eu'.Yii::app()->request->baseUrl.'"><img width="700px" src="http://ubi-sound.eu/instore_php/images/footer.png" alt="Footer image"></a>
				</body>';
				$name='=?UTF-8?B?'.base64_encode($user['username']).'?=';
				$subject='=?UTF-8?B?'.base64_encode('Password reset').'?=';
				$headers="From: Ubi Sound <info@ubi-sound.it>\r\n".
						"MIME-Version: 1.0\r\n".
						"Content-type: text/html; charset=iso-8859-1" . "\r\n";
				if(mail($user['email'],$subject,$msg,$headers))
					Yii::app()->user->setFlash('success','Please check your email ');
				else Yii::app()->user->setFlash('Error','Problem occured on sending Email ');;
				//mail($user['email'],$subject,$msg,$headers);
				$this->refresh();
				

			}
		}
		if($error != '')
		{
			$this->render('forgotpassword',array(
					'error'=>$error,
					'model'=>$model,
			));
		}
		else
		{
			$this->render('forgotpassword',array('model'=>$model));
		}

		//print_r($model);

	}
	public function actionNew_pass($id = '')
	{
		$model=new User;
		$user = $model->findByAttributes(array('password_conformation_code'=>$id,'password_reset'=>'1'));
		if(!$user)
		{
			$this->redirect(array('site/notfound'));
		}
		//echo $id;
		$error = '';
		
		if(isset($_POST['User']))
		{
			if($_POST['User']['password'] == '')
			{
				$error = '<div style="margin-left:14%;" id="User_email_em_" class="errorMessage">Password cannot be blank.</div>';
			}
			elseif($_POST['User']['password'] != $_POST['User']['confirm_password'])
			{
				$error = '<div style="margin-left:14%;" id="User_email_em_" class="errorMessage">Password do not match.</div>';
			}
			else 
			{
				//$user = $model->findByAttributes(array('password_conformation_code'=>$id));
				
				$new_password = hash_hmac('sha256', $_POST['User']['password'] , Yii::app()->params['encryptionKey']);
				//echo '$new_password';
				$model->updateByPk($user['id'],array('password_reset' => 0 ,'password' =>"$new_password"));
				$this->redirect(array('login'));
			}
			if($error != '')
			{
				$this->render('new_pass',array(
						'error'=>$error,
						'model'=>$model,
				));
			}
		}
		$this->render('new_pass',array('model'=>$model));
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
				'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
				'model'=>$model,
		));
	}
	/*public function actionError_mail()
	{
		$error = '';
		$model=new User;
		$user_email = 'caarif123@gmail.com';
		$msg = '<body width="700px">
				<a href="http://ubi-sound.eu'.Yii::app()->request->baseUrl.'"><img width="700px" src="http://ubi-sound.eu'.Yii::app()->request->baseUrl.'/images/header.png" alt="Header image"></a><br><br>
				Hi Instore admin <br><br><br>
					
				A srash message reported
				<br>
					
		Thank You<br><br>
					
		<br>
		Ubi Sound<br>
		<a target="_blank" href="http://ubi-sound.eu'.Yii::app()->request->baseUrl.'">Ubi Sound</a>
		</div>
		<a href="http://ubi-sound.eu'.Yii::app()->request->baseUrl.'"><img width="700px" src="http://ubi-sound.eu'.Yii::app()->request->baseUrl.'/images/footer.png" alt="Footer image"></a>
		</body>';
		$name='=?UTF-8?B?'.base64_encode('Instore').'?=';
		$subject='=?UTF-8?B?'.base64_encode('Crash report').'?=';
		$headers="From: Ubi Sound <info@ubi-sound.it>\r\n".
			"MIME-Version: 1.0\r\n".
			"Content-type: text/html; charset=iso-8859-1" . "\r\n";
			if(mail($user_email,$subject,$msg,$headers)) echo 'Success';
		
	}*/
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
