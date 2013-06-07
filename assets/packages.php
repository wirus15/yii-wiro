<?php

/**
 * @author Maciej Krawczyk <wirus15@gmail.com>
 */
return array(
    'jquery' => array(
	'basePath' => 'wiro.assets.js',
	'js' => array('jquery.min.js'),
    ),
    'jquery.livequery' => array(
	'basePath' => 'wiro.assets.js',
	'js' => array('jquery.livequery.js'),
	'depends' => array('jquery'),
    ),
    'jquery.mousewheel' => array(
	'basePath' => 'wiro.assets.js',
	'js' => array('jquery.mousewheel.js'),
	'depends' => array('jquery'),
    ),
    'jquery.transit' => array(
	'basePath' => 'wiro.assets.js',
	'js' => array('jquery.transit.js'),
	'depends' => array('jquery'),
    ),
    'modernizr' => array(
	'basePath' => 'wiro.assets.js',
	'js' => array('modernizr.min.js'),
    ),
    'bbq'=>array(
	'basePath' => 'wiro.assets.js',
	'js'=>array('jquery.ba-bbq.min.js'),
	'depends'=>array('jquery'),
    ),
);