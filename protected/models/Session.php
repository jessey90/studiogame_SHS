<?php

/**
 * This is the model class for table "session".
 *
 * The followings are the available columns in table 'session':
 * @property integer $session_id
 * @property string $session
 * @property integer $ip_address
 * @property integer $game_id
 * @property string $expired_date
 * @property integer $game_server_id
 * @property integer $user_game_id
 * @property string $last_login
 *
 * The followings are the available model relations:
 * @property UserSession[] $userSessions
 */
class Session extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'session';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('session, game_id', 'required'),
			array('ip_address, game_id, game_server_id, user_game_id', 'numerical', 'integerOnly'=>true),
			array('session', 'length', 'max'=>255),
			array('expired_date, last_login', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('session_id, session, ip_address, game_id, expired_date, game_server_id, user_game_id, last_login', 'safe', 'on'=>'search'),
            array('last_login','default',
                'value'=>new CDbExpression('NOW()'),
                'setOnEmpty'=>false,'on'=>'insert'),
            array('last_login','default',
                'value'=>new CDbExpression('NOW()'),
                'setOnEmpty'=>false,'on'=>'update')
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
			'userSessions' => array(self::HAS_MANY, 'UserSession', 'sesion_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'session_id' => 'Session',
			'session' => 'Session',
			'ip_address' => 'Ip Address',
			'game_id' => 'Game',
			'expired_date' => 'Expired Date',
			'game_server_id' => 'Game Server',
			'user_game_id' => 'User Game',
			'last_login' => 'Last Login',
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

		$criteria->compare('session_id',$this->session_id);
		$criteria->compare('session',$this->session,true);
		$criteria->compare('ip_address',$this->ip_address);
		$criteria->compare('game_id',$this->game_id);
		$criteria->compare('expired_date',$this->expired_date,true);
		$criteria->compare('game_server_id',$this->game_server_id);
		$criteria->compare('user_game_id',$this->user_game_id);
		$criteria->compare('last_login',$this->last_login,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Session the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
