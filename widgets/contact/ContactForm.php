<?php

namespace wiro\widgets\contact;

use CMap;
use CWidget;
use TbHtml;
use wiro\components\mail\YiiMailMessage;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 * @property-read ContactFormModel $model
 * @property-read boolean $messageSent
 */
class ContactForm extends CWidget
{
    const TOKEN_VAR = 'form-token';
    
    public $emailAddress;
    public $modelClass = 'wiro\widgets\contact\ContactFormModel';
    public $view = 'default';
    public $captchaOptions = array();
    public $useCaptcha = false;
    public $ajaxSubmit = false;
    private $model;
    private $messageSent = false;

    public function init()
    {
	$this->model = Yii::createComponent($this->modelClass);
	$this->emailAddress = Yii::app()->params->contactEmail;
	$this->captchaOptions = CMap::mergeArray(array(
		    'captchaAction' => '/site/captcha',
		    'clickableImage' => true,
		    'showRefreshButton' => false,
		    'imageOptions' => array(
			'style' => 'cursor: pointer',
		    ),
		), $this->captchaOptions);
	$this->model->captchaAction = $this->captchaOptions['captchaAction'];
	
	if($this->ajaxSubmit) {
	    Yii::app()->clientScript->registerScript($this->id, '
		$("body").on("submit", "#'.$this->id.' form", function(e) {
		    e.preventDefault();
		    var form = $(this);
		    var data = form.serialize();
		    var url = form.attr("action");
		    
		    form.find("input,textarea,button")
			.addClass("disabled")
			.attr("disabled", true);
			
		    $.post(url, data, function(html) {
			var content = $(html).find("#'.$this->id.'").html();
			$("#'.$this->id.'").html(content);
		    });
		});
	    ');
	}
    }

    public function run()
    {
	$modelClass = str_replace('\\', '_', $this->modelClass);
	if(isset($_POST[$modelClass])) {
	    $this->model->attributes = $_POST[$modelClass];
	    if($this->model->validate()) {
		$this->send();
		$this->messageSent = true;
	    }
	}

	$this->model->token = $this->generateToken();
	echo '<div id="'.$this->id.'">';
	$this->render($this->view, array(
	    'model' => $this->model,
	));
	echo '</div>';
    }

    private function send()
    {
	$message = new YiiMailMessage;
	$message->setSubject($this->model->subject);
	$message->setBody($this->model->body);
	$message->setFrom(array($this->model->email => $this->model->name));
	$message->setTo($this->emailAddress);
	$message->setReplyTo($this->model->email);
	Yii::app()->mail->send($message);
    }

    public function getModel()
    {
	return $this->model;
    }

    public function getMessageSent()
    {
	return $this->messageSent;
    }
    
    private function generateToken()
    {
	$token = uniqid();
	Yii::app()->user->setState(self::TOKEN_VAR, $token);
	return $token;
    }
}
