<?php
echo "u bent uitgelogd";
session_destroy();

header("Refresh: 1; URL=\"../login.php\"");
