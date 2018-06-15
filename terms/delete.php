<?php
require_once '../system/session.php';

include_once('../system/config.php');

include_once('../templates/content.php');

if(isset($_SESSION['id'])){


    
	if(@$_GET['action'] == "delete")
	{	
        
        try
        {
            $query=$conn->prepare("
                        DELETE FROM `terms` WHERE `terms_id` = :terms_id;");
            $query->execute(array(
                'terms_id' =>$_GET['id']
            ));
            header('Location: index.php');
            echo "succesvol verwijderd";
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
    getHeader("Sqits form-delete", "Form delete");
	getFooter();
}else {
    echo "please login first on login page";
    header("Location:../login.php");
    exit;
}

?>