<?php
require_once '../system/session.php';

include_once('../system/config.php');

include_once('../templates/content.php');
getHeader("overzicht", "Sqites SLA");

if (isset($_SESSION['id'])) {

    checkRole('admin');

    echo '<div class="right-panel">';

    getTopPanel("overzicht formulier") ;

    try {
/*        $query = $conn->prepare("SELECT f.form_id =:form_id, com.company_id =:company_id, f.type =:type,
                                                      f.version=:version, f.task_nr=:task, f.description=:description, 
                                                      f.signed_date=:signed_date, f.modified_date=:modified_date, f.created_date=:created_date
                                          FROM `form` as f 
                                          INNER JOIN `company` as com ON com.company_id = f.company_id
                                         ");*/

        $query = $conn->prepare("SELECT t.*
                                          FROM `terms` as t                                                                        
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
            <th>form_id</th>         
            <th>company_id</th> 
            <th>version</th>
            <th>description</th>
            <th>status</th>
            <th>created_date</th>
            <th>acties</th>
            </tr>";


    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $form_id = $row['terms_id'];
        $version = $row['acceptance'];
        $description = $row['service_level_agreement'];
        $status = $row['signature'];
        $contact = $row['contact'];
        $created_date = $row['created_date'];

        echo "<tr>
                <td>$form_id</td>                        
                <td>$version</td>             
                <td>$description</td>              
                <td>$status</td>
                <td>$contact</td>
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






