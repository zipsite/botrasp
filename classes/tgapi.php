<?php
class TgApi {
    public $keys;
    private $token;

    function __construct() {
        global $Config;
        $this->token = $Config->data->logintg->token;
        $this->keys = json_decode(file_get_contents(ConfigDir.'keytg.json'));
    }

    function request($method, $params) {
        $ch = curl_init('https://api.telegram.org/bot' . $this->token . "/" . $method);
	    curl_setopt($ch, CURLOPT_POST, 1);  
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_HEADER, false);
	    $res = curl_exec($ch);
	    curl_close($ch);

        fwrite(fopen(LogDir.'tg.log', 'a'), $res."\n");
        return $res;
    }

    function sendMessage($chat_id, $text, $key = NULL) {
        $params['chat_id'] = $chat_id;
        $params['text'] = $text;
        if (isset($key)) {
            $params['reply_markup'] = json_encode($key);
        }
        $this->request('sendMessage', $params);
    }

    function sendPhoto($chat_id, $photo) {
        $params['chat_id'] = $chat_id;
        $params['photo'] = $photo;
        $this->request('sendPhoto', $params);
    }
    function getUrlPhoto($file_id) {
        $params['file_id'] = $file_id;
        $res = $this->request('getFile', $params);
        return $res;
    }
}
?>