<?php
require_once "session.php";

define('DBSERVER', 'localhost'); // Database server
define('DBUSERNAME', 'root'); // Database username
define('DBPASSWORD', 'pdtpl0ktn'); // Database password
define('DBNAME', 'blogify_db'); // Database name

/* connect to MySQL database */
$db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // validate if email is empty
    if (empty($username)) {
        $error .= '<p class="error">Please enter username.</p>';
    }

    // validate if password is empty
    if (empty($password)) {
        $error .= '<p class="error">Please enter your password.</p>';
    }

    $result = $db->query("SELECT * FROM users_tb WHERE users_login = '$username'");

    if (empty($error)) {
        if($query = $db->prepare("SELECT * FROM users_tb WHERE users_login = ?")) {
            $query->bind_param('s', $username);
            $query->execute();
            $row = mysqli_fetch_row($result);
            if ($row) {
                if (password_verify($password, $row[2])) {
                    $_SESSION["userid"] = $row[1];
                    $_SESSION["user"] = $row;

                    // Redirect the user to welcome page
                    header("location: index.html");
                    exit;
                } else {
                    $error .= '<p class="error">The password is not valid.</p>';
                }
            } else {
                $error .= '<p class="error">No User exist with that email address.</p>';
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
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,300" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<table>
    <tr class="login card">
        <td>
                <h2>Login</h2>
                <p>Please fill in your email and password.</p>
                <form action="" method="post">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                    </div>
                    <p>Don't have an account? <a href="register.php">Register here</a>.</p>
                </form>
        </td>
    </tr>
</table>

</body>
</html>