<?php
require_once('../system/session.php');
require_once('../system/config.php');

require_once('../templates/content.php');

if (isset($_SESSION['id'])) {

    checkRole('admin');

    getHeader("Sqits", "Admin Dashboard");


    echo "<div class='content-wrapper'>";
    echo "<div class='container-fluid'>";

    getBreadCrumbs();
    getTopPanel();

    try {
        //query to get all pending data
        $query = $conn->prepare("SELECT COUNT(status) as 'pending' from `update` 
                                            WHERE status = :pending 
                                            GROUP BY status");
        $query->execute(array(
            'pending' => 'pending',

        ));
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $pending = $row['pending'];
        }

        //query to get all accepted data
        $query = $conn->prepare("SELECT COUNT(status) as 'accepted' from `update` 
                                            WHERE status = :accepted 
                                            GROUP BY status");
        $query->execute(array(
            'accepted' => 'accepted',
        ));
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $accepted = $row['accepted'];
        }

        $query = $conn->prepare("SELECT COUNT(status) as 'declined' from `update` 
                                            WHERE status = :declined 
                                            GROUP BY status");
        $query->execute(array(
            'declined' => 'declined',
        ));
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $declined = $row['declined'];
        }

    } catch (PDOException $e) {
        $sMsg = '<p> 
                    Line number: ' . $e->getLine() . '<br /> 
                    File: ' . $e->getFile() . '<br /> 
                    Error message: ' . $e->getMessage() .
            '</p>';
        trigger_error($sMsg);
    }


?>
    <div class="container">
    <div class="row">
       
        <div class="col-xl-4 col-sm-6 mb-4">
          <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-support"></i>
              </div>
                <?php
                if ($pending == 0 || $pending == NULL){
                    echo "   <div class=\"mr-5\">er zijn geen updates gevonden</div>";
                }elseif($pending == 1){
                    echo "   <div class=\"mr-5\">er is nog $pending update in de wachtrij</div>";
                }else{
                    echo "   <div class=\"mr-5\">$pending updates staan in de wachtrij</div>";
                }
                ?>
            </div>
            <a class="card-footer text-white clearfix small z-1" href=" <?= getPathToRoot() ?>update/index.php">
              <span class="float-left">Overzicht</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-4">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-long-arrow-up fa-fw"></i>
              </div>
                <?php
                if ($accepted == 0 || $accepted == NULL){
                    echo "   <div class=\"mr-5\">er zijn geen updates goedgekeurd</div>";
                }elseif($accepted == 1){
                    echo "   <div class=\"mr-5\">er is $accepted geaccepteerde update gevonden</div>";
                }else{
                    echo "   <div class=\"mr-5\">$accepted updates zijn geaccepteerd</div>";
                }
                ?>
            </div>
            <a class="card-footer text-white clearfix small z-1" href=" <?= getPathToRoot() ?>update/index.php">
              <span class="float-left">Overzicht</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-4">
          <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-long-arrow-down fa-fw"></i>
              </div>
                <?php
                if ($declined == 0 || $declined == NULL){
                    echo "   <div class=\"mr-5\">er zijn geen afgewezen updates gevonden</div>";
                }elseif($declined == 1){
                    echo "   <div class=\"mr-5\">er is $declined afgewezen update gevonden</div>";
                }else{
                    echo "   <div class=\"mr-5\">$declined updates zijn afgewezen</div>";
                }
                ?>

            </div>
            <a class="card-footer text-white clearfix small z-1" href=" <?= getPathToRoot() ?>update/index.php">
              <span class="float-left">Overzicht</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
      </div>
      </div>
      
<?php


    //closes container-fluid
    echo "</div>";

    //closes content wrapper
    echo "</div>";


    getFooter();

} else {
    echo "please login first on login page";
    header("Refresh: 1; URL='../login.php'");
    exit;
}
