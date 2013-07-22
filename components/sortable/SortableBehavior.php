<?php

namespace wiro\components\sortable;

use CActiveRecord;
use CActiveRecordBehavior;
use CDbCriteria;
use Yii;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class SortableBehavior extends CActiveRecordBehavior 
{
    public $orderAttribute = 'listOrder';
    public $groupAttribute;
    
    public function beforeFind($event)
    {
	$criteria = $this->owner->dbCriteria;
	if(!$criteria->order)
	    $criteria->order = $this->orderAttribute;
    }
    
    public function moveDown() 
    {
	$nextItem = $this->getNextItem();
	if($nextItem) 
	    $this->swapPositions($this->owner, $nextItem);
    }
    
    public function moveUp() {
	$previousItem = $this->getPreviousItem();
	if($previousItem) 
	    $this->swapPositions($this->owner, $previousItem);
    }
    
    public function beforeSave($event) 
    {
	if(parent::beforeSave($event)) {
	    if($this->owner->isNewRecord) {
		$last = $this->getLastPosition();
		$this->setPosition($this->owner, $last !== false ? $last+1 : 0, false);
	    }
	    return true;
	}
	return false;
    }
    
    /**
     *
     * @return CDbCriteria
     */
    protected function createCriteria() {
	$criteria = new CDbCriteria();

	if($this->groupAttribute) {
	    $criteria->addColumnCondition(array(
		$this->groupAttribute => $this->owner->{$this->groupAttribute}
	    ));
	}
	
	return $criteria;
    }
    
    /**
     * 
     * @return integer
     */
    private function getLastPosition() 
    {
	$criteria = $this->createCriteria();
	$criteria->select = "MAX({$this->orderAttribute})";
	return Yii::app()->db->commandBuilder->createFindCommand($this->owner->tableName(), $criteria)->queryScalar();
    }
    
    /**
     * 
     * @return CActiveRecord
     */
    public function getNextItem()
    {
	$criteria = $this->createCriteria();
	$criteria->addCondition("{$this->orderAttribute}>{$this->getPosition($this->owner)}");
	$criteria->order = $this->orderAttribute.' asc';
	return $this->owner->find($criteria);
    }
    
    /**
     * @return CActiveRecord
     */
    public function getPreviousItem()
    {
	$criteria = $this->createCriteria();
	$criteria->addCondition("{$this->orderAttribute}<{$this->getPosition($this->owner)}");
	$criteria->order = $this->orderAttribute.' desc';
	return $this->owner->find($criteria);
    }
    
    /**
     * 
     * @param CActiveRecord $model
     * @return integer
     */
    private function getPosition($model)
    {
	return $model->{$this->orderAttribute};
    }
    
    /**
     * 
     * @param CActiveRecord $model
     * @param integer $position
     * @param boolean $save
     */
    private function setPosition($model, $position, $save=true)
    {
	$model->{$this->orderAttribute} = $position;
	if($save === true)
	    $model->save();
    }
    
    /**
     * 
     * @param CActiveRecord $modelA
     * @param CActiveRecord $modelB
     */
    private function swapPositions($modelA, $modelB)
    {
	$tmp = $this->getPosition($modelA);
	$this->setPosition($modelA, $this->getPosition($modelB));
	$this->setPosition($modelB, $tmp);
    }
}

