<?php

require_once 'system/session.php';

include_once('system/config.php');

include_once('templates/content.php');

getHeader("Login", "Sqits Login panel");


/*require_once('sql/user.php');
$object = new User("jaseper", 16);
$object->DoSomething();*/

/*$result = $query->fetch(PDO::FETCH_CLASS, get_class($object));
var_dump_str($result);*/

//$id = $_GET['id'];


if (filter_has_var(INPUT_POST, 'submit')) {

    $sql = "SELECT * FROM `user` WHERE `username` = :username"; //alle gebruikers met het ingevoerde e-mailadres ophalen

    $ophalen = $conn->prepare($sql);
    $ophalen->execute(array(
        'username' => $_POST['username']
    ));
    $database_contents = FALSE;
    while ($record = $ophalen->fetch(PDO::FETCH_ASSOC)) {
        $database_contents = $record;
    }

    if ($database_contents === FALSE) {
        //blijkbaar komt het mailadres niet in de database voor!
        echo "<div id=\"logout_container\"><p id=\"logout_text\">The entered email address does not exist.</p></div>";
        header("Refresh: 2; URL=\"index.php\"");
    } else {
        //mailadres staat in de database, we gaan verder!
        //password nu vergelijken met ingevoerd password
        if (!password_verify($_POST['password'], $database_contents['password'])) {
            echo "<div id=\"logout_container\"><p id=\"logout_text\">Wrong password! ..</p></div>";
            header("Refresh: 2; URL=\"index.php\"");
        } else {
            //email staat in database en password klopt, sessie starten!
            //sessie opstarten
            $database_contents['password'] = "";
            //variable session wordt gevuld met de database$contents
            $_SESSION['id'] = $database_contents;
            echo "<div id=\"logout_container\"><p id=\"logout_text\">You are now logged in.</p></div>";

            header("Refresh: 1; URL=\"dashboard/index.php\"");
        }
    }
} else {
//formulier is nog niet verzonden, laat het zien in de html-modus
    ?>
<div class="login-container">
  <img class="login-image" src="assets/image/header.jpg"/>
    <div class="login-form">
<div class="login-logo-position">
    <img class="login-logo" src="assets/image/sqits-logo.png"/>
</div>




            <form name="inloggen" action="login.php" method="post">
                <fieldset>
                    <label for="userName">User Name</label>
                    <input id="userName" name="username" type="text" autocomplete="off" required />
                </fieldset>
                <fieldset>
                    <label for="passWord">Password</label>
                    <input id="passWord" name="password" type="password" autocomplete="off" required />

                </fieldset>
                <fieldset>
                    <input type="submit" name="submit" value="Log in">
                </fieldset>
            </form>

        morgen weer een dag


</div>


    <?php
}

getFooter();
?>


