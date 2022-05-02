<?php
require_once "session.php";
require_once "config.php";

$db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);

$error = '';

if ($result = $db->query("SELECT blogs_text, username FROM blogs"))
{
    while ($row = $result->fetch_row())
    {
        $texts[] = ['text' => $row[0], 'user' => $row[1]];
    }
} else
{
    $tmp = "No posts written yet";
    $texts[] = $tmp;
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blogify</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,300" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="row">
    <div class="column left">
        <div>
            <a href="main.php" id="top-name"><img src="imgs/blogify.svg" height="40em" alt="Blogify"></a>
            <a href="main.php" class="button" id="home-button"><img src="imgs/home.svg" height="20" width="20" style="margin-right: 10px">Home</a><br>
            <a href="random.php" class="button" id="random-button"><img src="imgs/random.svg" height="20" width="20" style="margin-right: 10px">Random</a><br>
            <a href="profile.php" class="button" id="profile-button"><img src="imgs/profile.svg" height="20" width="20" style="margin-right: 10px">Profile</a><br>
            <a href="new_post.html" class="button" id="newButton"><img src="imgs/new_post.svg" height="20" width="20" style="margin-right: 10px">New post</a><br>
        </div>
    </div>
    <div class="column right">
        <button onclick="topFunction()" id="scrollBtn">Home</button>
        <?php
        foreach ($texts as $text): ?>
        <div class="card">
                <p><?=$text['text'] ?></p>
                <h2>@<?=$text['user']?></h2>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<footer>
    <p>Made by Savva Balashov</p>
    <p><a href="mailto:balashovsava@mpei.ru">balashovsava@mpei.ru</a></p>
</footer>
<script src="scripts.js"></script>
</body>
</html>
