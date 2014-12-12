<?php
return array(
    'system_config' => array (
        'application_folder' => "application",
        'application_subfolder' => array(
            'controllers_folder' => "controllers",
            'models_folder' => "models",
            'views_folder' => "views",
            ),
	'system_folder' => "core",
        'system_vendor' => "IccTest",
        'autoloader' => "core/base/Autoloader/PsrAutoloader.php",
        'default_controller' => "",
    ),
    'user_config' => array(
        'routes' => array(
            'route1' => array(
                'vendor'=>"vendor1",
                'controllerclass' => "TestController",
                'defailtAction' => "index",
                'id' => array (
                    'separator' => "/",
                ),
                'action' => array (
                    'alias' => "action",//Только при использовании разделителя ?
                    'separator' => "/",
                ),
                'controller' => array (
                    'alias' => "controller",
                    'separator' => "/",
                   
                ),
            ),
            'route2' => array(
                'vendor'=>"vendor1",
                'controllerclass' => "TestController",
                'defailtAction' => "index",
                'id' => array (
                    'request' => "uri",
                    'child_request' => "uri"
                    
                ),
                'action' => array (
                    'alias' => "action",//Только при использовании разделителя ?
                    'request' => "uri",
                    
                ),
                'controller' => array (
                    'alias' => "controller",
                    'request' => "uri",
                    
                ),
            ),
        ),
    ),
);