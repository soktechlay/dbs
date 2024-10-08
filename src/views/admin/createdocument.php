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

$title = "បង្កើតឯកសារ";
include('src/includes/header.php');
?>

<div class="page-header d-print-none mt-0 mb-3">
    <div class="col-12">
        <div class="row g-2 align-items-center">
            <div class="col-12 d-flex align-items-center justify-content-between mb-3">
                <!-- Display the user's full name -->
                <h3 class="mb-0">
                    <span class="mef2 text-primary mx-2 me-0 mb-0">
                        បង្កើតឯកសារ
                    </span>
                </h3>

            </div>
        </div>
    </div>
</div>
<!-- filter -->
<div class="card">
    <div class="card-body">
        <form action="/dbs/createdocument" method="post" id="filterForm">
            <div class="row">
                <!-- Select for organizational unit -->
                <div class="col-md-3 mb-3">
                    <select name="sourcedoc_filter" class="form-select">
                        <option value="" disabled selected>ជ្រើសរើសអង្គភាពក្រោមឱវាទ អ.ស.ហ.</option>
                        <?php foreach ($typedepartments as $dept): ?>
                            <option value="<?php echo htmlentities($dept['id']); ?>">
                                <?php echo htmlentities($dept['typedepartment']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Select for document type -->
                <div class="col-md-3 mb-3">
                    <select name="typedoc_filter" class="form-select">
                        <option value="" disabled selected>ប្រភេទឯកសារ</option>
                        <?php foreach ($types as $type): ?>
                            <option value="<?php echo htmlentities($type['id']); ?>">
                                <?php echo htmlentities($type['typedoc']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Input field for search -->
                <div class="col-md-3 mb-3">
                    <input type="text" name="search_query" placeholder="ស្វែងរកតាមរយៈកូដឬឈ្មោះឯកសារ"
                        class="form-control">
                </div>
                <!-- Form for date range -->
                <div class="col-md-2 mb-3">
                    <input type="text" class="form-control" placeholder="ពីថ្ងៃខែឆ្នាំ ដល់ ថ្ងៃខែឆ្នាំ"
                        id="flatpickr-range" name="date_range" readonly>
                </div>
                <!-- Submit button -->
                <div class="col-md-1 justify-content-end">
                    <button type="submit" class="btn btn-secondary">ស្វែងរក</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="card mt-3">
    <div class="card-body">
        <div class="row">
            <!-- Empty column for spacing -->
            <div class="col-12 col-md-3"></div>

            <!-- Centered text -->
            <div class="col-12 col-md-6 text-center">
                <div class="h2">Internal Audit Unit Database System</div>
            </div>

            <!-- Right-aligned text -->
            <div class="col-12 col-md-3 d-flex align-items-center justify-content-end">
                <div class="btn-list">
                    <a href="#" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal-report">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5v14" />
                            <path d="M5 12h14" />
                        </svg> បញ្ចូលឯកសារថ្មី
                    </a>
                    <div class="modal modal-blur fade" id="modal-report" tabindex="-1" style="display: none;"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-primary">បញ្ចូលឯកសារថ្មី</h5>
                                </div>
                                <form method="POST" action="/dbs/createdocument" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">លេខកូដឯកសារ</label>
                                            <input type="text" class="form-control" name="codedoc"
                                                placeholder="សូមបំពេញលេខកូដឯកសារ..." required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">សង្ខេបឈ្មោះឯកសារ</label>
                                            <input type="text" class="form-control" name="namedoc"
                                                placeholder="សូមបំពេញសង្ខេបឈ្មោះឯកសារ..." required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">ប្រភេទឯកសារ</label>
                                            <select class="form-control" name="typedoc" required>
                                                <option value="" disabled selected>ប្រភេទឯកសារ</option>
                                                <?php foreach ($types as $type): ?>
                                                    <option value="<?php echo htmlentities($type['id']); ?>">
                                                        <?php echo htmlentities($type['typedoc']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">ប្រភពឯកសារ</label>
                                            <select class="form-control" name="sourcedoc" required>
                                                <option value="" disabled selected>ជ្រើសរើសអង្គភាពក្រោមឱវាទ អ.ស.ហ.
                                                </option>
                                                <?php foreach ($typedepartments as $dept): ?>
                                                    <option value="<?php echo htmlentities($dept['id']); ?>">
                                                        <?php echo htmlentities($dept['typedepartment']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">បញ្ចូលឯកសារ</label>
                                            <input class="form-control" type="file" id="formFile" name="file" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal">បោះបង់</button>
                                        <button type="submit" class="btn btn-success ms-auto">រក្សាទុក</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- show data -->
        <div class="card-datatable dataTable_select text-nowrap pb-2">
            <div class="table-responsive">
                <table class="datatables-ajax dt-select-table table dataTable no-footer dt-checkboxes-select"
                    id="example">
                    <thead>
                        <tr>
                            <th>ល.រ</th>
                            <th>លេខកូដឯកសារ</th>
                            <th>ឈ្មោះឯកសារ</th>
                            <th>ប្រភេទឯកសារ</th>
                            <th>ប្រភពឯកសារ</th>
                            <th>កាលបរិច្ឆេទបញ្ចូល</th>
                            <th>កាលបរិច្ឆេទកែប្រែ</th>
                            <th>សកម្មភាព</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($getdocs)) {
                            $cnt = 1; // Initialize counter
                            foreach ($getdocs as $getdoc) {
                                ?>
                                <tr> <!-- Opening <tr> tag for each document -->
                                    <td class="text-sm font-weight-bold mb-0"><b><?php echo htmlentities($cnt); ?></b></td>
                                    <td>
                                        <div class="d-inline-block text-truncate" style="max-width:180px;"
                                            data-bs-toggle="tooltip" title="<?php echo htmlentities($getdoc['codedoc']); ?>">
                                            <?php echo htmlentities($getdoc['codedoc']); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-inline-block text-truncate" style="max-width:250px;"
                                            data-bs-toggle="tooltip" title="<?php echo htmlentities($getdoc['namedoc']); ?>">
                                            <?php echo htmlentities($getdoc['namedoc']); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-inline-block text-truncate" style="max-width:250px;"
                                            data-bs-toggle="tooltip" title="<?php echo htmlentities($getdoc['typedoc']); ?>">
                                            <?php echo htmlentities($getdoc['typedoc']); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-inline-block text-truncate" style="max-width:250px;"
                                            data-bs-toggle="tooltip" title="<?php echo htmlentities($getdoc['sourcedoc']); ?>">
                                            <?php echo htmlentities($getdoc['sourcedoc']); ?>
                                        </div>
                                    </td>
                                    <td><?php echo htmlentities($getdoc['created_at']); ?></td>
                                    <td><?php echo htmlentities($getdoc['updated_at']); ?></td>
                                    <td>
                                        <div class="d-flex ">
                                            <!-- Modal view -->
                                            <a href="#" class="text-success me-2" data-bs-toggle="modal"
                                                data-bs-target="#documentModal-<?php echo htmlentities($getdoc['id']); ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                    <path
                                                        d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                </svg>
                                            </a>
                                            <div class="modal fade"
                                                id="documentModal-<?php echo htmlentities($getdoc['id']); ?>" tabindex="-1"
                                                aria-labelledby="documentModalLabel-<?php echo htmlentities($getdoc['id']); ?>"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-primary"
                                                                id="documentModalLabel-<?php echo htmlentities($getdoc['id']); ?>">
                                                                ពិនិត្យមើ់លឯកសារ</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <iframe
                                                                src="public/uploads/<?php echo htmlentities($getdoc['file']); ?>"
                                                                width="100%" height="700px"></iframe>
                                                        </div>
                                                        <div class="modal-footer bg-light">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">បោះបង់</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal edit Structure -->
                                            <a href="#" class="text-primary me-2" data-bs-toggle="modal"
                                                data-bs-target="#modal-success-<?php echo $getdoc['id']; ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icon-tabler-edit">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                    <path
                                                        d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                    <path d="M16 5l3 3" />
                                                </svg>
                                            </a>
                                            <div class="modal modal-blur fade" id="modal-success-<?php echo $getdoc['id']; ?>"
                                                tabindex="-1" aria-labelledby="modal-success-label" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <form method="POST" action="/dbs/editDocument"
                                                        enctype="multipart/form-data">
                                                        <input type="hidden" name="id" value="<?php echo $getdoc['id']; ?>">

                                                        <div class="modal-content">
                                                            <div class="modal-status bg-success"></div>
                                                            <div class="modal-body text-center py-4">
                                                                <h3>កែប្រែ</h3>

                                                                <div class="mb-3">
                                                                    <label class="form-label">លេខកូដឯកសារ</label>
                                                                    <input type="text" class="form-control" name="codedoc"
                                                                        value="<?php echo htmlentities($getdoc['codedoc']); ?>">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">សង្ខេបឈ្មោះឯកសារ</label>
                                                                    <input type="text" class="form-control" name="namedoc"
                                                                        value="<?php echo htmlentities($getdoc['namedoc']); ?>">
                                                                </div>

                                                                <!-- Dropdown for sourcedoc_id -->
                                                                <div class="mb-3">
                                                                    <label class="form-label">ប្រភពឯកសារ</label>
                                                                    <select class="form-control" name="sourcedoc_id">
                                                                        <!-- Default option -->
                                                                        <option value="">Select Source Document</option>
                                                                        <!-- Loop through available departments -->
                                                                        <?php foreach ($typedepartments as $dept): ?>
                                                                            <option value="<?php echo htmlentities($dept['id']); ?>"
                                                                                <?php echo (isset($getdoc['sourcedoc_id']) && $dept['id'] == $getdoc['sourcedoc_id']) ? 'selected' : ''; ?>>
                                                                                <?php echo htmlentities($dept['typedepartment']); ?>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>

                                                                <!-- Dropdown for typedoc_id -->
                                                                <div class="mb-3">
                                                                    <label class="form-label">ប្រភេទឯកសារ</label>
                                                                    <select class="form-control" name="typedoc_id">
                                                                        <!-- Default option -->
                                                                        <option value="">Select Document Type</option>
                                                                        <!-- Loop through available types -->
                                                                        <?php foreach ($types as $type): ?>
                                                                            <option value="<?php echo htmlentities($type['id']); ?>"
                                                                                <?php echo (isset($getdoc['typedoc_id']) && $type['id'] == $getdoc['typedoc_id']) ? 'selected' : ''; ?>>
                                                                                <?php echo htmlentities($type['typedoc']); ?>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>


                                                                <div class="mb-3">
                                                                    <label for="file" class="form-label">ឯកសារ</label>
                                                                    <div class="input-group">
                                                                        <!-- Display the current file name in a read-only text input -->
                                                                        <input type="text" class="form-control"
                                                                            value="<?php echo htmlentities($getdoc['file']); ?>"
                                                                            readonly>

                                                                        <!-- File input for uploading a new file -->
                                                                        <input type="file" class="form-control" id="file"
                                                                            name="file">
                                                                    </div>
                                                                    <!-- Hidden input to pass the current file name -->
                                                                    <input type="hidden" name="current_file"
                                                                        value="<?php echo htmlentities($getdoc['file']); ?>">
                                                                </div>


                                                            </div>

                                                            <div class="modal-footer bg-light">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-dismiss="modal">បោះបង់</button>
                                                                <button type="submit" class="btn btn-success">រក្សាទុក</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- Modal delete Structure -->
                                            <a href="#" class="text-danger " title="Delete" data-bs-toggle="modal"
                                                data-bs-target="#modal-danger-<?php echo $getdoc['id']; ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icon-tabler-trash">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 7l16 0" />
                                                    <path d="M10 11l0 6" />
                                                    <path d="M14 11l0 6" />
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                </svg>
                                            </a>
                                            <div class="modal modal-blur fade" id="modal-danger-<?php echo $getdoc['id']; ?>"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                                    <form method="POST" action="/dbs/deleteDocument">
                                                        <input type="hidden" name="id" value="<?php echo $getdoc['id']; ?>">
                                                        <div class="modal-content">
                                                            <div class="modal-status bg-danger"></div>
                                                            <div class="modal-body text-center py-4">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round"
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
                                                                        <div class="col">
                                                                            <button type="button" class="btn w-100"
                                                                                data-bs-dismiss="modal"><svg
                                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                                    width="24" height="24" viewBox="0 0 24 24"
                                                                                    fill="none" stroke="currentColor"
                                                                                    stroke-width="2" stroke-linecap="round"
                                                                                    stroke-linejoin="round"
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
                                                                            <button type="submit"
                                                                                class="btn btn-danger w-100"><svg
                                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                                    width="24" height="24" viewBox="0 0 24 24"
                                                                                    fill="none" stroke="currentColor"
                                                                                    stroke-width="2" stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-circle-dashed-check">
                                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                                        fill="none" />
                                                                                    <path d="M8.56 3.69a9 9 0 0 0 -2.92 1.95" />
                                                                                    <path d="M3.69 8.56a9 9 0 0 0 -.69 3.44" />
                                                                                    <path d="M3.69 15.44a9 9 0 0 0 1.95 2.92" />
                                                                                    <path d="M8.56 20.31a9 9 0 0 0 3.44 .69" />
                                                                                    <path
                                                                                        d="M15.44 20.31a9 9 0 0 0 2.92 -1.95" />
                                                                                    <path
                                                                                        d="M20.31 15.44a9 9 0 0 0 .69 -3.44" />
                                                                                    <path
                                                                                        d="M20.31 8.56a9 9 0 0 0 -1.95 -2.92" />
                                                                                    <path
                                                                                        d="M15.44 3.69a9 9 0 0 0 -3.44 -.69" />
                                                                                    <path d="M9 12l2 2l4 -4" />
                                                                                </svg>យល់ព្រម
                                                                            </button>
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
                                </tr> <!-- Closing <tr> tag for each document -->
                                <?php
                                $cnt++; // Increment counter
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                $('#example').DataTable({
                    "searching": false,
                    "responsive": {
                        "details": {
                            "type": 'column',
                            "target": 'tr' // Show details in a row
                        }
                    },
                    "language": {
                        "lengthMenu": "បង្ហាញ _MENU_ តារាង",
                        "zeroRecords": "គ្មានទិន្នន័យនៅក្នុងតារាងនេះទេ",
                        "info": "បង្ហាញ _START_ ទៅ _END_ នៃ _TOTAL_ ចំនួន",
                        "infoEmpty": "បង្ហាញ 0 ទៅ 0 នៃ 0 ចំនួន",
                        "infoFiltered": "(បានច្រោះពី _MAX_ ទិន្នន័យសរុប)",
                        "paginate": {
                            "first": "ទីមួយ",
                            "last": "ចុងក្រោយ",
                            "next": "បន្ទាប់",
                            "previous": "ត្រឡប់ក្រោយ"
                        },
                        "emptyTable": "គ្មានទិន្នន័យនៅក្នុងតារាង"
                    }
                });
            });
        </script>

    </div>
</div>
<!-- <a href="/dbs/logout" class="dropdown-item">Logout</a> -->

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">


<!-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> -->
<!-- <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script> -->


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
flatpickr("#flatpickr-range", {
    mode: "range",
    dateFormat: "Y-m-d", // Ensure date format is compatible
});
</script>



<?php include('src/includes/footer.php'); ?>