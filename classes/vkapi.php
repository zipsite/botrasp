<?php
class VkApi {
    private $keyboards;
    private $token;
    public $confirmation;
    private $v;

    function __construct() {
        global $Config;
        $this->token = $Config->data->loginvk->token;
        $this->confirmation = $Config->data->loginvk->confirmation;
        $this->v = $Config->data->loginvk->v;
    }

    function request($method, $params) {
        $params['access_token'] = $this->token;
        $params['v'] = $this->v;
        $params['random_id'] = '0';
        $query = http_build_query($params);
        $url = "https://api.vk.com/method/" . $method . '?' . $query;
	    return file_get_contents($url);
    }
    function send_mess($peer_id, $message) {
        $this->request('messages.send', array(
            'peer_id' => $peer_id,
            'message' => $message,
          ));
    }
}
?>