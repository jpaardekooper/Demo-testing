<?php
require_once('config/config.php');

require_once('templates/header.php');

include_once ('user.php')
?>


<button>
    <a  href="functions/logout.php">logout</a>
</button>

<form class="form-login" id="form-login" action="user.php">
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





<?php require_once('templates/footer.php') ?>
