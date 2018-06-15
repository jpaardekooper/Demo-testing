<?php
require_once('../system/session.php');
require_once('../system/config.php');

require_once('../templates/content.php');

if (isset($_SESSION["id"])) {

    switch (getUserRole()) {
        case "user":

            getHeader("Sqits", "User update index");

            echo "<div class='content-wrapper'>";
            echo "<div class='container-fluid'>";


            getTopPanel("update", " overzicht");

            try {
                $query = $conn->prepare("SELECT f.*, u.*, up.*, c.*
                                          FROM `update` as up                                           
                                          INNER JOIN `company` as c ON up.company_id = c.company_id 
                                          INNER JOIN `user` as u ON u.company_id = c.company_id   
                                          INNER JOIN `form` as f ON up.form_id = f.form_id
                                          WHERE u.user_id = :id                                 
                                         ");
                $query->execute(array(
                    'id' => $_SESSION['id']['user_id']
                ));
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
                              <th>Bedrijfsnaam</th>      
                              <th>Type</th>
                              <th>Versie</th>
                              <th>beschrijving</th>
                              <th>Status</th>
                              <th>Gemaakt op</th>
                              <th>Actie</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>                                     
                              <th>Bedrijfsnaam</th>      
                              <th>Type</th>
                              <th>Versie</th>
                              <th>beschrijving</th>
                              <th>Status</th>
                              <th>Gemaakt op</th>
                              <th>Actie</th>
                            </tr>
                        </tfoot>
                     <tbody>
                        ";

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $update_id = $row['update_id'];
                $form_id = $row['form_id'];
                $company_name = $row['company_name'];
                $type = $row['type'];
                $version = $row['version'];
                $description = $row['description'];
                $status = $row['status'];
                $created_date = $row['created_date'];

                if (strlen($description) > 20) $description = substr($description, 0, 20) . '...';

                //small sql error we had a type in the database

                echo "<tr>             
                <td><a href=\"update.php?action=delete&id=$update_id\">$company_name</a></td>
                <td>$type</td>
                <td>$version</td>             
                <td>$description</td>  ";
                if ($status == 'accepted') {
                    echo "<td> $status <i class=\"fa fa-check-circle fa-fw text-success\"></i></td>";
                } elseif ($status == 'declined') {
                    echo "<td>$status  <i class=\"fa fa-close fa-fw text-danger\"></i></td>";

                } else {
                    echo "<td> $status <i class=\"fa fa-spinner fa-fw text-warning\"></i></td>";
                }
                echo"
                <td>$created_date</td>
                <td><a href=\"update.php?action=delete&id=$update_id\"><i class='fa fa-edit'></i> Wijzigen</a></td>
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
        case "admin":

            getHeader("Sqits", "Admin update acceptance");

            echo "<div class='content-wrapper'>";
            echo "<div class='container-fluid'>";

            getTopPanel("Update", " overzicht");


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
                              <th>Form_id</th>         
                              <th>Company_id</th>      
                              <th>Type</th>
                              <th>Versie</th>
                              <th>Beschrijving</th>
                              <th>Status</th>
                              <th>Gemaakt op</th>
                              <th>Actie</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                              <th>Form_id</th>         
                              <th>Company_id</th>      
                              <th>Type</th>
                              <th>Versie</th>
                              <th>Beschrijving</th>
                              <th>Status</th>
                              <th>Gemaakt op</th>
                              <th>Actie</th>
                            </tr>
                        </tfoot>
                     <tbody>
                        ";

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $update_id = $row['update_id'];
                $form_id = $row['form_id'];
                $company_id = $row['company_id'];
                $type = $row['type'];
                $version = $row['version'];
                $description = $row['description'];
                $status = $row['status'];
                $created_date = $row['created_date'];

                if (strlen($description) > 20) $description = substr($description, 0, 20) . '...';
                //small sql error we had a type in the database
                if ($type == 'mayor-update'){
                    $type = 'major-update';
                }

                echo "<tr>
                <td>$form_id</td>
                <td>$company_id</td>
                <td>$type</td>
                <td>$version</td>             
                <td><a href='../form/update.php?action=delete&id=$form_id'>$description</a></td> 
                ";
                if ($status == 'accepted') {
                    echo "<td>$status  <i class=\"fa fa-check-circle fa-fw text-success\"></i></td>";
                } elseif ($status == 'declined') {
                    echo "<td>$status  <i class=\"fa fa-close fa-fw text-danger\"></i></td>";

                } else {
                    echo "<td> $status <i class=\"fa fa-spinner fa-fw text-warning\"></i></td>";
                }


                echo "
                <td>$created_date</td>
             
                    <td><a onclick=\"return confirm('Weet u zeker dat u het wilt verwijderen?')\" href=\"delete.php?action=update&id=$update_id\"><i class='fa fa-trash-o text-danger'></i></a>
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
            break;
        default:

            trigger_error("Invalid role specified: " . $role, E_USER_WARNING);


    }
}else {
    echo "please login first on login page";
    header("Location:../login.php");
    exit;
}

