<?php

require_once '../system/session.php';

include_once('../system/config.php');

include_once('../templates/content.php');



if ($_GET['action'] == "save") {

    try {
        $query = $conn->prepare("
                        UPDATE `user` as u 
                        INNER JOIN `phone` as p ON u.user_id = p.user_id
                        INNER JOIN `company` as com ON u.user_id = com.user_id
                        SET 
                        u.email = :email, u.password = :password, u.active = :active,
                        p.phone_number = :phone_number,
                        com.company_name = :company_name, com.first_name = :first_name, com.last_name = :last_name                                  
                        WHERE u.user_id = :user_id   
                        AND com.user_id = :user_id
                        AND p.user_id = :user_id                 
                        ");
        $query->execute(array(
            'user_id' => $_GET['id'],
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'active' => $_POST['active'],
            'phone_number' => $_POST['phone_number'],
            'company_name' => $_POST['company_name'],
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
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

    echo "<div class='content-wrapper'>";
    echo "<div class='container-fluid'>";
    getBreadCrumbs();
    getTopPanel("Gegevens wijzigen");

    try {
        $query = $conn->prepare("
                        SELECT  u.*, p.*, com.*
                                          FROM `user` as u
                                          INNER JOIN company as com  ON u.user_id = com.user_id  
                                          INNER JOIN phone as p ON u.user_id = p.user_id    
                                          WHERE u.user_id =:user_id");

        $query->execute(array(
            'user_id' => $_GET['id']
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
        $user_id = $row['user_id'];
        $company_name = $row['company_name'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $phone_number = $row['phone_number'];
        $email = $row['email'];
        $active = $row['active'];
        $password = $row['password'];
    }
    getFooter();

    echo "
            
            <form name=\"add\" action=\"?action=save&id=$user_id\" method=\"post\">
                <table>                  
                     <tr>
                        <td>Bedrijfsnaam</td>
                        <td><input type=\"text\" name=\"company_name\" value=\"$company_name\" required> </td>
                    </tr>
                     <tr>
                        <td>voornaam</td>
                        <td><input type=\"text\" name=\"first_name\" value=\"$first_name\" required> </td>
                    </tr>
                     <tr>
                        <td>achternaam</td>
                        <td><input type=\"text\" name=\"last_name\" value=\"$last_name\" required> </td>
                    </tr>
                     <tr>
                        <td>Telefoon</td>
                        <td><input type=\"text\" name=\"phone_number\" value=\"$phone_number\" required> </td>
                    </tr>
                    <tr>
                        <td>email</td>
                        <td><input type=\"email\" name=\"email\" value=\"$email\" required> </td>
                    </tr>
                     <tr>
                        <td>status active</td>
                        <td><input type=\"text\" name=\"active\" value=\"$active\" required> </td>
                    </tr>
                    <tr>
                        <td>Wachtwoord </td>
                        <td><input type=\"password\" name=\"password\" value=\"$password\" required> </td>
                    </tr>
                    <tr>
                        <td colspan=\"2\"><input type=\"reset\" name=\"reset\" value=\"Leeg maken\">
                                        <input type=\"submit\" name=\"submit\" value=\"Opslaan\"></td>
                    </tr>					
                </table>
            </form>
            </div>      
            </div>      
            ";
}

?>