<?php

namespace wiro\actions;

use CAction;
use Closure;
use CModel;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
abstract class Action extends CAction
{
    /**
     *
     * @var string
     */
    public $modelClass;

    /**
     *
     * @var string
     */
    public $view;

    /**
     *
     * @var string|array|Closure
     */
    public $redirectUrl;

    /**
     *
     * @var callable
     */
    public $accessCheck;
    
    /**
     * @var CModel
     */
    protected $model;
    
    /**
     * 
     * @param string $view
     * @param array $data
     * @param boolean $return
     * @return string
     */
    public function render($view, $data = null, $return = false)
    {
        return $this->controller->render($view, $data, $return);
    }

    /**
     * 
     * @param string|array|Closure $url
     * @param boolean $terminate
     * @param integer $statusCode
     */
    public function redirect($url, $terminate = true, $statusCode = 302)
    {
        if ($url instanceof Closure) {
            $url = $this->runClosure($url);
        }
        $this->controller->redirect($url, $terminate, $statusCode);
    }

    /**
     * @param boolean $terminate
     * @param string $anchor
     */
    public function refresh($terminate = true, $anchor = '')
    {
        return $this->controller->refresh($terminate = true, $anchor = '');
    }

    public function loadModel($id, $class = null, $criteria = array(), $exceptionOnNull = true)
    {
        return $this->controller->loadModel($id, $class ? : $this->modelClass, $criteria, $exceptionOnNull);
    }

    /**
     * 
     * @param Closure $closure
     * @param CModel $model
     * @return mixed
     */
    public function runClosure(Closure $closure, CModel $model = null)
    {
        return $closure($model ? : $this->model, $this->controller);
    }

}
