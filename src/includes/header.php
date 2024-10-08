<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start or resume session
}

// Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header("Location: /dbs/login");
//     exit();
// }

include('src/includes/Alerts.php');



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title><?php echo $title ?? "No Title" ?></title>
    <link rel="icon" href="public/img/favicon/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="public/img/favicon/favicon.ico" type="image/x-icon" />
    <!-- CSS -->
    <link href="public/dist/css/tabler.min.css?1668287865" rel="stylesheet" />
    <link href="public/dist/css/tabler-flags.min.css?1668287865" rel="stylesheet" />
    <link href="public/dist/css/tabler-payments.min.css?1668287865" rel="stylesheet" />
    <link href="public/dist/css/tabler-vendors.min.css?1668287865" rel="stylesheet" />
    <link href="public/dist/css/demo.min.css?1668287865" rel="stylesheet" />
    <link href="public/dist/libs/animate/animate.css?1668287865" rel="stylesheet" />
    <link href="public/dist/libs/litepicker/dist/css/plugins/multiselect.js.css?1668287865" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="public/dist/lib/datatables-checkboxes-jquery/datatables.checkboxes.css">
    <link rel="stylesheet" href="public/dist/lib/datatables-rowgroup-bs5/rowgroup.bootstrap5.css">
    <!-- full edit textarea css  -->

    <link rel="stylesheet" href="public/dist/lib/datatables-bs/datatables.bootstrap5.css">
    <link rel="stylesheet" href="public/dist/lib/datatables-responsive-bs5/responsive.bootstrap5.css">
    <!-- flatpickr  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        .sortable:hover {
            cursor: pointer;
            text-decoration: underline;
        }
    </style>
    
</head>

<body>


    <script src="public/dist/js/demo-theme.min.js?1668287865"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.1/js/bootstrap.min.js"></script>
    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>

        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr("#flatpickr-range", {
                mode: "range",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "F j, Y",
            });
        });
    </script>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> -->

    <!-- Bootstrap Toast (Success/Error) -->


    <div class="page">
        <!-- Navbar -->
        <div class="sticky-top">
            <?php
            if (isset($_SESSION['admin_id'])) {
                // Include admin-specific navbar and sidebar
                include('admin_navbar.php');
                include('admin_sidebar.php');
            } elseif (isset($_SESSION['user_id'])) {
                // Include user-specific navbar and sidebar
                include('navbar.php');
                include('sidebar.php');
            } else {
                // Optionally, redirect to login if neither session is set
                header('Location: /dbs/login');
                exit;
            }
            ?>
        </div>

        <div class="page-wrapper">
            <!-- Page header -->
            <?php echo $pageheader ?? "" ?>
            <!-- Page body -->
            <div class="page-body">
                <div class="container-xl">
                    
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?php echo $_SESSION['success'];
                            unset($_SESSION['success']); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $_SESSION['error'];
                            unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>