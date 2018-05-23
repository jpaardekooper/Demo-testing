<?php

require_once('templates/functions.php');

require_once ('sql/user.php');


$object = new User("jaseper", 16);
$object->DoSomething();

/*$result = $query->fetch(PDO::FETCH_CLASS, get_class($object));
var_dump_str($result);*/

//$id = $_GET['id'];

getHeader("Login", "Sqits Login panel");
?>



<button>
    <a  href="functions/logout.php">logout</a>
</button>

<form class="form-login" id="form-login" action="sql/user.php">
    <div class="login-group">
        <label>Login</label>
        <input type="text" />
    </div>

    <div class="login-group">
        <label>Password</label>
        <input type="password"/>
    </div>


    <input type="submit" value="login"/>
</form>


<a href="form/index.php">formulier</a>

<?php
getFooter();
?>