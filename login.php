<?php
// Initialisation
require_once "configs/session.php";
require_once "configs/config.php";

// Connect to MySQL database
$db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);

$msg = 'Please fill in your username and password.';
// If login button is pressed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate if email is empty
    if (empty($username)) {
        $msg .= '<p class="error">Please enter username.</p>';
    }

    // Validate if password is empty
    if (empty($password)) {
        $msg .= '<p class="error">Please enter your password.</p>';
    }

    // db query to get user
    $result = $db->query("SELECT * FROM your_users_table WHERE your_users_login = '$username'");

    // If no errors continue
    if ($msg == 'Please fill in your username and password.') {
        // Get array of strings with username and password
        if($query = $db->prepare("SELECT * FROM your_users_table WHERE your_users_login = ?")) {
            $query->bind_param('s', $username);
            $query->execute();
            $row = mysqli_fetch_row($result);
            // Verifying password^ that was hashed and salted and assigning user data to current session
            if ($row) {
                if (password_verify($password, $row[2])) {
                    $_SESSION["userid"] = $username;
                    $_SESSION["user"] = $row[0];
                    // Redirect the user to welcome page
                    if ($username == "admin")
                    {
                        header("location: control_page.php");
                    } else
                    {
                        header("location: main_page.php");
                    }
                    exit;
                } else {
                    $msg .= '<p class="error">The password is not valid.</p>';
                }
            } else {
                $msg .= '<p class="error">No User exist with that username.</p>';
            }
        }
        $query->close();
    }
    // Close connection
    mysqli_close($db);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="shortcut icon" type="image/x-icon" href="imgs/favicon.ico" />
    <link rel="stylesheet" href="styles_and_scripts/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,300" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<table class="small">
    <tr>
        <td>
            <img src="imgs/blogify.svg" height="50em" style="margin-top: 20px" alt="Blogify">
        </td>
    </tr>
    <tr class="login card">
        <td>
                <h1>Login</h1>
                <p><?=$msg?></p>
                <form action="" method="post">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" required placeholder="Username"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" required placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="button submit" value="Submit">
                    </div>
                    <p>Don't have an account? <a href="register.php" class="button login">Register here</a></p>
                </form>
        </td>
    </tr>
</table>
<footer class="login-footer">
        <p>Made by Savva Balashov</p>
        <p><a href="mailto:balashovsava@mpei.ru">balashovsava@mpei.ru</a></p>
        <p><a href="https://vk.com/magistrofhedgehogs">vk</a></p>
</footer>
<script src="styles_and_scripts/scripts.js"></script>
</body>
</html>
