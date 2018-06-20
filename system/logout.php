<?php
require_once ('session.php');

unset($_SESSION['id']);

session_destroy();

//this is for mathijs only
/*echo "<div style='height: 98vh; '>
                    <img style='height: 100%; width: 100%; margin: 0; padding: 0;' src='../assets/image/for-mathijs.gif'/>
            </div>";*/

header("Refresh: 4; URL=\"../login.php\"");


//this is for the presentation
echo "<div style='margin: 0 auto; width: 200px;'>
                    <img style='margin-top: 40vh;' src='../assets/image/logout.gif'/>
            </div>";

header("Refresh: 2; URL=\"../login.php\"");