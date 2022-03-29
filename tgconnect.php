<?php
require "bind.php";

$TgCallBack = new \TgCallBack();
$TgApi = new \TgApi();

//TgApi->send_mess($TgCallBack->getIdUser(), "Приу");

$TgApi->send_mess('592039349', "Приу");

?>