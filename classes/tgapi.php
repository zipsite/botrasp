<?php
class TgApi {
    private $keyboards;
    private $token;

    function __construct() {
        global $Config;
        $this->token = $Config->data->logintg->token;
    }

    function request($method, $params) {
        $query = http_build_query($params);
        $url = "https://api.telegram.org/bot" . $this->token . "/" . $method . '?' . $query;
        $reply = json_decode(file_get_contents($url));
        
        if ($reply->ok == false) {
            $report = "TgApi ERROR ".str($reply->error_code)."    ".$reply->description."\n";
            error_log($report, 0);
        }
        echo($report);
    }

    function send_mess($peer_id, $message) {
        $this->request('sendMessage', array(
            'chat_id' => $peer_id,
            'text' => $message,
          ));
    }
}
?>