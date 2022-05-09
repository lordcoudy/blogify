<?php
// Destroy the session.
session_start();
$_SESSION["user_id"] = "";
session_destroy();
header("Location: index.php");