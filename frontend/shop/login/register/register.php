<?php
include "api_register.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="register.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <h2>Register</h2>
            </div>

            <form class="form-horizontal" method="post" action="">
                <!-- Your form fields go here -->
                <div class="mb-3">
                    <div class="col-sm-12">
                        <input type="text" name="name" class="form-control" required minlength="3" placeholder="ชื่อ">
                    </div>
                </div>
                <div class="mb-3">
                    <div class="col-sm-12">
                        <input type="text" name="surname" class="form-control" required minlength="3" placeholder="นามสกุล">
                    </div>
                </div>
                <div class="mb-3">
                    <div class="col-sm-12">
                        <input type="text" name="username" class="form-control" required minlength="3" placeholder="Username">
                    </div>
                </div>
                <div class="mb-3">
                    <div class="col-sm-12">
                        <input type="password" name="password" class="form-control" required minlength="3" placeholder="Password">
                    </div>
                </div>
                <div class="mb-3">
                    <div class="col-sm-12">
                        <input type="text" name="email" class="form-control" required minlength="3" placeholder="Email">
                    </div>
                </div>
                <div class="d-grid gap-2 col-sm-12 mb-3">
                    <button type="submit" name="registerButton" class="btn btn-primary custom-button">Register</button>
                </div>
            </form>
        </div>
    </div>

    <?php
    include "modal_content.php";
    if ($registerError) {
        echo '<script>';
        echo '$(document).ready(function(){ $("#myModal").modal("show"); });';
        echo '</script>';
    }
    ?>

   
</body>
</html>
