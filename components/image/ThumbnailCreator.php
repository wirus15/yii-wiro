<?php

namespace wiro\components\image;

use CApplicationComponent;
use CJSON;
use PhpThumbFactory;
use wiro\helpers\PathHelper;
use Yii;

require_once Yii::getPathOfAlias('vendor.masterexploder.phpthumb.src').'/ThumbLib.inc.php';

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class ThumbnailCreator extends CApplicationComponent
{
    const THUMBS_DIR = '/thumbs';
    
    public $width = 120;
    public $height = 90;
    public $adaptive = false;
    public $basePath;
    public $baseUrl;
    
    public function init()
    {
        if(!$this->basePath)
            $this->basePath = PathHelper::build (Yii::app()->assetManager->basePath, self::THUMBS_DIR);
        if(!$this->baseUrl)
            $this->baseUrl = PathHelper::build (Yii::app()->assetManager->baseUrl, self::THUMBS_DIR);
        if(!is_dir($this->basePath))
            @ mkdir($this->basePath);
    }
    
    public function create($file, $width=null, $height=null, $adaptive=null)
    {
        $params = array(
            'file' => $file,
            'width' => $width ? $width : $this->width,
            'height' => $height ? $height : $this->height,
            'adaptive' => $adaptive ? $adaptive : $this->adaptive,
        );
        
        $thumbFile = $this->resolveThumbFile($params);
        $thumbPath = PathHelper::build($this->basePath, $thumbFile);
        $thumbUrl = PathHelper::build($this->baseUrl, $thumbFile);
        
        if(!file_exists($thumbPath)) {
            $image = PhpThumbFactory::create($file);
            if($adaptive)
                $image->adaptiveResize($params['width'], $params['height']);
            else
                $image->resize($params['width'], $params['height']);
            $image->save($thumbPath);
        }
        
        return $thumbUrl;
    }
    
    private function resolveThumbFile($params)
    {
        $extension = pathinfo($params['file'], PATHINFO_EXTENSION);
        return md5(CJSON::encode($params)).'.'.$extension;
    }
}
