<?php
/**
 * This class is used to unsunscribe user from GitHub timeline newsletter
 * User account is removed from database after unsubscribe.
 */

namespace Unsubscribe;

require_once __DIR__.'/DBConnection.class.php';

class Unsubscriber extends \DBConn\DBConnection {
    const TOKEN_LEN = 40;
    
    public $error = "";

    public function __construct($email, $token) {
        parent::__construct();

        $this->error = $this->unsubscribe($email, $token);
    }

    /**
     * unsubscribe user
     */
    private function unsubscribe($email, $token) {
        $result = $this->validate_email($email);
        if($result) return $result;

        $result = $this->validate_token($token);
        if($result) return $result;

        // get token from database
        $token_from_db = parent::getToken($email);
        if(!$token_from_db) return "User with this token not found in database";

        if($token_from_db !== $token) return "Token not matched.";

        // remove user from database
        $result = parent::deleteUser($email);
        if(!$result) return "Unsubscription failed!";

        return "";
    }

    /**
     * @param $email - Email of user
     * @description Validate email and return error, if invalid.
     */
    private function validate_email($email) {
        if($email == "") return "Email required!";

        $result = filter_var($email, FILTER_VALIDATE_EMAIL);
        if(!$result) return "Invalid Email";
        
        // check length of email
        if(strlen($email)>200) return "Email length must be less than 200 char.";

        return "";
    }

    /**
     * @param $token - 40 hex char verification token
     * @description Validate name and return error, if invalid.
     */
    private function validate_token($token) {
        if($token == "") return "Token required!";

        // check that given string chars are hex or not
        $result = ctype_xdigit($token);
        if(!$result) return "Invalid token!";
        
        // check token length
        if(strlen($token)!=self::TOKEN_LEN) return "Token length is invalid.";

        return "";
    }
}
