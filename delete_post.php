<?php
// Initialisation
require_once "configs/session.php";
require_once "configs/config.php";

try {

    $db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);

    // DB query to delete
    $sql = 'DELETE FROM your_text_table WHERE your_text_id = ?';

    $query = $db->prepare($sql);

    $query->bind_param('i', $_POST['id']);
    $query->execute();

    // If admin => GoTo admin page, else go to user page
    if($_SESSION["userid"] == "admin"){
        header("location: control_page.php");
    } else
    {
        header("location: profile.php");
    }
}
catch (PDOException $e) {
    $title = 'An error has occurred';

    $output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' .
        $e->getFile() . ':' . $e->getLine();
}
