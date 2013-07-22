<?php

namespace wiro\components\sortable;

use CAction;
use wiro\base\ActiveRecord;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class ReorderAction extends CAction
{
    public $itemClass;
    public $view = 'reorder';
    
    public function run()
    {
	$models = ActiveRecord::model($this->itemClass)->findAll();
	if(isset($_POST['itemId'])) {
	    $positions = array_flip($_POST['itemId']);
	    foreach($positions as $itemId => $position) 
		ActiveRecord::model($this->itemClass)->updateByPk($itemId, array('listOrder' => $position));
	    $this->controller->redirect(array('index'));
	}
	
	$this->controller->render($this->view, array(
	    'models' => $models,
	));
    }
}

