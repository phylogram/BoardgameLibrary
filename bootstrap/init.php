<?php

#according PSR-4:
#To Do: http://www.php-fig.org/bylaws/psr-naming-conventions/
#Here is the configuration
require('../conf/conf.php');
require('../conf/ini_set.conf.php');

#Here is the autoloader
spl_autoload_register(function ($classname) {
    $load_name = '..' . DIRECTORY_SEPARATOR;
    $subs = explode('\\', $classname);
    unset($classname);

    while (true) {
        if (count($subs)==1) {
            $load_name .= array_shift($subs);
            break;
        }
        $load_name .= NAMESPACE_FOLDER_RELATION[array_shift($subs)] . DIRECTORY_SEPARATOR;
    }

    $load_name .= '.php';
    
    require($load_name);

});
