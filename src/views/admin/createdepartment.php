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

$title = "បង្កើតប្រភេទអង្គភាពក្រោមឱវាទ អ.ស.ហ.";
include('src/includes/header.php');
?>

<style>
    .card-btn {
        background-color: transparent;
        /* No background color by default */
        border: 1px solid transparent;
        /* No border color by default */
        color: inherit;
        /* Inherit text color */
        transition: background-color 0.3s, border-color 0.3s;
        /* Smooth transition */
    }

    .card-btn:hover {
        color: #fff;
        /* Text color when hovered */
    }

    .btn-success.card-btn:hover {
        background-color: #28a745;
        /* Success color on hover */
        border-color: #28a745;
        /* Border color on hover */
    }

    .btn-danger.card-btn:hover {
        background-color: #c82333;
        /* Danger color on hover */
        border-color: #bd2130;
        /* Border color on hover */
    }
</style>

<div class="page-header d-print-none mt-0 mb-3">
    <div class="col-12">
        <div class="row g-2 align-items-center">
            <div class="col-12 d-flex align-items-center justify-content-between mb-3">
                <!-- Display the user's full name -->
                <h3 class="mb-0">
                    <span class="mef2 text-primary mx-2 me-0 mb-0">
                        ប្រភេទអង្គភាពក្រោមឱវាទ អ.ស.ហ.
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
                            </svg>បង្កើតប្រភេទអង្គភាព
                        </a>
                        <div class="modal modal-blur fade" id="modal-report" tabindex="-1" style="display: none;"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-primary">បង្កើតប្រភេទអង្គភាពក្រោមឱវាទ អ.ស.ហ.</h5>
                                    </div>
                                    <form method="POST" action="/dbs/createdepartment" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">ប្រភេទអង្គភាពក្រោមឱវាទ អ.ស.ហ.</label>
                                                <input type="text" class="form-control" name="typedepartment"
                                                    placeholder="សូមបង្កើតប្រភេទអង្គភាពក្រោមឱវាទ អ.ស.ហ...." required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">បញ្ចូល Logo</label>
                                                <input type="file" class="form-control" name="logo" accept="image/*"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">បោះបង់</button>
                                            <button type="submit" class="btn btn-success ms-auto">
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
<!-- Page body -->
<?php if (!empty($gettypedepartment)): ?>
    <div class="row">
        <?php foreach ($gettypedepartment as $department): ?>
            <div class="col-md-6 col-lg-4 mb-4"> <!-- Added mb-4 for spacing between cards -->
                <div class="card h-100">
                    <div class="card-body p-1 responsive ">
                        <div class="mb-1 p-2 d-flex align-items-center justify-content-center">
                            <span class="avatar rounded"
                                style="background-image: url('<?php echo !empty($department['logo']) ? "public/img/logo/" . $department['logo'] : "public/img/logo/default-logo.jpg"; ?>'); width: 50px; height: 50px; background-size: cover;">
                            </span>
                        </div>
                        <div class="mb-1 p-2 d-flex align-items-center justify-content-between">
                            <h5 class="text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-text">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                    <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                    <path d="M9 12h6" />
                                    <path d="M9 16h6" />
                                </svg>ប្រភេទអង្គភាពក្រោមឱវាទ អ.ស.ហ. :
                            </h5>

                            <span class="text-body"><?php echo htmlspecialchars($department['typedepartment']); ?></span>

                        </div>
                        <div class="mb-1 p-2 d-flex align-items-center justify-content-between">
                            <h5 class="text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-stats">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4" />
                                    <path d="M18 14v4h4" />
                                    <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                    <path d="M15 3v4" />
                                    <path d="M7 3v4" />
                                    <path d="M3 11h16" />
                                </svg>កាលបរិច្ឆេទបញ្ចូល :
                            </h5>
                            <?php
                            $date = new DateTime($department['created_at']);
                            $formattedDate = $date->format('F j, Y'); // Format as Month Day, Year
                            ?>
                            <span class="text-body"><?php echo htmlspecialchars($formattedDate); ?></span>

                        </div>
                    </div>
                    <div class="d-flex">
                        <a href="#" class="card-btn btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#modal-success-<?php echo $department['id']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                <path d="M16 5l3 3" />
                            </svg>
                            កែប្រែ
                        </a>
                        <!-- Modal edit Structure -->
                        <div class="modal modal-blur fade" id="modal-success-<?php echo $department['id']; ?>" tabindex="-1"
                            aria-labelledby="modal-success-label" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                <form method="POST" action="/dbs/editDepartment" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($department['id']); ?>">
                                    <div class="modal-content">
                                        <div class="modal-status bg-success"></div>
                                        <div class="modal-body text-center text-primary py-4">
                                            <h3>កែប្រែ</h3>
                                            <div class="text-secondary">
                                                <label class="form-label h4">ប្រភេទអង្គភាពក្រោមឱវាទ អ.ស.ហ.</label>
                                                <input type="text" class="form-control" name="typedepartment"
                                                    value="<?php echo htmlspecialchars($department['typedepartment']); ?>"
                                                    required>

                                                <div class="mt-3">
                                                    <label class="form-label">កែប្រែឡូហ្គូ</label>
                                                    <input type="file" class="form-control" name="logo" accept="image/*"
                                                        id="logoInput">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer bg-light">
                                            <div class="w-100">
                                                <div class="row">
                                                    <div class="col">
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-progress-x">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" />
                                                                <path d="M14 3.223a9.003 9.003 0 0 1 0 17.554" />
                                                                <path d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" />
                                                                <path
                                                                    d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305" />
                                                                <path d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" />
                                                                <path d="M14 14l-4 -4" />
                                                                <path d="M10 14l4 -4" />
                                                            </svg>
                                                            បោះបង់
                                                        </button>
                                                    </div>
                                                    <div class="col text-end">
                                                        <button type="submit" class="btn btn-success">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-progress-check">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" />
                                                                <path d="M14 3.223a9.003 9.003 0 0 1 0 17.554" />
                                                                <path d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" />
                                                                <path
                                                                    d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305" />
                                                                <path d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" />
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

                        <a href="#" class="card-btn btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#modal-danger-<?php echo $department['id']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icon-tabler-trash">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 7l16 0" />
                                <path d="M10 11l0 6" />
                                <path d="M14 11l0 6" />
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                            </svg>
                            លុប
                        </a>
                        <!-- Modal delete Structure -->
                        <div class="modal modal-blur fade" id="modal-danger-<?php echo $department['id']; ?>" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                <form method="POST" action="/dbs/deleteDepartment">
                                    <input type="hidden" name="id" value="<?php echo $department['id']; ?>">
                                    <div class="modal-content">

                                        <div class="modal-status bg-danger"></div>
                                        <div class="modal-body text-center py-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="icon mb-2 text-danger icon-lg">
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
                                                            data-bs-dismiss="modal"><svg xmlns="http://www.w3.org/2000/svg"
                                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-progress-x">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" />
                                                                <path d="M14 3.223a9.003 9.003 0 0 1 0 17.554" />
                                                                <path d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" />
                                                                <path
                                                                    d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305" />
                                                                <path d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" />
                                                                <path d="M14 14l-4 -4" />
                                                                <path d="M10 14l4 -4" />
                                                            </svg>បោះបង់</button></div>
                                                    <div class="col">
                                                        <button type="submit" class="btn btn-danger w-100"><svg
                                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-circle-dashed-check">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
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
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>





