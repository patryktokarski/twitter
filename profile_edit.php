<?php
session_start();

include_once './src/User.php';
include_once './src/connection.php';

if (!isset($_SESSION['loggedUserId'])) {
    header('Location: login.php');
} else {
            
    $userId = $_SESSION['loggedUserId'];
    $loadedUser = User::loadUserById($conn, $userId);
    $loadedUserName = $loadedUser->getUsername();
    $loadedUserEmail = $loadedUser->getEmail();
    $loadedUserId = $loadedUser->getId();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {


        if (isset($_POST['newName']) && trim($_POST['newName'] != '')) {
            $newName = $conn->real_escape_string($_POST['newName']);
            $loadedUser->setUserName($newName);
            echo 'Name has been updated';
        }
        if (isset($_POST['newEmail']) && trim($_POST['newEmail'] != '')) {
            $newEmail = $conn->real_escape_string($_POST['newEmail']);
            $user = User::getUserByEmail($conn, $newEmail);
            if ($user) {
                echo 'Podany adres e-mail jest zajety. Wprowadz inny adres e-mail.';
            } else {
                $loadedUser->setEmail($newEmail);
                echo 'Email has been updated';
            }
        }
        if (isset($_POST['newPassword']) && isset($_POST['newPasswordCon']) && trim($_POST['newPassword'] != '')) {
            $newPassword = $conn->real_escape_string($_POST['newPassword']);
            $newPasswordCon = $conn->real_escape_string($_POST['newPasswordCon']);
            if ($newPassword == $newPasswordCon) {
                $loadedUser->setHashedPassword($newPassword);
                echo 'Password has been updated';
            } else {
                echo 'Typed passwords are not the same';
            }
        }        
        if ($loadedUser->saveToDB($conn)) {
            //echo "Dane zaaktualizowane";
        } else {
            echo 'Blad przy aktualizacji danych';
        }
        
        if ($_POST['delete'] == true) {
            $loadedUser->delete($conn);
            unset($_SESSION['loggedUserId']);
            header('Location: login.php');
        }
    }    
}


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edit your profile</title>
    </head>
    <body>
        <a href='main.php'>Back to Main site</a>
        <h2>Your profile</h2>
        <h3>Your current informations</h3>
        <p>Name: <?php echo $loadedUserName?></p>
        <p>Email: <?php echo $loadedUserEmail?></p>
        <p>Do you want to make some changes in your profile. Type them in in the edit section below</p>
        <form method="POST">
            <label>Name:</label>
            <input type='text' name='newName'>
            <label>Email:</label>
            <input type='email' name='newEmail'>
            <label>New password:</label>
            <input type='password' name='newPassword'>
            <label>Confirm new password:</label>
            <input type='password' name='newPasswordCon'>
            <input type='submit' name='submit' value='Save Changes'>
            <hr>
            <p>To delete User press the button below.</p>
            <input type='submit' name='delete' value='Delete User'> 
        </form>
    </body>
</html>