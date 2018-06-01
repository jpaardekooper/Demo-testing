<?php
require_once('../system/session.php');
require_once('../system/config.php');

require_once('../templates/content.php');

if ($_SESSION["id"]) {

    switch (getUserRole()) {
        case "user":

            getHeader("Sqits", "user Dashboard");

            echo "     
                <div class='right-panel'>
                     <header>
                         <p>welkom: " . getUserName() . "</p>
                         <p>
                            ". getUserName() . "
                         </p>
        
                         this is update form
                     </header>
                </div>            
            ";

            getFooter();
            break;
        case "admin":

            getHeader("Sqits", "Admin update acceptance");

            echo "     
               <div class='right-panel'>
                     <header>
                         <p>welkom: " . getUserName() . "</p>
                         <p>
                             is user active: " . $_SESSION['id']['role'] . "
                         </p>
        
                         this is update form
                     </header>
                           
            ";
            try {
                /*        $query = $conn->prepare("SELECT f.form_id =:form_id, com.company_id =:company_id, f.type =:type,
                                                                      f.version=:version, f.task_nr=:task, f.description=:description,
                                                                      f.signed_date=:signed_date, f.modified_date=:modified_date, f.created_date=:created_date
                                                          FROM `form` as f
                                                          INNER JOIN `company` as com ON com.company_id = f.company_id
                                                         ");*/

                $query = $conn->prepare("SELECT f.*, user.*, u.*
                                          FROM `update` as u
                                          INNER JOIN `user` as user ON user.user_id = u.user_id      
                                          INNER JOIN `form` as f ON u.form_id = f.form_id                                 
                                         ");
                $query->execute();
            } catch (PDOException $e) {
                $sMsg = '<p> 
                    Line number: ' . $e->getLine() . '<br /> 
                    File: ' . $e->getFile() . '<br /> 
                    Error message: ' . $e->getMessage() .
                    '</p>';
                trigger_error($sMsg);
            }




            echo "<table name='form_overview'
            <tr>
            <td>form_id</td>         
            <td>company_id</td>      
            <td>type</td>
            <td>version</td>
            <td>description</td>
            <td>status</td>
            <td>created_date</td>
            </tr>";


            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $form_id = $row['form_id'];
                $company_id = $row['company_id'];
                $type = $row['type'];
                $version = $row['version'];
                $description = $row['description'];
                $status = $row['status'];
                $created_date = $row['created_date'];

                echo "<tr>
                <td>$form_id</td>
                <td>$company_id</td>
                <td>$type</td>
                <td>$version</td>             
                <td>$description</td>              
                <td>$status</td>
                <td>$created_date</td>
             
                    <td><a href=\"delete.php?action=delete&id=$form_id\">X</a>
                        <a href=\"update.php?action=delete&id=$form_id\">edit</a></td>
                            </tr>";
            }
            echo "</table>";
            echo "</div>";

            getFooter();
            break;
        default:

            trigger_error("Invalid role specified: " . $role, E_USER_WARNING);


    }
} else {
    echo "please login first on login page";
    header("Refresh: 1; URL=\"../login.php\"");
    exit;
}
