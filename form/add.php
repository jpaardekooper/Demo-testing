<?php
require_once '../system/session.php';

include_once('../system/config.php');

include_once('../templates/content.php');


if (isset($_SESSION['id'])) {

    checkRole('admin');

    getHeader("Sqits form-add", "Form add");

    echo '<div class="content-wrapper">';
    echo '<div class="container-fluid">';
    getBreadCrumbs();
    getTopPanel("formulier toevoegen");

    if (@$_GET['action'] == "save") {

        try {

//http://php.net/manual/en/password.constants.php

            $query = "INSERT INTO `form` (`company_id`, `type`, `version`, `task_nr`, `description`, status, end_date, create_date, modified_date) 
                                    VALUES (:company_id, :type, :version, :task_nr, :description, :status, :end_date, NOW(), NOW() )";
            $results = $conn->prepare($query);
            $results->execute(array(
                'company_id' => $_POST['company_id'],
                'type' => $_POST['type'],
                'version' => $_POST['version'],
                'task_nr' => $_POST['task_nr'],
                'description' => $_POST['description'],
                'status' => $_POST['status'],
                'end_date' => $_POST['end_date'],


            ));

            echo "<div class='loading-screen'>
                    <img class='loading' src='" . getAssetsDirectory() . "image/loading.gif'/>
            </div>";

            echo "het formulier is opgeslagen.";

            header("Refresh: 1; url=index.php");

        } catch (PDOException $e) {
            $sMsg = '<p>
                Regelnummer: ' . $e->getLine() . '<br />
                Bestand: ' . $e->getFile() . '<br />
                Foutmelding: ' . $e->getMessage() . '
            </p>';

            trigger_error($sMsg);
        }
    } else {


        ?>


        <?php
        echo "
          	<form name=\"add\" action=\"?action=save\" method=\"post\">
                <table>             
                    <tr>
                        <tr>bedrijfsnaam</tr>
                        <tr><input type=\"text\" name=\"company_id\" required> </tr>   
                        <tr>type</tr>
                        <tr><input type=\"text\" name=\"type\" required> </tr>  
                        <tr>versie</tr>
                        <tr><input type=\"number\" name=\"version\" required> </tr> <br/>
                        <tr>opdrachtnummer</tr> <br/>
                        <tr><input type=\"text\" name=\"task_nr\" required> </tr> <br/>
                        <tr>beschrijving</tr> <br/>
                        <tr><textarea rows=\"4\" cols=\"50\" type='text' name=\"description\" required> </textarea></tr>  <br/>
                        <tr>status</tr> <br/>
                        <tr>
                        <select name='status'>                      
                              <option value=\"pending\">pending</option>
                              <option value=\"1\">1</option>
                              <option value=\"2\">2</option>
                              <option value=\"3\">3</option>
                            </select>
                        </tr>  <br/>
                        <tr>eind datum</tr><br/>
                        <tr><input type=\"date\" name=\"end_date\" required> </tr> 
                 
              
                
                    <tr>
                        <td colspan=\"2\"><input type=\"reset\" name=\"reset\" value=\"Clear\">
                                        <input type=\"submit\" name=\"submit\" value=\"Opslaan\"></td>
                    </tr>					
                </table>
            </form>          
          
            ";

        echo"</div>";
        echo"</div>";

        getFooter();

    }
} else {
    echo "please login first on login page";
    header("Refresh: 1; URL=\"../login.php\"");
    exit;
}


?>