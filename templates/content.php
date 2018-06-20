<?php

function getHeader($description = "We denken graag met je mee naar een creatieve oplossing voor jouw vraagstuk. Een 'out of the box' oplossing door creatieve webontwikkelaars met een passie.", $title = "sqits :: creatief en technisch partner voor creatieve mensen en bureaus")
{
    $header = "<!DOCTYPE html>
    <html lang=\"nl\">
        <head>
            <meta charset=\"utf-8\">
            <meta name=\"description\" content=\"$description\">
            <meta name=\"author\" content=\"Jasper, David, Marnix, Luuk\">
            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
            <title> $title </title>
             <!-- Bootstrap core CSS-->
             <link rel=\"stylesheet\" href=" . getAssetsDirectory() . "vendor/bootstrap/css/bootstrap.min.css>      
               <!-- Custom fonts for this template-->   
            <link rel=\"stylesheet\" href=" . getAssetsDirectory() . "vendor/font-awesome/css/font-awesome.min.css>    
              <!-- Custom styles for this template-->     
            <link rel=\"stylesheet\" href=" . getAssetsDirectory() . "css/sb-admin.css> 
            <!-- Custom datatables styles for this template-->    
             <link rel=\"stylesheet\" type=\"text/css\" href=\"https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css\">                    
            <link rel=\"stylesheet\" href=" . getAssetsDirectory() . "css/customize.css>   
            <link rel=\"stylesheet\" href=" . getAssetsDirectory() . "css/print.css>   
            <link rel=\"stylesheet\" href=" . getAssetsDirectory() . "css/timeline.css>   
            <link rel=\"icon\" type=\"image/x-icon\" href=\"" . getAssetsDirectory() . "/icons/favicon.ico\">
  

        </head>
        <body class=\"fixed-nav sticky-footer bg-light\" id=\"page-top\">";
    echo $header;

    getSideBar();
}

function getLoginHeader($description = "We denken graag met je mee naar een creatieve oplossing voor jouw vraagstuk. Een 'out of the box' oplossing door creatieve webontwikkelaars met een passie.", $title = "sqits :: creatief en technisch partner voor creatieve mensen en bureaus")
{
    $header = "<!DOCTYPE html>
    <html lang=\"nl\">
        <head>
            <meta charset=\"utf-8\">
            <meta name=\"description\" content=\"$description\">
            <meta name=\"author\" content=\"Jasper, David, Marnix, Luuk\">
            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
            <title> $title </title>          
     
             <!-- Bootstrap core CSS-->
            <link rel=\"stylesheet\" href=" . getAssetsDirectory() . "vendor/bootstrap/css/bootstrap.min.css>               
            <link rel=\"stylesheet\" href=" . getAssetsDirectory() . "css/custom.css>        
            <link rel=\"icon\" type=\"image/x-icon\" href=\"" . getAssetsDirectory() . "/icons/favicon.ico\">
        </head>
        <body class=\"fixed-nav bg-light\" id=\"page-top\"> ";
    echo $header;

}

