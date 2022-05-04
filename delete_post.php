<?php
require_once "configs/session.php";
require_once "configs/config.php";

try {
    $db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);

    $sql = 'DELETE FROM blogs WHERE idblogs = ?';

    $query = $db->prepare($sql);

    $query->bind_param('i', $_POST['id']);
    $query->execute();

    header('location: profile.php');
}
catch (PDOException $e) {
    $title = 'An error has occurred';

    $output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' .
        $e->getFile() . ':' . $e->getLine();
}
