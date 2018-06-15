<?php
require_once '../system/session.php';

include_once('../system/config.php');

include_once('../templates/content.php');
getHeader("overzicht", "Sqites SLA");

if (isset($_SESSION['id'])) {

    checkRole('admin');

    echo '<div class="content-wrapper">';
    echo '<div class="container-fluid">';

    getTopPanel("overzicht"," formulier") ;

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


    echo " <div class=\"card mb-3\">
                <div class=\"card-header\">
                    <i class=\"fa fa-table\"></i></div>
                <div class=\"card-body\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-bordered\" id=\"table_id\" width=\"100%\" cellspacing=\"0\">                                                   
                        <thead>
                            <tr>
                             <th>Terms_id</th>         
                             <th>Acceptatie</th> 
                             <th>Service level agreement</th>
                             <th>Ondertekening</th>
                             <th>Contract</th>
                             <th>Gemaakt op</th>
                             <th>Acties</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                              <th>Terms_id</th>         
                             <th>Acceptatie</th> 
                             <th>Service level agreement</th>
                             <th>Ondertekening</th>
                             <th>Contract</th>
                             <th>Gemaakt op</th>
                             <th>Acties</th>
                            </tr>
                        </tfoot>
                     <tbody>
                        ";


    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $terms_id = $row['terms_id'];
        $acceptance = $row['acceptance'];
        $description = $row['service_level_agreement'];
        $signature = $row['signature'];
        $contract = $row['contract'];
        $created_date = $row['created_date'];

        if(strlen($acceptance) > 20) $acceptance = substr($acceptance, 0, 20).'...';
        if(strlen($description) > 20) $description = substr($description, 0, 20).'...';
        if(strlen($signature) > 20) $signature = substr($signature, 0, 20).'...';
        if(strlen($contract) > 20) $contract = substr($contract, 0, 20).'...';

        echo "<tr>
                <td>$terms_id</td>   
                 <td>$acceptance</td>                           
                <td>$description</td> 
                <td>$signature</td>
                <td>$contract</td>
                <td>$created_date</td>
             
                    <td>
                     <a href=\"update.php?action=update&id=$terms_id\"><i class='fa fa-edit'></i> Wijzigen</a>
                    <a onclick=\"return confirm('Weet u zeker dat u terms id: $terms_id het wilt verwijderen?')\" href=\"delete.php?action=delete&id=$terms_id\"><i class='fa fa-trash-o text-danger'></i></a>
                       
                       </td>
                            </tr>";
    }
    echo "       </tbody>
            </table>
          </div>
        </div>       
      </div>
    </div>";

    getFooter();

}else {
    echo "please login first on login page";
    header("Location:../login.php");
    exit;
}


getFooter();
echo "</div>";
?>






