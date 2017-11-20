<?php

/**
 * RegisterForm class.
 * RegisterForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RegisterForm extends CFormModel
{
	public $username;
	public $password;
	public $confirm_password;
	public $email_id;
	private $_identity;

	public function tableName()
	{
		return '{{user}}';
	}
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
				// username and password are required
				array('username, password, confirm_password, email', 'required'),
				array('password', 'length', 'min'=>6),
				// password needs to be same with confirm password
				array('password', 'compare', 'compareAttribute'=>'confirm_password', 'on'=>'register'),
		);
	}
	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function register()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			//$this->_identity->authenticate();
		}
		/* if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		 {
		$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
		Yii::app()->user->login($this->_identity,$duration);
		return true;
		} */
		else
			return false;
	}

}
