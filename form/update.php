<?php

require_once '../system/session.php';

include_once('../system/config.php');

include_once('../templates/content.php');


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

        $query = $conn->prepare("UPDATE `form` 
                                        SET 
                                         terms_id =:terms_id,
                                         type =:type,
                                          task_nr  =:task_nr,
                                          version =:version,                                          
                                            description=:description,                                            
                                              modified_date =:modified_date                                     
                                    WHERE form_id =:id");

        $query->execute(array(
            'id' => $_GET['id'],
            'terms_id' => $_POST['terms_id'],
            'type' => $_POST['type'],
            'task_nr' => $_POST['task_nr'],
            'version' => $_POST['version'],
            'description' => $_POST['description'],
            'modified_date' => date("Y-m-d")
        ));


        echo "wijzigingen zijn opgeslagen a.";

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
    getBreadCrumbs();
    getTopPanel("formulier wijzigen");

    try {
        $query = $conn->prepare("
                        SELECT * FROM form WHERE form_id = :id");

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
        $form_id = $row['form_id'];
        $terms_id = $row['terms_id'];
        $type = $row['type'];
        $task_nr = $row['task_nr'];
        $version = $row['version'];
        $description = $row['description'];
        $created_date = $row['created_date'];
        $modified_date = $row['modified_date'];
    }


    ?>

    <div class="container">
        <form name="add" action="?action=save&id=<?= $form_id ?>" method="post">
            <div class="card-header col-md-10">bedrijf gegevens</div>
            <div class="card-body">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-2">
                            <label for="exampleAccept">Form id</label>
                            <input class="form-control" id="exampleAccept" name="form_id"
                                   aria-describedby="form_id" readonly value="<?= $form_id ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="exampleAccept">Opdracht(nummer)</label>
                            <input class="form-control" id="exampleAccept" name="task_nr"
                                   aria-describedby="opdracht nummer" value="<?= $task_nr ?>">
                        </div>


                            <div class="col-md-2">
                                <label for="exampleAccept">Gemaakt op</label>
                                <input class="form-control" id="exampleAccept" name="created_date"
                                       aria-describedby="gemaakt op" readonly value="<?= $created_date ?>">
                            </div>


                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-3">
                            <label for="exampleV">Versie</label>
                            <input class="form-control" id="exampleV" name="version"
                                   aria-describedby="versie" value="<?= $version ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-5">
                            <?php


                            //SQL FOR FORM_ID SELECTION
                            $results = $conn->prepare("
						SELECT `terms_id`, created_date FROM `terms` 
						");
                            $results->execute();
                            $types = $results->fetchAll();
                            unset($result);

                            echo "<label>Voorwaarden formulier</label>";
                            echo "<select class='form-control' name='terms_id'>";
                            echo "<option value=''></option>";
                            foreach ($types as $type) {
                                if ($type['form_id'] == $form_id) {
                                    echo "<option value='" . htmlentities($type['terms_id']) . "'>" . htmlentities($type['terms_id']) . " " . htmlentities($type['created_date']) . " </option>";

                                } else {
                                    echo "<option value='" . htmlentities($type['terms_id']) . "' selected>" . htmlentities($type['terms_id']) . " " . htmlentities($type['created_date']) . "</option>";
                                }
                            }
                            echo "</select>";
                            echo "</div>";

                            //****end
                            ?>

                        <div class="col-md-5">
                            <label >Type</label>
                            <select  class="form-control" name='type' value='<?= $type ?>'>
                                <option value="mayor-update">mayor-update</option>
                                <option value="bug-fix">bug-fix</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-10">
                            <label for="exampleContract">Beschrijving</label>
                            <textarea class="form-control" id="exampleContract" rows="6" name="description"
                                      aria-describedby="contract"><?= $description ?></textarea>
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
?>