<?php
require_once '../system/session.php';

include_once('../system/config.php');

include_once('../templates/content.php');
getHeader("FOrmulier toevoegen", "Sqites indexform");
if(isset($_SESSION['id'] )){
    checkRole("user");

    try {
        $query = $conn->prepare("SELECT user_id, username, password, last_visit, company_name, created_date, role FROM `user` WHERE user_id = :id");
        $query->execute(array(
            'id'=> $_SESSION['id']['user_id']
        ));
    } catch (PDOException $e) {
        $sMsg = '<p> 
                    Regulnummer: ' . $e->getLine() . '<br /> 
                    Bestand: ' . $e->getFile() . '<br /> 
                    Foutmedling: ' . $e->getMessage() .
            '</p>';
        trigger_error($sMsg);
    }
    echo ' <div class="dashboard">';
    getSidebar();

    echo '<div class="right-panel">';


    echo "<table border=\"0\" name=\"user overzicht\"
            <tr>
            <td>userID</td>
            <td>username</td>
            <td>password</td>
            <td>last_visit</td>
            <td>active</td>
            <td>created_date</td>
            </tr>";


    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $password = $row['password'];
        $last_visit = $row['last_visit'];
        $created_date = $row['created_date'];
        $role = $row['role'];
        $company_name = $row['company_name'];

        echo "<tr>
                <td>".htmlentities($user_id)."</td>
                <td>".htmlentities($username)."</td>
                <td>".htmlentities($password)."</td>
                <td>".htmlentities($last_visit)."</td>  
                <td>".htmlentities($created_date)."</td>
                <td>".htmlentities($role)."</td>
                <td>".htmlentities($company_name)."</td>
             
                    <td><a href=\"delete.php?action=delete&id=$user_id\">X</a>
                        <a href=\"update.php?action=delete&id=$user_id\">edit</a></td>
                            </tr>";
    }
    echo "</table>";
    echo "</div>";

}

elseif (isset($_SESSION['id'])) {

    checkRole('admin');

    try {
        $query = $conn->prepare("SELECT * FROM `user`");
        $query->execute();
    } catch (PDOException $e) {
        $sMsg = '<p> 
                    Regulnummer: ' . $e->getLine() . '<br /> 
                    Bestand: ' . $e->getFile() . '<br /> 
                    Foutmedling: ' . $e->getMessage() .
            '</p>';
        trigger_error($sMsg);
    }
    echo ' <div class="dashboard">';
    getSidebar();

    echo '<div class="right-panel">';


    echo "<table border=\"0\" name=\"user overzicht\"
            <tr>
            <td>userID</td>
            <td>username</td>
            <td>password</td>
            <td>last_visit</td>
            <td>active</td>
            <td>created_date</td>
            </tr>";


    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $password = $row['password'];
        $last_visit = $row['last_visit'];
        $active = $row['active'];
        $created_date = $row['created_date'];

        echo "<tr>
                <td>$user_id</td>
                <td>$username</td>
                <td>$password</td>
                <td>$last_visit</td>              
                <td>$active</td>
                <td>$created_date</td>
             
                    <td><a href=\"delete.php?action=delete&id=$user_id\">X</a>
                        <a href=\"update.php?action=delete&id=$user_id\">edit</a></td>
                            </tr>";
    }
    echo "</table>";
    echo "</div>";

} else {

    echo "login eerst in op login.php";
    echo " <p><a href='../login.php'>inloggen</a>";

    header("Refresh: 1; URL=\"../login.php\"");
    exit;
}


getFooter();
echo "</div>";
?>






