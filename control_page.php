<?php
// Connect to db and session
require_once "configs/session.php";
require_once "configs/config.php";

// Set db connection
$db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);

// Variable for errors
$error = '';

// If session is not active => redirect to registration
if(isset($_SESSION["userid"])){
    $user = $_SESSION["userid"];
} else
{
    header("location: register.php");
}

// Loading all blogs from db and form a massive
if ($result = $db->query("SELECT blogs_text, idblogs, created, username FROM blogs"))
{
    while ($row = $result->fetch_row())
    {
        $all_texts[] = ['text' => $row[0], 'id' => $row[1], 'edited' => $row[2], 'user' => $row[3]];
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<!--    Connecting styles.css, Open Sans font group and font-awesome-->
    <link href="styles_and_scripts/<?= $_SESSION['theme'] ?>.css" type="text/css" rel="stylesheet" id="theme-link">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,300" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Profile</title>
</head>
<body>
<!--Table-like view with left menu column and right main column-->
<div class="row">
    <div class="column left">
<!--    Menu buttons-->
        <div>
            <a href="control_users.php" id="top-name"><img class="darkImage" src="imgs/blogify.svg" height="80px" alt="Blogify"></a>
            <a href="control_users.php" class="button" id="profile-button"><img class="darkImage" src="imgs/profile.svg" height="20" width="20" style="margin-right: 10px" alt="Users">Users</a><br>
            <a href="control_page.php" class="button" id="home-button"><img class="darkImage" src="imgs/new_post.svg" height="20" width="20" style="margin-right: 10px" alt="Posts">Posts</a>
        </div>
    </div>
    <div class="column right">
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
<!--    Profile name-->
        <div class="card profile">
            <?php
            print_r($user);
            ?>
        </div>
<!--    Checking if blogs exist-->
        <?php
        if (empty($all_texts)){?>
            <div class="card">
                <p>No posts written yet</p>
            </div>
            <?php
        } else
        {
//          Output of blogs in cycle in html template
            foreach (array_reverse($all_texts) as $a_text): ?>
                <div class="card">
                    <form action="delete_post.php" method="post">
                        <p><?=$a_text['text']?></p>
                        <h6><?=$a_text['edited']?></h6>
                        <h2>@<?=$a_text['user']?></h2>
                        <input type="hidden" name="id" value="<?=$a_text['id']?>">
                        <input class="button submit" type="submit" value="Delete">
                    </form>
                    <form action="edit_post.php" method="post">
                        <input type="hidden" name="id" value="<?=$a_text['id']?>">
                        <input class="button submit" type="submit" value="Edit">
                    </form>
                </div>
            <?php endforeach; }?>
<!--    Log out button-->
        <div class="card profile">
            <a href="logout.php" class="button" id="logoutButton">Log Out</a>
        </div>
    </div>
</div>
<footer>
    <p>Made by Savva Balashov</p>
    <p><a href="mailto:balashovsava@mpei.ru">balashovsava@mpei.ru</a></p>
    <p><a href="https://vk.com/magistrofhedgehogs">vk</a></p>
</footer>
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
