<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $user_id
 * @property string $user_name
 * @property string $password
 * @property integer $device_id
 * @property string $email
 * @property integer $tel
 * @property integer $scoin
 * @property string $avatar
 * @property string $birthday
 * @property string $fullname
 * @property integer $gender
 * @property string $last_login
 * @property string $join_time
 * @property string $modified_time
 * @property string $display_name
 * @property integer $inviter_id
 */
class Users extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('email,password', 'required'),
            array('email,device_id', 'unique'),
			array('device_id, tel, scoin, gender, inviter_id', 'numerical', 'integerOnly'=>true),
			array('user_name, password, email, avatar, fullname, display_name', 'length', 'max'=>255),
			array('birthday, last_login, join_time, modified_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, user_name, password, device_id, email, tel, scoin, avatar, birthday, fullname, gender, last_login, join_time, modified_time, display_name, inviter_id', 'safe', 'on'=>'search'),
            array('modified_time','default',
                'value'=>new CDbExpression('NOW()'),
                'setOnEmpty'=>false,'on'=>'update'),
            array('join_time,modified_time','default',
                'value'=>new CDbExpression('NOW()'),
                'setOnEmpty'=>false,'on'=>'insert')
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
			'user_id' => 'User',
			'user_name' => 'User Name',
			'password' => 'Password',
			'device_id' => 'Device',
			'email' => 'Email',
			'tel' => 'Tel',
			'scoin' => 'Scoin',
			'avatar' => 'Avatar',
			'birthday' => 'Birthday',
			'fullname' => 'Fullname',
			'gender' => 'Gender',
			'last_login' => 'Last Login',
			'join_time' => 'Join Time',
			'modified_time' => 'Modified Time',
			'display_name' => 'Display Name',
			'inviter_id' => 'Inviter',
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('device_id',$this->device_id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('tel',$this->tel);
		$criteria->compare('scoin',$this->scoin);
		$criteria->compare('avatar',$this->avatar,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('last_login',$this->last_login,true);
		$criteria->compare('join_time',$this->join_time,true);
		$criteria->compare('modified_time',$this->modified_time,true);
		$criteria->compare('display_name',$this->display_name,true);
		$criteria->compare('inviter_id',$this->inviter_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
