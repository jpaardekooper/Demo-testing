<?php

require_once '../system/session.php';

include_once('../system/config.php');

include_once('../templates/content.php');

//http://php.net/manual/en/function.filter-input.php
$c_phone = filter_input(INPUT_POST, "c_phone", FILTER_UNSAFE_RAW);
$company_name = filter_input(INPUT_POST, "company_name", FILTER_UNSAFE_RAW);
$email = filter_input(INPUT_POST, "email", FILTER_UNSAFE_RAW);
$kvk = filter_input(INPUT_POST, "kvk", FILTER_UNSAFE_RAW);
$zip_code = filter_input(INPUT_POST, "zip_code", FILTER_UNSAFE_RAW);
$address = filter_input(INPUT_POST, "address", FILTER_UNSAFE_RAW);
$location = filter_input(INPUT_POST, "location", FILTER_UNSAFE_RAW);

$username = filter_input(INPUT_POST, "username", FILTER_UNSAFE_RAW);
$password = filter_input(INPUT_POST, "password", FILTER_UNSAFE_RAW);
$first_name = filter_input(INPUT_POST, "first_name", FILTER_UNSAFE_RAW);
$last_name = filter_input(INPUT_POST, "last_name", FILTER_UNSAFE_RAW);
$role = filter_input(INPUT_POST, "role", FILTER_UNSAFE_RAW);
$status = filter_input(INPUT_POST, "status", FILTER_UNSAFE_RAW);

$p_phone = filter_input(INPUT_POST, "p_phone", FILTER_UNSAFE_RAW);

