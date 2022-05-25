<?php
class TgCallBack {
    public $request;

    function __construct() {
        $res = file_get_contents('php://input');
        //$res = file_get_contents(LogDir.'mess.txt');
        $this->request = json_decode($res);
        $fp = fopen(LogDir.'tg.log', 'a');
        fwrite($fp, $res."\n");
        fclose($fp);
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
        if (!empty($this->request->message->photo)) {
            return $this->request->message->photo[0]->file_id;
        }
    }

    function getType() {
        if (isset($this->request->message)) {
            return 'message';
        }
        elseif (isset($this->request->my_chat_member)) {
            return 'my_chat_member';
        }
    }
}
?>