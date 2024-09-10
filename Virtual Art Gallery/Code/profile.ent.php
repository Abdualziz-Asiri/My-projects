<?php
define('TITLE', "Profile");
include 'profileh.inc.php';
include 'header.php';
?>

<body>
   
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
            </div>

            <div class="col-sm-8 text-center" id="user-section">
                <h2><?php echo $user['username']; ?></h2>
                <h6><?php echo $user['nam']; ?></h6>
                <h6><?php echo $user['email']; ?></h6>
                <h6><?php echo $user['addres']; ?></h6>
                <h6><?php echo $user['typ']; ?></h6>
                <p><?php echo $user['bio']; ?></p>
                </div>
        </div>
    </div>
</body>