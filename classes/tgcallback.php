<?php
class TgCallBack {
    public $request;

    function __construct() {
        $this->request = json_decode(file_get_contents('php://input'));
    }
    
    function getIdUser() {
        return $request->message->from->id;
    }

    function getIdChat() {
        return $request->message->chat->id;
    }

    function getType() {
        return $request->type;
    }

    function getAttPhoto() {
        $photo = $request->object->message->attachments->photo;
        return "photo".$photo->owner_id."_".$photo->id."_".$photo->access_key;
    }

    function getAttType() {
        return $request->object->message->attachments->type;
    }
}
?>