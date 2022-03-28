<?php
define('MainDir', __DIR__);
define('ClassesDir', MainDir.'/classes/');
define('ScriptsDir', MainDir.'/scripts/');
define('ConfigDir', MainDir.'/config/');
define('StorageDir', MainDir.'/storage/');
define('TmpDir', MainDir.'/tmp/');
require 'vendor/autoload.php';

// Загрузчик классов
spl_autoload_register(function ($class) {
    $path = ClassesDir.strtolower(str_replace("\\","/", $class));
    spl_autoload($path);
});

global $Config, $BaseData;
$Config = new \Config();
$BaseData = new \BaseData();

$VkApi = new \VkApi();
$VkApi->send_mess("404323121", "Приу");
?>