<?php

/**
 * This is the model class for table "{{jingles}}".
 *
 * The followings are the available columns in table '{{jingles}}':
 * @property integer $id
 * @property string $tittle
 * @property string $path
 * @property integer $type
 */
class Jingles extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $upload;
	public function tableName()
	{
		return '{{jingles}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should, only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tittle,customer_id', 'required'),
			//array('upload', 'required', 'on' => 'hasUpload'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('tittle', 'length', 'max'=>150),
			array('upload', 'file','safe'=>true, 'allowEmpty' => true, 'types'=>'mp3', 'maxSize' => 1024 * 1024 * 10, // 10MB                
                'tooLarge' => 'The file was larger than 10MB. Please upload a smaller file.'),
			//array('path', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('id, tittle, path, type', 'safe', 'on'=>'search'),
		);
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
			'tittle' => 'Title',
			'path' => 'File',
			'type' => 'Type',
			'customer_id' => 'Customer',
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
		$criteria->compare('tittle',$this->tittle,true);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Jingles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
