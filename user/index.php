<?php
require_once('../system/session.php');
require_once('../system/config.php');

require_once('../templates/content.php');

if ($_SESSION["id"]) {
    checkRole("admin");
    switch (getUserRole()) {
        case "user":
            header("Refresh: 0; URL=\"../dashboard/index.php\"");
            break;
        case "admin":
            getHeader("Sqits", "overzicht klanten");
            try {
                $query = $conn->prepare("SELECT u.*, p.*, c.*
                                          FROM `user` as u
                                          INNER JOIN company as c  ON u.company_id = c.company_id  
                                          LEFT JOIN phone as p ON u.user_id = p.user_id                                                                                                                            
                                          ");
                $query->execute();

            } catch (PDOException $e) {
                $sMsg = '<p> 
                    Regulnummer: ' . $e->getLine() . '<br /> 
                    Bestand: ' . $e->getFile() . '<br /> 
                    Foutmedling: ' . $e->getMessage() .
                    '</p>';
                trigger_error($sMsg);
            }


            echo '<div class="content-wrapper">';
            echo '<div class="container-fluid">';


            getTopPanel("overzicht", " gebruikers");


            echo " <div class=\"card mb-3\">
                <div class=\"card-header\">
                    <i class=\"fa fa-table\"></i> Data Table Example</div>
                <div class=\"card-body\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-bordered\" id=\"table_id\" width=\"100%\" cellspacing=\"0\">                                                   
                        <thead>
                            <tr>
                             <th>bedrijfsnaam</th>
                             <th>Email: </th>
                             <th>voornaam</th>
                             <th>achternaam</th>           
                             <th>Contact persoon Tel</th>
                             <th>Bedrijfs Tel</th>
                             <th>account status</th>
                             <th>laatse bezoek</th>
                             <th>Gemaakt op</th>
                             <th>acties</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>bedrijfsnaam</th>
                             <th>Email: </th>
                             <th>voornaam</th>
                             <th>achternaam</th>           
                             <th>Contact persoon Tel</th>
                             <th>Bedrijfs Tel</th>
                             <th>account status</th>
                             <th>laatse bezoek</th>
                             <th>Gemaakt op</th>
                             <th>acties</th>
                            </tr>
                        </tfoot>
                     <tbody>";


            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $user_id = $row['user_id'];
                $first_name = $row['first_name'];
                $last_name = $row['last_name'];
                $email = $row['email'];
                $last_visit = $row['last_visit'];
                $active = $row['status'];
                $created_date = $row['created_date'];
                $role = $row['role'];
                $company_name = $row['company_name'];
                $phoneU = $row['phone_number'];
                $phoneC = $row['phone'];

                echo "<tr>
                <td><a href=\"update.php?action=delete&id=$user_id\">" . htmlentities($company_name) . "</a></td>                           
                <td>" . htmlentities($email) . "</td> 
                <td>" . htmlentities($first_name) . "</td>
                <td>" . htmlentities($last_name) . "</td>
                   <td>" . htmlentities($phoneU) . "</td>
                   <td>" . htmlentities($phoneC) . "</td>
                <td>" . htmlentities($active) . "</td>
                  <td>" . htmlentities($last_visit) . "</td>            
                <td>" . htmlentities($created_date) . "</td>          
              
             
             
                    <td> <a href=\"update.php?action=update&id=$user_id\"><i class='fa fa-edit'></i> Wijzigen</a>
                    <a onclick=\"return confirm('Weet u zeker dat u het bedrijf < $company_name >  contactpersoon < $first_name $last_name > het wilt verwijderen?')\" href=\"delete.php?action=delete&id=$user_id\"><i class='fa fa-trash-o text-danger'></i></a></td>
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
    }//stops the switch
} else {
    echo "please login first on login page";
    header("Location:../login.php");
    exit;
}

