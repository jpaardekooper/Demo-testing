<?php
require_once '../system/session.php';

include_once('../system/config.php');

include_once('../templates/content.php');


if (isset($_SESSION['id'])) {

    checkRole('admin');

    if (@$_GET['action'] == "save") {

        try {

//http://php.net/manual/en/password.constants.php

            $query = "INSERT INTO form (terms_id, type, task_nr,  version,  description, created_date, modified_date) 
                                    VALUES (:terms_id, :type, :task_nr,  :version, :description, NOW(), NOW() )";
            $results = $conn->prepare($query);
            $results->execute(array(
                'terms_id' => $_POST['terms_id'],
                'type' => $_POST['type'],
                'task_nr' => $_POST['task_nr'],
                'version' => $_POST['version'],
                'description' => $_POST['description'],

            ));

            echo "<div class='loading-screen'>
                    <img class='loading' src='" . getAssetsDirectory() . "image/loading.gif'/>
            </div>";


            echo "het formulier is opgeslagen.";

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
        getBreadCrumbs();
        getTopPanel("formulier toevoegen");

        ?>


        <div class="card card-register mx-auto mt-1">
            <form name="add" action="?action=save" method="post">
                <div class="card-header">Inlog gegevens</div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">

                                <?php

                                //SQL FOR FORM_ID SELECTION
                                $results = $conn->prepare("
						        SELECT `terms_id`, created_date FROM `terms` 
						        ");
                                $results->execute();
                                $types = $results->fetchAll();
                                unset($result);

                                echo "<label>Voorwaarden:</label>";
                                echo "<select  class='form-control' name='terms_id'>";
                                echo "<option value=''></option>";
                                foreach ($types as $type) {
                                    if ($type['form_id'] == $form_id) {
                                        echo "<option selected value='" . htmlentities($type['terms_id']) . "'>" . htmlentities($type['created_date']) . " </option>";

                                    } else {
                                        echo "<option value='" . htmlentities($type['terms_id']) . "'>" . htmlentities($type['created_date']) . " </option>";
                                    }
                                }
                                echo "</select>";

                                //****end
                                ?>
                            </div>
                            <div class="col-md-6">
                               <label>Type update</label>
                                <select class="form-control" name="type">
                                    <option value="bug-fix">bug-fix</option>
                                    <option value="mayor-update">mayor-update</option>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-4">
                                <label>Type</label>
                                <label for="exampleTaskNr">opdrachtnummer</label>
                                <input class="form-control" id="exampleTaskNr" name="task_nr" type="text"
                                       aria-describedby="emailHelp" placeholder="opdrachtnummer">
                            </div>
                            <div class="col-md-2">
                                <label for="exampleVersion">Versie</label>
                                <input class="form-control" id="exampleVersion" name="version" type="text"
                                       placeholder="1.1A">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleTextArea">update beschrijving</label>
                                    <textarea class="form-control" rows="5" id="exampleTextArea" name="description"
                                              placeholder="de update bevat de volgende onderdelen..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input class="btn btn-primary btn-block" type="submit" name="submit" value="Opslaan">
            </form>
        </div>


        <?php


        echo "</div>";
        echo "</div>";

        getFooter();

    }
} else {
    echo "please login first on login page";
    header("Refresh: 1; URL=\"../login.php\"");
    exit;
}


?>