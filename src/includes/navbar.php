<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: /dbs/login');
    exit();
}
// Get the user ID from the session
$userId = $_SESSION['user_id'];
?>

<header class="navbar navbar-expand-md navbar-light bg-light shadow-sm d-print-none">
    <div class="container-xl">
        <!-- Toggle Button for Mobile View -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
            aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Brand Logo -->
        <div class="navbar-brand pe-0 pe-md-3">
            <img src="public/img/icons/brands/logo3.png" alt="អង្គភាពសវនកម្មផ្ទៃក្នុង" class="navbar-brand-image"
                style="width: 150px; height: auto;">
        </div>

        <!-- Navbar Menu -->
        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="navbar-nav ms-auto d-flex flex-row align-items-center">
                <!-- Dark/Light Mode Toggle -->
                <div class="d-none d-md-flex">
                    <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode"
                        data-bs-toggle="tooltip" data-bs-placement="bottom">
                        <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                        </svg>
                    </a>
                    <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode"
                        data-bs-toggle="tooltip" data-bs-placement="bottom">
                        <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                            <path
                                d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                        </svg>
                    </a>
                </div>

                <!-- Notifications Dropdown -->
                <li class="nav-item dropdown d-none d-md-block me-3">
                    <a href="#" class="nav-link" data-bs-toggle="dropdown" aria-label="Show notifications">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                            <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                        </svg>
                        <span class="badge bg-danger"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <div class="dropdown-header">
                            <h6 class="dropdown-title">Last Updates</h6>
                        </div>
                        <div class="list-group list-group-flush">
                            <!-- Notification Item -->

                        </div>
                    </div>
                </li>

                <!-- User Menu Dropdown -->

                <li class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex align-items-center" data-bs-toggle="dropdown"
                        aria-label="Open user menu">
                        <img src="<?php echo htmlspecialchars($_SESSION['user_profile'] ); ?>"
                            alt="User Avatar" class="avatar avatar-sm rounded-circle me-2">
                        <div class="d-none d-xl-block">
                            <div><?php echo htmlspecialchars($_SESSION['user_khmer_name'] ?? ''); ?></div>
                            <small class="text-secondary"> <?= $_SESSION['position'] ; ?></small>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="/dbs/logout" class="dropdown-item">Logout</a>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</header>