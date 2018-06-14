<?php

require_once '../system/session.php';

include_once('../system/config.php');

include_once('../templates/content.php');

if (isset($_SESSION['id'])) {


    checkRole("admin");


    if ($_GET['action'] == "save") {

        try {
            /*        $query = $conn->prepare("
                                    UPDATE `user` SET email = :email, password = :password, active = :active WHERE user_id = :id");
                    $query->execute(array(
                        'id' => $_GET['id'],
                        'email' => $_POST['email'],
                        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                        'active' => $_POST['active']
                    ));*/

            $query = $conn->prepare("UPDATE `terms` 
                                        SET 
                                         acceptance =:acceptance,
                                          service_level_agreement =:sla,
                                           contact  =:contact,
                                            signature=:signature                                                                             
                                    WHERE terms_id =:id");

            $query->execute(array(
                'id' => $_GET['id'],
                'acceptance' => $_POST['acceptance'],
                'sla' => $_POST['service_level_agreement'],
                'contact' => $_POST['contact'],
                'signature' => $_POST['signature'],

                // 'modified_date' => date("d-m-Y")


            ));

            echo "wijzigingen zijn opgeslagen.";
            header("Refresh: 1; URL=index.php");
        } catch (PDOException $e) {
            $sMsg = '<p>
                    Line Number: ' . $e->getLine() . '<br />
                    File: ' . $e->getFile() . '<br />
                    Error Message: ' . $e->getMessage() . '
                </p>';

            trigger_error($sMsg);
        }
    } else {
        getHeader("Sqits form-update", "Form update");

        echo '<div class="content-wrapper">';
        echo '<div class="container-fluid">';

        getTopPanel("Voorwaarde", " wijzigen");
        try {
            $query = $conn->prepare("
                        SELECT * FROM terms WHERE terms_id = :id");

            $query->execute(array(
                'id' => $_GET['id']
            ));
        } catch (PDOException $e) {
            $sMsg = '<p>
                    Line Number: ' . $e->getLine() . '<br />
                    File: ' . $e->getFile() . '<br />
                    Error Message: ' . $e->getMessage() . '
                </p>';

            trigger_error($sMsg);
        }

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $terms_id = $row['terms_id'];
            $acceptance = $row['acceptance'];
            $sla = $row['service_level_agreement'];
            $contact = $row['contact'];
            $signature = $row['signature'];

        }
        ?>
        <div class="container">
            <form name="add" action="?action=save&id=<?= $terms_id ?>" method="post">
                <div class="card-header col-md-10">bedrijf gegevens</div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-10">
                                <label for="exampleAccept">Acceptatie</label>
                                <textarea class="form-control" id="exampleAccept" rows="21" name="acceptance"

                                          aria-describedby="acceptance"><?= $acceptance ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-10">
                                <label for="exampleAccept">Service level agreement</label>
                                <textarea class="form-control" id="exampleAccept" rows="6"
                                          name="service_level_agreement"

                                          aria-describedby="service level agreement"><?= $sla ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-10">
                                <label for="exampleContract">Contract</label>
                                <textarea class="form-control" id="exampleContract" rows="6" name="contact"

                                          aria-describedby="contract"><?= $contact ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-10">
                                <label for="exampleSign">Ondertekening</label>
                                <textarea class="form-control" id="exampleSign" rows="6" name="signature"

                                          aria-describedby="signature"><?= $signature ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-10">
                                <input class="btn btn-primary btn-block" type="submit" name="submit" value="Opslaan">
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>

        </div>
        </div>
        <?php

    }
    getFooter();

} else {
    echo "please login first on login page";
    header("Location:../login.php");
    exit;
}

?>