<?php
require_once "configs/session.php";
require_once "configs/config.php";

// Connect to db
$db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);

// Check db connection
if($db === false){
    die("Error: connection error. " . mysqli_connect_error());
}

$msg = 'Please fill this form to create an account.';

// If register button is pressed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $username = trim($_POST['login']);
    $password = trim($_POST['password']);
    // Hash and salt password with cost = 11
    $password_hash_salt = password_hash($password, PASSWORD_BCRYPT, array('cost' => 11));

    if($query = $db->prepare("SELECT * FROM users_tb WHERE users_login = ?")) {
        // Bind parameters (s = string, i = int)
        $query->bind_param('s', $username);
        $query->execute();
        // Store the result to check if the account exists in the database.
        $query->store_result();
        if ($query->num_rows > 0) {
            $msg .= '<p class="error">This username is already registered!</p>';
        } else {
            // Validate password
            if (strlen($password ) < 6) {
                $msg .= '<p class="error">Password must have at least 6 characters.</p>';
            }
            // If no errors assign user data to current session and add it to db
            if ($msg == 'Please fill this form to create an account.') {
                $insertQuery = $db->prepare("INSERT INTO users_tb (users_login, users_password) VALUES (?, ?);");
                $insertQuery->bind_param("ss", $username, $password_hash_salt);
                $result = $insertQuery->execute();
                if ($result) {
                    $msg .= '<p class="success">Your registration was successful!</p>';
                    $_SESSION["userid"] = $username;
                    $result_id = $db->query("SELECT idusers FROM users_tb WHERE users_login='$username'");
                    $row = $result_id->fetch_row();
                    $_SESSION["user"] =$row[0];
                    header("location: main_page.php");
                    exit;
                } else {
                    $msg .= '<p class="error">Something went wrong!</p>';
                }
            }
        }
    }
    $query->close();
}
// Close db connection
mysqli_close($db);
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
            <h1>Register</h1>
            <p><?=$msg?></p>
            <form action="" method="post">
                <div class="form-group">
                    <input type="text" name="login" class="form-control" required placeholder="Username">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" required placeholder="Password">
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" class="button submit" value="Submit">
                </div>
                <p>Already have an account? <a href="login.php" class="button login">Login here</a></p>
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
