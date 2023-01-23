<?php

require_once '../includes/DBConnection.class.php';

class Unsubscriber extends DBConnection {
    const TOKEN_LEN = 40;
    
    public $error = "";
    public function __construct($email, $token) {
        parent::__construct();

        $this->error = $this->unsubscribe($email, $token);
    }

    private function unsubscribe($email, $token) {
        $result = $this->validate_email($email);
        if($result) return $result;

        $result = $this->validate_token($token);
        if($result) return $result;

        $token_from_db = parent::getToken($email);
        if(!$token_from_db) return "User with this token not found in database";

        if($token_from_db !== $token) return "Token not matched.";

        $result = parent::deleteUser($email);
        if(!$result) return "Unsubscription failed!";

        return "";
    }

    private function validate_email($email) {
        if($email == "") return "Email required!";

        $result = filter_var($email, FILTER_VALIDATE_EMAIL);
        if(!$result) return "Invalid Email";
        
        if(strlen($email)>200) return "Email length must be less than 200 char.";

        return "";
    }

    private function validate_token($token) {
        if($token == "") return "Token required!";

        $result = ctype_xdigit($token);
        if(!$result) return "Invalid token!";
        
        if(strlen($token)!=self::TOKEN_LEN) return "Token length is invalid.";

        return "";
    }
}

?>