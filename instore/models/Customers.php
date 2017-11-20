<?php

/**
 * This is the model class for table "{{customers}}".
 *
 * The followings are the available columns in table '{{customers}}':
 * @property integer $id
 * @property integer $uid
 * @property string $first_name
 * @property string $last_name
 * @property string $user_email
 * @property string $country
 * @property integer $status
 * @property string $from
 * @property string $to
 */
class Customers extends CActiveRecord
{
	public $ad_no;
	public $ad_gap;
	public $jingle_gap;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{customers}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('company, name,city,location,device,status,shop_type,addresses,zip,vat,team_viewer','required'),
				array('start_date,end_date', 'date', 'format'=>'yyyy-MM-dd'),
				//array('status', 'numerical', 'integerOnly'=>true),
				//array('first_name, last_name', 'length', 'max'=>40),
				array('user_email', 'length', 'max'=>75),
				//array('country', 'length', 'max'=>50),
				array('user_email', 'email'),
				//array('user_email', 'unique'),
				//array('ip', 'unique'),
				// The following rule is used by search().
				// @todo Please remove those attributes that should not be searched.
				array('id, uid, company, name, city, location,device,shop_type, status', 'safe', 'on'=>'search'),
		);
	}
	// for fun cton befro save user details
	public function beforeSave()
	{
		if($this->id == '')
		{
			$last_user = Customers::model()->findAll(array('order' => 'uid'));	
			if(!empty($last_user))			
			{
				$last_user = end($last_user);
				$last_uid = $last_user->uid;
				$custom_uid = $last_uid+1;
			}
			else $custom_uid = 1000;
			//echo $custom_uid;
			//exit;
			$this->uid = $custom_uid;
		}
		return true;
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'id' => 'ID',
				'uid' => 'Uid',
				'company' => 'Ragione sociale',
				'name' => 'Insegna ',
				'city' => 'Località',
				'user_email' => 'User Email',
				'location' => 'Provincia',
				'status' => 'Status',
				'device'=>'Device',
				'shop_type' => 'Tipologia di esercizio',
				'addresses' => 'Indirizzo',
				'vat' => 'Partita IVA',
				'zip' => 'CAP (zip)',
				'start_date' => 'Data di attivazione servizio',
				'end_date' => 'Data di cessazione servizio',
				'team_viewer' => 'TeamViewr ID'
				//'to' => 'To',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('name',$this->name,true);
		//$criteria->compare('user_email',$this->user_email,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('device',$this->device,true);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,'pagination'=> array('pageSize'=>50),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Customers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
