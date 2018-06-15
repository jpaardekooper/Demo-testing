<?php
require_once '../system/session.php';

include_once('../system/config.php');

include_once('../templates/content.php');

if (isset($_SESSION['id'])) {
    checkRole("admin");




    if (@$_GET['action'] == "delete") {

        try {
            $query = $conn->prepare("
                        DELETE FROM `user` WHERE `user_id` = :id");
            $query->execute(array(
                'id' => $_GET['id']
            ));
            header('Location: index.php');
        } catch (PDOException $e) {
            $sMsg = '<p>
                    Regelnummer: ' . $e->getLine() . '<br />
                    Bestand: ' . $e->getFile() . '<br />
                    Foutmelding: ' . $e->getMessage() . '
                </p>';

            trigger_error($sMsg);
        }
    }
    getHeader("Sqits form-delete", "Form delete");

} else {
    echo "please login first on login page";
    header("Location:../login.php");
    exit;
}

?>