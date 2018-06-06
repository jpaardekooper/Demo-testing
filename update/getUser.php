<?php
require_once('../system/session.php');
require_once('../system/config.php');

require_once('../templates/content.php');

checkRole("admin");


try {
    $query = $conn->prepare("SELECT u.*, com.*, p.* 
                                        FROM user as u  
                                        INNER JOIN company as com ON com.company_id = u.company_id
                                        INNER JOIN phone as p ON p.user_id = u.user_id
                                        WHERE u.company_id = :company_id
                                         ");
    $query->execute(array(
        'company_id' => $_GET['u']
    ));
} catch (PDOException $e) {
    $sMsg = '<p> 
                    Line number: ' . $e->getLine() . '<br /> 
                    File: ' . $e->getFile() . '<br /> 
                    Error message: ' . $e->getMessage() .
        '</p>';
    trigger_error($sMsg);
}



while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $company_id = $row['company_id'];
    $company_id = $row['company_name'];
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $zip_code = $row['zip_code'];
    $address = $row['address'];
    $location = $row['location'];
    $email = $row['email'];

 
    echo "<p>Bedrijfs ID</p>";
    echo "<p>" . $row['company_id'] . "</p>";
    echo "<p>Bedrijfs naam</p>";
    echo "<p>" . $row['company_name'] . "</p>";
    echo "<p>voornaam</p>";
    echo "<p>" . $row['first_name'] . "</p>";
    echo "<p>achternaam</p>";
    echo "<p>" . $row['last_name'] . "</p>";
    echo "<p>postcode</p>";
    echo "<p>" . $row['zip_code'] . "</p>";
    echo "<p>adres</p>";
    echo "<p>" . $row['address'] . "</p>";
    echo "<p>woonplaats</p>";
    echo "<p>" . $row['location'] . "</p>";
    echo "<p>bedrijfsmail</p>";
    echo "<p>" . $row['email'] . "</p>";


}
echo "</table>";

getFooter();