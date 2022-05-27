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

// Loading all users from db and form a massive
if ($result = $db->query("SELECT your_login FROM your_users_table"))
{
    while ($row = $result->fetch_row())
    {
        $all_users[] = $row[0];
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles_and_scripts/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,300" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Profile</title>
</head>
<body>
<div class="row">
    <div class="column left">
        <div>
            <a href="control_users.php" id="top-name"><img src="imgs/blogify.svg" height="40em" alt="Blogify"></a>
            <a href="control_users.php" class="button" id="profile-button"><img src="imgs/profile.svg" height="20" width="20" style="margin-right: 10px" alt="Users">Users</a><br>
            <a href="control_page.php" class="button" id="home-button"><img src="imgs/new_post.svg" height="20" width="20" style="margin-right: 10px" alt="Posts">Posts</a>
        </div>
    </div>
    <div class="column right">
        <div class="card profile">
            <p>List of users</p>
        </div>
        <?php
        if (empty($all_users)){?>
            <div class="card">
                <p>No users exist</p>
            </div>
            <?php
        } else
        {
            foreach (array_reverse($all_users) as $a_user): ?>
            <?php if($a_user != "admin"){?>
                <div class="card">
                    <form action="delete_user.php" method="post">
                        <p><?=$a_user?></p>
                        <input type="hidden" name="id" value="<?=$a_user?>">
                        <input class="button submit" type="submit" value="Delete">
                    </form>
                </div>
                <?php } ?>
            <?php endforeach; }?>
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
</body>
</html>
