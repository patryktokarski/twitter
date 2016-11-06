<?php
session_start();

include_once './src/Tweet.php';
include_once './src/connection.php';
include_once './src/Comment.php';
include_once './src/User.php';

if (!isset($_SESSION['loggedUserId'])) {
    header('Location: login.php');
} else {
    
//   if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (!empty($_GET['tweet_id'])) {
            $tweetId = $_GET['tweet_id'];
            $loadedTweet = Tweet::loadTweetById($conn, $tweetId);
            $tweet = $loadedTweet->getText();
            $tweetAuthorId = $loadedTweet->getUserId();
            $tweetCreationDate = $loadedTweet->getCreationDate();
            $tweetAuthor = $loadedTweet->username;
            
        }
//    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!empty($_POST['comment'])) {
            $comment = $_POST['comment'];
            if (strlen($comment) > 60) {
                echo "Comment is to long. Max 60 characters";
            } else {
                $creationDate = date("Y/m/d H:i:s");
                $userId = $_SESSION['loggedUserId'];
                $tweetId = $_GET['tweet_id'];

                $newComment = new Comment();
                $newComment->setUserId($userId);
                $newComment->setTweetId($tweetId);
                $newComment->setCreationDate($creationDate);
                $newComment->setComment($comment);

                if ($newComment->saveToDB($conn)) {
                    echo "Comment added";
                } else {
                    echo "Error. Comment could not be added Error:$conn->error";
                }
            }
        }
    }
}
?>

<!DOCTYPE>
<html>
    <head>
        <title>More info...</title>
    </head>
    <body>
        <h2>More info:</h2>
        <div class='tweetInfo'>
            <p>Post contents:<?php echo @$tweet?></p>
            
            <p>Post author: <?php echo @$tweetAuthor ?></p>
            <p>Creation date: <?php echo @$tweetCreationDate ?></p>
        </div>
        <form action='#' method="POST">
            <h2>Comments added to this post:</h2>
            <div class='tweetComments'>
                <?php
                $result = Comment::loadAllCommentsByTweetId($conn, $tweetId);
                echo "<div>";
                foreach ($result as $key => $comment) {
                    echo "<div>" . $comment->getCreationDate() . "</div>";
                    echo "<div>" . $comment->getComment() . "</div>";
                    $CommentAuthorId = $comment->getUserId();
                    $commentAuthor = User::loadUserById($conn, $CommentAuthorId);
                    echo "<div>Comment form:" . $commentAuthor->getUsername() . "</div><hr>";
                }
                echo "</div>";
                ?>
            </div>
            <textarea name="comment" placeholder='Comment...'></textarea>
            <input type='submit' value='Send Comment'>
            <a href="main.php">Back to main site</a>
        </form>
    </body>
</html>

<?php
$conn->close();
$conn = null;
?>


