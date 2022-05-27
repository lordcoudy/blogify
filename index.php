<?php
// Connect to db and GoTo registration
require_once "configs/config.php";
require_once "configs/session.php";
session_start();
if (!isset($_SESSION["theme"]))
{
    $_SESSION["theme"] = 'light';
}
echo $_SESSION["userid"];
if(!empty($_SESSION["userid"])) {
    if ($_SESSION["userid"] == "admin")
    {
        header("location: control_page.php");
    } else
    {
        header("location: main_page.php");
    }
} else {
    header("location: register.php");
}
exit;