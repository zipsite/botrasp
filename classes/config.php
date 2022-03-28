<?php
class Config {
    public $data;
    function __construct() {
        $this->data = json_decode(file_get_contents(ConfigDir.'config.json'));
    }
}
?>