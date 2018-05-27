<?php
require_once ('function.php');


session_destroy();

header("Location: " . explode("logout.php", $_SERVER["REQUEST_URI"])[0] . getPathToRoot() . "login.php?");