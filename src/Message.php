<?php

class Message {
    private $id;
    private $senderId;
    private $receiverId;
    private $message;
    private $status;
    private $creationDate;
    
    public function __construct() {
        $this->id = -1;
        $this->senderId = '';
        $this->receiverId = '';
        $this->message = '';
        $this->status = 0;
        $this->creationDate = '';
    }
    
    function setSenderId($senderId) {
        $this->senderId = $senderId;
    }

    function setReceiverId($receiverId) {
        $this->receiverId = $receiverId;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    function getId() {
        return $this->id;
    }

    function getSenderId() {
        return $this->senderId;
    }

    function getReceiverId() {
        return $this->receiverId;
    }

    function getMessage() {
        return $this->message;
    }

    function getStatus() {
        return $this->status;
    }

    function getCreationDate() {
        return $this->creationDate;
    }

    static public function loadMessagesByReceiverId (mysqli $conn, $receiverId) {
        $sql = "SELECT Messages.id, Messages.sender_id, Messages.receiver_id, Messages.message, Messages.creation_date, Messages.status, users.username FROM Messages LEFT JOIN users ON Messages.sender_id = users.id WHERE Messages.receiver_id = '$receiverId'";
        $result = $conn->query($sql);
        $allMessagesByReceiverId = [];
        
        if ($result != false && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $loadedMessage = new Message();
                $loadedMessage->id = $row['id'];
                $loadedMessage->senderId = $row['sender_id'];
                $loadedMessage->receiver_id = $row['receiver_id'];
                $loadedMessage->message = $row['message'];
                $loadedMessage->creationDate = $row['creation_date'];
                $loadedMessage->status = $row['status'];
                $loadedMessage->username = $row['username'];
                
                $allMessagesByReceiverId[] = $loadedMessage;
            }
            return $allMessagesByReceiverId;
        }
        return $allMessagesByReceiverId;
    }

    static public function loadMessagesBySenderId(mysqli $conn, $senderId) {
        $sql = "SELECT Messages.id, Messages.sender_id, Messages.receiver_id, Messages.message, Messages.creation_date, Messages.status, users.username FROM Messages LEFT JOIN users ON Messages.receiver_id = users.id WHERE Messages.sender_id = '$senderId'";
        $result = $conn->query($sql);
        $allMessagesBySenderId = [];

        if ($result != false && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $loadedMessage = new Message();
                $loadedMessage->id = $row['id'];
                $loadedMessage->senderId = $row['sender_id'];
                $loadedMessage->receiverId = $row['receiver_id'];
                $loadedMessage->message = $row['message'];
                $loadedMessage->creationDate = $row['creation_date'];
                $loadedMessage->status = $row['status'];
                $loadedMessage->username = $row['username'];

                $allMessagesBySenderId[] = $loadedMessage;
            }
            return $allMessagesBySenderId;
        }
        return $allMessagesBySenderId;
    }
    
    public function saveMessageToDB (mysqli $conn) {
        $sql = "INSERT INTO Messages (sender_id, receiver_id, message, creation_date, status) VALUES ('$this->senderId', '$this->receiverId', '$this->message', '$this->creationDate', '$this->status')";
        $result = $conn->query($sql);
        if ($result != false) {
            $this->id = $conn->insert_id;
            return true;
        } else {
            return false;
        }
    }
    
    public function changeStatus(mysqli $conn, $messageId) {
        $sql = "UPDATE Messages SET Messages.status = '0' WHERE Messages.id = '$messageId'";
        $result = $conn->query($sql);
    }
    
    static public function loadMessageById(mysqli $conn, $messageId) {
        $sql = "SELECT Messages.id, Messages.sender_id, Messages.receiver_id, Messages.message, Messages.creation_date, Messages.status, users.username FROM Messages LEFT JOIN users ON Messages.receiver_id = users.id WHERE Messages.id = '$messageId'";
        $result = $conn->query($sql);
        if ($result != false && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            
            $loadedMessage = new Message();
            $loadedMessage->id = $row['id'];
            $loadedMessage->senderId = $row['sender_id'];
            $loadedMessage->receiverId = $row['receiver_id'];
            $loadedMessage->message = $row['message'];
            $loadedMessage->creationDate = $row['creation_date'];
            $loadedMessage->status = $row['status'];
            $loadedMessage->username = $row['username'];
            
            return $loadedMessage;
        }
    }

}
