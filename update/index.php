<?php
require_once('../system/session.php');
require_once('../system/config.php');

require_once('../templates/content.php');

if ($_SESSION["id"]) {

    switch (getUserRole()) {
        case "user":

            getHeader("Sqits", "user Dashboard");

            echo "     
                <div class='right-panel'>
                     <header>
                         <p>welkom: " . getUserName() . "</p>
                         <p>
                            ". getUserName() . "
                         </p>
        
                         this is update form
                     </header>
                </div>            
            ";

            getFooter();
            break;
        case "admin":

            getHeader("Sqits", "Admin Dashboard");

            echo "     
                <div class='right-panel'>
                     <header>
                         <p>welkom: " . getUserName() . "</p>
                         <p>
                             is user active: " . $_SESSION['id']['active'] . "
                         </p>
        
                         this is update form
                     </header>
                </div>            
            ";

            getFooter();
            break;
        default:
            trigger_error("Invalid role specified: " . $role, E_USER_WARNING);

    }
} else {
    echo "please login first on login page";
    header("Refresh: 1; URL=\"../login.php\"");
    exit;
}
