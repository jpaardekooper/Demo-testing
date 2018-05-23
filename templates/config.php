<?php

//Initalisatie databasevariabelen
$conn = array (
    'host' => 'localhost',
    'dbname' => 'useragreement',
    'user' => 'root',
    'pass' => 'root'
);

//Databaseverbinding maken
try
{
    $conn = new PDO('mysql:host='.$conn['host'].';dbname='.$conn['dbname'], $conn['user'], $conn['pass']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->query("SET SESSION sql_mode = 'ANSI,ONLY_FULL_GROUP_BY'");
}
catch(PDOException $e)
{
    $sMsg = '<p>
            Linenumber: '.$e->getLine().'<br />
            File: '.$e->getFile().'<br />
            Error Message: '.$e->getMessage().'
        </p>';

    trigger_error($sMsg);
}


?>
<!--//query maken
$query = $conn->prepare();

//query uitvoeren
//hierin kunnen we nog waardes meegeven
/*$query->execute(
[
'id' => $id
]
);*/
$query->execute();

//fetch is 1 waarde terug
//fetchAll is alle waardes terug
$result = $query->FetchAll();

var_dump($result);-->
