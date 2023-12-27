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
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $userData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $responseData = json_decode($response, true);

    if ($response === false) {
        $registerError = true;
        $errorMsg = 'Error connecting to the API.';
    } else {
        if ($responseData['success']) {
            $_SESSION['register_response'] = 'Registration successful!';
        } else {
            $registerError = true;
            $errorMsg = $responseData['message'];
        }
    }

    curl_close($ch);
}
?>