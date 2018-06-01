<?php
require_once '../system/session.php';

include_once('../system/config.php');

include_once('../templates/content.php');
getHeader("FOrmulier toevoegen", "Sqites indexform");

if (isset($_SESSION['id'])) {

    checkRole('admin');

    echo '<div class="right-panel">';

    try {
/*        $query = $conn->prepare("SELECT f.form_id =:form_id, com.company_id =:company_id, f.type =:type,
                                                      f.version=:version, f.task_nr=:task, f.description=:description, 
                                                      f.signed_date=:signed_date, f.modified_date=:modified_date, f.created_date=:created_date
                                          FROM `form` as f 
                                          INNER JOIN `company` as com ON com.company_id = f.company_id
                                         ");*/

        $query = $conn->prepare("SELECT f.*, com.*
                                          FROM `form` as f 
                                          INNER JOIN `company` as com ON com.company_id = f.company_id                                       
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

} else {

    echo "login eerst in op login.php";
    echo " <p><a href='../login.php'>inloggen</a>";

    header("Refresh: 1; URL=\"../login.php\"");
    exit;
}


getFooter();
echo "</div>";
?>






