<?php
// Start or resume the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Redirect to login if user_id is not set
if (!isset($_SESSION['admin_id'])) {
    header('Location: /dbs/login');
    exit();
}

$title = "បង្កើតប្រភេទឯកសារ";
include('src/includes/header.php');
?>

<div class="page-header d-print-none mt-0 mb-3">
    <div class="col-12">
        <div class="row g-2 align-items-center">
            <div class="col-12 d-flex align-items-center justify-content-between mb-3">
                <!-- Display the user's full name -->
                <h3 class="mb-0">
                    <span class="mef2 text-primary mx-2 me-0 mb-0">
                        ប្រភេទឯកសារ
                    </span>
                </h3>
                <div class="col-3 d-flex align-items-center justify-content-end">
                    <div class="btn-list">
                        <a href="#" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal-report">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>បង្កើតប្រភេទឯកសារ
                        </a>
                        <div class="modal modal-blur fade" id="modal-report" tabindex="-1" style="display: none;"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-primary">បង្កើតប្រភេទឯកសារ</h5>
                                    </div>
                                    <form method="POST" action="/dbs/createtype" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">ប្រភេទឯកសារ</label>
                                                <input type="text" class="form-control" name="typedoc"
                                                    placeholder="សូមបង្កើតប្រភេទឯកសារ" required>
                                            </div>

                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                                បោះបង់
                                            </button>
                                            <button type="submit" class="btn btn-success ms-auto">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-file">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                    <path
                                                        d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                                </svg>
                                                រក្សាទុក
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-12">
    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table table-striped">
                <thead>
                    <tr>
                        <th class="fw-bold fs-4">ល.រ.</th>
                        <th class="fw-bold fs-4">ប្រភេទឯកសារ</th>
                        <th class="fw-bold fs-4">កាលបរិច្ឆេទ</th>
                        <th class="fw-bold fs-4 ">សកម្មភាព</th>
                    </tr>
                </thead>
                <?php
                if (!empty($gettypedoc)) {
                    $cnt = 1;
                    foreach ($gettypedoc as $type) {
                        ?>
                        <tbody>
                            <tr>
                                <td class="text-sm font-weight-bold mb-0"><b><?php echo htmlentities($cnt); ?></b>
                                </td>
                                <td>
                                    <div class="d-inline-block text-truncate" data-bs-toggle="tooltip"
                                        title="<?php echo htmlentities($type['typedoc']); ?>">
                                        <?php echo htmlentities($type['typedoc']); ?>
                                    </div>
                                </td>
                                <td>
                                    <?php echo htmlentities($type['created_at']); ?>
                                </td>
                                <td>
                                    <div class="d-flex ">
                                        <a href="#" class="text-primary me-2 " data-bs-toggle="modal"
                                            data-bs-target="#modal-success-<?php echo $type['id']; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                <path
                                                    d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                <path d="M16 5l3 3" />
                                            </svg>
                                        </a>
                                        <!-- Modal edit Structure -->
                                        <div class="modal modal-blur fade" id="modal-success-<?php echo $type['id']; ?>" tabindex="-1"
                                            aria-labelledby="modal-success-label" aria-hidden="true">
                                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                                <form method="POST" action="/dbs/editType">
                                                    <input type="hidden" name="id" value="<?php echo $type['id']; ?>">
                                                    <div class="modal-content">
                                                        <div class="modal-status bg-success"></div>
                                                        <div class="modal-body text-center py-4">
                                                            <h3>កែប្រែ</h3>
                                                            <div class="text-secondary">
                                                                <label class="form-label">ប្រភេទឯកសារ</label>
                                                                <input type="text" class="form-control" name="typedoc"
                                                                    value="<?php echo htmlspecialchars($type['typedoc']); ?>"
                                                                    placeholder="<?php echo htmlspecialchars($type['typedoc']); ?>"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer bg-light">
                                                            <div class="w-100">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <button type="button" class="btn btn-danger"
                                                                            data-bs-dismiss="modal"><svg
                                                                                xmlns="http://www.w3.org/2000/svg" width="24"
                                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-progress-x">
                                                                                <path stroke="none" d="M0 0h24v24H0z"
                                                                                    fill="none" />
                                                                                <path
                                                                                    d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" />
                                                                                <path
                                                                                    d="M14 3.223a9.003 9.003 0 0 1 0 17.554" />
                                                                                <path
                                                                                    d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" />
                                                                                <path
                                                                                    d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305" />
                                                                                <path
                                                                                    d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" />
                                                                                <path d="M14 14l-4 -4" />
                                                                                <path d="M10 14l4 -4" />
                                                                            </svg>បោះបង់</button>
                                                                    </div>
                                                                    <div class="col">
                                                                        <button type="submit" class="btn btn-success ms-auto">
                                                                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-progress-check">
                                                                                <path stroke="none" d="M0 0h24v24H0z"
                                                                                    fill="none" />
                                                                                <path
                                                                                    d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" />
                                                                                <path
                                                                                    d="M14 3.223a9.003 9.003 0 0 1 0 17.554" />
                                                                                <path
                                                                                    d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" />
                                                                                <path
                                                                                    d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305" />
                                                                                <path
                                                                                    d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" />
                                                                                <path d="M9 12l2 2l4 -4" />
                                                                            </svg>
                                                                            រក្សាទុក
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <a href="#" class="text-danger" title="Delete" data-bs-toggle="modal"
                                            data-bs-target="#modal-danger-<?php echo $type['id']; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 7l16 0" />
                                                <path d="M10 11l0 6" />
                                                <path d="M14 11l0 6" />
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                            </svg>
                                        </a>
                                        <div class="modal modal-blur fade" id="modal-danger-<?php echo $type['id']; ?>"
                                            tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                                <form method="POST" action="/dbs/deleteType">
                                                    <input type="hidden" name="id" value="<?php echo $type['id']; ?>">
                                                    <div class="modal-content">

                                                        <div class="modal-status bg-danger"></div>
                                                        <div class="modal-body text-center py-4">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon mb-2 text-danger icon-lg">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M12 9v4"></path>
                                                                <path
                                                                    d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z">
                                                                </path>
                                                                <path d="M12 16h.01"></path>
                                                            </svg>
                                                            <h3>តើអ្នកប្រាកដទេ?</h3>
                                                            <div class="text-secondary">តើអ្នកពិតជាចង់លុបមែនទេ?
                                                                អ្វីដែលអ្នកបានលុបមិនអាចត្រឡប់មកវិញបានទេ។</div>
                                                        </div>
                                                        <div class="modal-footer bg-light">
                                                            <div class="w-100">
                                                                <div class="row">
                                                                    <div class="col"><button type="button" class="btn w-100"
                                                                            data-bs-dismiss="modal"><svg
                                                                                xmlns="http://www.w3.org/2000/svg" width="24"
                                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-progress-x">
                                                                                <path stroke="none" d="M0 0h24v24H0z"
                                                                                    fill="none" />
                                                                                <path
                                                                                    d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" />
                                                                                <path
                                                                                    d="M14 3.223a9.003 9.003 0 0 1 0 17.554" />
                                                                                <path
                                                                                    d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" />
                                                                                <path
                                                                                    d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305" />
                                                                                <path
                                                                                    d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" />
                                                                                <path d="M14 14l-4 -4" />
                                                                                <path d="M10 14l4 -4" />
                                                                            </svg>បោះបង់</button></div>
                                                                    <div class="col">
                                                                        <button type="submit" class="btn btn-danger w-100"><svg
                                                                                xmlns="http://www.w3.org/2000/svg" width="24"
                                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-circle-dashed-check">
                                                                                <path stroke="none" d="M0 0h24v24H0z"
                                                                                    fill="none" />
                                                                                <path d="M8.56 3.69a9 9 0 0 0 -2.92 1.95" />
                                                                                <path d="M3.69 8.56a9 9 0 0 0 -.69 3.44" />
                                                                                <path d="M3.69 15.44a9 9 0 0 0 1.95 2.92" />
                                                                                <path d="M8.56 20.31a9 9 0 0 0 3.44 .69" />
                                                                                <path d="M15.44 20.31a9 9 0 0 0 2.92 -1.95" />
                                                                                <path d="M20.31 15.44a9 9 0 0 0 .69 -3.44" />
                                                                                <path d="M20.31 8.56a9 9 0 0 0 -1.95 -2.92" />
                                                                                <path d="M15.44 3.69a9 9 0 0 0 -3.44 -.69" />
                                                                                <path d="M9 12l2 2l4 -4" />
                                                                            </svg>យល់ព្រម</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        </tbody>
                        <?php
                        $cnt++;
                    }
                }
                ?>
            </table>
        </div>
    </div>
</div>




<?php include('src/includes/footer.php'); ?>