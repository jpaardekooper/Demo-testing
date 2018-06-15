<?php
require_once ('session.php');




unset($_SESSION['id']);

session_destroy();

echo "<div style='height: 98vh; '>
                    <img style='height: 100%; width: 100%; margin: 0; padding: 0;' src='../assets/image/for-mathijs.gif'/>
            </div>";

header("Refresh: 4; URL=\"../login.php\"");
