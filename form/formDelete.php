<?php
include_once('../templates/functions.php');
	
	getHeader("Categorie Verwijderen", "Webshop de vrolijke snuiter - Categorie Verwijderen");
	
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