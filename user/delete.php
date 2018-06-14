<?php
require_once '../system/session.php';

include_once('../system/config.php');

include_once('../templates/content.php');

if (isset($_SESSION['id'])) {
    checkRole("admin");

    getHeader("Sqits form-delete", "Form delete");


//	$id = $_GET['id'];
//	$_SESSION['id']['user_id'];

    if (@$_GET['action'] == "delete") {

        try {
            $query = $conn->prepare("
                        DELETE FROM `user` WHERE `user_id` = 'id';");
            $query->execute(array(
                'id' => $user_id
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

    getFooter();
} else {
    echo "please login first on login page";
    header("Location:../login.php");
    exit;
}

?>