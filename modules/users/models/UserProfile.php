<?php

namespace wiro\modules\users\models;

use CActiveDataProvider;
use CDbCriteria;
use wiro\base\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{user_profiles}}".
 *
 * The followings are the available columns in table '{{user_profiles}}':
 * @property integer $profileId
 * @property integer $userId
 * @property string $companyName
 * @property string $firstName
 * @property string $lastName
 * @property string $phone
 * @property string $address
 */
class UserProfile extends ActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserProfile the static model class
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
	return '{{user_profiles}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
	return array(
	    array('companyName, firstName, lastName, address', 'length', 'max' => 255),
	    array('phone', 'length', 'max' => 15),
	    array('companyName, firstName, lastName, address', 'safe', 'on' => 'search'),
	);
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
	return array(
	    'user' => array(self::BELONGS_TO, 'wiro\modules\users\models\User', 'userId'),
	);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
	return array(
	    'companyName' => Yii::t('wiro', 'Company name'),
	    'firstName' => Yii::t('wiro', 'First name'),
	    'lastName' => Yii::t('wiro', 'Last name'),
	    'phone' => Yii::t('wiro', 'Phone'),
	    'address' => Yii::t('wiro', 'Address'),
	);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
	$criteria = new CDbCriteria;
	$criteria->compare('companyName', $this->companyName, true);
	$criteria->compare('firstName', $this->firstName, true);
	$criteria->compare('lastName', $this->lastName, true);
	$criteria->compare('address', $this->address, true);
	return new CActiveDataProvider($this, array(
	    'criteria' => $criteria,
	));
    }
}