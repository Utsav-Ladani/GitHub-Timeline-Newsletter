<?php
namespace Subscribe;

require_once __DIR__.'/DBConnection.class.php';


/**
 * @description Subscribe the GitHUb timeline newsletter
 */

class Subscriber extends \DBConn\DBConnection {

    public $error = "";
    public function __construct($name, $email) {
        parent::__construct();

        $this->error = $this->getSubscription($name, $email);
    }

    /**
     * @param Name
     * @param Email
     * @description Add User into database and send a verification email
     */
    private function getSubscription($name, $email) {

        $result = $this->validate_name($name);
        if($result) return $result;
        
        $result = $this->validate_email($email);
        if($result) return $result;

        // get user veririfcation status from database
        $result = parent::getUserStatus($email);
        if($result) return "You already subscribe GitHub Timeline.";

        /** 
         * check if user exist or not
         * if yes, update the name
         * if no, add user and name in database
         */
        $result = parent::isUserExist($email);
        if($result) {
            $result = parent::setName($name, $email);
            if(!$result) return "Your name is not updated!";
        }
        else {
            $result = parent::addUser($name, $email);
            if(!$result) return "User not added!";
        }

        // get token fro database
        $token = parent::getToken($email);
        if(!$token) {

            // if not, then generate and save token in database
            $token = $this->generate_and_save_token($email);
            if(!$token) return "Verification token is not generated.";
        }

        // send email
        $result = $this->send_email($name, $email, $token);
        if(!$result) return "Failed to send email.";

        return "";
    }

    /**
     * @param name
     * validate the name
     */
    private function validate_name($name) {
        if($name == "") return "Name is empty";

        // match pattern to validate name
        $name_pattern = "/^[a-zA-Z0-9]+$/";
        if(!preg_match($name_pattern, $name)) return "Name must contain only lower chars, upper chars and numbers";

        // check length of name
        if(strlen($name)>100) return "Name length must be less than 100 char.";

        return "";
    }

    /**
     * @param email
     * validate the email
     */
    private function validate_email($email) {
        if($email == "") return "Email is empty";

        // valodate email using built-in function
        $result = filter_var($email, FILTER_VALIDATE_EMAIL);
        if(!$result) return "Invalid Email";
        
        if(strlen($email)>200) return "Email length must be less than 200 char.";

        return "";
    }

    private function generate_and_save_token($email) {
        // generate random 20 bytes and convert it into hexadecimal numder
        $bytes = random_bytes(20);
        $token = bin2hex($bytes);
        
        // save token to database
        $result = parent::setToken($email, $token);
        if(!$result) return "Token is not saved.";

        return $token;

    }

    /**
     * @param name
     * @param email
     * @param token
     * send a verification email to given email and return mail transaction status
     */
    private function send_email($name, $email, $token) {
        $subject = "Confirm it's you";
        $message = "Hello $name, \nPlease use this link to verify your email.\nhttps://gh-timeline.lndo.site/verify.php?email=$email&&token=$token";
        return mail($email, $subject, $message);
    }
}

?>