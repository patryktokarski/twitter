<?php
session_start();

include_once './src/User.php';
include_once './src/connection.php';
include_once './src/Message.php';

if (!isset($_SESSION['loggedUserId'])) {
    header('location: login.php');
}
$loggedUser = intval($_SESSION['loggedUserId']);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(empty($_GET['receiverId'])) {
        header('Location: user_tweets.php');
    } else {
        $messageReceiverId = intval($_GET['receiverId']);
        $receiver = User::loadUserById($conn, $messageReceiverId);
        $receiverName = $receiver->getUsername();
        if ($loggedUser == $messageReceiverId) {
            echo "You can not send a message to yourself. <a href='user_tweets.php'>Back</a>";
            return false;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['message'])) {
        echo "You can not send an empty message. Write something";
    } else {
        $message = $_POST['message'];
        $creationDate = date('Y/m/d H:i:s');
        $senderId = $loggedUser;
        $receiverId = $_GET['receiverId'];

        
        $newMessage = new Message();
        $newMessage->setReceiverId($receiverId);
        $newMessage->setSenderId($senderId);
        $newMessage->setMessage($message);
        $newMessage->setCreationDate($creationDate);
        $newMessage->setStatus(1);
        
        if ($newMessage->saveMessageToDB($conn)) {
            header('user_tweets.php');
            echo "Message sent <a href='main.php'>Home</a>";
            return false;

        } else {
            echo "Message could not be send. Error: $conn->error.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Send Message</title>
    </head>
    <body>
        <form action="#" method="POST">
            <label>Send a message to <?php echo $receiverName ?></label>
            <input type="text" name="message">
            <input type="submit" value="Send">
        </form>
    </body>
</html>

<?php
$conn->close();
$conn = null;
?>