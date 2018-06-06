<?php
require_once('../system/session.php');
require_once('../system/config.php');

require_once('../templates/content.php');

checkRole('admin');


if (@$_GET['action'] == "save") {


    try {

        /*        $query = "INSERT INTO `user` as u
                        INNER JOIN `company` as c ON c.company_id = u.company_id
                        INNER JOIN `phone` as p ON p.user_id = u.user_id
                              (u.company_id, u.username, u.password, ,u.first_name, u.last_name, u.role, u.status, u.last_visit, u.created_date,
                              c.company_id, c.phone, c.company_name, c.email, c.kvk, c.zip_code, c.address, c.location, c.created_date
                              p.user_id, p.phone)
                        VALUES (:u_company_id, :username, :password, ,:first_name, :last_name, :role, :status, NOW(), NOW(),
                              :c_company_id, :c_phone, :company_name, :email, :kvk, :zip_code, :address, :location, NOW(),
                               :p_user_id, :p_phone
                         )";*/
//http://php.net/manual/en/password.constants.php

        $query = "INSERT INTO company
                   (phone, company_name, email, kvk, zip_code, address, location, created_date)
          VALUES  (:c_phone, :company_name, :email, :kvk, :zip_code, :address, :location, NOW()
          )";
        $results = $conn->prepare($query);
        $results->execute(array(
            'c_phone' => $_POST['c_phone'],
            'company_name' => $_POST['company_name'],
            'email' => $_POST['email'],
            'kvk' => $_POST['kvk'],
            'zip_code' => $_POST['zip_code'],
            'address' => $_POST['address'],
            'location' => $_POST['location']
        ));

        $last_inserted_company = $conn->lastInsertId();
        echo $last_inserted_company;

        $query = "INSERT INTO `user`
                  (company_id, username, password, first_name, last_name, role, status, last_visit, created_date)
          VALUES (:company_id, :username, :password, :first_name, :last_name, :role, :status, NOW(), NOW() )
        
          ";
        $ophalen = $conn->prepare($query);
        $ophalen->execute(array(
            'company_id' => $last_inserted_company,
            'username' => $_POST['username'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'role' => $_POST['role'],
            'status' => $_POST['status'],
        ));


        /*        $query = $conn->prepare("UPDATE `user`
                                                SET company_id = :company_id
                                            WHERE user_id =:user_id");
                $query->execute(array(
                        'user_id' => $last_id,
                        'company_id' => $last_id
                ));*/
        $last_inserted_user = $conn->lastInsertId();
        echo $last_inserted_user;

        $query = "INSERT INTO phone
                    (user_id, phone_number)
          VALUES   (:p_user_id, :p_phone) ";
        $ophalen = $conn->prepare($query);
        $ophalen->execute(array(
            'p_user_id' => $last_inserted_user,
            'p_phone' => $_POST['p_phone']
        ));


        echo "De user is opgeslagen.";
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

    echo '  <div class="content-wrapper">';
    echo '  <div class="container-fluid">';

    getTopPanel("gebruiker toevoegen");

    ?>

    <div class="card card-register mx-auto mt-1">
        <form name="add" action="?action=save" method="post">
            <div class="card-header">Inlog gegevens</div>
            <div class="card-body">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="exampleInputName">first name</label>
                            <input class="form-control" id="exampleInputName" name="first_name" type="text"
                                   aria-describedby="nameHelp" placeholder="Enter first name">
                        </div>
                        <div class="col-md-6">
                            <label for="exampleInputLastName">Last name</label>
                            <input class="form-control" id="exampleInputLastName" name="last_name" type="text"
                                   aria-describedby="nameHelp" placeholder="Enter last name">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1">username</label>
                            <input class="form-control" id="exampleInputEmail1" name="username" type="text"
                                   aria-describedby="emailHelp" placeholder="Enter username">
                        </div>
                        <div class="col-md-6">
                            <label for="exampleConfirmPassword">Confirm password</label>
                            <input class="form-control" id="exampleConfirmPassword" name="password" type="text"
                                   placeholder="Confirm password">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-4">
                            <label class="radio-inline"><input type="radio" name="role" value="user">user</label>
                            <label class="radio-inline"><input type="radio" name="role" value="admin">admin</label>
                        </div>
                        <div class="col-md-4">
                            <label class="radio-inline"><input type="radio" name="status" value="active">active</label
                            <label class="radio-inline"><input type="radio" name="status"
                                                               value="inactive">inactive</label>
                        </div>
                        <div class="col-md-4">
                            <label for="examplePhone">phone</label>
                            <input class="form-control" id="examplePhone" name="p_phone" type="text"
                                   placeholder="06..">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-header">bedrijf gegevens</div>
            <div class="card-body">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="exampleCompanyName">bedrijfsnaam</label>
                            <input class="form-control" id="exampleCompanyName" name="company_name" type="text"
                                   aria-describedby="company_name" placeholder="Enter bedrijfsnaam">
                        </div>
                        <div class="col-md-6">
                            <label for="exampleKvk">exampleKvk</label>
                            <input class="form-control" id="exampleKvk" name="kvk" type="text"
                                   aria-describedby="nameHelp" placeholder="Enter kvk">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="exampleCInputEmail1">email</label>
                            <input class="form-control" id="exampleCInputEmail1" name="email" type="email"
                                   aria-describedby="emailHelp" placeholder="Enter bedrijfsmail">
                        </div>
                        <div class="col-md-6">
                            <label for="exampleCompanyNumber">Telefoon</label>
                            <input class="form-control" id="exampleCompanyNumber" name="c_phone" type="text"
                                   placeholder="bedrijfsnummer">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-4">
                            <label for="exampleAddress">address</label>
                            <input class="form-control" id="exampleAddress" name="address" type="text"
                                   placeholder="address">
                        </div>
                        <div class="col-md-4">
                            <label for="examplePost">post</label>
                            <input class="form-control" id="examplePost" name="zip_code" type="text"
                                   placeholder="zip">
                        </div>
                        <div class="col-md-4">
                            <label for="exampleLoc">loc</label>
                            <input class="form-control" id="exampleLoc" name="location" type="text"
                                   placeholder="location">
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
}
getFooter();



