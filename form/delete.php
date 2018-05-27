<?php
require_once '../system/session.php';

include_once('../system/config.php');

include_once('../templates/content.php');

getHeader("Sqits form-delete", "Form delete");

	
	getHeader("formuleir  Verwijderen", "Sqits de vrolijke snuiter - form Verwijderen");
	
	$id = $_GET['id'];
    
	if(@$_GET['action'] == "delete")
	{	
        
        try
        {
            $query=$conn->prepare("
                        DELETE FROM `user` WHERE `user_id` = '$id';");
            $query->execute();
            header('Location: index.php');
        }
        catch(PDOException $e)
        {
            $sMsg = '<p>
                    Regelnummer: '.$e->getLine().'<br />
                    Bestand: '.$e->getFile().'<br />
                    Foutmelding: '.$e->getMessage().'
                </p>';

            trigger_error($sMsg);
        }           
    }
    
	getFooter();	
?>