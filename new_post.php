<?php
require_once "configs/session.php";


class Content {
    // (A) PROPERTIES
    public $error = ""; // Error message, if any

    // (B) CONSTRUCTOR - CONNECT TO DATABASE
    function __construct () {
        try {
            require_once "configs/config.php";
        } catch (Exception $ex) { exit($ex->getMessage()); }
    }

    // (C) DESTRUCTOR - CLOSE DATABASE CONNECTION
    function __destruct () {
        $db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);
        mysqli_close($db);
    }

    // (D) SAVE CONTENT
    function save ($content) {
        try {
            $db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);
            $query = $db->prepare(
                "INSERT INTO blogs (blogs_text, username) VALUES (?, ?)"
            );
            $query->bind_param('ss',$content, $_SESSION["userid"] );
            $query->execute();
            return true;
        } catch (Exception $ex) {
            $this->error = $ex->getMessage();
            return false;
        }
    }

    // (E) GET CONTENT
    function get () {
        $db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);
        $query = $db->query(
            "SELECT blogs_text FROM blogs"
        );

        $content = $query->fetch_row();
        return is_array($content) ? $content["blogs_text"] : "" ;
    }
}

// (G) NEW CONTENT OBJECT
$_CONTENT = new Content();

// (B) SAVE CONTENT ON FORM SUBMIT
if (isset($_POST["content"])) {
    // (B1) CONNECT TO DATABASE

    // (B2) SAVE
    // NOTE - CONTENT ID FIXED TO 99 FOR THIS DEMO
    // USE YOUR OWN ID IN YOUR PROJECT!
    echo $_CONTENT->save($_POST["content"])
        ? "<div>SAVED</div>"
        : "<div>{$_CONTENT->error}</div>" ;
}

header("Location: profile.php");
exit();
