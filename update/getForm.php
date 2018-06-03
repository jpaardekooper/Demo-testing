<?php
require_once('../system/session.php');
require_once('../system/config.php');

require_once('../templates/content.php');



try {
    $query = $conn->prepare("SELECT f.*, t.*
                                        FROM form as f  
                                        INNER JOIN terms as t ON f.terms_id = t.terms_id                                      
                                        WHERE f.form_id = :form_id
                                         ");
    $query->execute(array(
        'form_id' => $_GET['f']
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
    $form_id = $row['form_id'];
    $company_id = $row['company_id'];
    $type = $row['type'];
    $task_nr = $row['task_nr'];
    $description = $row['description'];
    $end_date = $row['end_date'];
    $terms_id = $row['terms_id'];
    $acceptance = $row['acceptance'];
    $SLA = $row['service_level_agreement'];
    $contact = $row['contact'];
    $signature = $row['signature'];
    $image = $row['image'];


    echo "<p>form ID</p>";
    echo "<p>" . $row['form_id'] . "</p>";
    echo "<p>Bedrijfs ID</p>";
    echo "<p>" . $row['company_id'] . "</p>";
    echo "<p>Type</p>";
    echo "<p>" . $row['type'] . "</p>";
    echo "<p>opdrachtgever:</p>";
    echo "<p>" . $row['task_nr'] . "</p>";
    echo "<p>beschrijving</p>";
    echo "<p>" . $row['description'] . "</p>";
    echo "<p>einddatum</p>";
    echo "<p>" . $row['end_date'] . "</p>";
    echo "<p>Terms ID</p>";
    echo "<p>" . $row['terms_id'] . "</p>";
    echo "<p>acceptance</p>";
    echo "<p>" . $row['acceptance'] . "</p>";
    echo "<p>SLA</p>";
    echo "<p>" . $row['service_level_agreement'] . "</p>";
    echo "<p>Contact</p>";
    echo "<p>" . $row['signature'] . "</p>";
    echo "<p>Ondertekening</p>";
    echo "<p>" . $row['image'] . "</p>";


}


getFooter();