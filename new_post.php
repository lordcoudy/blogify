<?php
class Content {
    // (A) PROPERTIES
    public $pdo = null; // PDO object
    public $query = null; // SQL statement
    public $error = ""; // Error message, if any

    // (B) CONSTRUCTOR - CONNECT TO DATABASE
    function __construct () {
        try {
            $this->pdo = new PDO(
                "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET,
                DB_USER, DB_PASSWORD, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (Exception $ex) { exit($ex->getMessage()); }

// (F) DATABASE SETTINGS - CHANGE TO YOUR OWN!
        define("DB_HOST", "localhost");
        define("DB_NAME", "blogify_db");
        define("DB_CHARSET", "utf8");
        define("DB_USER", "root");
        define("DB_PASSWORD", "pdtpl0ktn");
    }

    // (C) DESTRUCTOR - CLOSE DATABASE CONNECTION
    function __destruct () {
        if ($this->query!==null) { $this->query = null; }
        if ($this->pdo!==null) { $this->pdo = null; }
    }

    // (D) SAVE CONTENT
    function save ($content) {
        try {
            $this->query = $this->pdo->prepare(
                "INSERT INTO blogs (blogs_text) VALUES (?)"
            );
            $this->query->execute([$content]);
            return true;
        } catch (Exception $ex) {
            $this->error = $ex->getMessage();
            return false;
        }
    }

    // (E) GET CONTENT
    function get () {
        $this->query = $this->pdo->prepare(
            "SELECT blogs_text FROM blogs"
        );
        $this->query->execute([]);
        $content = $this->query->fetch();
        return is_array($content) ? $content["blogs_text"] : "" ;
    }
}

// (F) DATABASE SETTINGS - CHANGE TO YOUR OWN!
define("DB_HOST", "localhost");
define("DB_NAME", "blogify_db");
define("DB_CHARSET", "utf8");
define("DB_USER", "root");
define("DB_PASSWORD", "pdtpl0ktn");

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

header("Location: profile.html");
exit();
