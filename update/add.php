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
                echo "<div style='margin: 0 auto; width: 300px;'>
                    <img style='margin-top: 40vh;' src='" . getAssetsDirectory() . "image/loading.gif'/>
            </div>";
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

        getTopPanel("Update", " toevoegen");

        ?>

        <div class="card mx-auto mt-1">
            <form name="add" action="?action=save" method="POST">

                <div class="container">
                    <ul class="timeline">
                        <li>
                            <div class="timeline-badge warning"><i class="glyphicon glyphicon-check"></i></div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h6 class="timeline-title">Formulier versie en opdrachtnummer</h6>
                                </div>
                                <div class="timeline-body">
                                    <?php


                                    //SQL FOR FORM_ID SELECTION
                                    $results = $conn->prepare("
						                                            SELECT `form_id`, version, `task_nr`, type, `created_date` FROM `form` 
						                                            ");
                                    $results->execute();
                                    $types = $results->fetchAll();
                                    unset($result);

                                    echo "<select class='form-control' name='form_id' id='select-form' onchange='showForm(this.value); succes()'>";
                                    echo "<option value=''></option>";
                                    foreach ($types as $type) {
                                        if ($type['form_id'] == $form_id) {
                                            echo "<option selected value='" . htmlentities($type['form_id']) . "'>" . htmlentities($type['type']) . " " . htmlentities($type['version']) . "   " . htmlentities($type['task_nr']) . "</option>";
                                        } else {
                                            echo "<option value='" . htmlentities($type['form_id']) . "'>" . htmlentities($type['type']) . " " . htmlentities($type['version']) . "   " . htmlentities($type['task_nr']) . "</option>";
                                        }
                                    }
                                    echo "</select>";

                                    //****end
                                    ?>
                                </div>
                            </div>
                        </li>
                        <li id="form-succes" class="timeline-inverted nothing-selected">
                            <div class="timeline-badge success"><i class="glyphicon glyphicon-check"></i></div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h6 class="timeline-title">Formulier is toegevoegd</h6>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="timeline-badge warning"><i class="glyphicon glyphicon-credit-card"></i></div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h6 class="timeline-title">Bedrijfsinformatie</h6>
                                </div>
                                <div class="timeline-body">

                                    <?php
                                    //SQL FOR USER SELECTION
                                    $results = $conn->prepare("
						SELECT com.* 
						FROM `company` as com 													
						");
                                    $results->execute();
                                    $types = $results->fetchAll();
                                    unset($result);

                                    echo "<select class='form-control' name='company_id' id='select-company' onchange='showUser(this.value); succes2()'>";
                                    echo "<option value=''></option>";
                                    foreach ($types as $type) {
                                        if ($type['company_id'] == $company_id) {
                                            echo "<option selected value='" . htmlentities($type['company_id']) . "'>" . htmlentities($type['company_name']) . " ..  " . htmlentities($type['kvk']) . "</option>";
                                        } else {
                                            echo "<option value='" . htmlentities($type['company_id']) . "'>" . htmlentities($type['company_name']) . " .. " . htmlentities($type['kvk']) . "</option>";
                                        }
                                    }
                                    echo "</select>";

                                    //**** end
                                    ?>

                                </div>
                            </div>
                        </li>
                        <li id="form-succes2" class="timeline-inverted nothing-selected">
                            <div class="timeline-badge success"><i class="glyphicon glyphicon-check"></i></div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h6 class="timeline-title">Bedrijf is toegevoegd</h6>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="timeline-badge warning"><i class="glyphicon glyphicon-credit-card"></i></div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h6 class="timeline-title">Einddatum</h6>
                                </div>
                                <div class="timeline-body">
                                    <input class='form-control' type='date'  id='select-date' onchange='succes3()' name='end_date'>
                                </div>
                            </div>
                        </li>
                        <li id="form-succes3" class="timeline-inverted nothing-selected">
                            <div class="timeline-badge success"><i class="glyphicon glyphicon-check"></i></div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h6 class="timeline-title">Einddatum is toegevoegd</h6>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="form-group">
                    <div class="form-row">
                        <!-- output for the getForm.php -->
                        <div class="col-md-6">
                            <div id='showForm'></div>
                        </div>
                        <!-- output for the getuser.php -->
                        <div class="col-md-6">
                            <div id='showUser'></div>
                        </div>
                    </div>
                </div>


                <div class="form-group row">
                    <div class="card card-register mx-auto mt-1">
                        <button class="btn btn-primary btn-block" type="submit" name="submit"><i
                                    class="fa fa-paper-plane"> Versturen</i></button>
                    </div>
                </div>


            </form>
        </div>


        <?php
        echo "</div>";
        echo "</div>";
        getFooter();
    }
} else {
    echo "please login first on login page";
    header("Location:../login.php");
    exit;
}
