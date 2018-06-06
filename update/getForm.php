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
    $contact = $row['contact'];
    $signature = $row['signature'];

    ?>

    <div class="card-header">Formulier</div>
    <div class="card-body">
        <div class="form-group row">
            <label for="example-text-input" class="col-2 col-form-label">form id</label>
            <div class="col-4">
                <input class="form-control" type="text" value="<?= $form_id ?>" readonly id="example-text-input">
            </div>

            <label for="example-text-input" class="col-2 col-form-label">form id</label>
            <div class="col-4">
                <input class="form-control" type="text" value="<?= $created_date ?>" readonly id="example-text-input">
            </div>

        </div>

        <div class="form-group row">

            <label for="example-text-input" class="col-2 col-form-label">opdrachtnummer</label>
            <div class="col-4">
                <input class="form-control" type="text" value="<?= $task_nr ?>" readonly id="example-text-input">
            </div>

            <label for="example-text-input" class="col-2 col-form-label">versie</label>
            <div class="col-4">
                <input class="form-control" type="text" value="<?= $version ?>" readonly id="example-text-input">
            </div>
        </div>

        <div class="form-group row">
            <label for="example-text-input" class="col-2 col-form-label">locatie</label>
            <div class="col-4">
                <input class="form-control" type="text" value="<?= $type ?>" readonly id="example-text-input">
            </div>
        </div>

        <div class="form-group row">
            <label for="example-text-input" class="col-2 col-form-label">addres</label>
            <div class="col-10">
                <textarea class="form-control" type="text"  rows="7" readonly id="example-text-input"><?= $description ?></textarea>
            </div>
        </div>
    </div>
    <div class="card-header">Service level Agreement</div>
    <div class="card-body">

        <div class="form-group row">
            <label for="example-text-input" class="col-2 col-form-label">acceptatie</label>
            <div class="col-10">
                <textarea class="form-control" type="text" rows="5" readonly id="example-text-input"><?= $acceptance ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-2 col-form-label">service level agreement</label>
            <div class="col-10">
                <textarea class="form-control" type="text" rows="5" readonly id="example-text-input"><?= $SLA ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-2 col-form-label">contact</label>
            <div class="col-10">
                <textarea class="form-control" type="text"  rows="5" readonly id="example-text-input"><?= $contact ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-2 col-form-label">ondertekening</label>
            <div class="col-10">
                <textarea class="form-control" type="text" rows="5" readonly id="example-text-input"><?= $signature ?></textarea>
            </div>
        </div>
    </div>


<?php } ?>
