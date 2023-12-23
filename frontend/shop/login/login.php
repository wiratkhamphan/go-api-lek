<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Login</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .login-container {
            max-width: 400px;
            margin: auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <h2>Login</h2>
            </div>

            <?php
            session_start();

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['loginButton'])) {
                $username = $_POST['uname'];
                $password = $_POST['pw'];

                // Prepare data for API request
                $userData = json_encode(['username' => $username, 'password' => $password]);

                // Example using cURL to make a POST request to the Golang API
                $apiUrl = "http://localhost:8080/login";
                $ch = curl_init($apiUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $userData);
                $apiResponse = curl_exec($ch);
                curl_close($ch);

                // Handle API response
                $apiData = json_decode($apiResponse, true);

                if ($apiData['success']) {
                    $_SESSION['sid'] = session_id();
                    header('Location: ../home/index.php');
                    exit();
                } else {
                    $loginError = true;
                }
            }

            // Check if the logout button is clicked
            if (isset($_POST['logout'])) {
                session_destroy();
                header('Location: login.php');
                exit();
            }
            ?>

            <?php if (isset($loginError)) { ?>
                <div class='alert alert-danger'>
                    Username and/or Password ไม่ถูกต้อง
                </div>
            <?php } ?>

            <?php if (isset($_SESSION['sid'])) { ?>
                <form class="form-horizontal" method="post">
                    <div class="form-group">
                        <button type="submit" name="logout" class="btn btn-default btn-block">Logout</button>
						</div>
                </form>
            <?php } else { ?>
                <form class="form-horizontal" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="uname" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="pw" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="loginButton" class="btn btn-primary btn-block">Login</button>
                    </div>
                </form>
            <?php } ?>
            <div class="login-footer">
                &copy; 2023 Your Company
            </div>
        </div>
    </div>
</body>

</html>
