<?php
require "bind.php";

$Dialog = new \Dialog();

$Dialog->CallBack = new \TgCallBack();
$Dialog->Api = new \TgApi();

if ($Dialog->CallBack->getType() == 'message') {
    $Dialog->pars();
}
?>