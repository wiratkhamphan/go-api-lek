<?php
session_start();

if (!isset($_SESSION['sid'])) {
    // Redirect to login page if not logged in
    header('Location: ../login/login.php');
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Header</title>
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Your Logo</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <!-- Add more menu items as needed -->
            </ul>
            <form class="navbar-form navbar-right" method="post" action="">
            <button type="submit" name="logout" class="btn btn-default">Logout</button>
            <p class="navbar-text"><?php echo $_SESSION['username']; ?></p>
        </form>
        </div>
    </nav>
</body>
</html>

<?php
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: ../login/login.php');
    exit();
}
?>
