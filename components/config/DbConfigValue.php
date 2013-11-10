<?php

namespace wiro\components\config;

use CActiveDataProvider;
use CDbCriteria;
use wiro\base\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{config}}".
 * @author Maciej Krawczyk <wirus15@gmail.com>
 * @property string $fullKey
 * @property-read string $key
 * @property string $value
 * @property string $type
 */
class DbConfigValue extends ActiveRecord
{
    const STRING = 0;
    const INTEGER = 1;
    const FLOAT = 2;
    const TEXT = 3;
    const BOOLEAN = 4;
    const DATE = 5;
    const DATETIME = 6;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
	return '{{config}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
	return array(
	    array('key', 'required'),
	    array('key', 'length', 'max' => 255),
	    array('type', 'in', 'range' => array(
		self::STRING, self::INTEGER, self::FLOAT, self::TEXT, self::BOOLEAN, self::DATE, self::DATETIME
	    )),
	    array('value', 'safe'),
	    array('key', 'safe', 'on' => 'search'),
	);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
	return array(
	    'key' => Yii::t('wiro', 'Key'),
	    'value' => Yii::t('wiro', 'Value'),
	    'type' => Yii::t('wiro', 'Data type'),
	);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
	$criteria = new CDbCriteria;
	$criteria->compare('key', $this->key, true);
	return new CActiveDataProvider($this, array(
	    'criteria' => $criteria,
	    'sort' => array(
		'defaultOrder' => 'key asc',
	    ),
	));
    }
}