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
        $errorMsg = 'Error connecting to the API.';
    } else {
        $responseData = json_decode($response, true);

        if ($responseData === null) {
            $registerError = true;
            $errorMsg = 'Invalid JSON response from the API.';
        } else {
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
