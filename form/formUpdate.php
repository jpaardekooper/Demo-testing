<?php

include_once('../templates/config.php');
include_once('../templates/content.php');

	getHeader("Sqits", "FormUpdate ");
	
    if($_GET['action'] == "save")
    {
        $id = $_GET["id"];
        $password = $_POST['password'];
        
        try
        {
            $query = $conn->prepare("
                        UPDATE `user` SET `password` = '$password' WHERE user_id = '$id'");
            $query->execute();
            echo "De wachtwoord is gewijzigd.";
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
    else
    {
    	$id = $_GET["id"];
        
        try
        {
            $query = $conn->prepare("
                        SELECT * FROM user WHERE user_id = '$id'");
                                   
            $query->execute();
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
            
        while ($row = $query->fetch(PDO::FETCH_ASSOC))
        {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $password = $row['password'];
            $last_visit = $row['last_visit'];
            $active = $row['active'];
            $created_date = $row['created_date'];
        }
        
        

        echo "
            <form name=\"formAdd\" action=\"?action=save&id=$id\" method=\"post\">
                <table>
                    <tr>
                        <td>Wachtwoord naam</td>
                        <td><input type=\"text\" name=\"password\" value=\"$password\" required> </td>
                    </tr>
                    <tr>
                        <td colspan=\"2\"><input type=\"reset\" name=\"reset\" value=\"Leeg maken\">
                                        <input type=\"submit\" name=\"submit\" value=\"Opslaan\"></td>
                    </tr>					
                </table>
            </form>";
    }
	getFooter();	
?>