function getSidebar()
{

    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-sqits fixed-top" id="mainNav">
        <a class="navbar-brand" href="#">
            <img class="brand-image" src="<?= getAssetsDirectory() . "/image/sqits-logo.png" ?>">
        </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                    <a class="nav-link no-nav" href="#">
                        <i class="fa fa-drivers-license"></i>
                        <span class="nav-link-text">Welkom: <?= $_SESSION['id']['first_name'] ?>  <?= $_SESSION['id']['last_name'] ?> </span>
                    </a>
                </li>
                <?php
                switch (getUserRole()) {
                    case "user":
                        echo "<li class=\"nav-item " . isActiveOnPage('/dashboard/index.php') . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Dashboard\">
                            <a class=\"nav-link\" href='" . getPathToRoot() . "dashboard/index.php'>
                         <i class=\"fa fa-fw fa-dashboard\"></i>
                        <span class=\"nav-link-text\">Dashboard</span></a></li>";
                        break;
                    case "admin":
                        echo "<li  class=\"nav-item " . isActiveOnPage('/dashboard/admin.php') . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Dashboard\">
                            <a class=\"nav-link\" href='" . getPathToRoot() . "dashboard/admin.php'>
                         <i class=\"fa fa-fw fa-dashboard\"></i>
                        <span class=\"nav-link-text\">Dashboard Admin</span></a></li>";
                        break;
                }
                ?>


                <?php
                switch (getUserRole()) {
                    case "user":
                        echo "<li class=\"nav-item  " . isActiveOnPage('/update/index.php') . " " . isActiveOnPage('/update/update.php') . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Charts\" " . isActiveOnPage('/update/index.php') . ">
                        <a  class=\"nav-link\" href='" . getPathToRoot() . "update/index.php'>                        
                           <i class=\"fa fa-history\"></i>
                             <span class=\"nav-link-text\"> Update geschiedenis</span>
                        </a>
                        
                        </li>";
                        break;
                    case "admin":
                        echo "
                         <li class=\"nav-item  " . isActiveOnPage('/update/index.php') . " " . isActiveOnPage('/update/add.php') . " \" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Components\">
                            <a class=\"nav-link nav-link-collapse collapsed\" data-toggle=\"collapse\" href=\"#collapseUpdate\"
                               data-parent=\"#exampleAccordion\">
                                <i class=\"	fa fa-puzzle-piece\"></i>
                                <span class=\"nav-link-text\">Updates</span>
                            </a>
                                <ul class=\"sidenav-second-level collapse\" id=\"collapseUpdate\">
                                    <li>
                                        <a href='" . getPathToRoot() . "update/index.php'> <i class=\"fa fa-sort-amount-asc\"></i> Update overzicht</a>
                                    </li>	
                                    <li>
                                        <a href='" . getPathToRoot() . "update/add.php'><i class=\"fa fa-plus\"></i> Update Toevoegen</a>
                                    </li>
                                </ul>
                         </li>
                        ";
                        break;
                }

                switch (getUserRole()) {
                    case "user":
                        echo "<li  class=\"nav-item " . isActiveOnPage('/user/index.php') . " " . isActiveOnPage('/user/update.php') . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"user\" " . isActiveOnPage('/user/index.php') . ">
                        <a  class=\"nav-link\" href='" . getPathToRoot() . "user/update.php?action=update&id=" . $_SESSION['id']['user_id'] . ".php'>                        
                             <i class=\"fa fa-user\"></i>
                             <span class=\"nav-link-text\">Wijzig gegevens</span>
                        </a>
                        
                        </li>";
                        break;
                    case "admin":
                        echo "
                         <li class=\"nav-item  " . isActiveOnPage('/user/index.php') . " " . isActiveOnPage('/user/add.php') . " \" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Users\">
                            <a class=\"nav-link nav-link-collapse collapsed\" data-toggle=\"collapse\" href=\"#collapseUsers\"
                               data-parent=\"#exampleAccordion\">
                                <i class=\"fa fa-user\"></i>
                                <span class=\"nav-link-text\">Users</span>
                            </a>
                                <ul class=\"sidenav-second-level collapse\" id=\"collapseUsers\">
                                    <li>
                                        <a href='" . getPathToRoot() . "user/update.php?action=update&id=" . $_SESSION['id']['user_id'] . ".php'><i class=\"fa fa-user-circle\"></i> Gegevens wijzigen</a>
                                    </li>
                                    <li>
                                        <a href='" . getPathToRoot() . "user/index.php'><i class=\"fa fa-sort-amount-asc\"></i> Gebruikers overzicht</a>
                                    </li>
                                    <li>
                                        <a href='" . getPathToRoot() . "user/add.php'><i class=\"fa fa-plus\"></i> Gebruiker Toevoegen</a>
                                    </li>
                                </ul>
                         </li>
                        ";
                        break;
                }


                switch (getUserRole()) {

                    case "admin":
                        echo "
                            <li class=\"nav-item " . isActiveOnPage('/form/index.php') . " " . isActiveOnPage('/form/add.php') . " \" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Formulieren\">
                                <a class=\"nav-link nav-link-collapse collapsed\" data-toggle=\"collapse\" href=\"#collapseForms\"
                                data-parent=\"#exampleAccordion\">
                                <i class=\"fa fa-clone\"></i>
                                <span class=\"nav-link-text\">Formulier overzicht</span>
                                </a>
                                <ul class=\"sidenav-second-level collapse\" id=\"collapseForms\">
                            <li>
                                <a href='" . getPathToRoot() . "form/index.php'><i class=\"fa fa-sort-amount-asc\"></i> Formulier overzicht</a>
                            </li>
                            <li>
                                <a href='" . getPathToRoot() . "form/add.php'><i class=\"fa fa-plus\"></i> Formulier Toevoegen</a>
                            </li>
                        </ul>
                        </li>
                        ";
                        break;
                }
                switch (getUserRole()) {

                    case "admin":
                        echo "<li class=\"nav-item  " . isActiveOnPage('/terms/index.php') . " " . isActiveOnPage('/terms/add.php') . " \" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Formulieren\">
                                <a class=\"nav-link nav-link-collapse collapsed\" data-toggle=\"collapse\" href=\"#collapseTerms\"
                                data-parent=\"#exampleAccordion\">
                                <i class=\"	fa fa-info\"></i>
                                <span class=\"nav-link-text\">Voorwaarden</span>
                                </a>
                                <ul class=\"sidenav-second-level collapse\" id=\"collapseTerms\">
                            <li>
                                <a href='" . getPathToRoot() . "terms/index.php'><i class=\"fa fa-sort-amount-asc\"></i> Voorwaarde overzicht</a>
                            </li>
                            <li>
                                <a href='" . getPathToRoot() . "terms/add.php'><i class=\"fa fa-plus\"></i> Voorwaarde Toevoegen</a>
                            </li>
                        </ul>
                        </li>
                        ";
                        break;
                }
                ?>
            </ul>
            <ul class="navbar-nav sidenav-toggler">
                <li class="nav-item">
                    <a class="nav-link text-center" id="sidenavToggler">
                        <i class="fa fa-fw fa-angle-left"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link sessionOut" data-toggle="modal" data-target="#logoutModal">
                        <i class="fa fa-fw fa-sign-out"></i>Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <?php
}


