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
                            " . getUserName() . "
                         </p>
        
                         this is update form
                     </header>
                </div>            
            ";

            getFooter();
            break;
        case "admin":

            getHeader("Sqits", "Admin update acceptance");

            echo "<div class='content-wrapper'>";
            echo "<div class='container-fluid'>";

            getBreadCrumbs();

            getTopPanel("update overzicht");


            try {
                $query = $conn->prepare("SELECT f.*, u.*, up.*, c.*
                                          FROM `update` as up                                           
                                          INNER JOIN `company` as c ON up.company_id = c.company_id 
                                          INNER JOIN `user` as u ON u.company_id = c.company_id   
                                          INNER JOIN `form` as f ON up.form_id = f.form_id                                 
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
                    <i class=\"fa fa-table\"></i> Data Table Example</div>
                <div class=\"card-body\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-bordered\" id=\"table_id\" width=\"100%\" cellspacing=\"0\">                                                   
                        <thead>
                            <tr>
                              <th>form_id</th>         
                              <th>company_id</th>      
                              <th>type</th>
                              <th>version</th>
                              <th>description</th>
                              <th>status</th>
                              <th>created_date</th>
                              <th>actie</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>form_id</th>         
                                <th>company_id</th>      
                                <th>type</th>
                                <th>version</th>
                                <th>description</th>
                                <th>status</th>
                                <th>created_date</th>
                                <th>actie</th>
                            </tr>
                        </tfoot>
                     <tbody>
                        ";

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $form_id = $row['form_id'];
                $company_id = $row['company_id'];
                $type = $row['type'];
                $version = $row['version'];
                $description = $row['description'];
                $status = $row['status'];
                $created_date = $row['created_date'];

                if (strlen($description) > 20) $description = substr($description, 0, 20) . '...';

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
            echo "       </tbody>
            </table>
          </div>
        </div>       
      </div>
    </div>";

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
