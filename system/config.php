<?php
require_once 'function.php';

//Initalisatie databasevariabelen
$conn = array (
    'host' => 'localhost',
    'dbname' => 'software_update',
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
            Line number: '.$e->getLine().'<br />
            File: '.$e->getFile().'<br />
            Error Message: '.$e->getMessage().'<br/>
        </p>';

    trigger_error($sMsg);
}
