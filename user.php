<?php
// Initialisation
require_once "configs/session.php";
require_once "configs/config.php";

$db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);

$error = '';

// If user does not exist then plug
if(isset($_POST['name'])){
    $user = $_POST['name'];
} else
{
    $user = "No such user!";
}

// Get blogs of selected user and assign them to array of strings
if ($result = $db->query("SELECT your_text, your_text_time FROM your_text_table where your_text_username='$user'"))
{
    while ($row = $result->fetch_row())
    {
        $user_texts[] = ['text' => $row[0], 'edited' => $row[1]];
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="image/x-icon" href="imgs/favicon.ico" />
    <link rel="stylesheet" href="styles_and_scripts/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,300" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Profile</title>
</head>
<body>
<div class="row">
    <div class="column left">
        <div>
            <a href="main_page.php" id="top-name"><img src="imgs/blogify.svg" height="40px" alt="Blogify"></a>
            <a href="main_page.php" class="button" id="home-button"><img src="imgs/home.svg" height="20" width="20" style="margin-right: 10px" alt="home">Home</a><br>
            <a href="random.php" class="button" id="random-button"><img src="imgs/random.svg" height="20" width="20" style="margin-right: 10px" alt="random">Random</a><br>
            <a href="profile.php" class="button" id="profile-button"><img src="imgs/profile.svg" height="20" width="20" style="margin-right: 10px" alt="profile">Profile</a><br>
            <a href="new_post_page.html" class="button" id="newButton"><img src="imgs/new_post.svg" height="20" width="20" style="margin-right: 10px" alt="new_post">New post</a><br>
        </div>
    </div>
    <div class="column right">
        <div class="card profile">
            <?php
            print_r($user);
            ?>
        </div>
        <?php
        if (empty($user_texts)){?>
            <div class="card">
                <p>No posts written yet</p>
            </div>
            <?php
        } else
        {
            foreach (array_reverse($user_texts) as $u_text): ?>
                <div class="card">
                    <p><?=$u_text['text']?></p>
                    <h6><?=$u_text['edited']?></h6>
                </div>
            <?php endforeach; }?>
    </div>
</div>
<footer class="random-footer">
    <p>Made by Savva Balashov</p>
    <p><a href="mailto:balashovsava@mpei.ru">balashovsava@mpei.ru</a></p>
    <p><a href="https://vk.com/magistrofhedgehogs">vk</a></p>
</footer>
</body>
</html>
