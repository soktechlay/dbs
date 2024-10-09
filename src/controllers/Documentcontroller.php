<?php
require_once 'src/models/User.php';
require_once 'src/models/departments/departmentModel.php';
require_once 'src/models/type/typeModel.php';
require_once 'src/models/documents/documentModel.php';


class Documentcontroller
{
    // public function createdocument()
    // {
    //     // Check if the form was submitted via POST
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $code = $_POST['codedoc'];
    //         $name = $_POST['namedoc'];
    //         $type = $_POST['typedoc'];
    //         $source = $_POST['sourcedoc'];

    //         // Initialize variables
    //         $targetDir = "public/uploads/";
    //         $fileName = basename($_FILES["file"]["name"]);
    //         $targetFilePath = $targetDir . $fileName;
    //         $uploadOk = true;

    //         // Create an instance of DocumentModel
    //         $DocumentModel = new DocumentModel();

    //         // Check if codedoc already exists
    //         if ($DocumentModel->codedocExists($code)) {
    //             $_SESSION['error'] = 'លេខកូដឯកសារមានរួចហើយ!';
    //             $uploadOk = false;
    //         }

    //         // Check if file type is valid
    //         $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    //         $allowedTypes = ['jpg', 'png', 'pdf', 'doc', 'docx'];
    //         if (!in_array($fileType, $allowedTypes)) {
    //             $_SESSION['error'] = 'Invalid file type.';
    //             $uploadOk = false;
    //         }

    //         // Attempt file upload if everything is OK
    //         if ($uploadOk && move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
    //             // File uploaded successfully, save document data to the database
    //             if ($uploadOk) {
    //                 $result = $DocumentModel->createdocument([
    //                     'codedoc' => $code,
    //                     'namedoc' => $name,
    //                     'typedoc' => $type,
    //                     'sourcedoc' => $source,
    //                     'file' => $fileName,
    //                 ]);

    //                 if ($result) {
    //                     // Success message
    //                     $_SESSION['success'] = "ប្រភេទឯកសារត្រូវបានបង្កើតដោយជោគជ័យ!";
    //                 } else {
    //                     // Error message
    //                     $_SESSION['error'] = "មានបញ្ហាក្នុងការបង្កើតប្រភេទឯកសារ!";
    //                 }

    //                 // Redirect after processing
    //                 header('Location: /dbs/createdocument');
    //                 exit;
    //             }
    //         }
    //     }


    //     // Load departments and types for the form
    //     $departmentcontroller = new departmentModel();
    //     $typedepartments = $departmentcontroller->gettypedepartment(); // Fetch department types

    //     $typecontroller = new typeModel();
    //     $types = $typecontroller->gettype(); // Fetch document types

    //     $userController = new documentModel();
    //     $getdocs = $userController->getdoc(); // Fetch documents

    //     // Load the view
    //     require 'src/views/admin/createdocument.php';
    // }

    public function editDocument()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Collect POST data
            $data = [
                'id' => $_POST['id'],
                'typedoc_id' => $_POST['typedoc_id'],  // Receiving typedoc_id from the form
                'sourcedoc_id' => $_POST['sourcedoc_id'],  // Receiving sourcedoc_id from the form
                'codedoc' => $_POST['codedoc'],  // Receiving codedoc from the form
                'namedoc' => $_POST['namedoc'],  // Receiving namedoc from the form
                'file' => $_POST['current_file']  // Default to current file
            ];

