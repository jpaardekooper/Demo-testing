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

echo "<table>
    <tr>
        <th>form_id</th>
        <th>company_id</th>
        <th>type</th>     
        <th>task_nr</th>
        <th>description</th>
        <th>end_date</th>
        <th>terms_id</th>
        <th>accaptance</th>
        <th>SLA</th>
        <th>contact</th>
        <th>signature</th>      
        <th>image</th>      
    </tr>";

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

    echo "<tr>";
    echo "<td>" . $row['form_id'] . "</td>";
    echo "<td>" . $row['company_id'] . "</td>";
    echo "<td>" . $row['type'] . "</td>";
    echo "<td>" . $row['task_nr'] . "</td>";
    echo "<td>" . $row['description'] . "</td>";
    echo "<td>" . $row['end_date'] . "</td>";
    echo "<td>" . $row['terms_id'] . "</td>";
    echo "<td>" . $row['acceptance'] . "</td>";
    echo "<td>" . $row['service_level_agreement'] . "</td>";
    echo "<td>" . $row['contact'] . "</td>";
    echo "<td>" . $row['signature'] . "</td>";
    echo "<td>" . $row['image'] . "</td>";
    echo "</tr>";

}
echo "</table>";

getFooter();