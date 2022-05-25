<?php
define('MainDir', __DIR__);
define('ClassesDir', MainDir.'/classes/');
define('ScriptsDir', MainDir.'/scripts/');
define('ConfigDir', MainDir.'/config/');
define('BgDir', MainDir.'/background/');
define('RaspFileDir', MainDir.'/raspfile/');
define('TmpDir', MainDir.'/tmp/');
define('LogDir', MainDir.'/log/');

require 'vendor/autoload.php';

// Загрузчик классов
spl_autoload_register(function ($class) {
    $path = ClassesDir.strtolower(str_replace("\\","/", $class));
    spl_autoload($path);
});

global $Config, $BaseData;
$Config = new \Config();
$BaseData = new \BaseData();
?>