<?php
define('DBSERVER', 'localhost'); // Database server
define('DBUSERNAME', 'root'); // Database username
define('DBPASSWORD', 'pdtpl0ktn'); // Database password
define('DBNAME', 'blogify_db'); // Database name

/* connect to MySQL database */
$db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);

// Check db connection
if($db === false){
    die("Error: connection error. " . mysqli_connect_error());
}

