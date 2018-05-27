<?php
require_once '../system/session.php';

include_once('../system/config.php');

include_once('../templates/content.php');

getHeader("Sqits form-add", "Form add");

if (@$_GET['action'] == "save")
{
	try
    {

//http://php.net/manual/en/password.constants.php

        $sql = "INSERT INTO `user` (`username`, `password`, `last_visit`, `active`, `created_date`) VALUES (:username, :password, NOW(), :active, NOW() )";
        $ophalen = $conn->prepare($sql);
        $ophalen->execute(array(
            'username' => $_POST['username'],
            'password' => password_hash($_POST['password'],PASSWORD_DEFAULT),
            'active' => $_POST['active']

        ));


        echo "De user is opgeslagen.";

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
	echo "
          	<form name=\"add\" action=\"?action=save\" method=\"post\">
                <table>
                    <tr>
                        <td>user toevoegen</td>
                        <td><input type=\"text\" name=\"username\" required> </td>   
                        <td><input type=\"text\" name=\"password\" required> </td>  
                        <td><input type=\"active\" name=\"active\" required> </td>
              
                    </tr>
                    <tr>
                        <td colspan=\"2\"><input type=\"reset\" name=\"reset\" value=\"Clear\">
                                        <input type=\"submit\" name=\"submit\" value=\"Opslaan\"></td>
                    </tr>					
                </table>
            </form>";
}
getFooter();	

?>