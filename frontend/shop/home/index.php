<?php
session_start();

if (!isset($_SESSION['sid'])) {
    // Redirect to login page if not logged in
    header('Location: ../login/login.php');
    exit();
}

include dirname(__FILE__) . '/../menu/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Home</title>
</head>
<body>
<div class="container-fluid">
    <h2>Welcome to the Home Page!</h2>
    <p>This is some content for the logged-in user.</p>
    <form method="post">
        <button type="submit" name="logout" class="btn btn-default">Logout</button>
    </form>
</div>
</body>
</html>

<?php
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: ../login/login.php');
    exit();
}
?>
