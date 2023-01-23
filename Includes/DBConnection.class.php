<?php

class DBConnection {

    private $hostname = "database";
    private $username = "rtcamp";
    private $password = "rtcamp";
    private $database = "gh-timeline";

    protected $db = NULL;

    public function __construct() {
        $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

        if($conn->connect_error) {
            die("Failed to connect with database! ". $conn->connect_error);
        }
        else {
            $this->db = $conn;

            // for dynamic testing
            $this->create_table();
            // $this->truncate_table();
        }

    }

    public function getInfo() {
        $sql = "SHOW databases;";
        $result = $this->db->query($sql);
    }

    public function addUser($name, $email) {
        $sql = "INSERT INTO User (Name, Email, IsVerified, Token) VALUES ('$name', '$email', false, '');";
        $result = $this->db->query($sql);

        return $result;
    }

    public function deleteUser($email) {
        $sql = "DELETE FROM User WHERE Email='$email';";
        $result = $this->db->query($sql);

        return $this->db->affected_rows>0;
    }

    public function getUserStatus($email) {
        $sql = "SELECT * FROM User Where Email='$email' AND IsVerified;";
        $result = $this->db->query($sql);

        return $result->num_rows>0;
    }

    public function setUserStatus($email) {
        $sql = "UPDATE User SET IsVerified=true WHERE Email='$email';";
        $result = $this->db->query($sql);

        return $this->db->affected_rows>0;
    }

    public function isUserExist($email) {
        $sql = "SELECT * FROM User Where Email='$email';";
        $result = $this->db->query($sql);

        return $result->num_rows>0;
    }

    public function setName($name, $email) {
        $sql = "UPDATE User SET Name='$name' WHERE Email='$email';";
        $result = $this->db->query($sql);

        return $this->db->affected_rows>0;
    }

    public function getToken($email) {
        $sql = "SELECT * FROM User Where Email='$email' AND Token<>'';";
        $result = $this->db->query($sql);

        if($result->num_rows==0) return "";

        $arr = $result->fetch_array();
        return $arr['Token'];
    }

    public function setToken($email, $token) {
        $sql = "UPDATE User SET Token='$token' WHERE Email='$email';";
        $result = $this->db->query($sql);

        return $this->db->affected_rows>0;
    }

    public function getUsersWithSubscription() {
        $sql = "SELECT * FROM User Where IsVerified=true;";
        $result = $this->db->query($sql);

        return $result;
    }

    private function create_table() {
        $sql = "CREATE TABLE IF NOT EXISTS User ( 
            Name VARCHAR(100) NOT NULL, 
            Email VARCHAR(200) NOT NULL PRIMARY KEY,
            IsVerified BOOLEAN,
            Token VARCHAR(100)
            );";
        $result = $this->db->query($sql);
    }

    private function truncate_table() {
        $sql = "TRUNCATE TABLE User;";
        $result = $this->db->query($sql);
    }

    public function __destruct() {
        $this->db->close();
    }
}
