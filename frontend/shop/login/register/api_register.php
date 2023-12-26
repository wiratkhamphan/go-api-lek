<?php
session_start();
$registrationError = false;
$errorMsg = '';

// Check if the logout button is clicked
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: register.php');
    exit();
}

// Check if the registration form is submitted
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
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($userData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $apiResponse = curl_exec($ch);

    if (curl_errno($ch)) {
        $registrationError = true;
        $errorMsg = 'Error connecting to the API: ' . curl_error($ch);
    } else {
        $apiData = json_decode($apiResponse, true);

        if (isset($apiData['success']) && $apiData['success']) {
            // Registration successful
            $_SESSION['sid'] = session_id();
            $_SESSION['username'] = $userData['username'];
            $Register = true; // Set $Register to true
        } else {
            $registrationError = true;
            $errorMsg = isset($apiData['message']) ? $apiData['message'] : 'Registration failed.';
        }
    }

    curl_close($ch);
}
?>
