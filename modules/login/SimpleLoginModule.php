<?php

namespace wiro\modules\login;

use CWebModule;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class SimpleLoginModule extends CWebModule
{
    public $username = 'admin';
    public $password = 'admin';
    public $controllerNamespace = 'wiro\modules\login\controllers';
}
