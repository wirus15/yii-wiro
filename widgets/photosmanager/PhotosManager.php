<?php

namespace wiro\widgets\photosmanager;

use CHttpException;
use CInputWidget;
use TbHtml;
use wiro\components\image\Image;
use wiro\helpers\DefaultAttributes;
use Yii;

/**
 * Description of PhotosManager
 *
 * @author wirus
 */
class PhotosManager extends CInputWidget
{
    public $template = '<legend>{label}&nbsp;{loader}</legend>{images}<div class="form-actions">{uploadButton}</div>';
    public $label;
    public $buttonLabel;
    public $thumbWidth = 120;
    public $thumbHeight = 120;
	    
    public function init()
    {
	if(isset($_POST['PhotosManager']['action']))
	    $this->runAction($_POST['PhotosManager']['action']);
	
	DefaultAttributes::set($this, array(
	    'label' => Yii::t('wiro', 'Photos'),
	    'buttonLabel' => Yii::t('wiro', 'Add photos'),
	));
	
	$this->registerScripts();
    }
    
    protected function runAction($action)
    {
	switch($action) {
	    case 'upload':
		break;
	    case 'sort':
		$this->model->sortImages($this->attribute, $_POST['PhotosManager']['sort']);
		break;
	    case 'remove':
		$this->model->removeImage($this->attribute, $_POST['PhotosManager']['image']);
		break;
	    default:
		throw new CHttpException('Unknown photos manager action.');
	}
	$this->model->save();
	
	if(Yii::app()->request->isAjaxRequest)
	    Yii::app()->end();
	else
	    $this->controller->refresh();
    }
    
    private function registerScripts()
    {
	$script = Yii::app()->assetManager->publish(__DIR__.'/photos-manager.js');
	Yii::app()->clientScript
	    ->registerScriptFile($script)
	    ->registerScript($this->id, '$("#'.$this->id.'").photosManager();')
	    ->registerCoreScript('jquery.ui')
	    ->registerCss($this->id, '
		ul.thumbnails li .remove-button {
		    opacity: 0;
		    position: absolute;
		    margin-left: 3px;
		    margin-top: -33px;
		    transition: all .2s;
		    -webkit-transition: all .2s;
		    -moz-transition: all .2s;
		}
		ul.thumbnails li:hover .remove-button {
		    opacity: 1;
		}
	    ');
    }
    
    public function run()
    {
	$loader = Yii::app()->assetManager->publish(Yii::getPathOfAlias('wiro.assets.images').'/loader.gif');
	
	echo TbHtml::openTag('div', array('id' => $this->id));
	echo strtr($this->template, array(
	    '{label}' => $this->label,
	    '{loader}' => TbHtml::image($loader, '', array('class' => 'ajax-loader')),
	    '{images}' => $this->renderThumbnails(),
	    '{uploadButton}' => $this->renderUploadButton(),
	));
	echo TbHtml::closeTag('div');
    }
    
    protected function renderThumbnails()
    {
	ob_start();
	$this->beginWidget('bootstrap.widgets.TbActiveForm');
	echo TbHtml::hiddenField('PhotosManager[action]', 'sort');
	if(is_array($images = $this->model->{$this->attribute})) {
	    echo TbHtml::openTag('ul', array('class'=>'thumbnails'));
	    foreach($images as $image)
		$this->renderSingleThumbnail($image);
	    echo TbHtml::closeTag('ul');
	}
	$this->endWidget();
	return ob_get_clean();
    }
    
    /**
     * 
     * @param Image $image
     */
    protected function renderSingleThumbnail($image)
    {
	$thumbnail = TbHtml::image($image->thumb($this->thumbWidth, $this->thumbHeight));
	$orderField = TbHtml::hiddenField('PhotosManager[sort][]', $image->relativePath);
	$removeButton = TbHtml::btn(TbHtml::BUTTON_TYPE_LINK, '', array(
	    'url' => Yii::app()->request->url,
	    'icon' => 'icon-remove icon-white',
	    'color' => TbHtml::BUTTON_COLOR_DANGER,
	    'class' => 'remove-button',
	    'data-image' => $image->relativePath,
	));
	echo TbHtml::thumbnailLink($thumbnail.$orderField.$removeButton, $image->url);
    }

    protected function renderUploadButton()
    {
	ob_start();
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	    'htmlOptions' => array('enctype' => 'multipart/form-data'),
	));
	echo TbHtml::hiddenField('PhotosManager[action]', 'upload');
	echo $form->fileField($this->model, $this->attribute.'[]', array('multiple' => true, 'accept' => 'image/*'));
	echo TbHtml::button($this->buttonLabel, array(
	    'class' => 'upload-button',
	    'color' => TbHtml::BUTTON_COLOR_PRIMARY,
	    'icon' => 'icon-plus icon-white',
	));
	$this->endWidget();
	return ob_get_clean();
    }
}
