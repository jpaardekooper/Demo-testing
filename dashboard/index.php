<?php
require_once('../system/session.php');
require_once('../system/config.php');

require_once('../templates/content.php');

if (isset($_SESSION['id'])) {
    checkRole('user');
   // echo $_SESSION['id']['active'];


    getHeader("Sqits", "user Dashboard");
?>

        <div class="right-panel">
            <?php getTopPanel() ?>

            <div class="content">
                <?php
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

                    echo "<span class='patch-version'>Current version: 4.0.1A</span>";

                }
                ?>
            </div>
        </div>


    <?php
    getFooter();
} else {
    echo "please login first on login page";
    header("Refresh: 1; URL=\"../login.php\"");
    exit;
}
