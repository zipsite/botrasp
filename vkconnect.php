<?php
require "bind.php";
$Dialog = new \Dialog();

$Dialog->CallBack = new \VkCallBack();
$Dialog->Api = new \VkApi();

if ($Dialog->CallBack->getType() == 'confirmation') {
    echo $Dialog->Api->confirmation;
}
elseif ($Dialog->CallBack->getType() == 'message_new') {
    $Dialog->pars();
    echo('ok');
}
?>