<?php

namespace wiro\modules\pages\models;

use CActiveDataProvider;
use CDbCriteria;
use wiro\helpers\DateHelper;
use Yii;
use wiro\base\ActiveRecord;

class Page extends ActiveRecord
{
    /**
     * @return Page
     */
    public static function model($className = __CLASS__)
    {
	return parent::model($className);
    }
    
    public function tableName()
    {
	return '{{pages}}';
    }
    
    public function rules() {
        return array(
            array('pageTitle', 'required'),
            array('pageTitle, pageAlias, metaKeywords, pageView', 'length', 'max'=>255),
            array('pageContent, metaDescription, updateTime', 'safe'),
            array('pageContent, metaKeywords, metaDescription, pageView, updateTime', 'default', 'setOnEmpty' => true, 'value' => null),
            array('pageId, pageTitle, pageContent, metaKeywords, metaDescription, pageView, updateTime', 'safe', 'on'=>'search'),
        );
    }

    public function attributeLabels()
    {
	return array(
	    'pageTitle' => Yii::t('wiro', 'Page title'),
	    'pageAlias' => Yii::t('wiro', 'Page alias'),
	    'pageContent' => Yii::t('wiro', 'Page content'),
	    'metaKeywords' => Yii::t('wiro', 'Meta keywords'),
	    'metaDescription' => Yii::t('wiro', 'Meta description'),
	    'pageView' => Yii::t('wiro', 'Page\'s view'),
	    'updateTime' => Yii::t('wiro', 'Last modified'),
	);
    }
    
    public function behaviors() {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => null,
                'updateAttribute' => 'updateTime',
                'timestampExpression' => DateHelper::now(),
            ),
        );
    }
    
    public function search() {
        $criteria = new CDbCriteria;
	$criteria->compare('pageAlias', $this->pageAlias);
        $criteria->compare('pageTitle', $this->pageTitle, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}