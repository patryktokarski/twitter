<?php

class Tweet {
    private $id;
    private $userId;
    private $text;
    private $creationDate;
    
    public function setUserId($userId) {
        $this->userId = $userId;
        return $this;
    }
    
    public function setText($text) {
        $this->text = $text;
        return $this;
    }
    
    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
        return $this;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getUserId() {
        return $this->userId;
    }
    
    public function getText() {
        return $this->text;
    }
    
    public function getCreationDate() {
        return $this->creationDate;
    }
    
    public function __construct() {
        $this->id = -1;
        $this->userId = "";
        $this->text = "";
        $this->creationDate = "";
    }
    
    static public function loadTweetById (mysqli $conn, $id) {
        $sql = "SELECT tweets.id, tweets.user_id, tweets.text, tweets.creation_date, users.username FROM tweets LEFT JOIN users ON tweets.user_id = users.id WHERE tweets.id='$id'";
        $result = $conn->query($sql);
        
        if($result && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            
            $loadedTweet = new Tweet();
            $loadedTweet->id = $row['id'];
            $loadedTweet->text = $row['text'];
            $loadedTweet->creationDate = $row['creation_date'];
            $loadedTweet->username = $row['username'];
            
            return $loadedTweet;
        }
        return null;
    }
    
    static public function loadAllTweetByUserId(mysqli $conn, $userId) {
        $sql = "SELECT * FROM tweets WHERE user_id = '$userId' ORDER BY creation_date DESC";
        $result = $conn->query($sql);
        $allTweets = [];

        if ($result && $result->num_rows != 0) {
            while ($row = $result->fetch_assoc()) {
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->text = $row['text'];
                $loadedTweet->creationDate = $row['creation_date'];

                $allTweets[] = $loadedTweet;
            }
        }
        return $allTweets;
    }

    static public function loadAllTweets(mysqli $conn) {
        $sql = "SELECT * FROM tweets ORDER BY creation_date DESC ";
        $result = $conn->query($sql);
        $allTweets = [];

        if ($result && $result->num_rows != 0) {
            while ($row = $result->fetch_assoc()) {
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->text = $row['text'];
                $loadedTweet->userId = $row['user_id'];
                $loadedTweet->creationDate = $row['creation_date'];

                $allTweets[] = $loadedTweet;
            }
        }
        return $allTweets;
    }

    public function saveToDB(mysqli $conn) {
        
        if ($this->id == -1) {
            $sql = "INSERT INTO tweets (user_id, text, creation_date) VALUES ('$this->userId', '$this->text', '$this->creationDate')";
            $result = $conn->query($sql);
            if ($result == true) {
                $this->id = $conn->insert_id;
                return true;
            } else {
                echo "Tweet nie zostal dodany. Error: $conn->error";   
            }
        } else {
            $sql = "UPDATE tweets SET text= '$this->text' WHERE id= '$this->id'";
            $result = $conn->query($sql);
        }
        return false;
    }
}



?>
