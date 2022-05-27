<?php

// Initialisation
require_once "configs/session.php";
require_once "configs/config.php";


try {
    $msg = '';
    $db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);

    // Get id of blog and set db query to get that blog
    $blog_id= $_POST['id'];
    $sql = "SELECT blogs_text, idblogs FROM blogs WHERE idblogs = '$blog_id'";

    $result = $db->query($sql);

    // Get blog text and id to string array
    $row = $result->fetch_row();

    // If text has been edited and saved
    if (isset($_POST["content"])) {
        try {
            // Update text of blog and go to profile
            $content = $_POST["content"];
            $sql = "UPDATE blogs SET blogs_text=?, created=CURRENT_TIMESTAMP WHERE idblogs=?";
            $query = $db->prepare($sql);
            $search = 'img';
            $replace = 'img style="max-width: 100%; height: auto; border-radius: 15px;" ';
            $count = 1;
            $content = str_replace($search, $replace, $content, $count);
            $query->bind_param('ss', $content, $blog_id);
            $query->execute();
            if($_SESSION["userid"] == "admin"){
                header("location: control_page.php");
            } else
            {
                header("location: profile.php");
            }
        } catch (Exception $ex) {
            $msg = $ex->getMessage();
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
    <link href="styles_and_scripts/<?= $_SESSION['theme'] ?>.css" type="text/css" rel="stylesheet" id="theme-link">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,300" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://cdn.tiny.cloud/1/uzkd05yfnkqwh5rah24mo87d7ip7v8ss4twofqazf5djlf5z/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector : "#mceText",
            width: "100%",
            height: "100%",
            resize: false,
            skin: "oxide-dark",
            content_css: "dark",
            file_picker_types: 'image',
            file_picker_callback: (cb) => {
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                input.addEventListener('change', (e) => {
                    const file = e.target.files[0];

                    const reader = new FileReader();
                    reader.addEventListener('load', () => {
                        /*
                          Note: Now we need to register the blob in TinyMCEs image blob
                          registry. In the next release this part hopefully won't be
                          necessary, as we are looking to handle it internally.
                        */
                        const id = 'blobid' + (new Date()).getTime();
                        const blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                        const base64 = reader.result.split(',')[1];
                        const blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);

                        /* call the callback and populate the Title field with the file name */
                        cb(blobInfo.blobUri(), { title: file.name });
                    });
                    reader.readAsDataURL(file);
                });

                input.click();
            },
            images_file_types: 'jpg,svg,webp, gif',
            plugins: [
                'save', 'advlist', 'autolink', 'lists', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'table', 'code', 'help', 'wordcount'
            ],
            toolbar: "undo redo | blocks | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | save",
            icons: "material",
            content_style: "body { font-family:Helvetica,Arial,sans-serif; font-size:14px } " +
                " img{ max-width: 100%; max-height: 100%; border-radius: 15px; padding 5px; }",
            entity_encoding : "raw"
        });
    </script>
    <title>Edit</title>
</head>
<body>
<div class="row">
    <div class="column left">
        <div>
            <a href="main_page.php"><img class="darkImage" src="imgs/blogify.svg" height="80px" alt="Blogify"></a>
            <a href="main_page.php" class="button" id="home-button"><img class="darkImage" src="imgs/home.svg" height="20" width="20" style="margin-right: 10px" alt="home">Home</a><br>
            <a href="random.php" class="button" id="random-button"><img class="darkImage" src="imgs/random.svg" height="20" width="20" style="margin-right: 10px" alt="random">Random</a><br>
            <a href="profile.php" class="button" id="profile-button"><img class="darkImage" src="imgs/profile.svg" height="20" width="20" style="margin-right: 10px" alt="profile">Profile</a><br>
            <a href="new_post.php" class="button" id="newButton"><img class="darkImage" src="imgs/new_post.svg" height="20" width="20" style="margin-right: 10px" alt="new_post">New post</a><br>
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
        <form method="post" action="edit_post.php" id="textForm">
            <textarea id="mceText" name="content">
                <?=$row[0]?>
            </textarea>
            <input type="hidden" name="id" value="<?=$row[1]?>">
        </form>
        <p><?=$msg?></p>
    </div>
</div>
<footer class="random-footer">
    <p>Made by Savva Balashov</p>
    <p><a href="mailto:balashovsava@mpei.ru">balashovsava@mpei.ru</a></p>
    <p><a href="https://vk.com/magistrofhedgehogs">vk</a></p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/@tinymce/tinymce-webcomponent@1/dist/tinymce-webcomponent.min.js"></script>
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

