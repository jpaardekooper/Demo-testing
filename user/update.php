<?php

require_once '../system/session.php';

include_once('../system/config.php');

include_once('../templates/content.php');

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

            switch (getUserRole()){
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


            echo "<div class='loading-screen'>
                    <img class='loading' src='" . getAssetsDirectory() . "image/loading.gif'/>
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
        getBreadCrumbs();
        getTopPanel("Gegevens wijzigen");

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
                <li class="li-panel-tab"><a class="nav-link user-toggle"data-toggle="tab" href="#company">Bedrijfsgegevens</a></li>
                <li class="li-panel-tab"><a class="nav-link user-toggle"data-toggle="tab" href="#information">Persoonsgegevens</a></li>
                <li class="li-panel-tab"><a class="nav-link user-toggle"data-toggle="tab" href="#password">wijzig wachtwoord</a></li>

            </ul>

            <div class="tab-content">
                <div id="company" class="tab-pane fade in">
                    <form name="add" action="?action=save&id=<?= $user_id ?>" method="post">
                        <div class="card-header">bedrijf gegevens</div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="exampleCompanyName">bedrijfsnaam</label>
                                        <input class="form-control" id="exampleCompanyName" name="company_name"
                                               type="text"
                                               aria-describedby="company_name" value="<?= $company_name ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleKvk">exampleKvk</label>
                                        <input class="form-control" id="exampleKvk" name="kvk" type="text"
                                               aria-describedby="nameHelp" value="<?= $kvk ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="exampleCInputEmail1">email</label>
                                        <input class="form-control" id="exampleCInputEmail1" name="email" type="email"
                                               aria-describedby="emailHelp" value="<?= $email ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleCompanyNumber">Telefoon</label>
                                        <input class="form-control" id="exampleCompanyNumber" name="phone" type="text"
                                               value="<?= $phone ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <label for="exampleAddress">address</label>
                                        <input class="form-control" id="exampleAddress" name="address" type="text"
                                               value="<?= $address ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="examplePost">postcode</label>
                                        <input class="form-control" id="examplePost" name="zip_code" type="text"
                                               value="<?= $zip_code ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="exampleLoc">loc</label>
                                        <input class="form-control" id="exampleLoc" name="location" type="text"
                                               value="<?= $location ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input class="btn btn-primary btn-block" type="submit" name="submit" value="Opslaan">
                </div>
                <div id="information" class="tab-pane fade">

                        <div class="card-header">Gebruiker gegevens</div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="exampleInputName">first name</label>
                                        <input class="form-control" id="exampleInputName" name="first_name" type="text"
                                               aria-describedby="nameHelp" value="<?= $first_name ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleInputLastName">Last name</label>
                                        <input class="form-control" id="exampleInputLastName" name="last_name"
                                               type="text"
                                               aria-describedby="nameHelp" value="<?= $last_name ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">username</label>
                                        <input class="form-control" id="exampleInputEmail1" name="username" type="text"
                                               aria-describedby="emailHelp" value="<?= $username ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="examplePhone">Bereikbaar op</label>
                                        <input class="form-control" id="examplePhone" name="phone_number" type="text"
                                               aria-describedby="Bereikbaar op" value="<?= $p_phone ?>">
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
                                            <div class="col-md-4">
                                                <label for="examplePhone">phone</label>
                                                <input class="form-control" id="examplePhone" name="phone_number"
                                                       type="text"
                                                       value="<?= $p_phone ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    break;
                            }
                            ?>
                        </div>
                        <input class="btn btn-primary btn-block" type="submit" name="submit" value="Opslaan">
                </div>
                </form>

                <div id="password" class="tab-pane fade">
                    <form name="add2" action="?action=save2&id=<?= $user_id ?>" method="post">
                        <div class="card-header">Wachtwoord instellen</div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="exampleConfirmPassword">Confirm password</label>
                                        <input class="form-control" id="exampleConfirmPassword" name="password"
                                               type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input class="btn btn-primary btn-block" type="submit" name="submit" value="Opslaan">
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