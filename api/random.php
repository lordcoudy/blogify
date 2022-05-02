<?php
    require_once "session.php";
    require_once "config.php";
$db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);

$error = '';

if(isset($_SESSION["userid"])){
    $user = $_SESSION["userid"];
} else
{
    $user = "Guest";
}

if ($result = $db->query("SELECT blogs_text, username FROM blogs ORDER BY RAND() LIMIT 1"))
{
    $row = $result->fetch_row();
    $rand_texts[] = ['text' => $row[0], 'user' => $row[1]];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,300" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Random</title>
</head>
<body>
<div class="row">
    <div class="column left">
        <div>
            <a href="main_page.php" id="top-name"><img src="../imgs/blogify.svg" height="40em" alt="Blogify"></a>
            <a href="main_page.php" class="button" id="home-button"><img src="../imgs/home.svg" height="20" width="20" style="margin-right: 10px" alt="home">Home</a><br>
            <a href="random.php" class="button" id="random-button"><img src="../imgs/random.svg" height="20" width="20" style="margin-right: 10px" alt="random">Random</a><br>
            <a href="profile.php" class="button" id="profile-button"><img src="../imgs/profile.svg" height="20" width="20" style="margin-right: 10px" alt="profile">Profile</a><br>
            <a href="new_post_page.html" class="button" id="newButton"><img src="../imgs/new_post.svg" height="20" width="20" style="margin-right: 10px" alt="new_post">New post</a><br>
        </div>
    </div>
    <div class="column right">
        <?php
        if (empty($rand_texts)){?>
            <div class="card rand">
                    <p>No posts written yet</p>
            </div>
            <?php
        } else
        {
            foreach ($rand_texts as $r_text): ?>
                <div class="card rand">
                        <p><?=$r_text['text']?></p>
                        <h2>@<?=$r_text['user']?></h2>
                </div>
            <?php endforeach; }?>
    </div>
</div>
</body>
</html>