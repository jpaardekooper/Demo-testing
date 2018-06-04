<?php
require_once('../system/session.php');
require_once('../system/config.php');

require_once('../templates/content.php');

if (isset($_SESSION['id'])) {

    checkRole('admin');

    getHeader("Sqits", "Admin Dashboard");


    echo "<div class=\"content-wrapper\">";
    echo "<div class=\"container-fluid\">";

    getBreadCrumbs();
    getTopPanel();


    //random query in order to get current patch
    try {
        $query = $conn->prepare("SELECT email FROM `user` WHERE user_id = :id");
        $query->execute(array(
            'id' => $_SESSION['id']['user_id']
        ));
    } catch (PDOException $e) {
        $sMsg = '<p> 
                    Line number: ' . $e->getLine() . '<br /> 
                    File: ' . $e->getFile() . '<br /> 
                    Error message: ' . $e->getMessage() .
            '</p>';
        trigger_error($sMsg);
    }

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $email = $row['email'];

        echo "<span class='patch-version'> this is dashboard form ADMIN</span>";

    }

    echo "
    <div class=\"row\">
        <div class=\"col-xl-3 col-sm-6 mb-3\">
          <div class=\"card text-white bg-primary o-hidden h-100\">
            <div class=\"card-body\">
              <div class=\"card-body-icon\">
                <i class=\"fa fa-fw fa-comments\"></i>
              </div>
              <div class=\"mr-5\">26 New Messages!</div>
            </div>
            <a class=\"card-footer text-white clearfix small z-1\" href=\"#\">
              <span class=\"float-left\">View Details</span>
              <span class=\"float-right\">
                <i class=\"fa fa-angle-right\"></i>
              </span>
            </a>
          </div>
        </div>
        <div class=\"col-xl-3 col-sm-6 mb-3\">
          <div class=\"card text-white bg-warning o-hidden h-100\">
            <div class=\"card-body\">
              <div class=\"card-body-icon\">
                <i class=\"fa fa-fw fa-list\"></i>
              </div>
              <div class=\"mr-5\">11 New Tasks!</div>
            </div>
            <a class=\"card-footer text-white clearfix small z-1\" href=\"#\">
              <span class=\"float-left\">View Details</span>
              <span class=\"float-right\">
                <i class=\"fa fa-angle-right\"></i>
              </span>
            </a>
          </div>
        </div>
        <div class=\"col-xl-3 col-sm-6 mb-3\">
          <div class=\"card text-white bg-success o-hidden h-100\">
            <div class=\"card-body\">
              <div class=\"card-body-icon\">
                <i class=\"fa fa-fw fa-shopping-cart\"></i>
              </div>
              <div class=\"mr-5\">123 New Orders!</div>
            </div>
            <a class=\"card-footer text-white clearfix small z-1\" href=\"#\">
              <span class=\"float-left\">View Details</span>
              <span class=\"float-right\">
                <i class=\"fa fa-angle-right\"></i>
              </span>
            </a>
          </div>
        </div>
        <div class=\"col-xl-3 col-sm-6 mb-3\">
          <div class=\"card text-white bg-danger o-hidden h-100\">
            <div class=\"card-body\">
              <div class=\"card-body-icon\">
                <i class=\"fa fa-fw fa-support\"></i>
              </div>
              <div class=\"mr-5\">13 New Tickets!</div>
            </div>
            <a class=\"card-footer text-white clearfix small z-1\" href=\"#\">
              <span class=\"float-left\">View Details</span>
              <span class=\"float-right\">
                <i class=\"fa fa-angle-right\"></i>
              </span>
            </a>
          </div>
        </div>
      </div>
    ";

    //closes container-fluid
    echo "</div>";

    //closes content wrapper
    echo "</div>";


    getFooter();

} else {
    echo "please login first on login page";
    header("Refresh: 1; URL=\"../login.php\"");
    exit;
}
