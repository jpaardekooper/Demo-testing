<?php
require_once('../system/session.php');
require_once('../system/config.php');

require_once('../templates/content.php');

checkRole('admin');



if (@$_GET['action'] == "save") {


    try {

//http://php.net/manual/en/password.constants.php

        $sql = "INSERT INTO `user` (`email`, `password`, `last_visit`, `active`, `created_date`, `company_id`, `role`) VALUES (:email, :password, NOW(), :active, NOW(), :company_id, :role )";
        $ophalen = $conn->prepare($sql);
        $ophalen->execute(array(
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'active' => $_POST['active'],
            'company_id' => $_POST['company_id'],
            'role' => $_POST['role']

        ));


        echo "De user is opgeslagen.";
        header("Refresh: 1; URL=index.php");

    } catch (PDOException $e) {
        $sMsg = '<p>
                Regelnummer: ' . $e->getLine() . '<br />
                Bestand: ' . $e->getFile() . '<br />
                Foutmelding: ' . $e->getMessage() . '
            </p>';

        trigger_error($sMsg);
    }
} else {
    getHeader("Sqits form-add", "Form add");

    echo '  <div class="content-wrapper">';
    echo '  <div class="container-fluid">';

    getTopPanel("gebruiker toevoegen");

    ?>
    <div class="content">
        <form name="add" action="?action=save" method="post">
            <label>name</label> <input type="email" name="email" required>
            <label>pass</label> <input type="text" name="password" required>
            <label>active</label> <input type="text" name="active" required>
            <label>bedrijfsnaam</label> <input type="text" name="company_id" required>
            <label>rol</label> <input type="text" name="role" required>
            <input type="reset" name="reset" value="Clear">
            <input type="submit" name="submit" value="Opslaan">
        </form>
    </div>
    </div>
    </div>
    <?php
}
getFooter();



