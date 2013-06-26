<?php

namespace wiro\widgets\contact;

use CMap;
use CWidget;
use wiro\components\mail\YiiMailMessage;
use wiro\helpers\DefaultAttributes;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 * @property-read ContactFormModel $model
 * @property-read boolean $messageSent
 */
class ContactForm extends CWidget
{
    const TOKEN_VAR = 'form-token';
    const VIEW_DEFAULT = 'default';
    const VIEW_BOOTSTRAP = 'bootstrap';
    
    public $emailAddress;
    public $modelClass = 'wiro\widgets\contact\ContactFormModel';
    public $formClass;
    public $formOptions = array();
    public $view = self::VIEW_DEFAULT;
    public $useCaptcha = false;
    public $captchaOptions = array();
    public $ajaxSubmit = false;
    private $model;
    private $messageSent = false;
    private $form;
    
    public function __get($name)
    {
	try {
	    return parent::__get($name);
	} catch (CException $e) {
	    return $this->form->__get($name);
	}
    }
    
    public function __set($name, $value)
    {
	try {
	    return parent::__set($name, $value);
	} catch (CException $e) {
	    return $this->form->__set($name, $value);
	}
    }
    
    public function __isset($name)
    {
	try {
	    return parent::__isset($name);
	} catch (CException $e) {
	    return $this->form->__isset($name);
	}
    }
    
    public function __unset($name)
    {
	try {
	    return parent::__unset($name);
	} catch (CException $e) {
	    return $this->form->__unset($name);
	}
    }
    
    public function init()
    {
	$this->model = Yii::createComponent($this->modelClass);
	$this->captchaOptions = CMap::mergeArray(array(
		    'captchaAction' => '/site/captcha',
		    'clickableImage' => true,
		    'showRefreshButton' => false,
		    'imageOptions' => array(
			'style' => 'cursor: pointer',
		    ),
		), $this->captchaOptions);
	$this->model->captchaAction = $this->captchaOptions['captchaAction'];
	
	DefaultAttributes::set($this, array(
	    'emailAddress' => Yii::app()->params->contactEmail,
	));
	
	$this->processSubmittedForm();
	$this->renderFormHeader();
    }
    
    private function processSubmittedForm()
    {
	$modelClass = str_replace('\\', '_', $this->modelClass);
	if(isset($_POST[$modelClass])) {
	    $this->model->attributes = $_POST[$modelClass];
	    if($this->model->validate()) {
		$this->send();
		$this->messageSent = true;
	    }
	}
    }
    
    private function renderFormHeader()
    {
	echo '<div id="'.$this->id.'">';
	$this->form = $this->beginWidget($this->formClass, $this->formOptions);
	echo $this->form->hiddenField($this->model, 'token');
	if($this->ajaxSubmit)
	    echo $this->ajaxSubmitScript();
    }

    public function run()
    {
	if($this->view !== null) {
	    $this->render($this->view, array(
		'form' => $this->form,
		'model' => $this->model,
	    ));
	}
	$this->model->token = $this->generateToken();
	$this->endWidget();
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
    
    public function getForm()
    {
	return $this->form;
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
    
    private function ajaxSubmitScript() {
	return '<script>
		(function($) {
		    $("#'.$this->id.' form").submit(function(e) {
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
		})(jQuery);
	    </script>';
    }
}
