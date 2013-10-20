<?php

namespace wiro\modules\users\models;

use CActiveDataProvider;
use CDbCriteria;
use UserProfile;
use wiro\base\ActiveRecord;
use wiro\helpers\DateHelper;
use wiro\helpers\StringHelper;
use wiro\modules\users\UserModule;
use Yii;

/**
 * This is the model class for table "{{users}}".
 *
 * The followings are the available columns in table '{{users}}':
 * @property integer $userId
 * @property string $username
 * @property string $password
 * @property string $email
 * @property boolean $active
 * @property string $activationCode
 * @property string $registrationDate
 * @property string $lastLogin
 * @property boolean $suspended
 * @property string $suspensionReason
 * @property string $role
 * @property UserProfile $profile
 */
class User extends ActiveRecord
{
    /**
     * @var string
     */
    public $confirmPassword;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__)
    {
	return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
	return '{{users}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
	return array(
	    array('username, password, email', 'required'),
	    array('confirmPassword', 'required', 'on'=>'register'),
	    array('username, password, email, role', 'length', 'max' => 80),
	    array('email', 'email'),
	    array('confirmPassword', 'compare', 'compareAttribute' => 'password', 'on' => 'register'),
	    array('activationCode', 'default', 'value' => StringHelper::getRandom()),
	    array('active', 'default', 'value' => Yii::app()->getModule('user')->accountActivation === UserModule::NO_ACTIVATION),
	    array('suspended', 'default', 'value' => false),
	    array('registrationDate', 'default', 'value' => DateHelper::now()),
	    array('username, email', 'unique'),
	    array('username, email, active, registrationDate, lastLogin, suspended, role', 'safe', 'on' => 'search'),
	);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
	return array(
	    'username' => Yii::t('wiro', 'Username'),
	    'password' => Yii::t('wiro', 'Password'),
	    'confirmPassword' => Yii::t('wiro', 'Confirm password'),
	    'email' => Yii::t('wiro', 'Email'),
	    'active' => Yii::t('wiro', 'Activated'),
	    'activationCode' => Yii::t('wiro', 'Activation code'),
	    'registrationDate' => Yii::t('wiro', 'Registered'),
	    'lastLogin' => Yii::t('wiro', 'Last login'),
	    'suspended' => Yii::t('wiro', 'Suspended'),
	    'suspensionReason' => Yii::t('wiro', 'Suspension reason'),
	    'role' => Yii::t('wiro', 'Role'),
	);
    }

    /**
     * 
     * @return array
     */
    public function relations()
    {
	$relations = array();
	if($profileClass=Yii::app()->getModule('user')->profileClass)
	    $relations['profile'] = array(self::HAS_ONE, $profileClass, 'userId');
	return $relations;
    }
    
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
	$criteria = new CDbCriteria;
	$criteria->compare('username', $this->username, true);
	$criteria->compare('email', $this->email, true);
	$criteria->compare('active', $this->active);
	$criteria->compare('registrationDate', $this->registrationDate, true);
	$criteria->compare('lastLogin', $this->lastLogin, true);
	$criteria->compare('suspended', $this->suspended);
	$criteria->compare('role', $this->role);
	return new CActiveDataProvider($this, array(
	    'criteria' => $criteria,
	    ));
    }
    
    protected function beforeSave()
    {
	if(parent::beforeSave()) {
	    $hash = Yii::app()->hash->pass;
	    if(!$hash->isHashed($this->password))
		$this->password = $hash->make($this->password);
	    return true;
	}
	return false;
    }
    
    public function getRoleName()
    {
	$role = Yii::app()->authManager->roles[$this->role];
	return $role->description;
    }
    
    public function getIsLocked()
    {
	return $this->role == 'admin' || $this->role == 'developer';
    }
    
    public function getHasProfile()
    {
	return isset($this->profile);
    }
}