<?php
include_once('system/config.php');

include_once('templates/content.php');

getLoginHeader();

if (filter_has_var(INPUT_POST, 'submit')) {

    $query = "SELECT u.user_id, u.company_id, u.username, u.password, u.first_name, u.last_name, u.role, u.last_visit, c.company_name, c.kvk, c.email,c.phone 
            FROM `user` as u
            INNER JOIN `company` as c ON u.company_id = c.company_id
            WHERE `username` = :username"; //alle gebruikers met het ingevoerde e-mailadres ophalen

    $results = $conn->prepare($query);
    $results->execute(array(
        'username' => $_POST['username']
    ));
    $database_contents = FALSE;
    while ($record = $results->fetch(PDO::FETCH_ASSOC)) {
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

            session_start();

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

            //  print_r($_SESSION['id']);

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
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input class="form-control" id="exampleInputEmail1" name="username" type="email" aria-describedby="emailHelp" placeholder="iemand@example.com">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Wachtwoord</label>
                    <input class="form-control" id="exampleInputPassword1" name="password" type="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox"> Remember Password</label>
                    </div>
                </div>
                <input class="btn btn-secondary btn-block" type="submit" name="submit" value="Inloggen">
            </form>
        </div>
    </div>


    <?php
}

?>


