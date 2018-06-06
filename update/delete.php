<?php
require_once '../system/session.php';

include_once('../system/config.php');

include_once('../templates/content.php');

getHeader("Sqits form-delete", "Form delete");

checkRole("admin");

//	$id = $_GET['id'];
//	$_SESSION['id']['user_id'];
    
	if(@$_GET['action'] == "delete")
	{	
        
        try
        {
            $query=$conn->prepare("
                        DELETE FROM `update` WHERE `update_id` = :id");
            $query->execute(array(
                'id' => $_GET['id']
            ));
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