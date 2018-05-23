<?php

include_once('../templates/functions.php');



getHeader("FOrmulier toevoegen", "SQits add form");

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

echo"<table border=\"0\" name=\"categorieoverzicht\"
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
                    <td><a href=\"formDelete.php?action=delete&id=$user_id\"><img src=\"../img/delete.jpg\"></a>
                        <a href=\"formUpdate.php?action=delete&id=$user_id\"><img src=\"../img/edit.jpg\"></a></td>
                            </tr>";
}
echo "</table>";

getFooter();
