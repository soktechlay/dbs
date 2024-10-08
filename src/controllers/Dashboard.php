<?php
require_once 'src/models/User.php';
require_once 'src/models/departments/departmentModel.php';
require_once 'src/models/type/typeModel.php';
require_once 'src/models/documents/documentModel.php';

class Dashboard
{
    public function dashboard()
    {
        // Check if the user is logged in as admin
        if (isset($_SESSION['admin_id'])) {
            // Load the admin dashboard
            $countModel = new documentModel();
            $sourcedocCounts = $countModel->countRecordsBySourcedoc();
            $documentModel = new documentModel();
            $getdocs = $documentModel->getdoc();
            require 'src/views/dashboard/admin.php';
        } elseif (isset($_SESSION['user_id'])) {
            // Load the user dashboard if logged in as a regular user
            $departmentModel = new departmentModel();
            $typeModel = new typeModel();
            $typedepartments = $departmentModel->gettypedepartment(); // Fetch department types
            $types = $typeModel->gettype(); // Fetch document types

            // Initialize the document model
            $documentModel = new documentModel();

            // Check if the filter form was submitted
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $getdocs = $this->getDocuments();
            } else {
                // Fetch all documents for initial load
                $userModel = new documentModel();

                $getdocs = $documentModel->getdoc(); // Use getdoc() to fetch documents
                $filteredDocs = []; // Initialize to an empty array
            }

            // Count records by sourcedoc
            $countModel = new documentModel();
            $sourcedocCounts = $countModel->countRecordsBySourcedoc();

            // Pass data to the user dashboard view
            require 'src/views/dashboard/user.php';
        } else {
            // If not logged in, redirect to the login page
            header('Location: /dbs/login');
            exit;
        }
    }

    private function getDocuments()
    {
        $documentModel = new documentModel();

        // Handle filtering if there are filter criteria
        $sourcedoc_filter = $_POST['sourcedoc_filter'] ?? null;
        $typedoc_filter = $_POST['typedoc_filter'] ?? null;
        $search_query = $_POST['search_query'] ?? null;
        $date_range = $_POST['date_range'] ?? null;

        // Fetch filtered documents if any filters are applied
        if ($sourcedoc_filter || $typedoc_filter || $search_query || $date_range) {
            return $documentModel->getdoc($sourcedoc_filter, $typedoc_filter, $search_query, $date_range);
        }

        // If no filters, fetch all documents
        return $documentModel->getdoc();
    }
}
