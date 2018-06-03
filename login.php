<?php

require_once 'system/session.php';

include_once('system/config.php');

include_once('templates/content.php');

getLoginHeader("Login", "Sqits Login panel");


/*require_once('sql/user.php');
$object = new User("jaseper", 16);
$object->DoSomething();*/

/*$result = $query->fetch(PDO::FETCH_CLASS, get_class($object));
var_dump_str($result);*/

//$id = $_GET['id'];


if (filter_has_var(INPUT_POST, 'submit')) {

    $query = "SELECT u.user_id, u.company_id, u.email, u.password, u.role, u.last_visit FROM `user` u
            INNER JOIN `company` as c ON u.user_id = c.user_id
            WHERE `email` = :email"; //alle gebruikers met het ingevoerde e-mailadres ophalen

    $ophalen = $conn->prepare($query);
    $ophalen->execute(array(
        'email' => $_POST['email']
    ));
    $database_contents = FALSE;
    while ($record = $ophalen->fetch(PDO::FETCH_ASSOC)) {
        $database_contents = $record;
    }

    if ($database_contents === FALSE) {
        //blijkbaar komt het mailadres niet in de database voor!
        echo "<div>
                <p>The entered email address does not exist.</p>
                </div>
                ";
        header("Refresh: 2; url=login.php");
    } else {
        //mailadres staat in de database, we gaan verder!
        //password nu vergelijken met ingevoerd password
        if (!password_verify($_POST['password'], $database_contents['password'])) {
            echo "<div>
                    <p>Wrong password! ..</p>
                    </div>
                    ";
            header("Refresh: 2; URL=\"login.php\"");
        } else {
            //email staat in database en password klopt, sessie starten!
            //sessie opstarten
            $database_contents['password'] = "";
            //variable session wordt gevuld met de database$contents
            $_SESSION['id'] = $database_contents;

            $query = $conn->prepare("
                        UPDATE `user` 
                        SET last_visit = :last_visit 
                        WHERE user_id = :id
                        ");
            $query->execute(array(
                'id' => $_SESSION['id']['user_id'],
                'last_visit' => date("Y-m-d")
            ));

            print_r($_SESSION['id']);

            echo "<div class='loading-screen'>
                    <img class='loading' src='" . getAssetsDirectory() . "image/loading.gif'/>
            </div>";

            if ($_SESSION["id"]) {

                switch (getUserRole()) {
                    case "user":
                        header("Refresh: 1; url=dashboard/index.php");
                        break;
                    case "admin":
                        header("Refresh: 1; url=dashboard/admin.php");
                        break;
                    default:
                        trigger_error("Invalid role specified: " . $role, E_USER_WARNING);
                }
                exit();
            }
            //   header("Refresh: 2; url=dashboard/index.php");

        }
    }
} else {
//formulier is nog niet verzonden, laat het zien in de html-modus
?>
<div class="login-container">
    <img class="login-image" src="assets/image/header.jpg"/>
    <div class="login-background">
        <div class="login-logo-position">
            <img class="login-logo" src="assets/image/sqits-logo.png"/>
        </div>


        <form class="login-form" action="login.php" method="post">
            <fieldset>
                <label for="email">Gebruikersnaam</label>
                <input id="email" name="email" type="email" required/>
            </fieldset>
            <fieldset>
                <label for="wachtwoord">Wachtwoord</label>
                <input id="wachtwoord" name="password" type="password" required/>
            </fieldset>

            <fieldset>
                <input type="submit" name="submit" value="Inloggen">
            </fieldset>
        </form>


    </div>


    <?php
    }

    getFooter();
    ?>


