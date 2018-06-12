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
            getHeader("	&nbsp; ", "	&nbsp;");
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
                                <span class="small text-muted text-center">Deze update is geldig tot <?= $newDate ?></span>
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

                                        <hr>
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
                                        <hr>

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
                                            <div class="col-12">
                                                <textarea class="form-control col-form-label" rows="6"
                                                          style="resize:none;" readonly><?= $description ?></textarea>
                                            </div>

                                        </div>
                                        <hr>
                                        <h6>ACCEPTATIE</h6>
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <textarea class="form-control col-form-label" rows="21"
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
                                            <label class="btn btn-secondary">
                                                <input type="radio" name="status" id="option1" autocomplete="off"
                                                       value="accepted"> Accept
                                            </label>
                                            <label class="btn btn-secondary">
                                                <input type="radio" name="status" id="option2" autocomplete="off"
                                                       value="declined"> Decline
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <div class="text-center">
                                            <span class="small ">
                                            Let op: De release zoals omschreven onder het kopje ‘betreft’ zal pas worden uitgerold wanneer
                                                sqits dit document ondertekend in bezit heeft. Hierop zijn géén uitzonderingen mogelijk.
                                        </span>
                                            </div>

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

                    <div class="container visible-print-block">
                        <div class="card-header"><h2>Acceptatie en Oplevering
                            </h2></div>

                        <div class="card-header"><h4>Opdrachtgever</h4></div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">bedrijfsnaam</label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" value="<?= $company_name ?>" readonly
                                           id="example-text-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">address</label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" value="<?= $address ?>" readonly
                                           id="example-text-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Postcode en
                                    plaats</label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" value="<?= $zip_code ?>, <?= $location ?>"
                                           readonly
                                           id="example-text-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Kvk nummer</label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" value="<?= $kvk ?>" readonly
                                           id="example-text-input">
                                </div>

                            </div>
                        </div>
                        <div class="card-header"><h4>Leverancier</h4></div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">bedrijfsnaam</label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" value="Sqits B.V." readonly
                                           id="example-text-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">address</label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" value="Bleiswijkseweg 55I" readonly
                                           id="example-text-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Postcode en
                                    plaats</label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" value="2712 PB, Zoetermeer" readonly
                                           id="example-text-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Kvk nummer</label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" value="71075828" readonly
                                           id="example-text-input">
                                </div>
                            </div>
                        </div>
                        <div class="card-header"><h4>Betreft</h4></div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Opdracht(nummer)</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" value="<?= $task_nr ?>" readonly
                                           id="example-text-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Type</label>
                                <div class="col-md-3">
                                    <input class="form-control" type="text" value="<?= $type ?>" readonly
                                           id="example-text-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-2 col-form-label">versie</label>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" value="<?= $version ?>" readonly
                                           id="example-text-input">
                                </div>

                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Omschreven</label>
                                <div class="col-md-10">
                            <textarea class="form-control" type="text" rows="14" readonly
                                      id="example-text-input"><?= $description ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row PDF-SIGNATURE">
                                Acceptatie opdracht <?= $task_nr ?> &nbsp;&nbsp;&nbsp;&nbsp; versie <?= $version ?>
                                &nbsp;&nbsp;&nbsp;&nbsp; Paraaf opdrachtgever: ………………………………..
                            </div>
                            <div class="form-group row PDF-PAGE-BREAK">
                            </div>
                        </div>

                        <div class="card-header PDF-DISTANCE"><h3>Acceptatie</h3></div>
                        <div class="card-body">
                            <div class="form-group row PDF-DISTANCE">
                                <label for="example-text-input"
                                       class="col-md-2 col-form-label accept-pdf">acceptatie</label>
                                <div class="col-md-10">
                            <textarea class="form-control" type="text" rows="23" readonly
                                      id="example-text-input"><?= $acceptance ?></textarea>
                                    <br/>
                                </div>
                            </div>
                            <div class="form-group row PDF-DISTANCE">
                                <label for="example-text-input"
                                       class="col-md-2 col-form-label"></label>
                                <textarea class="form-control" type="text" rows="4" readonly>Meer informatie over het accepteren van een oplevering is te vinden in onze Algemene Voorwaarden artikel 3 met de titel “Contractsduur; uitvoeringstermijnen, uitvoering en wijziging overeenkomst”.</textarea>
                            </div>
                            <div class="form-group row PDF-SIGNATURE PDF-DISTANCE-2">
                                Acceptatie opdracht <?= $task_nr ?> &nbsp;&nbsp;&nbsp;&nbsp;
                                versie <?= $version ?>&nbsp;&nbsp;&nbsp;&nbsp; Paraaf opdrachtgever:
                                ………………………………..
                            </div>
                            <div class="form-group row PDF-PAGE-BREAK">
                            </div>
                        </div>


                        <div class="card-body">
                            <div class="form-group row"></div>

                            <div class="card-header PDF-DISTANCE PDF-SIGNATURE"><h3>Service level
                                    agreement</h3></div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-3 col-form-label accept-pdf">service level
                                    agreement</label>
                                <div class="col-md-9">
                            <textarea class="form-control" type="text" rows="2" readonly
                                      id="example-text-input"><?= $SLA ?></textarea>
                                </div>
                            </div>
                            <div class="card-header PDF-SIGNATURE"><h3>Contract</h3></div>
                            <div class="form-group row">

                                <label for="example-text-input"
                                       class="col-md-3 col-form-label accept-pdf">Contract</label>
                                <div class="col-md-9">
                            <textarea class="form-control" type="text" rows="4" readonly
                                      id="example-text-input"><?= $contact ?></textarea>
                                </div>
                            </div>
                            <div class="card-header PDF-SIGNATURE"><h3>Ondertekening</h3></div>
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-md-3 col-form-label accept-pdf">ondertekening</label>
                                <div class="col-md-9">
                            <textarea class="form-control" type="text" rows=4" readonly
                                      id="example-text-input"><?= $signature ?></textarea>
                                </div>
                            </div>

                            <div class="PDF-SIGNATURE ">


                            <div class="form-group row PDF-DISTANCE">
                                <div class="col-md-6">
                                    Handtekening akkoord Sqits B.V.:
                                </div>
                                <div class="col-md-6">
                                    Handtekening akkoord opdrachtgever:
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 PDF-DISTANCE">
                                    <img src="<?= getAssetsDirectory() . "/image/david.jpg" ?>">
                                </div>
                                <div class="col-md-6 PDF-DISTANCE-MAX">
                                    ....................................................................................
                                </div>
                            </div>
                            <div class="form-group row PDF-DISTANCE-MAX">
                                <label for="example-text-input" class="col-md-2 col-form-label">Naam</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="text" value="Ruud Schaaphuizen" readonly
                                           id="example-text-input">
                                </div>

                                <label for="example-text-input" class="col-md-2 col-form-label">Naam</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="text" value="......................" readonly
                                           id="example-text-input">
                                </div>

                                <label for="example-text-input" class="col-md-2 col-form-label">Datum</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="text" value="<?= $created_date ?>" readonly
                                           id="example-text-input">
                                </div>

                                <label for="example-text-input" class="col-md-2 col-form-label">Datum</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="text" value="......................" readonly
                                           id="example-text-input">
                                </div>


                                <label for="example-text-input" class="col-md-2 col-form-label">Locatie</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="text" value="Zoetermeer" readonly
                                           id="example-text-input">
                                </div>

                                <label for="example-text-input" class="col-md-2 col-form-label">Locatie</label>
                                <div class="col-md-4">
                                    <input class="form-control" type="text" value="......................" readonly
                                           id="example-text-input">
                                </div>
                            </div>

                            <div class="form-group row PDF-SIGNATURE PDF-DISTANCE-MAX">
                                Acceptatie opdracht <?= $task_nr ?> &nbsp;&nbsp;&nbsp;&nbsp;
                                versie <?= $version ?>&nbsp;&nbsp;&nbsp;&nbsp; Paraaf opdrachtgever:
                                ………………………………..
                            </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        function forprint() {
                            if (!window.print) {
                                return
                            }
                            window.print()
                        }
                    </script>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-2 mx-auto mt-1">
                                <button class="btn btn-default btn-block" onclick="forprint()">print pdf</button>
                            </div>
                        </div>
                    </div>

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