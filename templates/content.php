<?php

function getHeader($description, $title = "Sqits")
{
    $header = "<!DOCTYPE html>
    <html lang=\"nl\">
        <head>
            <meta charset=\"utf-8\">
            <meta name=\"description\" content=\"$description\">
            <meta name=\"author\" content=\"Jasper, David, Marnix, Luuk\">
            <title> $title </title>
            <link rel=\"stylesheet\" href=" . getAssetsDirectory() . "css/reset.css>
            <link rel=\"stylesheet\" href=" . getAssetsDirectory() . "css/custom.css>          
            <link rel=\"stylesheet\" href=" . getAssetsDirectory() . "css/dashboard.css>
        </head>
        <body>";
    echo $header;

    getSideBar();
}

function getLoginHeader($description, $title = "Sqits login page")
{
    $header = "<!DOCTYPE html>
    <html lang=\"nl\">
        <head>
            <meta charset=\"utf-8\">
            <meta name=\"description\" content=\"$description\">
            <meta name=\"author\" content=\"Jasper, David, Marnix, Luuk\">
            <title> $title </title>
            <link rel=\"stylesheet\" href=" . getAssetsDirectory() . "css/reset.css>
            <link rel=\"stylesheet\" href=" . getAssetsDirectory() . "css/custom.css>         
        </head>
        <body>";
    echo $header;

}

function getSidebar()
{

    ?>
    <!--  opens dashboar panel but doesn't close it-->
    <div class="dashboard">
    <div class="left-panel">
        <div class="panel-name">
            <img class="panel-image" src="<?= getAssetsDirectory() . "/image/sqits-logo.png" ?>">
        </div>
        <div class="panel-name">
            <?php
            switch (getUserRole()) {
                case "user":
                    echo "<li " . isActiveOnPage('/dashboard/index.php') . "><a href='" . getPathToRoot() . "dashboard/index.php'>dashboard</a></li>";
                    break;
                case "admin":
                    echo "<li " . isActiveOnPage('/dashboard/admin.php') . "><a href='" . getPathToRoot() . "dashboard/admin.php'>admin -dashboard</a></li>";
                    break;
            }
            ?>
        </div>
        <div class="panel-name">
            <li <?= isActiveOnPage("/form/index.php") ?>><a
                        href="<?= getPathToRoot() . "form/index.php" ?>">formulier</a></li>


            <?php
            switch (getUserRole()) {
                case "admin":
                    echo "<li " . isActiveOnPage('/form/add.php') . "><a href='" . getPathToRoot() . "form/add.php'>form toevoegen</a></li>";
                    break;
            }
            ?>

        </div>
        <div class="panel-name">
            <li <?= isActiveOnPage("/update/index.php") ?>><a href="<?= getPathToRoot() . "update/index.php" ?>">update</a> <span class="update">1</span></li>

            <?php
            switch (getUserRole()) {
                case "admin":
                    echo "<li " . isActiveOnPage('/update/add.php') . "><a href='" . getPathToRoot() . "update/add.php'>update toevoegen</a></li>";
                    break;
            }
            ?>
        </div>
        <div class="panel-name">
            <li <?= isActiveOnPage("/user/index.php") ?>><a href="<?= getPathToRoot() . "user/index.php" ?>">user
                    info</a></li>
            <?php
            switch (getUserRole()) {
                case "admin":
                    echo "<li " . isActiveOnPage('/user/add.php') . "><a href='" . getPathToRoot() . "user/add.php'>gebruiker toevoegen</a></li>";
                    break;
            }
            ?>
        </div>
        <div class="panel-name">
            <a href="<?= getPathToRoot() . "system/logout.php" ?>">logout</a>
        </div>

    </div>
    <?php
}


function getTopPanel($panelDescription = "dashboard")
{
    $topPanel = "
                <header>
                    <div class='topPanel'>
                            ". $_SESSION['id']['email'] ."                        
                            ". $panelDescription ."                        
                    </div>
                </header>
";

    echo $topPanel;
}

function getFooter()
{
    $footer = "
                <!--closes dashboard-->
                </div>
                <footer></footer>
                <script src=" . getAssetsDirectory() . "js/validate.js></script>
                <script src=" . getAssetsDirectory() . "js/getUser.js></script>
        </body>         
    </html>";
    echo $footer;
}

function getBreadCrumbs()
{
    $crumbs = explode("/", $_SERVER["REQUEST_URI"]);
    echo "<ul>";
    foreach ($crumbs as $crumb) {

        echo "<li><a href=" . ucfirst(str_replace(array("", "Sqits-framework"), array("User", ""), $crumb) . ' ') . ">$crumb</a></li>";
    }
    echo "</ul>";
}

