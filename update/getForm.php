<?php
require_once('../system/session.php');
require_once('../system/config.php');

require_once('../templates/content.php');

checkRole("admin");

try {
    $query = $conn->prepare("SELECT f.*, t.*
                                        FROM form as f  
                                        INNER JOIN terms as t ON f.terms_id = t.terms_id                                      
                                        WHERE f.form_id = :form_id
                                         ");
    $query->execute(array(
        'form_id' => $_GET['f']
    ));
} catch (PDOException $e) {
    $sMsg = '<p> 
                    Line number: ' . $e->getLine() . '<br /> 
                    File: ' . $e->getFile() . '<br /> 
                    Error message: ' . $e->getMessage() .
        '</p>';
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

    $acceptance = $row['acceptance'];
    $SLA = $row['service_level_agreement'];
    $contract = $row['contract'];
    $signature = $row['signature'];

    ?>

    <div class="card-header">Formulier</div>
    <div class="card-body">
        <div class="form-group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Form id</label>
            <div class="col-md-3">
                <input class="form-control" type="text" value="<?= $form_id ?>" readonly id="example-text-input">
            </div>

            <label for="example-text-input" class="col-md-3 col-form-label">Gemaakt op</label>
            <div class="col-md-3">
                <input class="form-control" type="text" value="<?= $created_date ?>" readonly id="example-text-input">
            </div>

        </div>

        <div class="form-group row">

            <label for="example-text-input" class="col-md-3 col-form-label">Opdracht(nummer)</label>
            <div class="col-md-3">
                <input class="form-control" type="text" value="<?= $task_nr ?>" readonly id="example-text-input">
            </div>

            <label for="example-text-input" class="col-md-3 col-form-label">Versie</label>
            <div class="col-md-3">
                <input class="form-control" type="text" value="<?= $version ?>" readonly id="example-text-input">
            </div>
        </div>

        <div class="form-group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Soort update</label>
            <div class="col-md-3">
                <input class="form-control" type="text" value="<?= $type ?>" readonly id="example-text-input">
            </div>
        </div>

        <div class="form-group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Beschrijving</label>
            <div class="col-md-9">
                <textarea class="form-control" type="text"  rows="7" readonly id="example-text-input"><?= $description ?></textarea>
            </div>
        </div>
    </div>
    <div class="card-header">Service level Agreement</div>
    <div class="card-body">

        <div class="form-group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Acceptatie</label>
            <div class="col-md-9">
                <textarea class="form-control" type="text" rows="5" readonly id="example-text-input"><?= $acceptance ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Service level agreement</label>
            <div class="col-md-9">
                <textarea class="form-control" type="text" rows="5" readonly id="example-text-input"><?= $SLA ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Contract</label>
            <div class="col-md-9">
                <textarea class="form-control" type="text"  rows="5" readonly id="example-text-input"><?= $contract ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Ondertekening</label>
            <div class="col-md-9">
                <textarea class="form-control" type="text" rows="5" readonly id="example-text-input"><?= $signature ?></textarea>
            </div>
        </div>
    </div>


<?php } ?>
