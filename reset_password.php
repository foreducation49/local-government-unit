<?php 
session_start();
include('./assets/config/dbconn.php');

// Check for reset token in the URL
if(isset($_GET['token'])) {
    $token = $_GET['token'];

    // Validate token and expiry
    $sql = "SELECT * FROM users WHERE reset_token='$token' AND reset_token_expiry > NOW() LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        if(isset($_POST['reset_password'])) {
            $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password and clear the reset token
            $update_sql = "UPDATE users SET password='$hashed_password', reset_token=NULL, reset_token_expiry=NULL WHERE reset_token='$token'";
            mysqli_query($conn, $update_sql);

            $_SESSION['message'] = "Your password has been reset successfully.";
            header('location: login.php');
            exit(0);
        }
    } else {
        $_SESSION['message'] = "Invalid or expired token.";
        header('location: login.php');
        exit(0);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Reset Password</title>
</head>
<body>
    <section class="container">
        <div class="form">
            <?php include('message.php'); ?>
            <div class="form-content">
                <header>Reset Password</header>

                <form action="" method="post">
                    <div class="input-group">
                        <input type="password" name="new_password" id="new_password" placeholder="New Password" required>
                    </div>

                    <div class="input-group">
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                    </div>

                    <div class="button">
                        <input type="submit" class="btn" value="Reset Password" name="reset_password">
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script src="./assets/js/script.js"></script>
</body>
</html>
