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
                                <a class="nav-link <?= ($current_page == 'dashboard') ? 'active' : '' ?>" href="/dbs/dashboard">
                                    <span class="nav-link-title">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-home">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                        </svg>
                                        ទំព័រដើម
                                    </span>
                                </a>
                            </li>

                            <!-- Management Dropdown Menu -->
                            <li class="nav-item dropdown <?= $is_management_active ? 'active' : '' ?>">
                                <a href="#" class="nav-link dropdown-toggle <?= $is_management_active ? 'active' : '' ?>" data-bs-toggle="dropdown" role="button" aria-expanded="<?= $is_management_active ? 'true' : 'false' ?>">
                                    <span class="nav-link-title">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-box">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 3l8 4.5v9l-8 4.5l-8 -4.5v-9l8 -4.5" />
                                            <path d="M12 12l8 -4.5" />
                                            <path d="M12 12v9" />
                                            <path d="M12 12l-8 -4.5" />
                                        </svg>
                                        គ្រប់គ្រង
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item <?= ($current_page == 'createdepartment') ? 'active' : '' ?>" href="/dbs/createdepartment">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-arrow-big-right-line">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 9v-3.586a1 1 0 0 1 1.707 -.707l6.586 6.586a1 1 0 0 1 0 1.414l-6.586 6.586a1 1 0 0 1 -1.707 -.707v-3.586h-6v-6h6z" />
                                                <path d="M3 9v6" />
                                            </svg>
                                            បង្កើតប្រភេទអង្គភាពក្រោមឱវាទ អ.ស.ហ.
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item <?= ($current_page == 'createtype') ? 'active' : '' ?>" href="/dbs/createtype">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-arrow-big-right-line">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 9v-3.586a1 1 0 0 1 1.707 -.707l6.586 6.586a1 1 0 0 1 0 1.414l-6.586 6.586a1 1 0 0 1 -1.707 -.707v-3.586h-6v-6h6z" />
                                                <path d="M3 9v6" />
                                            </svg>
                                            បង្កើតប្រភេទឯកសារ
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <!-- Create Document Menu Item -->
                            <li class="nav-item">
                                <a class="nav-link <?= ($current_page == 'createdocument') ? 'active' : '' ?>" href="/dbs/createdocument">
                                    <span class="nav-link-title">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-clipboard-data">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                            <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                            <path d="M9 17v-4" />
                                            <path d="M12 17v-1" />
                                            <path d="M15 17v-2" />
                                            <path d="M12 17v-1" />
                                        </svg>
                                        បង្កើតឯកសារ
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
