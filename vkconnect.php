<?php
require "bind.php";
$Dialog = new \Dialog();
echo('ok');
$Dialog->CallBack = new \VkCallBack();
$Dialog->Api = new \VkApi();

$Dialog->pars();



/*
$VkCallBack = new \VkCallBack();
$VkApi = new \VkApi();


if ($VkCallBack->getType() == 'confirmation') {
    echo($VkApi->confirmation);
}
elseif ($VkCallBack->getType() == 'message_new') {
    echo('ok');
}
$VkApi->send_mess('404323121', "Приу");
*/
?>