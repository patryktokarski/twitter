<?php
include_once 'src/User.php';
include_once 'src/connection.php';

if (($_SERVER['REQUEST_METHOD']) == 'POST') {
    if (isset($_POST['email']) && trim($_POST['email']) != " " &&
            isset($_POST['password']) && trim($_POST['password']) != " " &&
            isset($_POST['password2']) && trim($_POST['password2']) != " " &&
            isset($_POST['userName']) && trim($_POST['userName']) != " ") {
        
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $username = $_POST['userName'];

        $user = User::getUserByEmail($conn, $email);
        if ($user) {
            echo 'Uzytkownik o podanym adresie e-mail juz istnieje. Wprowadz inny adres e-mail.';
        } else if ($password == $password2) {
            $user = new User();
            $user->setEmail($email);
            $user->setHashedPassword($password);
            $user->setUserName($username);

            if ($user->saveToDB($conn)) {
                header('Location: login.php');
            }
        }
    } else {
        echo "Wprowadz wszystkie dane";
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Sing in</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <h2>Join us!</h2>
        <form class="form" method="POST">
            <label>User Name</label>
            <input type="text" name="userName" class="form" id="userName">
            <label>User Email:</label>
            <input type="email" name="email" class="form" id="email">
            <label>Password:</label>
            <input type="password" name="password" class="form" id="pass">
            <label>Confirm Password:</label>
            <input type="password" name="password2" class="form" id="pass2">
            <input type="submit" name="submit" value="Register">
            <p>Are you already registered? Click the linl below.</p>
            <a href='login.php'>Login</a>
        </form>
    </body>  
</html>

<?php
$conn->close();
$conn = null;
?>