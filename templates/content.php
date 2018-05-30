<?php

function getHeader($description, $title = "Sqits voor jou en mie")
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
}

function getFooter()
{
    $footer = "<footer></footer>
                <script src=" . getAssetsDirectory() . "js/validate.js></script>
        </body>         
    </html>";
    echo $footer;
}

function getSidebar(){

    ?>
    <div class="left-panel">
        <div class="panel-name">
            <a href="<?=getPathToRoot()."dashboard/index.php" ?>">dashboard</a>

        </div>
        <div class="panel-name">
            <ul>
                <li><a href="<?=getPathToRoot()."form/index.php" ?>">formulier</a></li>
            </ul>
            <?php
            if(isLoggedIn() && getUserRole() == 'admin'){
                ?>
                    <li> <a href="<?=getPathToRoot()."form/add.php" ?>"> . toevoegen</a></li>
                <?php
            }
            ?>
        </div>
        <div class="panel-name">
            <a href="<?=getPathToRoot()."update/index.php" ?>">update</a>
        </div>
        <div class="panel-name">
            <a href="<?=getPathToRoot()."user/index.php" ?>">user info</a>
            <?php
            if(isLoggedIn() && getUserRole() == 'admin'){
            ?>
            <li> <a href="<?=getPathToRoot()."user/add.php" ?>"> . toevoegen</a></li>
                <?php
                }
                ?>
        </div>
        <div class="panel-name">
            <a href="<?=getPathToRoot()."system/logout.php" ?>">logout</a>
        </div>

    </div>
<?php
}

function getBreadCrumbs(){
    $crumbs = explode("/",$_SERVER["REQUEST_URI"]);
    echo"<ul>";
    foreach($crumbs as $crumb){

        echo "<li><a href=". ucfirst(str_replace(array("","Sqits-framework", "dashboard"),array(""," "),$crumb) . ' '). ">$crumb</a></li>";
    }
    echo"</ul>";
}

