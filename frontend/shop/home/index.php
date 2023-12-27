

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <?php 
    include __DIR__ . '/../menu/header.php';
    ?>
<div class="container-fluid">
    <h2>Welcome to the Home Page, </h2>
    <h2>tese git </h2>
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
