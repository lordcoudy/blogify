<?php
require_once "configs/session.php";


class Content {
    // Error message, if any
    public $error = "";

    // Constructor (connect to database)
    function __construct () {
        try {
            require_once "configs/config.php";
        } catch (Exception $ex) { exit($ex->getMessage()); }
    }

    // Destructor (close connection)
    function __destruct () {
        $db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);
        mysqli_close($db);
    }

    // Save blog text
    function save ($content) {
        try {
            // Add to blogs text and username of user who wrote it
            $db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);
            $query = $db->prepare(
                "INSERT INTO blogs (blogs_text, username, userid) VALUES (?, ?, ?)"
            );
            $query->bind_param('ssi',$content, $_SESSION["userid"], $_SESSION["user"] );
            $query->execute();
            return true;
        } catch (Exception $ex) {
            $this->error = $ex->getMessage();
            return false;
        }
    }
}

// Class initialisation
$_CONTENT = new Content();

// Save content when save button is pressed
if (isset($_POST["content"])) {
    $blog = $_POST["content"];
        $search = 'img';
        $replace = 'img style="width: 100%; height: auto; border-radius: 15px;" ';
        $count = 1;
    echo $_CONTENT->save(str_replace($search, $replace, $blog, $count))
        ? "<div>SAVED</div>"
        : "<div>{$_CONTENT->error}</div>" ;
}

// GoTo profile
header("Location: profile.php");
exit();
