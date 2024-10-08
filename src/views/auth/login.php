<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <title>ចូលប្រើប្រាស់ប្រព័ន្ធ</title>
    <link rel="icon" href="public/img/favicon/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="public/img/favicon/favicon.ico" type="image/x-icon" />
    <!-- CSS files -->
    <link href="public/css/tabler.min.css" rel="stylesheet" />
    <link href="public/css/tabler-flags.min.css" rel="stylesheet" />
    <link href="public/css/tabler-payments.min.css" rel="stylesheet" />
    <link href="public/css/tabler-vendors.min.css" rel="stylesheet" />
    <link href="public/css/demo.min.css" rel="stylesheet" />
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>


<body class="d-flex flex-column"
    style="min-height: 100vh; background-image: url('public/img/backgrounds/blue2.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">

    <div class="page page-center d-flex justify-content-center align-items-center flex-grow-1">
        <div class="container container-tight d-flex justify-content-center align-items-center min-vh-100">
            <div class="card border-0 shadow-lg p-5 rounded-5"
                style="max-width: 500px; width: 100%; background: rgba(255, 255, 255, 0.5);">
                <div class="card-body text-center">
                    <span class="app-brand-log demo d-block">
                        <img src="public/img/logo/logo2.png" class=" mx-auto" alt="Logo"
                            style="max-width: 100px; height: auto;background: rgba(255, 255, 255, 0);">
                    </span>
                    <h2 class="h2 text-center mb-4 fw-bold">IAU Database System</h2>

                    <!-- Display error if exists -->
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger text-center">
                            <strong><?php echo htmlspecialchars($_SESSION['error']['title']); ?></strong><br>
                            <?php echo htmlspecialchars($_SESSION['error']['message']); ?>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <form action="/dbs/login" method="POST" class="needs-validation" novalidate>
                        <div class="form-floating mb-4">
                            <input type="text" name="email" class="form-control" id="email" placeholder="email"
                                required>
                            <label for="email">email</label>
                            <div class="invalid-feedback">
                                Please enter your email.
                            </div>
                        </div>

                        <div class="form-floating mb-4 position-relative">
                            <input type="password" name="password" class="form-control" id="password"
                                placeholder="Password" required>
                            <label for="password">Password</label>
                            <div class="invalid-feedback">
                                Please enter your password.
                            </div>
                            <span class="position-absolute end-0 top-50 translate-middle-y me-3"
                                onclick="togglePasswordVisibility()">
                                <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="icon">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path
                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg>
                                </a>
                            </span>
                        </div>

                        <script>
                            function togglePasswordVisibility() {
                                const passwordInput = document.getElementById('password');
                                const icon = document.querySelector('.icon');

                                if (passwordInput.type === 'password') {
                                    passwordInput.type = 'text';
                                    icon.classList.add('icon-visible');  // Optionally change the icon when visible
                                } else {
                                    passwordInput.type = 'password';
                                    icon.classList.remove('icon-visible');
                                }
                                
                            }
                        </script>


                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <a href="forgot-password.html" class="small">Forgot password?</a>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill shadow-sm">Sign In</button>
                    </form>
                </div>
                <div class="text-center mt-4">
                    <span>Don't have an account?</span> <a href="/dbs/register" class="fw-bold">Sign up</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Validation -->
    <script>
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
        if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    </script>
</body>

</html>