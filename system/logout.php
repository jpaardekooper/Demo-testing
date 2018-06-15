<?php
require_once ('session.php');

echo "u bent uitgelogd";

unset($_SESSION['id']);

session_destroy();

header("Refresh: 1; URL=\"../login.php\"");
