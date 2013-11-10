<?php

namespace wiro\base;

use CActiveRecord;
use CDbCriteria;
use CHtml;

/**
 * EActiveRecord class
 *
 * Some cool methods to share amount your models
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @copyright 2013 2amigOS! Consultation Group LLC
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
class ActiveRecord extends CActiveRecord
{
    /**
     * default form ID for the current model. Defaults to get_class()+'-form'
     */
    private $_formId;

    public function setFormId($value)
    {
	$this->_formId = $value;
    }

    public function getFormId()
    {
	if(null !== $this->_formId)
	    return $this->_formId;
	else {
	    $this->_formId = strtolower(get_class($this)) . '-form';
	    return $this->_formId;
	}
    }
    /**
     * default grid ID for the current model. Defaults to get_class()+'-grid'
     */
    private $_gridId;

    public function setGridId($value)
    {
	$this->_gridId = $value;
    }

    public function getGridId()
    {
	if(null !== $this->_gridId)
	    return $this->_gridId;
	else {
	    $this->_gridId = strtolower(get_class($this)) . '-grid';
	    return $this->_gridId;
	}
    }
    /**
     * default list ID for the current model. Defaults to get_class()+'-list'
     */
    private $_listId;

    public function setListId($value)
    {
	$this->_listId = $value;
    }

    public function getListId()
    {
	if(null !== $this->_listId)
	    return $this->_listId;
	else {
	    $this->_listId = strtolower(get_class($this)) . '-list';
	    return $this->_listId;
	}
    }
    
    /**
     * 
     * @param string $nameColumn
     * @param CDbCriteria|array $criteria
     * @return array
     */
    public function listModels($nameColumn, $criteria=array())
    {
        $models = $this ->findAll($criteria);
        return CHtml::listData($models, $this->tableSchema->primaryKey, $nameColumn);
    }
    
    /**
     * 
     * @param string $className
     * @return ActiveRecord
     */
    public static function model($className = null)
    {
        return parent::model($className ?: get_called_class());
    }
}