if ($_SESSION["id"]) {

    if ($_GET['action'] == "save2") {

        try {
            $query = $conn->prepare("
                        UPDATE `user` as u                        
                        SET                         
                          u.password = :password
                               
                        WHERE u.user_id = :user_id   
                                
                        ");
            $query->execute(array(
                'user_id' => $_GET['id'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            ));

            echo "<div class='loading-screen'>
                    <img class='loading' src='" . getAssetsDirectory() . "image/loading.gif'/>
            </div>";

            switch (getUserRole()) {
                case "user":
                    header("Refresh: 1; URL=../dashboard.index.php");
                    break;
                case "admin":
                    header("Refresh: 1; URL=index.php");
                    break;
            }

        } catch (PDOException $e) {
            $sMsg = '<p>
                    Line Number: ' . $e->getLine() . '<br />
                    File: ' . $e->getFile() . '<br />
                    Error Message: ' . $e->getMessage() . '
                </p>';

            trigger_error($sMsg);
        }
    }

    if ($_GET['action'] == "save") {

        try {


            switch (getUserRole()) {
                case "user":
                    $query = $conn->prepare("
                        UPDATE `user` as u 
                        INNER JOIN `phone` as p ON u.user_id = p.user_id
                        INNER JOIN `company` as com ON u.company_id = com.company_id
                        SET 
                          u.user_id = :user_id,
                          u.username = :username,
                         
                          u.first_name = :first_name,
                          u.last_name = :last_name, 
                             
                          p.phone_number = :phone_number,
                        
                          com.company_name = :company_name,
                          com.email = :email, 
                          com.phone = :phone,
                          com.address = :address,
                          com.location = :location,
                          com.zip_code = :zip_code,
                          com.kvk = :kvk  
                                                          
                        WHERE u.user_id = :user_id
                                
                        ");

                    $query->execute(array(

                        'user_id' => $_SESSION['id']['user_id'],
                        'username' => $_POST['username'],
                        'first_name' => $_POST['first_name'],
                        'last_name' => $_POST['last_name'],
                        'phone_number' => $_POST['phone_number'],
                        'company_name' => $_POST['company_name'],
                        'email' => $_POST['email'],
                        'phone' => $_POST['phone'],
                        'address' => $_POST['address'],
                        'location' => $_POST['location'],
                        'zip_code' => $_POST['zip_code'],
                        'kvk' => $_POST['kvk'],

                    ));

                    break;

                case "admin":
                    $query = $conn->prepare("
                        UPDATE `user` as u 
                        INNER JOIN `phone` as p ON u.user_id = p.user_id
                        INNER JOIN `company` as com ON u.company_id = com.company_id
                        SET 
                          u.user_id = :user_id,
                          u.username = :username,
                         
                          u.first_name = :first_name,
                          u.last_name = :last_name,
                          u.status = :status, 
                          u.role = :role, 
                             
                          p.phone_number = :phone_number,
                        
                          com.company_name = :company_name,
                          com.email = :email, 
                          com.phone = :phone,
                          com.address = :address,
                          com.location = :location,
                          com.zip_code = :zip_code,
                          com.kvk = :kvk  
                                                          
                        WHERE u.user_id = :user_id
                                
                        ");

                    $query->execute(array(

                        'user_id' => $_GET['id'],
                        'username' => $_POST['username'],
                        'first_name' => $_POST['first_name'],
                        'last_name' => $_POST['last_name'],
                        'status' => $_POST['status'],
                        'role' => $_POST['role'],

                        'phone_number' => $_POST['phone_number'],

                        'company_name' => $_POST['company_name'],
                        'email' => $_POST['email'],
                        'phone' => $_POST['phone'],
                        'address' => $_POST['address'],
                        'location' => $_POST['location'],
                        'zip_code' => $_POST['zip_code'],
                        'kvk' => $_POST['kvk'],

                    ));
                    break;
            }


            echo "<div style='margin: 0 auto; width: 300px;'>
                    <img style='margin-top: 40vh;' src='" . getAssetsDirectory() . "image/loading.gif'/>
            </div>";

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

        echo "<div class='content-wrapper'>";
        echo "<div class='container-fluid'>";

        getTopPanel("Gegevens"," wijzigen");

        try {
            $query = $conn->prepare("
                                          SELECT  u.*, p.*, com.*
                                          FROM `user` as u
                                          INNER JOIN company as com  ON u.company_id = com.company_id  
                                          INNER JOIN phone as p ON u.user_id = p.user_id    
                                          WHERE u.user_id =:user_id");

            $query->execute(array(
                'user_id' => $_GET['id']
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
            $company_id = $row['company_id'];
            $company_name = $row['company_name'];
            $email = $row['email'];
            $phone = $row['phone'];
            $kvk = $row['kvk'];
            $zip_code = $row['zip_code'];
            $address = $row['address'];
            $zip_code = $row['zip_code'];
            $location = $row['location'];

            $user_id = $row['user_id'];
            $username = $row['username'];
            $password = $row['password'];
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $role = $row['role'];
            $status = $row['status'];

            $p_phone = $row['phone_number'];
        }

        ?>
        <div class="container">
            <ul class="nav nav-tabs">
                <li class="li-panel-tab"><a class="nav-link user-toggle" data-toggle="tab" href="#company">Bedrijfsgegevens</a>
                </li>
                <li class="li-panel-tab"><a class="nav-link user-toggle" data-toggle="tab" href="#information">Persoonsgegevens</a>
                </li>
                <li class="li-panel-tab"><a class="nav-link user-toggle" data-toggle="tab" href="#password">Wijzig
                        wachtwoord</a></li>
            </ul>

            <div class="tab-content">
                <div id="company" class="tab-pane fade in">
                    <form name="add" action="?action=save&id=<?= htmlentities($user_id) ?>" method="post">
                        <div class="card-header">Bedrijfsgegevens</div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="exampleCompanyName">Bedrijfsnaam</label>
                                        <input class="form-control" id="exampleCompanyName" name="company_name"
                                               type="text"
                                               aria-describedby="company_name" value="<?= htmlentities($company_name) ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleKvk">Kvk</label>
                                        <input class="form-control" id="exampleKvk" name="kvk" type="text"
                                               aria-describedby="nameHelp" value="<?= htmlentities($kvk) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="exampleCInputEmail1">Email</label>
                                        <input class="form-control" id="exampleCInputEmail1" name="email" type="email"
                                               aria-describedby="emailHelp" value="<?= htmlentities($email) ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleCompanyNumber">Telefoon</label>
                                        <input class="form-control" id="exampleCompanyNumber" name="phone" type="text"
                                               value="<?= htmlentities($phone) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <label for="exampleAddress">Adres</label>
                                        <input class="form-control" id="exampleAddress" name="address" type="text"
                                               value="<?= htmlentities($address) ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="examplePost">Postcode</label>
                                        <input class="form-control" id="examplePost" name="zip_code" type="text"
                                               value="<?= htmlentities($zip_code) ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="exampleLoc">Locatie</label>
                                        <input class="form-control" id="exampleLoc" name="location" type="text"
                                               value="<?= htmlentities($location) ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="card card-register mx-auto mt-1">
                                <input class="btn btn-primary btn-block" type="submit" name="submit" value="Opslaan">
                            </div>
                        </div>

                </div>
                <div id="information" class="tab-pane fade">

                    <div class="card-header">Gebruiker gegevens</div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="exampleInputName">Voornaam</label>
                                    <input class="form-control" id="exampleInputName" name="first_name" type="text"
                                           aria-describedby="nameHelp" value="<?= htmlentities($first_name) ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputLastName">Achternaam</label>
                                    <input class="form-control" id="exampleInputLastName" name="last_name"
                                           type="text"
                                           aria-describedby="nameHelp" value="<?= htmlentities($last_name) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">username</label>
                                    <input class="form-control" id="exampleInputEmail1" name="username" type="text"
                                           aria-describedby="emailHelp" value="<?= htmlentities($username) ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="examplePhone">Bereikbaar op</label>
                                    <input class="form-control" id="examplePhone" name="phone_number" type="text"
                                           aria-describedby="Bereikbaar op" value="<?= htmlentities($p_phone) ?>">
                                </div>
                            </div>
                        </div>
                        <?php

                        switch (getUserRole()) {
                            case "admin":
                                ?>
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <?php
                                            if ($role == 'user') {
                                                echo "  <label class=\"radio-inline\"><input type=\"radio\" name=\"role\" value=\"user\" checked=\"checked\">user</label>";
                                                echo " <label class=\"radio-inline\"><input type=\"radio\" name=\"role\" value=\"admin\">admin</label>";
                                            } else {
                                                echo "  <label class=\"radio-inline\"><input type=\"radio\" name=\"role\" value=\"user\">user</label>";
                                                echo " <label class=\"radio-inline\"><input type=\"radio\" name=\"role\" value=\"admin\" checked=\"checked\">admin</label>";
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-4">


                                            <?php
                                            if ($status == 'active') {
                                                echo "  <label class=\"radio-inline\"><input type=\"radio\" name=\"status\" value=\"active\" checked='checked'>active</label>";
                                                echo "   <label class=\"radio-inline\"><input type=\"radio\" name=\"status\"
                                                           value=\"inactive\">inactive</label>";
                                            } else {
                                                echo "  <label class=\"radio-inline\"><input type=\"radio\" name=\"status\" value=\"active\">active</label>";
                                                echo "   <label class=\"radio-inline\"><input type=\"radio\" name=\"status\"
                                                           value=\"inactive\"  checked='checked'>inactive</label>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                break;
                        }
                        ?>
                    </div>
                    <div class="form-group row">
                        <div class="card card-register mx-auto mt-1">
                            <input class="btn btn-primary btn-block" type="submit" name="submit" value="Opslaan">
                        </div>
                    </div>

                </div>
                </form>

                <div id="password" class="tab-pane fade">
                    <form name="add2" action="?action=save2&id=<?= htmlentities($user_id) ?>" method="post">
                        <div class="card-header">Wachtwoord instellen</div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="exampleConfirmPassword">Nieuw wachtwoord</label>
                                        <input class="form-control" id="exampleConfirmPassword" name="password"
                                               type="text">
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
        </div>

        <?php


        echo "
 
            </div>      
            </div>      
            ";

        getFooter();
    }

} else {
    echo "please login first on login page";
    header("Refresh: 1; URL=\"../login.php\"");
    exit;
}
?>