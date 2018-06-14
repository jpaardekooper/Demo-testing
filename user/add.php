<?php
require_once('../system/session.php');

require_once('../system/config.php');

require_once('../templates/content.php');

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

            //http://php.net/manual/en/password.constants.php
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
                                <label for="exampleInputName">Voornaam</label>
                                <input class="form-control" id="exampleInputName" name="first_name" type="text"
                                       aria-describedby="nameHelp" placeholder="Enter first name"
                                       pattern="[a-zA-Z0-9 _-]{1,40}">
                            </div>
                            <div class="col-md-6">
                                <label for="exampleInputLastName">Achternaam</label>
                                <input class="form-control" id="exampleInputLastName" name="last_name" type="text"
                                       aria-describedby="nameHelp" placeholder="Enter last name"
                                       pattern="[a-zA-Z0-9 _-]{1,40}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="exampleInputEmail1">Email (inloggegevens)</label>
                                <input class="form-control" id="exampleInputEmail1" name="username" type="text"
                                       aria-describedby="emailHelp" placeholder="iemand@example.com">
                            </div>
                            <div class="col-md-6">
                                <label for="exampleConfirmPassword">Wachtwoord</label>
                                <input class="form-control" id="exampleConfirmPassword" name="password" type="text"
                                       placeholder="*******">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-4">
                                <label class="radio-inline"><input type="radio" name="role" value="user"
                                                                   checked="checked">user</label><br/>
                                <label class="radio-inline"><input type="radio" name="role" value="admin">admin</label>
                            </div>
                            <div class="col-md-4">
                                <label class="radio-inline"><input type="radio" name="status" value="active"
                                                                   checked="checked">active</label><br/>
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
                                <label for="exampleCompanyName">Bedrijfsnaam</label>
                                <input class="form-control" id="exampleCompanyName" name="company_name" type="text"
                                       aria-describedby="company_name" placeholder="Enter bedrijfsnaam">
                            </div>
                            <div class="col-md-6">
                                <label for="exampleKvk">Kvk(nummer)</label>
                                <input class="form-control" id="exampleKvk" name="kvk" type="text"
                                       aria-describedby="nameHelp" placeholder="Kvk...">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="exampleCInputEmail1">Bedrijfs email</label>
                                <input class="form-control" id="exampleCInputEmail1" name="email" type="email"
                                       aria-describedby="emailHelp" placeholder="Enter bedrijfsmail">
                            </div>
                            <div class="col-md-6">
                                <label for="exampleCompanyNumber">Telefoonnummer</label>
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
} else {
    echo "please login first on login page";
    header("Refresh: 1; URL=\"../login.php\"");
    exit;
}
?>


