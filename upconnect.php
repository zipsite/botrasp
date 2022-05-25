<?php
require "bind.php";

$UpdateRasp = new \UpdateRasp();
$UpdateRasp->updateStatus();
if ($UpdateRasp->getStatus() > 1) {
    $UpdateRasp->syncRaspFile();
    $UpdateRasp->whohave();
}
?>