<?php
require_once "configs/session.php";
require_once "configs/config.php";

$db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);

$error = '';

if ($result = $db->query("SELECT blogs_text, username, created, idblogs FROM blogs"))
{
    while ($row = $result->fetch_row())
    {
        $texts[] = ['text' => $row[0], 'user' => $row[1], 'edited' => $row[2], 'id' => $row[3]];
    }
} else
{
    $tmp = "No posts written yet";
    $texts[] = $tmp;
}

function readMoreHelper($story_desc, $chars = 1000)
{
    $story_desc = substr($story_desc, 0, $chars);
    $story_desc = substr($story_desc, 0, strrpos($story_desc, ' '));
    $story_desc = $story_desc . " <input type='submit' name='filler' id='moreButton' value='Show More...'>";

    return $story_desc;
}

if(isset($_POST['more_id'])){
    $shown = $_POST['more_id'];
} else
{
    $shown = 0;
}

if(isset($_POST['less_id'])){
    $hidden = $_POST['less_id'];
} else
{
    $hidden = 0;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blogify</title>
    <link rel="stylesheet" href="styles_and_scripts/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,300" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="row">
    <div class="column left">
        <div>
            <a href="main_page.php" id="top-name"><img src="imgs/blogify.svg" height="40em" alt="Blogify"></a>
            <a href="main_page.php" class="button" id="home-button"><img src="imgs/home.svg" height="20" width="20" style="margin-right: 10px" alt="home">Home</a><br>
            <a href="random.php" class="button" id="random-button"><img src="imgs/random.svg" height="20" width="20" style="margin-right: 10px" alt="random">Random</a><br>
            <a href="profile.php" class="button" id="profile-button"><img src="imgs/profile.svg" height="20" width="20" style="margin-right: 10px" alt="profile">Profile</a><br>
            <a href="new_post_page.html" class="button" id="newButton"><img src="imgs/new_post.svg" height="20" width="20" style="margin-right: 10px" alt="new_post">New post</a><br>
        </div>
    </div>
    <div class="column right">
        <button onclick="topFunction()" id="scrollBtn">Home</button>
        <?php
        foreach (array_reverse($texts) as $text){?>
        <div class="card">
            <?php if ($shown == 0 || $text["id"] != $shown) {?>
                <form method="post">
                    <p><?=readMoreHelper($text['text'])?></p>
                    <input type='hidden' name='more_id' id='user_button' value='<?=$text["id"]?>'>
                </form>
            <?php } else{?>
                <?php if ($hidden != $text["id"] || $hidden == 0){?>
                    <span id="anchor"></span>
                    <form method="post">
                        <p><?=$text['text']?></p>
                        <input type='submit' name='hide' id='moreButton' value='Show Less...'>
                        <input type='hidden' name='less_id' id='user_button' value='<?=$text["id"]?>'>
                    </form>
                <?php } ?>
            <?php } if ($hidden==$text["id"]){?>
            <span id="anchor"></span><?php }?>
            <form method="post" action="user.php">
                <h2>@<input type="submit" name="name" id="user_button" value="<?=$text['user']?>"></h2>
                <h6><?=$text['edited']?></h6>
            </form>
        </div>
        <?php } ?>
    </div>
</div>
<footer>
    <p>Made by Savva Balashov</p>
    <p><a href="mailto:balashovsava@mpei.ru">balashovsava@mpei.ru</a></p>
    <p><a href="https://vk.com/magistrofhedgehogs"></a>vk</p>
</footer>
<script src="styles_and_scripts/scripts.js"></script>
<script>
    // window.scroll(0,findPos(document.getElementById("anchor")));
    document.querySelector('#anchor').scrollIntoView({
        behavior: 'smooth',
        block: "center"
    });
</script>
</body>
</html>
