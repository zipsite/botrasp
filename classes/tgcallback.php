<?php
class TgCallBack {
    public $request;

    function __construct() {
        $res = file_get_contents('php://input');
        //$res = file_get_contents(LogDir.'mess.txt');
        $this->request = json_decode($res);
        fwrite(fopen(LogDir.'tg.log', 'a'), $res."\n");
    }
    
    function getIdUser() {
        return $this->request->message->from->id;
    }

    function getIdChat() {
        return $this->request->message->chat->id;
    }

    function getPlatform() {
        return "tg";
    }

    function getMessage() {
        return $this->request->message->text;
    }

    function getAttPhoto() {
        return $this->request->message->photo->file_id;
    }
}
?>