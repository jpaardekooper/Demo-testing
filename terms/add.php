<?php
require_once '../system/session.php';

include_once('../system/config.php');

include_once('../templates/content.php');


if (isset($_SESSION['id'])) {

    checkRole('admin');

    if (@$_GET['action'] == "save") {

        try {

//http://php.net/manual/en/password.constants.php

            $query = "INSERT INTO terms (acceptance, service_level_agreement, contact, signature, created_date) 
                                    VALUES (:acceptance, :service_level_agreement,  :contact, :signature, NOW() )";
            $results = $conn->prepare($query);
            $results->execute(array(
                'acceptance' => $_POST['acceptance'],
                'service_level_agreement' => $_POST['service_level_agreement'],
                'contact' => $_POST['contact'],
                'signature' => $_POST['signature'],

            ));


            echo "<div style='margin: 0 auto; width: 300px;'>
                    <img style='margin-top: 40vh;' src='" . getAssetsDirectory() . "image/loading.gif'/>
            </div>";

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

        echo '<div class="content-wrapper">';
        echo '<div class="container-fluid">';

        getTopPanel("Voorwaarde", " toevoegen");

        ?>

        <div class="container">
            <div class="card card-register mx-auto mt-1">
                <form name="add" action="?action=save" method="post">
                    <div class="card-header">Voorwaarden Forumulier</div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleTextArea1">Acceptatie</label>
                                        <textarea class="form-control" rows="5" id="exampleTextArea1" name="acceptance"
                                                  placeholder="de update bevat de volgende onderdelen..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleTextArea2">Voorwaarden</label>
                                        <textarea class="form-control" rows="5" id="exampleTextArea2"
                                                  name="service_level_agreement"
                                                  placeholder="de update bevat de volgende onderdelen..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleTextArea3">Contract</label>
                                        <textarea class="form-control" rows="5" id="exampleTextArea3" name="contact"
                                                  placeholder="de update bevat de volgende onderdelen..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleTextArea4">Ondertekening</label>
                                        <textarea class="form-control" rows="5" id="exampleTextArea4" name="signature"
                                                  placeholder="de update bevat de volgende onderdelen..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="card card-register mx-auto mt-1">
                            <input class="btn btn-primary btn-block" type="submit" name="submit" value="Opslaan">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <?php


        echo "</div>";
        echo "</div>";

        getFooter();

    }
} else {
    echo "please login first on login page";
    header("Location:../login.php");
    exit;
}


?>