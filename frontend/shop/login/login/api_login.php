<?php
session_start();

$loginError = false;
$errorMsg = '';

// Check if the logout button is clicked
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['loginButton'])) {
    $username = $_POST['uname'];
    $password = $_POST['pw'];

    // Check if username or password is empty
    if (empty($username) || empty($password)) {
        $loginError = true;
        $errorMsg = 'Please enter both username and password.';
    } else {
        $userData = json_encode(['username' => $username, 'password' => $password]);

        $apiUrl = "http://localhost:8080/login";
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $userData);
        $apiResponse = curl_exec($ch);

        if (curl_errno($ch)) {
            $loginError = true;
            $errorMsg = 'Error connecting to the API.';
        } else {
            $apiData = json_decode($apiResponse, true);

            if (isset($apiData['success']) && $apiData['success']) {
                $_SESSION['sid'] = session_id();
                $_SESSION['username'] = $username;
                header('Location:http://localhost/go-api-lek/frontend/shop/home/index.php');
                exit();
            } else {
                $loginError = true;
                $errorMsg = 'Invalid username or password.!!  ';
            }
        }

        curl_close($ch);
    }
}
?>
