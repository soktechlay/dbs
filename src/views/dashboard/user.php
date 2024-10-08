<?php
// Start or resume the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if user_id is not set
if (!isset($_SESSION['user_id'])) {
    header('Location: /dbs/login');
    exit();
}

$title = "ទំព័រដើម";
include('src/includes/header.php');
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

<div class="page-header d-print-none mt-0 mb-3">
    <div class="col-12">
        <div class="row g-2 align-items-center">
            <div class="col-12 d-flex align-items-center justify-content-between mb-3">
                <!-- Display the user's full name -->
                <h3 class="mb-0">
                    <span class="mef2 text-primary mx-2 me-0 mb-0">
                        <?php
                        // Display the user's full name from session if available, else fallback to 'User Name'
                        echo isset($_SESSION['user_khmer_name']) ? htmlspecialchars($_SESSION['user_khmer_name']) : 'User Name';
                        ?>
                    </span>
                </h3>
                <div class="dropdown">
                    <?php date_default_timezone_set('Asia/Bangkok'); ?>
                    <div class="text-primary h4">
                        <i class="bx bx-calendar me-2"></i>
                        <span id="real-time-clock"></span>
                        </d>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <?php foreach ($sourcedocCounts as $department): ?>
        <div class="col-12 col-sm-6 col-md-4 col-xl-3 mt-2 d-flex">
            <div class="card card-link w-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-auto ">
                            <!-- Display department logo -->
                            <span class="avatar rounded"
                                style="background-image: url('<?php echo !empty($department['logo']) ? "public/img/logo/" . $department['logo'] : "public/img/logo/default-logo.jpg"; ?>'); width: 50px; height: 50px; background-size: cover;">
                            </span>
                        </div>
                        <div class="col">
                            <!-- Display department name -->
                            <div class="font-weight-medium h5">
                                <?php echo $department['typedepartment'] ?? 'Unknown Department'; ?>
                            </div>
                            <!-- Display document count -->
                            <div class="text-primary text-center mt-2">
                                <h4><?php echo $department['document_count'] ?? 0; ?> ឯកសារ</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Filter section -->
<div class="card mt-3">
    <div class="card-body">
        <form action="/dbs/dashboard" method="post" id="filterForm">
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
            <div class="col-12 col-md-3"></div>
            <div class="col-12 col-md-6 text-center">
                <div class="h2">Internal Audit Unit Database System</div>
            </div>
        </div>
        <!-- Show data -->
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
                            $cnt = 1;
                            foreach ($getdocs as $getdoc) {
                                ?>
                                <tr> <!-- Add this opening <tr> tag -->
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
                                        <div class="d-flex">
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
                                            <div class="modal fade modal-blur"
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
                                        </div>
                                    </td>
                                </tr> <!-- Close the <tr> tag here -->
                                <?php
                                $cnt++; // Increment the counter
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




<script>
    function updateDateTime() {
        const clockElement = document.getElementById('real-time-clock');
        const currentTime = new Date();

        const daysOfWeek = ['អាទិត្យ', 'ច័ន្ទ', 'អង្គារ', 'ពុធ', 'ព្រហស្បតិ៍', 'សុក្រ', 'សៅរ៍'];
        const dayOfWeek = daysOfWeek[currentTime.getDay()];

        const months = ['មករា', 'កុម្ភៈ', 'មិនា', 'មេសា', 'ឧសភា', 'មិថុនា', 'កក្កដា', 'សីហា', 'កញ្ញា', 'តុលា', 'វិច្ឆិកា', 'ធ្នូ'];
        const month = months[currentTime.getMonth()];

        const day = currentTime.getDate();
        const year = currentTime.getFullYear();

        let hours = currentTime.getHours();
        let period;

        if (hours >= 5 && hours < 12) {
            period = 'ព្រឹក'; // Khmer for AM (morning)
        } else if (hours >= 12 && hours < 17) {
            period = 'រសៀល'; // Khmer for afternoon
        } else if (hours >= 17 && hours < 20) {
            period = 'ល្ងាច'; // Khmer for evening
        } else {
            period = 'យប់'; // Khmer for night
        }

        hours = hours % 12 || 12;
        const minutes = currentTime.getMinutes().toString().padStart(2, '0');
        const seconds = currentTime.getSeconds().toString().padStart(2, '0');

        const dateTimeString = `${dayOfWeek}, ${day} ${month} ${year} ${hours}:${minutes}:${seconds} ${period}`;
        clockElement.textContent = dateTimeString;
    }

    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>
<script>
    flatpickr("#flatpickr-range", {
        mode: "range",
        dateFormat: "Y-m-d",
        locale: {
            rangeSeparator: " to "
        }
    });
</script>
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
<?php
include('src/includes/footer.php');
?>