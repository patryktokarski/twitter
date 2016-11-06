<?php
session_start();

include_once './src/User.php';
include_once './src/connection.php';
include_once './src/Tweet.php';
include_once './src/Comment.php';

if (!isset($_SESSION['loggedUserId'])) {
    header('Location: login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userTweets = $_POST['user'];
    $tweetsAuthor = User::loadUserById($conn, $userTweets);   
}


?>

<!DOCTYPE html>
<html>
    <head>
        <title>Tweet by user</title>
    </head>
    <body>
        <a href='main.php'>Back to main site</a>
        <form action='#' method="POST">
            <label>Select user:</label>
            <select name="user">
                <?php 
                $result = User::loadAllUsers($conn);
                foreach($result as $user) {
                    $userId = $user->getId();
                    echo "<option value=" . $userId . ">" . $user->getUsername() . "</option>";
                }
                ?>
            </select>
            <input type='submit' value='Show all Tweets'>
        </form>
        <table border="1">
            <?php
                @$result = Tweet::loadAllTweetByUserId($conn, $userTweets);
                echo "All tweets written by: " . @$tweetsAuthor->getUsername() ."";
                foreach ($result as $key => $tweet) {
                    $userId = $tweet->getUserId();
                    //echo '<tr><td>' . $userId . 'wrote on<td>';
                    echo '<td>' . $tweet->getCreationDate() . '</td></tr>';
                    echo '<tr><td>' . $tweet->getText() . '</td>';
                    $tweetId = $tweet->getId();
                    $commentsToTweet = Comment::loadAllCommentsByTweetId($conn, $tweetId);
                    $num = 0;
                    foreach($commentsToTweet as $comment) {
                        $num++;
                    }
                    echo '<td>Number of comments: ' . $num . '</td></tr>';
                }
            ?>
        </table>
            <hr>
            <span>Send a message to: </span>
            <a href="send_message.php?receiverId=<?php echo $tweetsAuthor->getId() ?>"><?php echo $tweetsAuthor->getUsername()?></a>
    </body>
</html>

<?php
$conn->close();
$conn = null;
?>