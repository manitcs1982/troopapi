<?php 
class Push {
 
    // push message title
    private $title;
    private $message;
    private $image;
    // push message payload
    private $data;
    // flag indicating whether to show the push
    // notification or not
    // this flag will be useful when perform some opertation
    // in background when push is recevied
    private $is_background;
 
    function __construct() {
         
    }
 
    public function setTitle($title) {
        $this->title = $title;
    }
 
    public function setMessage($message) {
        $this->message = $message;
    }
    
    public function setNativeTitle($nativeTitle) {
        $this->nativeTitle = $nativeTitle;
    }
 
    public function setNativeMessage($nativeMessage) {
        $this->nativeMessage = $nativeMessage;
    } 
    
    public function setAdditionalJson($additionalJson) {
        $this->additionalJson = $additionalJson;
    }
    
    public function setNotificationType($notificationType) {
        $this->notificationType = $notificationType;
    }
 
    public function setImage($imageUrl) {
        $this->image = $imageUrl;
    }
 
    public function setPayload($data) {
        $this->data = $data;
    }
 
    public function setIsBackground($is_background) {
        $this->is_background = $is_background;
    }
    

    public function getPush() {
        $res = array();
        $res['data']['title'] = $this->title;
        $res['data']['nativeTitle'] = $this->nativeTitle;
        $res['data']['is_background'] = $this->is_background;
        $res['data']['message'] = $this->message;
        $res['data']['nativeMessage'] = $this->nativeMessage;
        $res['data']['notificationType'] = $this->notificationType;
        $res['data']['additionalJson'] = $this->additionalJson;
        $res['data']['image'] = $this->image;
        $res['data']['payload'] = $this->data;
        $res['data']['timestamp'] = date('Y-m-d G:i:s');
        return $res;
    }
 
}

?>