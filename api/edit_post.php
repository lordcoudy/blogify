<?php
require_once "configs/session.php";
require_once "configs/config.php";


try {
    $db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);

    $blog_id= $_POST['id'];
    $sql = "SELECT blogs_text, idblogs FROM blogs WHERE idblogs = '$blog_id'";

    $result = $db->query($sql);

    $row = $result->fetch_row();

    if (isset($_POST["content"])) {

        try {
            $content = $_POST["content"];
            $sql = "UPDATE blogs SET blogs_text='$content' WHERE idblogs='$blog_id'";
            $db->query($sql);
            header('location: profile.php');
        } catch (Exception $ex) {
            $this->error = $ex->getMessage();
        }
    }
}
catch (PDOException $e) {
    $title = 'An error has occurred';

    $output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' .
        $e->getFile() . ':' . $e->getLine();
}

//header("profile.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles_and_scripts/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,300" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://cdn.tiny.cloud/1/uzkd05yfnkqwh5rah24mo87d7ip7v8ss4twofqazf5djlf5z/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector : "#mceText",
            width: "100%",
            height: "100%",
            resize: false,
            menubar: false,
            plugins: [
                'save', 'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
            ],
            toolbar: "undo redo | blocks | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | save",
            icons: "material",
            content_style: "body { font-family:Helvetica,Arial,sans-serif; font-size:14px }"
        });
    </script>
    <title>Edit</title>
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
        <form method="post" action="edit_post.php" id="textForm">
            <textarea id="mceText" name="content">
                <p><?=$row[0]?></p>
            </textarea>
            <input type="hidden" name="id" value="<?=$row[1]?>">
        </form>
    </div>
</div>
<footer>
    <p>Made by Savva Balashov</p>
    <p><a href="mailto:balashovsava@mpei.ru">balashovsava@mpei.ru</a></p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/@tinymce/tinymce-webcomponent@1/dist/tinymce-webcomponent.min.js"></script>
<script src="styles_and_scripts/scripts.js"></script>
</body>
</html>