            // Check if a new file is uploaded
            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                // Define the target directory where the file will be stored
                $targetDir = "/public/uploads/";
                $fileName = basename($_FILES["file"]["name"]);
                $targetFilePath = $targetDir . $fileName;

                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
                    // File uploaded successfully
                    $data['file'] = $fileName;  // Save the new file name in the $data array
                } else {
                    $_SESSION['error'] = 'File upload failed';
                    header('Location: /dbs/createdocument');
                    exit();
                }
            }

            // Call the model to update the document
            $documentController = new DocumentModel();
            $editType = $documentController->editDocument($data);

            // Check if the update was successful
            if ($editType) {
                $_SESSION['success'] = 'កែប្រែបានជោគជ័យ';
            } else {
                $_SESSION['error'] = 'កែប្រែមិនបានជោគជ័យ';
            }

            // Redirect after update
            header('Location: /dbs/createdocument');
            exit();
        }
    }

    public function manageDocuments()
    {
        // Load departments and types for the form
        $departmentModel = new departmentModel();
        $typeModel = new typeModel();
        $typedepartments = $departmentModel->gettypedepartment(); // Fetch department types
        $types = $typeModel->gettype(); // Fetch document types

        // Check if the form was submitted via POST for document creation
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['codedoc'])) {
            $this->createDocument();
        } else {
            // If no POST request, fetch all documents for initial load
            $getdocs = $this->getDocuments();
        }

        // Load the view
        require 'src/views/admin/createdocument.php';
    }

    private function createDocument()
    {
        // Check if file upload has errors
        if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            $errorCode = $_FILES['file']['error'];
            switch ($errorCode) {
                case UPLOAD_ERR_INI_SIZE:
                    $_SESSION['error'] = "Error: File exceeds the upload_max_filesize directive in php.ini.";
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $_SESSION['error'] = "Error: File exceeds the MAX_FILE_SIZE directive specified in the HTML form.";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $_SESSION['error'] = "Error: File was only partially uploaded.";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $_SESSION['error'] = "Error: No file was uploaded.";
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $_SESSION['error'] = "Error: Missing a temporary folder.";
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $_SESSION['error'] = "Error: Failed to write file to disk.";
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $_SESSION['error'] = "Error: A PHP extension stopped the file upload.";
                    break;
                default:
                    $_SESSION['error'] = "Unknown error occurred during file upload.";
            }
            header('Location: /dbs/createdocument');
            exit;
        }

        // Validate and sanitize input data
        $code = htmlspecialchars(trim($_POST['codedoc']));
        $name = htmlspecialchars(trim($_POST['namedoc']));
        $type = htmlspecialchars(trim($_POST['typedoc']));
        $source = htmlspecialchars(trim($_POST['sourcedoc']));

        // Instantiate the document model
        $documentModel = new documentModel();

        // Check if codedoc already exists
        if ($documentModel->codedocExists($code)) {
            $_SESSION['error'] = 'លេខកូដឯកសារមានរួចហើយ!';
            header('Location: /dbs/createdocument');
            exit;
        }

        // File upload setup
        $targetDir = "public/uploads/";
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        // Check if file type is valid
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'png', 'pdf', 'doc', 'docx'];
        if (!in_array($fileType, $allowedTypes)) {
            $_SESSION['error'] = 'Invalid file type.';
            header('Location: /dbs/createdocument');
            exit;
        }

        // Try to move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            // Save document data to the database
            $result = $documentModel->createDocument([
                'codedoc' => $code,
                'namedoc' => $name,
                'typedoc' => $type,
                'sourcedoc' => $source,
                'file' => $fileName,
            ]);

            if ($result) {
                $_SESSION['success'] = "ប្រភេទឯកសារត្រូវបានបង្កើតដោយជោគជ័យ!";
            } else {
                $_SESSION['error'] = "មានបញ្ហាក្នុងការបង្កើតប្រភេទឯកសារ!";
            }
        } else {
            $_SESSION['error'] = "មានបញ្ហាក្នុងការផ្ទុកឡើងឯកសារ!!";
        }

        // Redirect after processing
        header('Location: /dbs/createdocument');
        exit;
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

    public function deleteDocument()
    {
        // Retrieve the department ID from the POST data
        $documentId = $_POST['id'];

        // Call the delete method from the model
        $documentController = new documentModel();
        $isDeleted = $documentController->deleteDocument($documentId);

        if ($isDeleted) {
            // Success message
            $_SESSION['success'] = "លុបបានជោគជ័យ";
        } else {
            // Error message
            $_SESSION['error'] = "លុបមិនបានជោគជ័យ";
        }

        // Redirect back to the department listing page
        header("location: /dbs/createdocument");
        exit();
    }


}


