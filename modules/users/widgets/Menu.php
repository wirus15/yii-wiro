<?php

Yii::import('bootstrap.widgets.TbMenu');

class Menu extends TbMenu
{
    private $_js = array();

    public function init()
    {
	parent::init();
	foreach ($this->items as $id => $item)
	    $this->initClickEvents($id, $item);
	$this->registerScript();
    }

    protected function initClickEvents($id, $item)
    {
	static $count = 0;
	if (isset($item['click'])) {
	    $id = 'mi' . $count++;
	    if (!isset($item['linkOptions']['id']))
		$this->items[$id]['linkOptions']['id'] = 'mi' . $count;
	    if (!$item['click'] instanceof CJavaScriptExpression)
		$this->items[$id]['click'] = new CJavaScriptExpression($item['click']);

	    $function = CJavaScript::encode($this->items[$id]['click']);
	    $this->_js[] = "$(document).on('click','#$id',$function);";
	}
    }

    private function registerScript()
    {
	if ($this->_js !== array())
	    Yii::app()->clientScript->registerScript('menu-' . $this->id, implode("\n", $this->_js));
    }
}

?>
