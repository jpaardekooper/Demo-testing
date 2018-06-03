<?php
require_once('../system/session.php');
require_once('../system/config.php');

require_once('../templates/content.php');



try {
    $query = $conn->prepare("SELECT u.*, com.*, p.* 
                                        FROM user as u  
                                        INNER JOIN company as com ON com.user_id = u.user_id
                                        INNER JOIN phone as p ON p.user_id = u.user_id
                                        WHERE u.user_id = :user_id
                                         ");
    $query->execute(array(
        'user_id' => $_GET['u']
    ));
} catch (PDOException $e) {
    $sMsg = '<p> 
                    Line number: ' . $e->getLine() . '<br /> 
                    File: ' . $e->getFile() . '<br /> 
                    Error message: ' . $e->getMessage() .
        '</p>';
    trigger_error($sMsg);
}

echo "<table>
    <tr>
        <th>Company_id</th>
        <th>bedrijfsnaam</th>
        <th>Firstname</th>     
        <th>Lastname</th>
        <th>zip_code</th>
        <th>address</th>
        <th>location</th>
        <th>email</th>
    </tr>";

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $company_id = $row['company_id'];
    $company_id = $row['company_name'];
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $zip_code = $row['zip_code'];
    $address = $row['address'];
    $location = $row['location'];
    $email = $row['email'];

    echo "<tr>";
    echo "<td>" . $row['company_id'] . "</td>";
    echo "<td>" . $row['company_name'] . "</td>";
    echo "<td>" . $row['first_name'] . "</td>";
    echo "<td>" . $row['last_name'] . "</td>";
    echo "<td>" . $row['zip_code'] . "</td>";
    echo "<td>" . $row['address'] . "</td>";
    echo "<td>" . $row['location'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "</tr>";

}
echo "</table>";

getFooter();