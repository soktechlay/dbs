<?php
$current_page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$is_management_active = in_array($current_page, ['createdepartment', 'createtype']);
?>
<style>
    .nav-link.active,
    .dropdown-item.active {
        color: #0d6efd !important;
        /* Bootstrap Primary Blue */
    }

    .nav-item.active .nav-link-title {
        color: #0d6efd !important;
        /* Make the title blue */
    }

    .nav-item.active .dropdown-toggle {
        color: #0d6efd !important;
        /* Make the dropdown link blue */
    }
</style>

<header class="navbar-expand-md bg-light shadow-sm d-print-none">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar">
            <div class="container-xl h-100">
                <div class="row flex-fill align-items-center justify-content-between">
                    <div class="col d-flex align-items-center">
                        <ul class="navbar-nav">
                            <!-- Dashboard Menu Item -->
                            <li class="nav-item">
                                <a class="nav-link <?= ($current_page == 'dashboard') ? 'active' : '' ?>"
                                    href="/dbs/dashboard">
                                    <span class="nav-link-title">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icon-tabler-home">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                        </svg>
                                        ទំព័រដើម
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>