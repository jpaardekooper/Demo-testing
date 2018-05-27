<?php
require_once '../system/session.php';

include_once('../system/config.php');

include_once('../templates/content.php');
getHeader("FOrmulier toevoegen", "Sqites indexform");


if (isset($_SESSION['id'])) {


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






