<?php

require_once '../system/session.php';

include_once('../system/config.php');

include_once('../templates/content.php');

getHeader("Sqits form-update", "Form update");

if ($_GET['action'] == "save") {

    try {
        $query = $conn->prepare("
                        UPDATE `user` SET username = :username, password = :password, active = :active WHERE user_id = :id");
        $query->execute(array(
            'id' => $_GET['id'],
            'username' => $_POST['username'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'active' => $_POST['active']
        ));
        echo "wijzigingen zijn opgeslagen.";
    } catch (PDOException $e) {
        $sMsg = '<p>
                    Line Number: ' . $e->getLine() . '<br />
                    File: ' . $e->getFile() . '<br />
                    Error Message: ' . $e->getMessage() . '
                </p>';

        trigger_error($sMsg);
    }
} else {


    try {
        $query = $conn->prepare("
                        SELECT * FROM user WHERE user_id = :id");

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
        $user_id = $row['user_id'];
        $username = $row['username'];
        $password = $row['password'];
        $last_visit = $row['last_visit'];
        $active = $row['active'];
        $created_date = $row['created_date'];
    }


    echo ' <div class="dashboard">';
    getSidebar();

    echo '<div class="right-panel">';
    echo "
    


    <header class='header'>
        <p>welkom: <?= getUserName(); ?></p>
        <p>
            is user role: " . $_SESSION['id']['role'] . "
        </p>

        this is form edit
    </header>


            <form name=\"add\" action=\"?action=save&id=$user_id\" method=\"post\">
                <table>
                    
                        id
                        <input type=\"text\" name=\"id\" value=\"$user_id\" required> 
                    
                    
                        username
                        <input type=\"text\" name=\"username\" value=\"$username\" required> 
                    
                     
                        status active
                        <input type=\"text\" name=\"active\" value=\"$active\" required> 
                    
                    
                        Wachtwoord 
                        <input type=\"text\" name=\"password\" value=\"$password\" required> 
                    
                    
                        <td colspan=\"2\"><input type=\"reset\" name=\"reset\" value=\"Leeg maken\">
                                        <input type=\"submit\" name=\"submit\" value=\"Opslaan\">
                    					
                </table>
            </form>
   
            </div>
            </div>";
}
getFooter();
?>