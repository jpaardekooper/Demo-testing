<?php
include_once('../templates/config.php');
include_once('../templates/content.php');


getHeader("user Toevoegen", "Gebruiker toevoegen");

if (@$_GET['action'] == "save")
{
/*   // $user_id = $_POST['user_id'];
    $username = $_POST['username'];
  //  $password = $_POST['password'];
    $last_visit = $_POST['last_visit'];
    $active = $_POST['active'];
    $created_date = $_POST['created_date'];*/


	try
    {
 /*       $query=$conn->prepare("
                    INSERT INTO `user` (`username`, `password`, `last_visit`, `active`, `created_date`) VALUES ('$username', , '$last_visit', '$active',$created_date )");
        $query->execute();*/


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
          	<form name=\"formAdd\" action=\"?action=save\" method=\"post\">
                <table>
                    <tr>
                        <td>user toevoegen</td>
                        <td><input type=\"text\" name=\"username\" required> </td>   
                        <td><input type=\"text\" name=\"password\" required> </td>
                     <!--   <td><input type=\"date\" name=\"last_visit\" required> </td>-->
                        <td><input type=\"active\" name=\"active\" required> </td>
                    <!--    <td><input type=\"date\" name=\"created_date\" required> </td>-->
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