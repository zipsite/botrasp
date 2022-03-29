<?php
class TgCallBack {
    public $request;

    function __construct() {
        $this->request = json_decode(file_get_contents('php://input'));
        file_put_contents(LogDir. '/message.txt', print_r($this->request, true));
    }
    
    function getIdUser() {
        return $this->request->message->from->id;
    }

    function getIdChat() {
        return $this->request->message->chat->id;
    }

    function getMessage() {
        return $this->request->message->text;
    }
}
?>