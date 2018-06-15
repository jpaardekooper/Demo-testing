<?php
require_once '../system/session.php';

include_once('../system/config.php');

include_once('../templates/content.php');
getHeader("FOrmulier toevoegen", "Sqites indexform");

if (isset($_SESSION['id'])) {

    checkRole('admin');

    echo '<div class="content-wrapper">';
    echo '<div class="container-fluid">';
    getTopPanel("overzicht", " formulier");

    try {
        /*        $query = $conn->prepare("SELECT f.form_id =:form_id, com.company_id =:company_id, f.type =:type,
                                                              f.version=:version, f.task_nr=:task, f.description=:description,
                                                              f.signed_date=:signed_date, f.modified_date=:modified_date, f.created_date=:created_date
                                                  FROM `form` as f
                                                  INNER JOIN `company` as com ON com.company_id = f.company_id
                                                 ");*/

        $query = $conn->prepare("SELECT f.*, t.*
                                          FROM `form` as f 
                                          INNER JOIN `terms` as t ON f.terms_id = t.terms_id                                       
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

    echo " <div class=\"card mb-3\">
                <div class=\"card-header\">
                    <i class=\"fa fa-table\"></i></div>
                <div class=\"card-body\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-bordered\" id=\"table_id\" width=\"100%\" cellspacing=\"0\">                                                   
                        <thead>
                            <tr>
                              <th>form_id</th>         
                                <th>terms_id</th>      
                                <th>type</th>
                                <th>opdrachtnummer</th>
                                <th>version</th>
                                <th>description</th>                               
                                <th>created_date</th>
                                 <th>modified_date</th>
                                <th>acties</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                               <th>form_id</th>         
                                <th>terms_id</th>      
                                <th>type</th>
                                <th>opdrachtnummer</th>
                                <th>version</th>
                                <th>description</th>                               
                                <th>created_date</th>
                                 <th>modified_date</th>
                                <th>acties</th>
                            </tr>
                        </tfoot>
                     <tbody>
                        ";


    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $form_id = $row['form_id'];
        $terms_id = $row['terms_id'];
        $type = $row['type'];
        $task_nr = $row['task_nr'];
        $version = $row['version'];
        $description = $row['description'];
        $created_date = $row['created_date'];
        $modified_date = $row['modified_date'];

        if (strlen($description) > 20) $description = substr($description, 0, 20) . '...';


        echo "<tr>
                <td>$form_id</td>
                <td>$terms_id</td>
                <td>$type</td>
                <td>$task_nr</td>
                <td>$version</td>             
                <td>$description</td> 
                <td>$created_date</td>
                <td>$modified_date</td>
             
                    <td>   <a href=\"update.php?action=update&id=$form_id\"><i class='fa fa-edit'></i> Wijzigen</a>
                    <a onclick=\"return confirm('Weet u zeker dat u het wilt verwijderen?')\" href=\"delete.php?action=delete&id=$form_id\"><i class='fa fa-trash-o text-danger'></i></a>
                            </tr>";
    }
    echo "       </tbody>
            </table>
          </div>
        </div>        
      </div>
      </div>
    </div>";

    getFooter();

} else {
    echo "please login first on login page";
    header("Location:../login.php");
    exit;
}
?>






