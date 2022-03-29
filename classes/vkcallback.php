<?php
class VkCallBack {
    public $request;

    function __construct() {
        $this->request = json_decode(file_get_contents('php://input'));
    }
    
    function getIdUser() {
        return $this->request->object->message->from_id;
    }

    function getIdChat() {
        return $this->request->object->message->peer_id;
    }

    function getType() {
        return $this->request->type;
    }

    function getAttPhoto() {
        $photo = $this->request->object->message->attachments->photo;
        return "photo".$photo->owner_id."_".$photo->id."_".$photo->access_key;
    }

    function getAttType() {
        return $this->request->object->message->attachments->type;
    }
    function getMessage() {
        return $this->request->object->message->text;
    }
}
?>