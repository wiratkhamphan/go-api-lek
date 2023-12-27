<?php
session_start();

$registerError = false;
$errorMsg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registerButton'])) {
    $userData = [
        'name' => $_POST['name'],
        'surname' => $_POST['surname'],
        'username' => $_POST['username'],
        'password' => $_POST['password'],
        'iso_p_code' => $_POST['email'],
    ];

    $apiUrl = "http://localhost:8080/register";

    // Encode data as JSON
    $jsonData = json_encode($userData);

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Set the content type to JSON
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $response = curl_exec($ch);

    if ($response === false) {
        $registerError = true;
        $errorMsg = 'Error connecting to the API. cURL Error: ' . curl_error($ch);
    } else {
        $responseData = json_decode($response, true);

        if ($responseData === null) {
            $registerError = true;
            $errorMsg = 'Invalid JSON response from the API.';
        } else {
            // Debugging: Output the response data
            // echo '<pre>';
            // print_r($responseData);
            // echo '</pre>';

            // หลังจากที่คุณได้รับข้อมูลจาก API
            if (isset($responseData['success']) && $responseData['success']) {
                $_SESSION['register_response'] = 'Registration successful!';
            } else {
                $registerError = true;
                $errorMsg = isset($responseData['message']) ? $responseData['message'] : 'Registration failed.';
            }
        }
    }

    curl_close($ch);
}
?>
<!-- HTML code -->

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
                <div>
                    <h5><a href="../login/login.php">login</a></h5>
                </div>
            </form>
        </div>
    </div>
    <?php
    // Include "modal_content.php" if needed

    // Display modal based on registration status
    if ($registerError || isset($_SESSION['register_response'])) {
        echo '<script>';
        echo '$(document).ready(function(){ $("#registrationModal").modal("show"); });';
        if ($registerError) {
            // Output cURL error to console
            echo 'console.error("cURL Error: ' . $errorMsg . '");';
        }
        echo '</script>';

        // Clear the session variable to avoid showing the modal on page reload
        unset($_SESSION['register_response']);
    }
    ?>



</body>

</html>

<!-- Bootstrap Modal -->
<div class="modal fade" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Registration Status</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                if ($registerError) {
                    // แสดงผลข้อความเมื่อมีปัญหา
                    echo '<div class="alert alert-danger">' . $errorMsg . '</div>';
                } elseif (isset($responseData['success']) && $responseData['success']) {
                    // แสดงผลข้อมูลลงทะเบียนสำเร็จ
                    echo '<div class="alert alert-success">' . $responseData['message'] . '</div>';
                } else {
                    // แสดงข้อความเมื่อลงทะเบียนไม่สำเร็จ
                    echo '<div class="alert alert-danger">' . (isset($responseData['message']) ? $responseData['message'] : 'Registration failed.') . '</div>';
                }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="redirectToLogin()">Close and Go to Login</button>
            </div>

        </div>
    </div>
</div>
<script>
    function redirectToLogin() {
        // Redirect to the login page
        window.location.href = '../login/login.php';
    }
</script>