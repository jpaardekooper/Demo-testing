<?php
require_once('../system/session.php');
require_once('../system/config.php');

require_once('../templates/content.php');


if (isset($_SESSION['id'])) {

    checkRole('admin');


    if (@$_GET['action'] == "save") {
        try {
//http://php.net/manual/en/password.constants.php

            $sql = "INSERT INTO `update` (`company_id`, `form_id`, status, `end_date`, `created_date`) 
                                  VALUES (:company_id, :form_id, 'pending', :end_date, NOW() )";
            $ophalen = $conn->prepare($sql);
            $ophalen->execute(array(
                'company_id' => $_POST['company_id'],
                'form_id' => $_POST['form_id'],
                'end_date' => $_POST['end_date']
            ));

            $query = $conn->prepare("SELECT u.first_name, u.last_name, c.company_name, c.email, c.address, c.location, c.zip_code, c.kvk, f.description
                                                FROM `user` as u
                                                INNER JOIN company as c ON u.company_id = c.company_id
                                                INNER JOIN `update` as up ON up.company_id = c.company_id
                                                INNER JOIN form as f ON f.form_id = up.form_id                               
                                                WHERE u.company_id = :id AND up.company_id = :id");
            $query->execute(array(
                'id' => $_POST['company_id'],
            ));

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $first_name = $row['first_name'];
                $last_name = $row['last_name'];
                $company_name = $row['company_name'];
                $email = $row['email'];
                $address = $row['address'];
                $location = $row['location'];
                $zip_code = $row['zip_code'];
                $kvk = $row['kvk'];

                $description = $row['description'];

            }

            //mail function
            $to = $email;
            $subject = 'Sqits heeft een update voor u beschikbaar';

// Message
            $message = '
            <html>
            <head>
              <title>Sqits heeft een update voor u beschikbaar</title>
            </head>
            <body>
              <p>Beste ' . $company_name . ',</p>
              <p>Er is een nieuwe update voor u beschikbaar. <br/>
              Ga naar de website <a href="https://www.sqits.nl/">www.Sqits-Updates.nl</a> om de voorwaarde te lezen en te accepteren.</p>
              
              <p>Update Info:</p>
              <p>' . $description . '</p>
              
            <p>Heeft u nog vragen, neem dan gerust contact op. <br/>
            Email: <a href="mailto:r.schaaphuizen@sqits.nl?Subject=Vraag%20over" target="_top">r.schaaphuizen@sqits.nl</a> <br/>
            Telefoon: 085 760 80 90
            </p> <br/>
            <p>Met vriendelijke groet, <br/>
            Ruud Schaaphuizen <br/>
            SQITS founder</p>
            <img style="width:100px; height:100px;" src="https://pbs.twimg.com/profile_images/568078699996520448/XThN4wCd_400x400.png"/>
            </body>
            </html>
            ';

// To send HTML mail, the Content-type header must be set
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';

// Additional headers
            $headers[] = 'From: Sqits Reminder <infoSqits@example.com>';
            $headers[] = 'Cc: infoSqits@example.com';
            $headers[] = 'Bcc: infoSqits@example.com';

// Mail it

            $retval = mail($to, $subject, $message, implode("\r\n", $headers));
            if ($retval == true) {
                echo "Message sent successfully...";
                echo "Het formulier is opgeslagen en verzonden.";
                header("Refresh: 1; URL=index.php");
            } else {
                echo "Message could not be sent...";
            }


        } catch (PDOException $e) {
            $sMsg = '<p>
                Regelnummer: ' . $e->getLine() . '<br />
                Bestand: ' . $e->getFile() . '<br />
                Foutmelding: ' . $e->getMessage() . '
            </p>';

            trigger_error($sMsg);
        }
    } else {

        getHeader("Sqits form-add", "Update add");
        echo '<div class="content-wrapper">';
        echo '<div class="container-fluid">';

        getBreadCrumbs();

        getTopPanel("Update toevoegen");

        ?>

        <div class="card mx-auto mt-1">
            <form name="add" action="?action=save" method="POST">
                <div class="card-header">Voorwaarden Forumulier</div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-4">
                                <?php


                                //SQL FOR FORM_ID SELECTION
                                $results = $conn->prepare("
						SELECT `form_id`, version, `task_nr`, type, `created_date` FROM `form` 
						");
                                $results->execute();
                                $types = $results->fetchAll();
                                unset($result);

                                echo "<label>Formulier versie en opdrachtnummer</label>";
                                echo "<select class='form-control' name='form_id' id='selectid' onchange='showForm(this.value)'>";
                                echo "<option value=''></option>";
                                foreach ($types as $type) {
                                    if ($type['form_id'] == $form_id) {
                                        echo "<option selected value='" . htmlentities($type['form_id']) . "'>" . htmlentities($type['type']) . " " . htmlentities($type['version']) . "   " . htmlentities($type['task_nr']) . "</option>";

                                    } else {
                                        echo "<option value='" . htmlentities($type['form_id']) . "'>" . htmlentities($type['type']) . " " . htmlentities($type['version']) . "   " . htmlentities($type['task_nr']) . "</option>";
                                    }
                                }
                                echo "</select>";
                                echo "</div>";

                                //****end

                                //SQL FOR USER SELECTION
                                $results = $conn->prepare("
						SELECT com.* 
						FROM `company` as com 													
						");
                                $results->execute();
                                $types = $results->fetchAll();
                                unset($result);

                                echo " <div class=\"col-md-4\">";
                                echo "<label>user informatie</label>";
                                echo "<select class='form-control' name='company_id'  onchange='showUser(this.value)'>";
                                echo "<option value=''></option>";
                                foreach ($types as $type) {
                                    if ($type['company_id'] == $company_id) {
                                        echo "<option selected value='" . htmlentities($type['company_id']) . "'>" . htmlentities($type['company_name']) . " ..  " . htmlentities($type['kvk']) . "</option>";
                                    } else {
                                        echo "<option value='" . htmlentities($type['company_id']) . "'>" . htmlentities($type['company_name']) . " .. " . htmlentities($type['kvk']) . "</option>";
                                    }
                                }
                                echo "</select>";
                                echo "</div>";
                                //**** end

                                echo " <div class=\"col-md-4\">";
                                echo "<label>laatste datum</label>";
                                echo "<input  class='form-control' type='date' name='end_date'>";
                                echo "</div>";
                                ?>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div id='showForm'></div>
                                </div>
                                <div class="col-md-6">

                                    <div id='showUser'></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card card-register mx-auto mt-1">
                    <input class="btn btn-primary btn-block" type="submit" name="submit" value="Opslaan">
                </div>
        </div>

        </form>
        </div>

        <?php
        echo "<input type=\"reset\" name=\"reset\" value=\"Clear\">
<input type=\"submit\" name=\"submit\" value=\"Opslaan\">
";


//closes right-panel
        echo "</div>";
        echo "</div>";

        getFooter();
    }
} else {
    echo "please login first on login page";
    header("Refresh: 1; URL=\"../login.php\"");
    exit;
}