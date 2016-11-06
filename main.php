<?php

include_once './src/Tweet.php';
include_once './src/connection.php';
include_once './src/User.php';

session_start();
if (!isset($_SESSION['loggedUserId'])) {
    header('Location: login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['tweet'])) {
        echo 'Wpisz wiadomosc';
    } else {
        $tweetText = $conn->real_escape_string(trim($_POST['tweet']));
        $userId = $_SESSION['loggedUserId'];
        $creationDate = date('Y-m-d H:i:s');
        if (strlen($tweetText) < 140) {
            $tweet = new Tweet();
            $tweet->setUserId($userId);
            $tweet->setText($tweetText);
            $tweet->setCreationDate($creationDate);
            $tweet->saveToDB($conn);
        } else {
            echo "Your message is to long. It can not be longer then 140 characters";
        }
    }
}
?>
<html>
    <head>
        <title>Twitter</title>
    </head>
    <body>
        <h1>Twitter</h1>
        <a href="logout.php">Logout</a>
        <a href="profile_edit.php">My Profile</a>
        <a href='user_tweets.php'>Tweets By User</a>
        <a href="main.php">Refresh</a>
        <a href="user_messages.php">Messages</a>
        <form action="#" method="POST">
            <label>Share what you thinking about</label>
            <textarea name="tweet" class='tweetInput'></textarea>
            <input type="submit" value='Przeslij'>
            <p>Previous Tweets</p>
            <table border= 1>
                <?php
                $result = Tweet::loadAllTweets($conn);
                foreach ($result as $key => $tweet) {
                    $userId = $tweet->getUserId();
                    $user = User::loadUserById($conn, $userId);
                    echo '<tr><td>' . $user->getUsername() . ' wrote: </td>';
                    echo '<td>' . $tweet->getCreationDate() . '</td></tr>';
                    echo '<tr><td>' . $tweet->getText() . '<a href="show_tweet.php?tweet_id=' . $tweet->getId() . '">more</a></td></tr>';
                }
                ?>
            </table>
        </form>
    </body>
</html>

<?php
$conn->close();
$conn = null;
?>