<?php

namespace wiro\modules\users\models\forms;

use CFormModel;
use wiro\modules\users\models\User;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class PasswordForm extends CFormModel
{
    /**
     *
     * @var string
     */
    public $oldPassword;
    /**
     *
     * @var string
     */
    public $password;
    /**
     *
     * @var string
     */
    public $confirmPassword;
    /**
     *
     * @var string
     */
    private $_currentPassword;
    
    public function __construct(User $user)
    {
	parent::__construct('update');
	$this->_currentPassword = $user->password;
    }

    public function rules()
    {
	return array(
	    array('oldPassword, password, confirmPassword', 'required'),
	    array('confirmPassword', 'compare', 'compareAttribute' => 'password'),
	    array('oldPassword', 'validatePassword'),
	);
    }
    
    public function validatePassword() 
    {
	if(!Yii::app()->hash->pass->compare($this->oldPassword, $this->_currentPassword)) 
	    $this->addError('oldPassword', Yii::t('wiro', 'Invalid password.'));
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
	return array(
	    'oldPassword' => Yii::t('wiro', 'Current password'),
	    'password' => Yii::t('wiro', 'New password'),
	    'confirmPassword' => Yii::t('wiro', 'Confirm new password'),
	);
    }
}
