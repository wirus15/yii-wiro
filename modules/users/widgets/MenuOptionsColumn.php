<?php

Yii::import('user.widgets.ButtonColumn');

class MenuOptionsColumn extends ButtonColumn
{
    /**
     * @var string
     */
    public $type = 'primary';
    /**
     * @var string
     */
    public $label;
    /**
     * @var string[]
     */
    public $template = array('view', 'update', 'delete');
    /**
     * @var string
     */
    public $size = 'mini';

    public function init()
    {
	if ($this->label === null)
	    $this->label = Yii::t('wiro', 'Action');
	parent::init();
    }

    /**
     * @param integer $row
     * @param User $data
     */
    protected function renderDataCellContent($row, $data)
    {

	$buttons = array();
	foreach ($this->template as $id) {
	    if (($button = $this->renderButton($id, $this->buttons[$id], $row, $data)) !== null) {
		$buttons[] = $button;
	    }
	}

	Yii::app()->controller->widget('bootstrap.widgets.TbButtonGroup', array(
	    'type' => $this->type,
	    'size' => $this->size,
	    'buttons' => array(
		array('label' => $this->label, 'items' => $buttons),
	    ),
	));
    }

    protected function renderButton($id, $button, $row, $data)
    {
	if (isset($button['visible']) && !$this->evaluateExpression($button['visible'], array('row' => $row, 'data' => $data)))
	    return null;

	$icon = isset($button['icon']) ? $button['icon'] : null;
	$label = isset($button['label']) ? $button['label'] : $id;
	$url = isset($button['url']) ? $this->evaluateExpression($button['url'], array('data' => $data, 'row' => $row)) : '#';
	$options = isset($button['options']) ? $button['options'] : array();

	return array(
	    'label' => $label,
	    'icon' => $icon,
	    'url' => $url,
	    'linkOptions' => $options,
	);
    }

    protected function buttonExistsInTemplate($id)
    {
	return in_array($id, $this->template);
    }
}

?>