<!-- <div class="card-datatable dataTable_select text-nowrap pb-2">
    <div id="DataTables_Table_3_wrapper">
        <table class="datatables-ajax dt-select-table table dataTable no-footer dt-checkboxes-select" id="example"
            aria-describedby="DataTables_Table_3_info">
            <thead>
                <tr>
                    <th>ល.រ</th>
                    <th>ប្រភេទអង្គភាពក្រោមឱវាទ អ.ស.ហ.</th>
                    <th>កាលបរិច្ឆេទបញ្ចូល</th>
                    <th>សកម្មភាព</th>
                </tr>
            </thead>
            <tbody>
                Data will be inserted here
            </tbody>
        </table>
    </div>
</div>

 <script>
    $(document).ready(function () {
        $('#example').DataTable({
            "searching": false,  // Disable search feature
            "language": {
                "lengthMenu": "បង្ហាញ _MENU_ តារាង",
                "zeroRecords": "គ្មានទិន្នន័យនៅក្នុងតារាងនេះទេ",
                "info": "បង្ហាញ _START_ ទៅ _END_ នៃ _TOTAL_ នាក់",
                "infoEmpty": "បង្ហាញ 0 ទៅ 0 នៃ 0 ចំនួន",
                "infoFiltered": "(បានច្រោះពី _MAX_ ទិន្នន័យសរុប)",
                "paginate": {
                    "first": "ទីមួយ",
                    "last": "ចុងក្រោយ",
                    "next": "បន្ទាប់",
                    "previous": "ថយក្រោយ"
                },
                "emptyTable": "គ្មានទិន្នន័យនៅក្នុងតារាង"
            }
        });
    });
</script>  -->


<?php include('src/includes/footer.php'); ?>