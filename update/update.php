<?php

require_once '../system/session.php';

include_once('../system/config.php');

include_once('../templates/content.php');


switch (getUserRole()) {
    case "user":
        if ($_GET['action'] == "save") {

            try {
                $query = $conn->prepare("
                        UPDATE `update`                         
                        SET status = :status                                               
                        WHERE update_id = :update_id  
                                     
                        ");
                $query->execute(array(
                    'update_id' => $_GET['id'],
                    'status' => $_POST['status']
                ));

                echo "<div class='loading-screen'>
                    <img class='loading' src='" . getAssetsDirectory() . "image/loading.gif'/>
            </div>";
               // echo "wijzigingen zijn opgeslagen.";

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
            getHeader("Sqits form-update", "ACCEPTATIE OPLEVERING");
            echo "<div class='content-wrapper'>";
            echo "<div class='container-fluid'>";
            //getTopPanel("Update wijzigen");

            try {
                $query = $conn->prepare("
                        SELECT up.*, f.*, t.*, c.*
                        FROM `update` as up
                        INNER JOIN company as c ON up.company_id = c.company_id                  
                        INNER JOIN form as f ON up.form_id = f.form_id
                        INNER JOIN terms as t on f.terms_id = t.terms_id
                        WHERE up.update_id = :id
                   
                        ");

                $query->execute(array(
                    'id' => $_GET['id'],

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
                $company_name = $row['company_name'];
                $address = $row['address'];
                $location = $row['location'];
                $zip_code = $row['zip_code'];
                $kvk = $row['kvk'];

                $update_id = $row['update_id'];
                $form_id = $row['form_id'];
                $terms_id = $row['terms_id'];
                $type = $row['type'];
                $task_nr = $row['task_nr'];
                $version = $row['version'];
                $status = $row['status'];
                $description = $row['description'];
                $created_date = $row['created_date'];
                $end_date = $row['end_date'];

                $acceptance = $row['acceptance'];
                $SLA = $row['service_level_agreement'];
                $contact = $row['contact'];
                $signature = $row['signature'];


                $originalDate = $end_date;
                $newDate = date("d-m-Y", strtotime($originalDate));

                if ($status == 'pending') {
                    ?>
                    <div class="card card-login mx-auto mt-5">
                        <div class="card-header">Opdracht(nummer) <?= $task_nr ?></div>
                        <div class="card-body">
                            <div class="form-group">

                            </div>
                            <div class="form-group">

                            </div>
                            <div class="form-group">

                            </div>
                            <div class="text-center">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModalLong">
                                    Bevestig uw update
                                </button>
                            </div>
                            <div class="text-center">
                                <span class="small text-muted text-center">deze update is geldig tot <?= $newDate ?></span>
                            </div>
                        </div>
                    </div>



                    <!-- Modal -->
                    <form name="add" action="?action=save&id=<?= $update_id ?>" method="post">
                        <div class="modal fade " id="exampleModalLong" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">ACCEPTATIE OPLEVERING</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <!-- update information for the user -->
                                    <div class="modal-body">
                                        <h6>OPDRACHTGEVER</h6>
                                        <div class="form-group row">
                                            <label class="col-4 col-form-label">bedrijfsnaam</label>
                                            <div class="col-8">
                                                <label class="col-form-label"><?= $company_name ?></label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-4 col-form-label">adres</label>
                                            <div class="col-8">
                                                <label class="col-form-label"><?= $address ?></label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-4 col-form-label">Postcode en plaats</label>
                                            <div class="col-8">
                                                <label class="col-form-label"><?= $zip_code ?>, <?= $location ?></label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-4 col-form-label">Kvk-nummer</label>
                                            <div class="col-8">
                                                <label class="col-form-label"><?= $kvk ?></label>
                                            </div>
                                        </div>


                                        <h6>LEVERANCIER</h6>
                                        <div class="form-group row">
                                            <label class="col-4 col-form-label">bedrijfsnaam</label>
                                            <div class="col-8">
                                                <label class="col-form-label">Sqits B.V.</label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-4 col-form-label">adres</label>
                                            <div class="col-8">
                                                <label class="col-form-label">Bleiswijkseweg 55I</label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-4 col-form-label">Postcode en plaats</label>
                                            <div class="col-8">
                                                <label class="col-form-label">2712 PB, Zoetermeer</label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-4 col-form-label">Kvk-nummer</label>
                                            <div class="col-8">
                                                <label class="col-form-label">71075828</label>
                                            </div>
                                        </div>


                                        <h6>BETREFT</h6>
                                        <div class="form-group row">
                                            <label class="col-4 col-form-label">Opdracht(nummer)</label>
                                            <div class="col-8">
                                                <label class="col-form-label"><?= $task_nr ?></label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-4 col-form-label">Versie</label>
                                            <div class="col-8">
                                                <label class="col-form-label"><?= $version ?></label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label">Omschreven</label>
                                            <div class="col-9">
                                                <textarea class="form-control col-form-label" rows="6"
                                                          style="resize:none;" readonly><?= $description ?></textarea>
                                            </div>

                                        </div>

                                        <h6>ACCEPTATIE</h6>
                                        <span class="small">Met het ondertekenen van dit document is de opdrachtgever zich bewust van de volgende
                                            zaken:</span>
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <textarea class="form-control col-form-label" rows="6"
                                                          style="resize:none;" readonly><?= $acceptance ?></textarea>
                                            </div>
                                        </div>

                                        <h6>SERVICE LEVEL AGREEMENT</h6>
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <textarea class="form-control col-form-label" rows="6"
                                                          style="resize:none;" readonly><?= $SLA ?></textarea>
                                            </div>
                                        </div>
                                        <h6>SUPPORT CONTACT</h6>
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <textarea class="form-control col-form-label" rows="6"
                                                          style="resize:none;" readonly><?= $contact ?></textarea>
                                            </div>
                                        </div>
                                        <h6>ONDERTEKENING</h6>
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <textarea class="form-control col-form-label" rows="6"
                                                          style="resize:none;" readonly><?= $signature ?></textarea>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer">

                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="status" id="option1" autocomplete="off"
                                                       value="accepted"> Accept
                                            </label>
                                            <label class="btn btn-secondary">
                                                <input type="radio" name="status" id="option2" autocomplete="off"
                                                       value="declined"> Decline
                                            </label>
                                        </div>

                                    </div>
                                    <div class="card card-register mx-auto mt-1">
                                        <input class="btn btn-primary btn-block" type="submit" name="submit"
                                               value="Opslaan">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
                } else {
                    ?>
                    <div class="card-header">Opdrachtgever en leverancier</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">bedrijfsnaam</label>
                            <div class="col-5">
                                <input class="form-control" type="text" value="<?= $company_name ?>" readonly
                                       id="example-text-input">
                            </div>
                            <div class="col-5">
                                <input class="form-control" type="text" value="Sqits B.V." readonly
                                       id="example-text-input">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">address</label>
                            <div class="col-5">
                                <input class="form-control" type="text" value="<?= $address ?>" readonly
                                       id="example-text-input">
                            </div>
                            <div class="col-5">
                                <input class="form-control" type="text" value="Bleiswijkseweg 55I" readonly
                                       id="example-text-input">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">Postcode en plaats</label>
                            <div class="col-5">
                                <input class="form-control" type="text" value="<?= $zip_code ?>, <?= $location ?>" readonly
                                       id="example-text-input">
                            </div>
                            <div class="col-5">
                                <input class="form-control" type="text" value="2712 PB, Zoetermeer" readonly
                                       id="example-text-input">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">Kvk nummer</label>
                            <div class="col-5">
                                <input class="form-control" type="text" value="<?= $kvk ?>" readonly
                                       id="example-text-input">
                            </div>
                            <div class="col-5">
                                <input class="form-control" type="text" value="71075828" readonly
                                       id="example-text-input">
                            </div>
                        </div>
                    </div>
                    <div class="card-header">Betreft</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">Opdracht(nummer)</label>
                            <div class="col-2">
                                <input class="form-control" type="text" value="<?= $task_nr ?>" readonly
                                       id="example-text-input">
                            </div>

                            <label for="example-text-input" class="col-2 col-form-label">Type</label>
                            <div class="col-3">
                                <input class="form-control" type="text" value="<?= $type ?>" readonly
                                       id="example-text-input">
                            </div>

                            <label for="example-text-input" class="col-1 col-form-label">versie</label>
                            <div class="col-2">
                                <input class="form-control" type="text" value="<?= $version ?>" readonly
                                       id="example-text-input">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">Omschreven</label>
                            <div class="col-10">
                            <textarea class="form-control" type="text" rows="9" readonly
                                      id="example-text-input"><?= $description ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card-header">Acceptatie</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">acceptatie</label>
                            <div class="col-10">
                            <textarea class="form-control" type="text" rows="13" readonly
                                      id="example-text-input"><?= $acceptance ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">service level agreement</label>
                            <div class="col-10">
                            <textarea class="form-control" type="text" rows="2" readonly
                                      id="example-text-input"><?= $SLA ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">Contract</label>
                            <div class="col-10">
                            <textarea class="form-control" type="text" rows="4" readonly
                                      id="example-text-input"><?= $contact ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">ondertekening</label>
                            <div class="col-10">
                            <textarea class="form-control" type="text" rows=3" readonly
                                      id="example-text-input"><?= $signature ?></textarea>
                            </div>
                        </div>
                    </div>


                    <script>
                        function forprint()
                        {
                            if (!window.print)
                            {
                                return
                            }
                            window.print()
                        }
                    </script>
                    <div class="card card-register mx-auto mt-1">
                        <button class="btn btn-default btn-block" onclick="forprint()">print pdf</button>
                    </div>

                    <?php
                    //closes else
                }
                //closes while loop
            }
//closes not save method else
        }
        echo "</div>";
        echo "</div>";
        getFooter();

        break;
    case "admin":

        checkRole("admin");

        break;
}
?>