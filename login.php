<?php
session_start();

require_once 'src/connection.php';
require_once 'src/User.php';
require_once 'src/Tweet.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['email']) && trim($_POST['email']) != "" &&
            isset($_POST['password']) && trim($_POST['password'])) {
        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);

        if ($userId = User::logIn($conn, $email, $password)) {
            $_SESSION['loggedUserId'] = $userId;
            $_SESSION['loggedUserEmail'] = $email;
            header("Location: main.php");
        } else {
            echo("Niepoprawne dane logowania.<br>");
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Twitter</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <h2>Login</h2>
        <form role="form" method='POST'>
            <div class="form">
                <label>E-mail:</label>
                <input type="email" name="email" class="form" id="email" placeholder="Enter email">
            </div>
            <div class="form">
                <label>Password:</label>
                <input type="password" name="password" class="form" id="pass" placeholder="Enter password">
            </div>
            <div class="checkbox">
                <label><input type="checkbox">Zapamietaj mnie</label>
            </div>
            <button type="submit" name="submit" class="button">Login</button>
        </form>
        <label>Odwiedzasz nas po raz pierwszy? Zarejestruj sie --></label>
        <a href="register.php">Zarejestruj</a>
    </body>
</html>

<?php
$conn->close();
$conn = null;
?>
