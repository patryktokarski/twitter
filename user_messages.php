<?php
session_start();

include_once './src/Message.php';
include_once './src/connection.php';
include_once './src/User.php';

if (!isset($_SESSION['loggedUserId'])) {
    header('Location: login.php');
}

$userId = $_SESSION['loggedUserId'];



?>

<!DOCTYPE html>
<html>
    <head>
        <title>Your Messages</title>
    </head>
    <body>
        <a href="main.php">Back to main site</a>
        <h2>Sent Messages:</h2>
        <div>
            <table border='1'>
                <?php
                $sentMessages = Message::loadMessagesBySenderId($conn, $userId);
                foreach ($sentMessages as $message) {
                    echo "<tr ><td>Message: " . substr($message->getMessage(), 0, 30) . "<a href='show_message.php?messageId=" . $message->getId() . "'>more...</a></td>";
                    echo "<td>on: " . $message->getCreationDate() . "</td>";
                    echo "<td>Sent to: " . $message->username . "</td></tr>";
                    
                    
                }
                ?>
            </table>
        </div>
        <h2>Received Messages:</h2>
        <div>
            <table border='1'>
                <?php
                $receivedMessages = Message::loadMessagesByReceiverId($conn, $userId);
                foreach ($receivedMessages as $message) {
                    echo "<tr><td>Message: " . substr($message->getMessage(), 0, 30) . "<a href='show_message.php?messageId=" . $message->getId() . "'>more...</a></td>";
                    echo "<td>on: " . $message->getCreationDate() . "</td>";
                    echo "<td>From: " . $message->username . "</td>";
                    $status = $message->getStatus();
                    if ($status == 1) {
                        echo "<td>NEW</td></tr>";
                    }
                }
                ?>
            </table>
        </div>
    </body>
</html>

<?php
$conn->close();
$conn = null;
?>