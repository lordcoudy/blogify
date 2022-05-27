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
    <link href="styles_and_scripts/<?= $_SESSION['theme'] ?>.css" type="text/css" rel="stylesheet" id="theme-link">
    <link rel="shortcut icon" type="image/x-icon" href="imgs/favicon.ico" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,300" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php if ($_SESSION["theme"] == "light"){ ?>
    <div id="toggleTheme">Switch Theme</div>
    <label class="switchTheme">
        <input type="checkbox" name="theme" id="theme-button">
        <span class="slider round"">
    </label>
<?php }else { ?>
    <div id="toggleTheme">Switch Theme</div>
    <label class="switchTheme">
        <input type="checkbox" name="theme" id="theme-button" checked>
        <span class="slider round"">
    </label>
<?php }?>
<table class="small">
    <tr>
        <td>
            <img class="darkImage" src="imgs/blogify.svg" height="100px" style="margin-top: 20px" alt="Blogify">
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
<script>
    var btn = document.getElementById("theme-button");
    var link = document.getElementById("theme-link");
    btn.addEventListener("click", function () { ChangeTheme(); });
    function ChangeTheme() {
        let lightTheme = "styles_and_scripts/light.css";
        let darkTheme = "styles_and_scripts/dark.css";
        var currTheme = link.getAttribute("href");
        var theme = "";

        if (currTheme === lightTheme) {
            currTheme = darkTheme;
            theme = "dark";
        } else {
            currTheme = lightTheme;
            theme = "light";
        }
        link.setAttribute("href", currTheme);
        Save(theme);
    }

    function Save(theme) {
        var Request = new XMLHttpRequest();
        Request.open("GET", "configs/themes.php?theme=" + theme, true); // путь к php файлу отвечающий за сохранение
        Request.send();
    }
</script>
</body>
</html>
