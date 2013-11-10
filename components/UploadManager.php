<?php

namespace wiro\components;

use CApplicationComponent;
use CModel;
use CUploadedFile;
use wiro\helpers\PathHelper;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class UploadManager extends CApplicationComponent 
{
    public $uploadPath;
    public $uploadUrl;
    public $preserveFilenames = false;
    
    public function init()
    {
	if($this->uploadPath === null)
	    $this->uploadPath = Yii::getPathOfAlias('root.upload');
	if($this->uploadUrl === null)
	    $this->uploadUrl = Yii::app()->baseUrl.'/upload';
    }
    
    /**
     * 
     * @param CUploadedFile $file
     * @return string Relative path
     */
    public function saveUploadedFile($file, $directory='', $preserveFilename=null)
    {
	if($preserveFilename === null)
	    $preserveFilename = $this->preserveFilenames;
	
	$filename = $preserveFilename ? $file->name : $this->randomizeFileName($file->name);
	$filepath = PathHelper::build($directory, $filename);
	$fullpath = PathHelper::build($this->uploadPath, $filepath);
	
	if(!is_dir(dirname($fullpath)))
	    @ mkdir(dirname($fullpath), 0777, true);
	return $file->saveAs($fullpath) ? $filepath : false;
    }
    
    public function getUploadedFile($model, $attribute=null)
    {
	if($model instanceof CModel)
	    return CUploadedFile::getInstance($model, $attribute);
	else
	    return CUploadedFile::getInstanceByName ($model);
    }
    
    public function getUploadedFiles($model, $attribute=null)
    {
	if($model instanceof CModel)
	    return CUploadedFile::getInstances ($model, $attribute);
	else
	    return CUploadedFile::getInstancesByName ($model);
    }
    
    public function randomizeFileName($filename, $length = 15)
    {
	$extension = pathinfo($filename, PATHINFO_EXTENSION);
	return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length).'.'.$extension;
    }
}
