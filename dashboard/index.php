<?php
require_once('../system/session.php');
require_once('../system/config.php');

require_once('../templates/content.php');

if (isset($_SESSION['id'])) {
    checkRole('user');
   // echo $_SESSION['id']['active'];


    getHeader("Sqits", "user Dashboard");
    echo "<div class=\"content-wrapper\">";
    echo "<div class=\"container-fluid\">";

    getBreadCrumbs();
    getTopPanel();
?>



            <div class="content">
                <?php
                //random query in order to get current patch
                try {
                    $query = $conn->prepare("SELECT COUNT(up.company_id) as waarde
                                                        FROM `update` as up
                                                        INNER JOIN company as c ON c.company_id = up.company_id
                                                        INNER JOIN user as u ON u.company_id = c.company_id                                                        
                                                        WHERE u.user_id = :id");
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
                    $update_id = $row['waarde'];
                    echo $update_id;

                }
                ?>
               <span class='patch-version'>Current version: 4.0.1A</span>
            </div>

        </div>
        </div>


    <?php
    getFooter();
} else {
    echo "please login first on login page";
    header("Refresh: 1; URL=\"../login.php\"");
    exit;
}
