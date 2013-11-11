<?php

namespace wiro\widgets;

use CActiveForm;
use CHtml;
use CInputWidget;
use TbHtml;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class UploadButton extends CInputWidget
{
    /**
     * @var CActiveForm
     */
    public $form;
    public $action;
    public $label = 'Add file';
    public $buttonOptions = array();
    private $endForm = false;
    private $fieldId;
    
    public function init()
    {
        if(!$this->form) {
            $this->endForm = true;
            $this->form = Yii::app()->controller->beginWidget('CActiveForm', array(
                'action' => $this->action,
                'htmlOptions' => array(
                    'enctype' => 'multipart/form-data',
                ),
            ));
        }
        
        $this->buttonOptions['id'] = $this->id;
    }
    
    public function run()
    {
        $options = array(
            'style' => 'display: none; position: absolute; left: -9999px; top: -9999px',
        );
        
        echo TbHtml::button($this->label, $this->buttonOptions);
        
        if($this->model && $this->attribute) {
            echo $this->form->fileField($this->model, $this->attribute, $options);
            $this->fieldId = CHtml::activeId($this->model, $this->attribute);
        } else {
            echo CHtml::fileField($this->name, null, $options);
            $this->fieldId = $this->name;
        }

        $this->registerScript();
        if($this->endForm)
            Yii::app()->controller->endWidget();
    }
    
    private function registerScript()
    {
        Yii::app()->clientScript->registerScript('upload#'.$this->id, '
            $("#'.$this->id.'").on("click", function(e) {
                $("#'.$this->fieldId.'").trigger("click");
            });
            
            $("#'.$this->fieldId.'").on("change", function(e) {
                $(this).parents("form").submit();
            });
        ');
    }
}
