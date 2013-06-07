<?php

namespace wiro\widgets\fancybox;

use CJavaScript;
use CWidget;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class Fancybox extends CWidget
{
    public $target = '.fancybox';
    public $linkTogether = true;
    public $options = array();
    
    public function init()
    {
	$script = '$("'.$this->target.'")';
	if($this->linkTogether)
	    $script .= '.attr("rel", "'.$this->id.'")';
	$script .= '.fancybox('.CJavaScript::encode($this->options).');';
	
	$assets = Yii::app()->assetManager->publish(__DIR__.'/assets');
	Yii::app()->clientScript
		->registerScriptFile($assets.'/jquery.fancybox.pack.js')
		->registerCssFile($assets.'/jquery.fancybox.css')
		->registerCoreScript('jquery.mousewheel')
		->registerScript($this->id, $script);
    }
}
