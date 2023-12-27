<?php
include "api_login.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <h2>Login</h2>
            </div>

            <form class="form-horizontal" method="post" action="">
                <div class="form-group">
                    <input type="text" class="form-control" name="uname" required minlength="3" placeholder="Username">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="pw" required minlength="3"  placeholder="Password">
                </div>
                <div class="form-group">
                    <button type="submit" name="loginButton" class="btn btn-primary custom-button">Login</button>
                   

                </div>
                <div>
                    <h4><a href="../register/register.php">register</a></h4>
                </div>

                .


            </form>

            <!-- <div class="login-footer">
                &copy; 2023 Your Company
            </div> -->
        </div>
    </div>

    <?php
    // Include the modal script only if there's a login error
    if ($loginError) {
        echo '<script>';
        echo '$(document).ready(function(){ $("#myModal").modal("show"); });';
        echo '</script>';
    }
    ?>


    <?php
    include "modal_content.php";

    ?>
    <script>
        // Add this script to reset modal status on page load
        $(document).ready(function() {
            // If the page is reloaded, close the modal
            if (performance.navigation.type === 1) {
                $("#myModal").modal("hide");
            }
        });


    </script>
</body>

</html>