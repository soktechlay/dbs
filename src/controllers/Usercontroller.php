<?php
require_once 'src/models/User.php';
require_once 'src/models/departments/departmentModel.php';
require_once 'src/models/type/typeModel.php';
require_once 'src/models/documents/documentModel.php';

class Usercontroller
{

    public function manageDocuments()
    {
        // Load departments and types for the form
        $departmentModel = new departmentModel();
        $typeModel = new typeModel();
        $typedepartments = $departmentModel->gettypedepartment(); // Fetch department types
        $types = $typeModel->gettype(); // Fetch document types

        // Fetch all documents for initial load
        $getdocs = $this->getDocuments();

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
