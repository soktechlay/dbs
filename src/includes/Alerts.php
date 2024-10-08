<?php
// Handle session success and error messages
if (isset($_SESSION['toast'])):
?>
    <!-- Bootstrap Toast (Success/Error) -->
    <div aria-live="polite" aria-atomic="true" class="position-relative" style="z-index: 1000;">
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="toastMessage" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <span id="toastMessageText"></span>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toastElement = document.getElementById('toastMessage');
            const toastBody = document.getElementById('toastMessageText');

            <?php if ($_SESSION['toast']['type'] === 'success'): ?>
                toastElement.classList.add('bg-success', 'text-white'); // Add success classes
                toastBody.textContent = "<?= $_SESSION['toast']['message'] ?>";
            <?php elseif ($_SESSION['toast']['type'] === 'error'): ?>
                toastElement.classList.add('bg-danger', 'text-white'); // Add error classes
                toastBody.textContent = "<?= $_SESSION['toast']['message'] ?>";
            <?php endif; ?>

            // Show the toast
            const toast = new bootstrap.Toast(toastElement);
            toast.show();

            <?php unset($_SESSION['toast']); // Clear the session toast ?>
        });
    </script>
<?php endif; ?>
