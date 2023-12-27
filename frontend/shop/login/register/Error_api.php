<?php
// Assuming $registrationSuccess is set based on the registration result
$registrationSuccess = true; // Set this based on your logic

$modalMessage = $registrationSuccess ? "Registration successful" : "Registration failed";
?>

<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Registration Status</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php
                echo '<div class="alert ' . ($registrationSuccess ? 'alert-success' : 'alert-danger') . '">' . $modalMessage . '</div>';
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
