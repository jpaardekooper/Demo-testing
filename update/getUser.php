<?php
require_once('../system/session.php');
require_once('../system/config.php');

require_once('../templates/content.php');

checkRole("admin");


try {
    $query = $conn->prepare("SELECT u.*, com.*, p.* 
                                        FROM user as u  
                                        INNER JOIN company as com ON com.company_id = u.company_id
                                        LEFT JOIN phone as p ON p.user_id = u.user_id
                                        WHERE u.company_id = :company_id
                                         ");
    $query->execute(array(
        'company_id' => $_GET['u']
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
    $company_id = $row['company_id'];
    $kvk = $row['kvk'];
    $company_name = $row['company_name'];
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $zip_code = $row['zip_code'];
    $address = $row['address'];
    $location = $row['location'];
    $email = $row['email'];
    $phone_number = $row['phone_number'];
    $phone = $row['phone'];

    ?>
    <div class="card-header">Bedrijfsgegevens</div>
<div class="card-body">
    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Kvk</label>
        <div class="col-md-4">
            <input class="form-control" type="text" value="<?= $kvk ?>" readonly id="example-text-input">
        </div>

    </div>

    <div class="form-group row">

        <label for="example-text-input" class="col-md-2 col-form-label">Bedrijfsnaam</label>
        <div class="col-md-4">
            <input class="form-control" type="text" value="<?= $company_name ?>" readonly id="example-text-input">
        </div>

        <label for="example-text-input" class="col-md-2 col-form-label">Mail</label>
        <div class="col-md-4">
            <input class="form-control" type="text" value="<?= $email ?>" readonly id="example-text-input">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Locatie</label>
        <div class="col-md-4">
            <input class="form-control" type="text" value="<?= $location ?>" readonly id="example-text-input">
        </div>

        <label for="example-text-input" class="col-md-2 col-form-label">Postcode</label>
        <div class="col-md-4">
            <input class="form-control" type="text" value="<?= $zip_code ?>" readonly id="example-text-input">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Adres</label>
        <div class="col-md-4">
            <input class="form-control" type="text" value="<?= $address ?>" readonly id="example-text-input">
        </div>

        <label for="example-text-input" class="col-md-2 col-form-label">Telefoon</label>
        <div class="col-md-4">
            <input class="form-control" type="text" value="<?= $phone ?>" readonly id="example-text-input">
        </div>
    </div>
    </div>
    <div class="card-header">Contactgegevens</div>
    <div class="card-body">

        <div class="form-group row">
            <label for="example-text-input" class="col-md-2 col-form-label">Voornaam</label>
            <div class="col-md-4">
                <input class="form-control" type="text" value="<?= $first_name ?>" readonly id="example-text-input">
            </div>

            <label for="example-text-input" class="col-md-2 col-form-label">Achternaam</label>
            <div class="col-md-4">
                <input class="form-control" type="text" value="<?= $last_name ?>" readonly id="example-text-input">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-md-2 col-form-label">Telefoonnummer</label>
            <div class="col-md-6">
                <input class="form-control" type="text" value="<?= $phone_number ?>" readonly id="example-text-input">
            </div>
        </div>
    </div>
<?php } ?>


