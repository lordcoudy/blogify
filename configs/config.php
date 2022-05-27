<?php
define('DBSERVER', 'your_host');        // Database server
define('DBUSERNAME', 'your_username');           // Database username
define('DBPASSWORD', 'your_password');      // Database password
define('DBNAME', 'your_db_name');         // Database name

// Connect to MySQL database
$db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);

// Check db connection
if($db === false){
    die("Error: connection error. " . mysqli_connect_error());
}