function getTopPanel($panelDescription1 = "Dashboard", $panelDescription2 = " ")
{
    $topPanel = "
                <header>
                    <div class='top-panel'>                    
                                             
                            <h1>" . $panelDescription1 . " <span class='sq-bl'> " . $panelDescription2 . " </span> </h1> 
                            <hr/>  
                    </div>
                </header>
";
    echo $topPanel;
}

function getFooter()
{
    getLogoutModal();
    $footer = "              
                  <footer class=\"sticky-footer\">
      <div class=\"container\">
        <div class=\"text-center\">
          <small>Copyright © De Haagse Hogeschool</small>
        </div>
      </div>
    </footer>
         <!-- Scroll to Top Button-->
         <a class=\"scroll-to-top rounded\" href=\"#page-top\">
           <i class=\"fa fa-angle-up\"></i>
         </a>
       <!-- Bootstrap core JavaScript-->
      <script src=" . getAssetsDirectory() . "vendor/jquery/jquery.min.js></script>
      <script src=" . getAssetsDirectory() . "vendor/bootstrap/js/bootstrap.bundle.min.js></script>
      <script src=" . getAssetsDirectory() . "vendor/jquery-easing/jquery.easing.min.js></script>             
      <script src=" . getAssetsDirectory() . "js/sb-admin.min.js></script> 
      <script type=\"text/javascript\" charset=\"utf8\" src=\"https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js\"></script>
      <script src=" . getAssetsDirectory() . "js/validate.js></script>
      <script src=" . getAssetsDirectory() . "js/getUser.js></script>
        </body>         
    </html>";

    echo $footer;
}

function getLogoutModal()
{
    $logoutModal = "
     <!-- Logout Modal-->
    <div class=\"modal fade\" id=\"logoutModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"logoutModalLabel\" aria-hidden=\"true\">
      <div class=\"modal-dialog\" role=\"document\">
        <div class=\"modal-content\">
          <div class=\"modal-header\">
            <h5 class=\"modal-title\" id=\"exampleModalLabel\">Ready to Leave?</h5>
            <button class=\"close\" type=\"button\" data-dismiss=\"modal\" aria-label=\"Close\">
              <span aria-hidden=\"true\">×</span>
            </button>
          </div>
          <div class=\"modal-body\">Select \"Logout\" below if you are ready to end your current session.</div>
          <div class=\"modal-footer\">
            <button class=\"btn btn-secondary\" type=\"button\" data-dismiss=\"modal\">Cancel</button>
            <a class=\"btn btn-primary\" href='" . getPathToRoot() . "system/logout.php'>Logout</a>
          </div>
        </div>
      </div>
    </div>
    ";
    echo $logoutModal;
}

function getBreadCrumbs()
{
    /*    $crumbs = explode("/", $_SERVER["REQUEST_URI"]);
        echo "<ol class='breadcrumb'>";
        foreach ($crumbs as $crumb) {

            echo "<li class=\"breadcrumb-item\"><a href=" . ucfirst(str_replace(array(" ", "Sqits-framework", "dashboard", "user", "update"), array(" ", ""), $crumb) . ' ') . ">$crumb</a></li>";
        }
        echo "</ol>";*/

     echo "<ol class='breadcrumb'>
             <li class='breadcrumb-item'>Welkom: " . $_SESSION['id']['first_name'] . "  " . $_SESSION['id']['last_name'] . " </li>
           </ol>";
}

