<?php
require_once('../system/session.php');
require_once('../system/config.php');

require_once('../templates/content.php');


getHeader("Sqits form-add", "Update add");

if (isset($_SESSION['id'])) {

    checkRole('admin');


    echo '<div class="right-panel">';

    getTopPanel("Update toevoegen");

    if (@$_GET['action'] == "save") {
        try {
//http://php.net/manual/en/password.constants.php

            $sql = "INSERT INTO `update` (`user_id`, `form_id`, `status`, `type`, `end_date`,`send_date`,`created_date`) 
                VALUES (:user_id, :form_id, :status, :type, :end_date, NOW(), NOW() )";
            $ophalen = $conn->prepare($sql);
            $ophalen->execute(array(
                'user_id' => $_POST['user_id'],
                'form_id' => $_POST['form_id'],
                'status' => 'pending',
                'type' => $_POST['type'],
                'end_date' => $_POST['end_date']
            ));

            $query = $conn->prepare("SELECT u.email, com.first_name, com.last_name, com.company_name
                                                FROM `user` as u
                                                INNER JOIN company as com ON u.user_id = com.user_id
                                                WHERE u.user_id = :id");
            $query->execute(array(
                'id' => $_POST['user_id'],
            ));

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $email = $row['email'];
                $first_name = $row['first_name'];
                $last_name = $row['last_name'];
                $company_name = $row['company_name'];

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
  <p>Here are the  upcoming changes in August!</p>
  <table>
    <tr>
      <th>' . $company_name . '</th><th>Day</th><th>Month</th><th>Year</th>
    </tr>
    <tr>
      <td>' . $first_name . '</td><td>hans</td><td>Wanda</td><td>1970</td>
    </tr>
    <tr>
      <td>' . $last_name . '</td><td>17th</td><td>August</td><td>1973</td>
    </tr>
    <tr>
    <td><img style="width:100px; height:100px;" src="https://pbs.twimg.com/profile_images/568078699996520448/XThN4wCd_400x400.png"/></td>
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
        echo "<form name='preview' action=\"?action=save\" method='POST'>";

        //opens conetent top
        echo "<div class='content-top'>";

        //SQL FOR FORM_ID SELECTION
        $results = $conn->prepare("
						SELECT `form_id`, `version`, `task_nr` FROM `form` 
						");
        $results->execute();
        $types = $results->fetchAll();
        unset($result);

        echo "<label>Formulier versie en opdrachtnummer</label>";
        echo "<select  name='form_id' onchange='showForm(this.value)'>";
        echo "<option value=''></option>";
        foreach ($types as $type) {
            if ($type['form_id'] == $form_id) {
                echo "<option selected value='" . htmlentities($type['form_id']) . "'>" . htmlentities($type['version']) . "   " . htmlentities($type['task_nr']) . "</option>";

            } else {
                echo "<option value='" . htmlentities($type['form_id']) . "'>" . htmlentities($type['version']) . "   " . htmlentities($type['task_nr']) . "</option>";
            }
        }
        echo "</select>";
        //****end

        //SQL FOR USER SELECTION
        $results = $conn->prepare("
						SELECT u.*, com.* 
						FROM `user` as u 
						INNER JOIN company as com ON com.user_id = u.user_id								
						");
        $results->execute();
        $types = $results->fetchAll();
        unset($result);

        echo "<label>user informatie</label>";
        echo "<select  name='user_id'  onchange='showUser(this.value)'>";
        echo "<option value=''></option>";
        foreach ($types as $type) {
            if ($type['user_id'] == $user_id) {
                echo "<option selected value='" . htmlentities($type['user_id']) . "'>" . htmlentities($type['company_id']) . "   " . htmlentities($type['company_name']) . "</option>";
            } else {
                echo "<option value='" . htmlentities($type['user_id']) . "'>" . htmlentities($type['company_id']) . "   " . htmlentities($type['company_name']) . "</option>";
            }
        }
        echo "</select>";
        //**** end

        echo "<label>Type</label>";
        echo "<select name='type'>";
        echo "<option value='mayor-update'>mayor-update</option>";
        echo "<option value='bug-fix'>bug-fix</option>";
        echo "</select>";


        echo "<label>laatste datum</label>";
        echo "<input type='date' name='end_date'>";




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

        getFooter();
    }
} else {
    echo "please login first on login page";
    header("Refresh: 1; URL=\"../login.php\"");
    exit;
}