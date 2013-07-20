<?php

namespace wiro\modules\users\components;

use CApplicationComponent;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class ProfileFactory extends CApplicationComponent
{
    private $profileClass;
    
    public function __construct($profileClass)
    {
	$this->profileClass = $profileClass;
    }
    
    public function create($user, $scenario = 'insert')
    {
	$profile = null;
	if($this->profileClass !== null) {
	    $profile = Yii::createComponent($this->profileClass);
	    $profile->scenario = $scenario;
	    $profile->userId = $user->userId;
	}
	return $profile;
    }
}
