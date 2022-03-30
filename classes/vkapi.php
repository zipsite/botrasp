<?php
class VkApi {
    public $keys;
    private $token;
    public $confirmation;
    private $v;

    function __construct() {
        global $Config;
        $this->keys = json_decode(file_get_contents(ConfigDir.'keyvk.json'));
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

        $reply = json_decode(file_get_contents($url));
        if ($reply->error) {
            error_log("VkApi ERROR {$reply->error->error_code}    {$reply->error->error_msg}\n", 0);
        }
    }
    function sendMessage($peer_id, $message, $key) {
        $params['peer_id'] = $peer_id;
        $params['message'] = $message;
        if (!empty($key)) {
            $params['keyboard'] = json_encode($key);
        }
        $this->request('messages.send', $params);
    }
}
?>