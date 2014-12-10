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
        'autoloader' => "core/base/Autoloader/PsrAutoloader.php"
    ),
    'user_config' => array(
        'module1' => array(
            'vendor'=>"vendor1",//Является корнем пространства имен пользователя
            'routing_rule' => array(),
                    ),
        'module2' => array(
            'vendor'=>"vendor2",//Является корнем пространства имен пользователя
            'routing_rule' => array(),
        ),
    ),
);