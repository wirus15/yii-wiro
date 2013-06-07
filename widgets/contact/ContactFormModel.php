<?php

namespace wiro\widgets\contact;

use CCaptcha;
use CFormModel;
use Yii;

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactFormModel extends CFormModel
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;
    public $captchaAction;
    public $token;
    
    /**
     * Declares the validation rules.
     */
    public function rules()
    {
	return array(
	    array('name, email, subject, body', 'required'),
	    array('email', 'email'),
	    //array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements(), 'captchaAction' => $this->captchaAction),
	    array('token', 'compare', 'compareValue' => Yii::app()->user->getState(ContactForm::TOKEN_VAR)),
	);
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
	return array(
	    'name' => Yii::t('wiro', 'Name'),
	    'email' => Yii::t('wiro', 'E-mail'),
	    'subject' => Yii::t('wiro', 'Subject'),
	    'body' => Yii::t('wiro', 'Body'),
	    'verifyCode' => Yii::t('wiro', 'Rewrite code'),
	);
    }
}