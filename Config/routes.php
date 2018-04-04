<?php
/**
 * Routes configuration
 *
 * @author vinay
 *
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /src/Template/Pages/home.ctp)...
 */
if (\Configure::read('debug') > 0):
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
else :
	Router::connect('/', array('controller' => \Configure::read('masterController'), 'action' => 'index'));
endif;

/**
 * Parse all extensions.
 */
	Router::parseExtensions();

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
