<?php
session_start();

include_once './src/Message.php';
include_once './src/connection.php';
include_once './src/User.php';

if (!isset($_SESSION['loggedUserId'])) {
    header('Location: login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $messageId = $_GET['messageId'];
    $loadedMessage = Message::loadMessageById($conn, $messageId);
    $messageText = $loadedMessage->getMessage();
    $messageReceiver = $loadedMessage->username;

    $messageSenderId = $loadedMessage->getSenderId();
    $messageAuthor = User::loadUserById($conn, $messageSenderId);
    $messageAuthorName = $messageAuthor->getUsername();

    $userId = $_SESSION['loggedUserId'];
    $user = User::loadUserById($conn, $userId);
    $authorName = $user->getUsername();
    $authorId = $loadedMessage->getSenderId();

    if ($userId != $authorId) {
        $loadedMessage->changeStatus($conn, $messageId);
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Message Info</title>
    </head>
    <body>
        <a href='user_messages.php'>Back to user messages</a>
        <h2>More info about message</h2>
        <p>Message form: <?php echo $messageAuthorName ?></p>
        <p>Message to: <?php echo $messageReceiver ?></p>
        <p><?php echo $messageText ?></p>
        
    </body>
</html>

<?php
$conn->close();
$conn = null;
?>