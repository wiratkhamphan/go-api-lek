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
                if (isset($_SESSION['register_response'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['register_response'] . '</div>';
                    // Clear the session variable to avoid showing the modal on page reload
                    unset($_SESSION['register_response']);
                } elseif ($registerError) {
                    echo '<div class="alert alert-danger">' . $errorMsg . '</div>';
                }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
