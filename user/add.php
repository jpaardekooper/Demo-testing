<?php
require_once('../system/session.php');
require_once('../system/config.php');

require_once('../templates/content.php');

checkRole('admin');

getHeader("Sqits form-add", "Form add");

echo '  <div class="right-panel">';

if (@$_GET['action'] == "save") {


    try {

//http://php.net/manual/en/password.constants.php

        $sql = "INSERT INTO `user` (`username`, `password`, `last_visit`, `active`, `created_date`, `company_name`, `role`) VALUES (:username, :password, NOW(), :active, NOW(), :company_name, :role )";
        $ophalen = $conn->prepare($sql);
        $ophalen->execute(array(
            'username' => $_POST['username'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'active' => $_POST['active'],
            'company_name' => $_POST['company_name'],
            'role' => $_POST['role']

        ));


        echo "De user is opgeslagen.";

    } catch (PDOException $e) {
        $sMsg = '<p>
                Regelnummer: ' . $e->getLine() . '<br />
                Bestand: ' . $e->getFile() . '<br />
                Foutmelding: ' . $e->getMessage() . '
            </p>';

        trigger_error($sMsg);
    }
} else {
    ?>

        <div class="right-panel">
            <?php getBreadCrumbs(); ?>


            <header class="header">
                <p>welkom: <?= getUserName(); ?></p>
                <p>
                    is user role: <?= $_SESSION['id']['role'];; ?>
                </p>

                gebruiker toevoegen
            </header>

            <div class="content">
                <form name="add" action="?action=save" method="post">


                    <label>name</label> <input type="text" name="username" required>
                    <label>pass</label> <input type="text" name="password" required>
                    <label>active</label> <input type="active" name="active" required>
                    <label>bedrijfsnaam</label> <input type="active" name="company_name" required>
                    <label>rol</label> <input type="active" name="role" required>


                    <input type="reset" name="reset" value="Clear">
                    <input type="submit" name="submit" value="Opslaan">

                </form>
            </div>
    </div>
    <?php
}
getFooter();



