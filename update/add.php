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

            $query = $conn->prepare("SELECT u.first_name, u.last_name, c.company_name, c.email, c.address, c.location, c.zip_code, c.kvk
                                                FROM `user` as u
                                                INNER JOIN company as c ON u.company_id = c.company_id
                                                WHERE u.company_id = :id");
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

            }


            $to = $email;
            //$first_name = trim($_POST["firstname"]);
            /* $subject = "Aanvraag afspraak door " . $first_name;

             $message = "Beste " . $first_name . ",\r\n
                         Er is een nieuwe update voor u beschikbaar. Login op sqitsframework.nl\r\n
                         Met vriendelijke groet,\r
                         SqitsTeammzz";

             $headers = 'From: info@Sqitszir.com' . "\r\n" .
                 'Reply-To: info@Sqitszir.com' . "\r\n" .
                 'X-Mailer: PHP/' . phpversion();
             $headers .= 'Bcc: info@Sqitszir.com' . "\r\n";*/
            $subject = 'Sqits heeft een update voor u beschikbaar';

// Message
            $message = '
<html>
<head>
  <title>Sqits heeft een update voor u beschikbaar</title>
</head>
<body>
  <p>Here are the  upcoming changes in August! for ' . $company_name . '</p>
  <table>
    <tr>
      <th>' . $kvk . '</th><th>' . $location . '</th><th>' . $address . '</th><th>' . $zip_code . '</th>
    </tr>
    <tr>
      <td>' . $first_name . '</td><td>' . $last_name . '</td><td></td><td></td>
    </tr>   
    <tr>
    <td><img style="width:100px; height:100px;" src="https://pbs.twimg.com/profile_images/568078699996520448/XThN4wCd_400x400.png"/>
    </td>
</tr>
  </table>
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

        echo "<form name='preview' action=\"?action=save\" method='POST'>";

        //opens conetent top
        echo "<div class='content-top'>";

        //SQL FOR FORM_ID SELECTION
        $results = $conn->prepare("
						SELECT `form_id`, version, `task_nr`, type, `created_date` FROM `form` 
						");
        $results->execute();
        $types = $results->fetchAll();
        unset($result);

        echo "<div class='content-panel'>";
        echo "<label>Formulier versie en opdrachtnummer</label>";
        echo "<select  name='form_id' id='selectid' onchange='showForm(this.value)'>";
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

        echo "<div class='content-panel'>";
        echo "<label>user informatie</label>";
        echo "<select  name='company_id'  onchange='showUser(this.value)'>";
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



        echo "<div class='content-panel'>";
            echo "<label>laatste datum</label>";
            echo "<input type='date' name='end_date'>";
        echo "</div>";


        //closes content-top
        echo "</div>";

        echo "<div class='content'>";
            echo "<div class='content-left'>";
                echo "<div id='showForm'></div>";
            echo "</div>";

            echo "<div class='content-right'>";
                echo "<div id='showUser'></div>";
            echo "</div>";
        echo "</div>";

        echo "<input type=\"reset\" name=\"reset\" value=\"Clear\">
             <input type=\"submit\" name=\"submit\" value=\"Opslaan\">
         ";
        echo "</form>";

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