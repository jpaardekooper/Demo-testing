<?php

require_once '../system/session.php';

include_once('../system/config.php');

include_once('../templates/content.php');


checkRole("admin");


getTopPanel("formulier wijzigen") ;
if ($_GET['action'] == "save") {

    try {
/*        $query = $conn->prepare("
                        UPDATE `user` SET email = :email, password = :password, active = :active WHERE user_id = :id");
        $query->execute(array(
            'id' => $_GET['id'],
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'active' => $_POST['active']
        ));*/

        $query = $conn->prepare("UPDATE `form` 
                                        SET company_id =:company_id,
                                         type =:type,
                                          version =:version,
                                           task_nr  =:task_nr,
                                            description=:description,
                                             status =:status, 
                                             end_date =:end_date,
                                              modified_date =:modified_date                                     
                                    WHERE form_id =:id");

        $query->execute(array(
            'id' =>  $_GET['id'],
            'company_id' => $_POST['company_id'],
            'type' => $_POST['type'],
            'version' => $_POST['version'],
            'task_nr' => $_POST['task_nr'],
            'description' => $_POST['description'],
            'status' => $_POST['status'],
            'end_date' => $_POST['end_date'],
            'modified_date' => date("d-m-Y")


        ));
        
        echo "wijzigingen zijn opgeslagen.";
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
    echo '<div class="content-wrapper">';
    echo '<div class="container-fluid">';

    try {
        $query = $conn->prepare("
                        SELECT * FROM form WHERE form_id = :id");

        $query->execute(array(
            'id' => $_GET['id']
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
        $form_id = $row['form_id'];
        $company_id = $row['company_id'];
        $type = $row['type'];
        $status = $row['status'];
        $version = $row['version'];
        $task_nr = $row['task_nr'];
        $description = $row['description'];
        $end_date = $row['end_date'];
        $modified_date = $row['modified_date'];
    }

    echo "    


    <header class='header'>
        <p>welkom: <?= getUserName(); ?></p>
        <p>
            is user role: " . $_SESSION['id']['role'] . "
        </p>

        this is form edit
    </header>


            <form name=\"add\" action=\"?action=save&id=$form_id\" method=\"post\">
                <table>
                 <tr>
                        <tr>form_id</tr>
                        <tr><input type=\"text\" name=\"company_id\" value='$form_id' required> </tr>   
                        <tr>bedrijfsnaam</tr>
                        <tr><input type=\"text\" name=\"company_id\" value='$company_id' required> </tr>   
                        <tr>type</tr>
                        <tr><input type=\"text\" name=\"type\" value='$type' required> </tr>  
                        <tr>versie</tr>
                        <tr><input type=\"number\" name=\"version\" value='$version' required> </tr> <br/>
                        <tr>opdrachtnummer</tr> <br/>
                        <tr><input type=\"text\" name=\"task_nr\" value='$task_nr' required> </tr> <br/>
                        <tr>beschrijving</tr> <br/>
                        <tr><textarea rows=\"4\" cols=\"50\" type='text' name=\"description\"  required>$description</textarea></tr>  <br/>
                        <tr>status</tr> <br/>
                        <tr>
                        <select name='status' value='$status'>                      
                              <option value=\"pending\">pending</option>
                              <option value=\"1\">1</option>
                              <option value=\"2\">2</option>
                              <option value=\"3\">3</option>
                            </select>
                        </tr>  <br/>
                        <tr>eind datum</tr><br/>
                        <tr><input type=\"date\" name=\"end_date\" value='$end_date' required> </tr> 
                                    
                       
                    
                    
                        <td colspan=\"2\"><input type=\"reset\" name=\"reset\" value=\"Leeg maken\">
                                        <input type=\"submit\" name=\"submit\" value=\"Opslaan\">
                    					
                </table>
            </form>   
            </div>
            </div>";
}
getFooter();
?>