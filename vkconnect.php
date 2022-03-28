<?php
require "bind.php";

$VkCallBack = new \VkCallBack();
$VkApi = new \VkApi();

/*
if ($VkCallBack->getType() == 'confirmation') {
    echo($VkApi->confirmation);
}
elseif ($VkCallBack->getType() == 'message_new') {
    $VkApi->send_mess($VkCallBack->getIdUser(), "Приу");
    echo('ok');
}
*/
$VkApi->send_mess('404323121', 'Приу');

?>