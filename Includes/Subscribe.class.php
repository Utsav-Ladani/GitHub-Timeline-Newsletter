<?php

require_once '../includes/DBConnection.class.php';

class Subscriber extends DBConnection {
    public $error = "";
    public function __construct($name, $email) {
        parent::__construct();

        $this->error = $this->getSubscription($name, $email);
    }

    private function getSubscription($name, $email) {

        $result = $this->validate_name($name);
        if($result) return $result;
        
        $result = $this->validate_email($email);
        if($result) return $result;

        $result = parent::getUserStatus($email);
        if($result) return "You already subscribe GitHub Timeline.";

        $result = parent::isUserExist($email);
        if($result) {
            $result = parent::setName($name, $email);
            if($result) return "Your name is not updated!";
        }
        else {
            $result = parent::addUser($name, $email);
            if(!$result) return "User not added!";
        }

        $token = parent::getToken($email);
        if(!$token) {
            $token = $this->generate_and_save_token($email);
            if(!$token) return "Verification token is not generated.";
        }

        $result = $this->send_email($name, $email, $token);
        if(!$result) return "Failed to send email.";


        return "";
    }

    private function validate_name($name) {
        if($name == "") return "Name is empty";

        $name_pattern = "/^[a-zA-Z0-9]+$/";
        if(!preg_match($name_pattern, $name)) return "Name must contain only lower chars, upper chars and numbers";

        if(strlen($name)>100) return "Name length must be less than 100 char.";

        return "";
    }

    private function validate_email($email) {
        if($email == "") return "Email is empty";

        $result = filter_var($email, FILTER_VALIDATE_EMAIL);
        if(!$result) return "Invalid Email";
        
        if(strlen($email)>200) return "Email length must be less than 200 char.";

        return "";
    }

    private function generate_and_save_token($email) {
        $bytes = random_bytes(20);
        $token = bin2hex($bytes);
        
        $result = parent::setToken($email, $token);
        if(!$result) return "Token is not saved.";

        return $token;

    }

    private function send_email($name, $email, $token) {
        $subject = "Confirm it's you";
        $message = "Hello $name, \nPlease use this link to verify your email.\nhttps://gh-timeline.lndo.site/verify.php?email=$email&&token=$token";
        return mail($email, $subject, $message);
    }
}

?>