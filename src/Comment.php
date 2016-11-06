<?php

class Comment {
    private $id;
    private $userId;
    private $tweetId;
    private $creationDate;
    private $comment;
    
    public function __construct() {
        $this->id = -1;
        $this->userId = '';
        $this->tweetId = '';
        $this->creationDate = '';
        $this->comment = '';
    }
    
    function setUserId($userId) {
        $this->userId = $userId;
        return $this;
    }

    function setTweetId($tweetId) {
        $this->tweetId = $tweetId;
        return $this;
    }

    function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
        return $this;
    }

    function setComment($comment) {
        $this->comment = $comment;
        return $this;
    }
    
    function getId() {
        return $this->id;
    }

    function getUserId() {
        return $this->userId;
    }

    function getTweetId() {
        return $this->tweetId;
    }

    function getCreationDate() {
        return $this->creationDate;
    }

    function getComment() {
        return $this->comment;
    }
    
    static public function loadCommentById(mysqli $conn, $id) {
        $sql = "SELECT * FROM comments WHERE id = '$id'";
        $result = $conn->query($sql);
        
        if ($result != false && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            
            $loadedComment = new Comment();
            $loadedComment->id = $row['id'];
            $loadedComment->userId = $row['user_id'];
            $loadedComment->tweetId = $row['tweet_id'];
            $loadedComment->creationDate = $row['creation_date'];
            $loadedComment->comment = $row['comment'];
            
            return $loadedComment;
        }
        return null;
    }
    
    static public function loadAllCommentsByTweetId(mysqli $conn, $tweetId) {
        $sql = "SELECT * FROM comments WHERE tweet_id = '$tweetId' ORDER BY creation_date DESC";
        $result = $conn->query($sql);
        $allComments = [];
        
        if ($result != false && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $loadedComment = new Comment();
                $loadedComment->id = $row['id'];
                $loadedComment->userId = $row['user_id'];
                $loadedComment->tweetId = $row['tweet_id'];
                $loadedComment->creationDate = $row['creation_date'];
                $loadedComment->comment = $row['comment'];
                
                $allComments[] = $loadedComment;
            }
            return $allComments;
        }
        return $allComments;
    }
    
    public function saveToDB(mysqli $conn) {
        if($this->id == -1) {
            $sql = "INSERT INTO comments (user_id, tweet_id, creation_date, comment) VALUES ('$this->userId', '$this->tweetId', '$this->creationDate', '$this->comment')";
            
            $result = $conn->query($sql);
            if ($result) {
                $this->id = $conn->insert_id;
                return true;
            } else {
                return false;
            }
        } 
    }
    
    public function changeStatus (mysqli $conn, $messageId) {
        $sql = "UPDATE Messages SET status = 1 WHERE Messages.id = '$messageId'";
        $result = $conn->query($sql);
        if ($result != false) {
            return true;
        } else {
            return false;
        }
    }

}


?>
