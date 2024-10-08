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

$title = "ទំព័រដើម";
include('src/includes/header.php');
?>

<div class="page-header d-print-none mt-0 mb-2">
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
        <div class="col-12 col-sm-6 col-md-4 col-xl-3 mt-3 d-flex">
            <div class="card card-link w-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-auto">
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

<!-- Modal Structure with Table -->
<div class="modal fade" id="departmentModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Department Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Display department logo -->
                <div class="text-center mb-3">
                    <img id="modal-logo" src="" alt="Department Logo" class="img-fluid" style="width: 100px;">
                </div>
                <!-- Department Details Table -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Department Name</th>
                            <th>Document Count</th>
                            <th>Other Details</th> <!-- Add more columns as needed -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="modal-department-name"></td>
                            <td id="modal-document-count"></td>
                            <td id="modal-other-details"></td> <!-- Additional details will go here -->
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>document.addEventListener('DOMContentLoaded', function () {
        var departmentModal = document.getElementById('departmentModal');

        departmentModal.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            var card = event.relatedTarget;

            // Extract info from data-* attributes
            var departmentName = card.getAttribute('data-department');
            var documentCount = card.getAttribute('data-document-count');
            var logo = card.getAttribute('data-logo');
            var otherDetails = JSON.parse(card.getAttribute('data-other-details'));

            // Update the modal's content
            document.getElementById('modal-department-name').textContent = departmentName;
            document.getElementById('modal-document-count').textContent = documentCount;
            document.getElementById('modal-logo').src = logo;
            document.getElementById('modal-other-details').textContent = otherDetails || 'No additional details available';
        });
    });
</script>





<!-- <a href="/dbs/logout" class="dropdown-item">Logout</a> -->
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
    $(document).ready(function () {
        $('#example').DataTable({
            "searching": false,  // Disable search feature
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
                    "previous": "ថយក្រោយ"
                },
                "emptyTable": "គ្មានទិន្នន័យនៅក្នុងតារាង"
            }
        });
    });
</script>



<?php include('src/includes/footer.php'); ?>