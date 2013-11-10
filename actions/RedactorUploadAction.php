<?php

namespace wiro\actions;

use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class RedactorUploadAction extends Action
{
    public $fieldName = 'file';
    
    public function run($clipboard=false)
    {
        $upload = Yii::app()->upload;
        
        if($clipboard)
            $path = $this->uploadFromClipboard();
        else 
            $path = $upload->saveUploadedFile(
                    $upload->getUploadedFile($this->fieldName));
        
        echo stripslashes(json_encode(array(
            'filelink' => $upload->uploadUrl.'/'.$path,
        )));
    }
    
    private function uploadFromClipboard()
    {
        $upload = Yii::app()->upload;
        
        $data = base64_decode($_POST['data']);
        $filename = $upload->randomizeFileName('clipboard.'.
                $this->getExtension($_POST['contentType']));
        
        file_put_contents($upload->uploadPath.'/'.$filename, $data);
        
        return $filename;
    }
    
    private function getExtension($contentType)
    {
        static $extensions;
        if($extensions === null)
            $extensions = array_flip(require(Yii::getPathOfAlias('system.utils.mimeTypes').'.php'));
        
        return isset($extensions[$contentType]) ? $extensions[$contentType] : null;
    }
}
