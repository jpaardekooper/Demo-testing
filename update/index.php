<?php
require_once('../system/session.php');
require_once('../system/config.php');

require_once('../templates/content.php');

if (isset($_SESSION['id']) && $_SESSION['id']['active'] == 'yes') {
    echo $_SESSION['id']['active'];

    getHeader("Sqits", "user Dashboard");

    echo getUserName();


    getFooter();
} elseif (isset($_SESSION['id']) && $_SESSION['id']['active'] == 'no') {


    getHeader("Sqits", "Admin Dashboard");

    ?>
    <div class="dashboard">
        <?php getSidebar();?>

        <div class="right-panel">
            <header>
                <p>welkom: <?= getUserName(); ?></p>
                <p>
                    is user active: <?= $_SESSION['id']['active'];; ?>
                </p>

this is update form
            </header>


        </div>
    </div>

    <?php
    getFooter();

} else {
    echo "please login first on login page";
    header("Refresh: 1; URL=\"../login.php\"");
    exit;
}
