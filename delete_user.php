<?php
// Initialisation
require_once "configs/session.php";
require_once "configs/config.php";

try {
    $db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);

    // db query to delete user
    $sql = 'DELETE FROM users_tb WHERE users_login = ?';

    $query = $db->prepare($sql);

    $query->bind_param('s', $_POST['id']);
    $query->execute();

    // GoTo admin page
    header('location: control_users.php');
}
catch (PDOException $e) {
    $title = 'An error has occurred';

    $output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' .
        $e->getFile() . ':' . $e->getLine();
}
