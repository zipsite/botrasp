<?php
class BaseData {
    public $bd;
    function __construct() {
        global $Config;
        $host = $Config->data->loginbd->host;
        $login = $Config->data->loginbd->login;
        $pass = $Config->data->loginbd->pass;
        $namebd = $Config->data->loginbd->namebd;
        $this->bd = @new mysqli($host, $login, $pass, $namebd);
        if($this->bd->connect_errno) return exit("Mysql error");
    }
}
/*
        $sql = "SELECT * FROM user WHERE id = '{$user_id}'";
		$result = $mysqli->query($sql);
		$rows = $result->num_rows;

		$result->data_seek(0);
		$user = $result->fetch_assoc();

        $sql = "DELETE FROM user WHERE  id ='{$user_id}'";
        $mysqli->query($sql);
        $sql = "DELETE FROM subscribe WHERE  id ='{$user_id}';";
        $mysqli->query($sql);
        $sql = "INSERT INTO `user` (`id`,`pach`,`version`) VALUES ('{$user_id}','start/','beta')";
        $sql = "UPDATE user SET pach = 'search/' WHERE id = '{$user_id}'";
*/

?>