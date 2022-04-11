<?php
class User {
    public $id;
    public $platform;
    public $platform_id;
    public $type;
    public $bg_id;
    public $subcribe;
    public $path;
    public $permition;

    function __construct($platform, $platform_id) {
        global $BaseData;
        $this->bd = $BaseData->bd;
        $this->platform = $platform;
        $this->platform_id = $platform_id;
    }

    function loadUserData() {
        $result = $this->bd->query("SELECT * FROM user WHERE platform_id = '{$this->platform_id}' AND platform = '{$this->platform}'");
        $rows = $result->num_rows;

        if($rows == 1){
	        $result->data_seek(0);
            $userdata = $result->fetch_assoc();

            $this->id = $userdata['id'];
            $this->type = $userdata['type'];
            $this->BgId = $userdata['bg_id'];
            $this->subcribe = $userdata['subscribe'];
            $this->path = $userdata['path'];
            $this->permition = $userdata['permition'];
            return 1;
        }
        elseif($rows > 1) {
            return 2;
        }
        elseif($rows < 1) {
            return 0;
        }
    }

    function setUserData($name, $value) {
        $this->bd->query("UPDATE user SET {$name} = '{$value}' 
        WHERE platform_id = '{$this->platform_id}' AND platform = '{$this->platform}'");
    }

    function setPath($path) {
        $this->setUserData('path',$path);
    }

    function setType($type) {
        $this->setUserData('type',$type);
    }

    function createBgId() {
        global $Api;
        
    }

    function setBgId($bg_id) {
        $this->setUserData('bg_id',$bg_id);
    }

    function setPerm($perm) {
        $this->setUserData('permition',$perm);
    }

    function setSubscribe($subscribe) {
        $this->setUserData('subscribe',$subscribe);
    }

    function crtNewUser() {
        $this->bd->query("INSERT INTO user (platform, platform_id, bg_id, path, permition) 
        VALUES ('{$this->platform}', '{$this->platform_id}', '0', 'start/', 'guest')");
    }

    function dltUser() {
        $this->bd->query("DELETE FROM user WHERE platform_id = '{$this->platform_id}' AND platform = '{$this->platform}'");
    }

    function getUserId() {
        return $this->id; 
    }
    function getUserPlatform() {
        return $this->platform; 
    }
    function getUserPlatform_id() {
        return $this->platform_id; 
    }
    function getUserType() {
        return $this->type;
    }
    function getBgId() {
        return $this->BgId;
    }
    function getUserSubcribe() {
        return $this->subscribe;
    }
    function getPath() {
        return explode('/', stripslashes(htmlspecialchars(trim($this->path))));
    }
    function getPerm() {
        return $this->permition;
    }
    
}
?>