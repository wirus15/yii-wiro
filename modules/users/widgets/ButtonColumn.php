<?php

Yii::import('bootstrap.widgets.TbButtonColumn');

class ButtonColumn extends TbButtonColumn
{

    public function init()
    {
	$this->initDefaultButtons();

	foreach ($this->buttons as $id => $button) {
	    if ($this->buttonExistsInTemplate($id) == false) {
		unset($this->buttons[$id]);
		continue;
	    }

	    $this->initAjaxButton($id);
	    $this->initModalButton($id);
	    $button = $this->buttons[$id];
	    if (isset($button['click'])) {
		if (!isset($button['options']['class']))
		    $this->buttons[$id]['options']['class'] = $id;
		if (!($button['click'] instanceof CJavaScriptExpression))
		    $this->buttons[$id]['click'] = new CJavaScriptExpression($button['click']);
	    }
	}

	$this->registerClientScript();
    }

    private function initAjaxButton($id)
    {
	$button = $this->buttons[$id];
	if (isset($button['ajaxUrl'])) {
	    $this->buttons[$id]['url'] = $button['ajaxUrl'];
	    $this->buttons[$id]['click'] = "function(e) {
		e.preventDefault();
	        $.fn.yiiGridView.update('{$this->grid->id}', {
	            type:'POST',
	            url:$(this).attr('href'),
	            success:function(data) {
		        $.fn.yiiGridView.update('{$this->grid->id}');
		    },
		}); 
	    }";
	}
    }

    private function initModalButton($id)
    {
	$button = $this->buttons[$id];
	if (isset($button['modal']) && $button['modal'] !== false) {
	    $modal = is_string($button['modal']) ? array('size' => $button['modal']) : $modal;
	    $this->buttons[$id]['click'] = 'function(e) {
		e.preventDefault();
		var url = $(this).attr("href");		
		$.wiro.modalWindow(url, ' . CJavaScript::encode($modal) . ');
	    }';
	}
    }

    protected function initDefaultButtons()
    {
	if (isset($this->buttons['delete']['click'])) {
	    parent::initDefaultButtons();
	} else {
	    parent::initDefaultButtons();
	    $this->buttons['delete']['click'] = "function(e) {
		e.preventDefault();
		var url = $(this).attr('href');
		$.wiro.deleteConfirm('{$this->deleteConfirmation}', function(result) {
		    if(result) $.fn.yiiGridView.update('{$this->grid->id}', {
			type:'POST',
			url: url,
			success:function(data) {
			    $.fn.yiiGridView.update('{$this->grid->id}');
			}
		    });
		}, {
		    confirmLabel: '" . Yii::t('wiro', 'Delete') . "',
		    cancelLabel: '" . Yii::t('wiro', 'Cancel') . "',
		});
	    }";
	}
    }

    protected function buttonExistsInTemplate($id)
    {
	return strpos($this->template, '{' . $id . '}') !== false;
    }

    protected function registerClientScript()
    {
	parent::registerClientScript();
	Yii::app()->clientScript->registerScriptFile(Wiro::publishAssets('js/bootbox.min.js'));
    }
}

?>
