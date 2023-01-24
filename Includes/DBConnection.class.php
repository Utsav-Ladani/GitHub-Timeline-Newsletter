<?php

/** 
 * DBConnection is used to create a database connection. It provides varoius data manipulation functions.
 * Here User database is used for all database transactions
 */
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

            // checking table is created or not using code is bad idea, but it is for testing purpose only.
            $this->create_table();
            // $this->truncate_table(); // truncate the table, if want.
        }

    }

    /**
     * @param $name - Username
     * @param $email - Email of user
     * @description Insert a new user record with email and name into database
     */
    public function addUser($name, $email) {
        $sql = "INSERT INTO User (Name, Email, IsVerified, Token) VALUES ('$name', '$email', false, '');";
        $result = $this->db->query($sql);

        return $result;
    }

    /**
     * @param $email - Email of user
     * @description Delete the user record with particular email
     */
    public function deleteUser($email) {
        $sql = "DELETE FROM User WHERE Email='$email';";
        $result = $this->db->query($sql);

        return $this->db->affected_rows>0;
    }

    /**
     * @param $email - Email of user
     * @description Give the varification status of the user using email
     */
    public function getUserStatus($email) {
        $sql = "SELECT * FROM User Where Email='$email' AND IsVerified;";
        $result = $this->db->query($sql);

        return $result->num_rows>0;
    }

    /**
     * @param $email - Email of user
     * @description Mark the user varification status as true using email
     */
    public function setUserStatus($email) {
        $sql = "UPDATE User SET IsVerified=true WHERE Email='$email';";
        $result = $this->db->query($sql);

        return $this->db->affected_rows>0;
    }

    /**
     * @param $email - Email of user
     * @description Check whether tje user with given email exist in the database or not
     */
    public function isUserExist($email) {
        $sql = "SELECT * FROM User Where Email='$email';";
        $result = $this->db->query($sql);

        return $result->num_rows>0;
    }

    /**
     * @param $name - User name
     * @param $email - Email of user
     * @description Update username associated with given email
     */
    public function setName($name, $email) {
        $sql = "UPDATE User SET Name='$name' WHERE Email='$email';";
        $result = $this->db->query($sql);

        return $result;
    }

    /**
     * @param $email - Email of user
     * @description Give the token of user associated with given email
     */
    public function getToken($email) {
        $sql = "SELECT * FROM User Where Email='$email' AND Token<>'';";
        $result = $this->db->query($sql);

        if($result->num_rows==0) return "";

        // fetch all data as an array
        $arr = $result->fetch_array();
        return $arr['Token'];
    }

    /**
     * @param $email - Email of user
     * @description Set the token of user associated with given email
     */
    public function setToken($email, $token) {
        $sql = "UPDATE User SET Token='$token' WHERE Email='$email';";
        $result = $this->db->query($sql);

        // return true if token updated 
        return $this->db->affected_rows>0;
    }

    /**
     * @description Give verified users
     */
    public function getUsersWithSubscription() {
        $sql = "SELECT * FROM User Where IsVerified=true;";
        $result = $this->db->query($sql);

        return $result;
    }

    /**
     * @description Create User table if not exist in database
     */
    private function create_table() {
        $sql = "CREATE TABLE IF NOT EXISTS User ( 
            Name VARCHAR(100) NOT NULL, 
            Email VARCHAR(200) NOT NULL PRIMARY KEY,
            IsVerified BOOLEAN,
            Token VARCHAR(100)
            );";
        $result = $this->db->query($sql);
    }

    /**
     * @description Truncate User table 
     */
    private function truncate_table() {
        $sql = "TRUNCATE TABLE User;";
        $result = $this->db->query($sql);
    }

    /**
     * @description Close the data connection
     */
    public function __destruct() {
        $this->db->close();
    }
}
