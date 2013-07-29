<?php

namespace wiro\modules\config;

use CWebModule;

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
class ConfigModule extends CWebModule
{
    public $layout = '//layouts/admin';
    public $controllerNamespace = 'wiro\modules\config\controllers';
}

