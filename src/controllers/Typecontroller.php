<?php
require_once 'src/models/User.php';
require_once 'src/models/departments/departmentModel.php';
require_once 'src/models/type/typeModel.php';

class Typecontroller
{
    public function createTpye()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize input
            $typedoc = htmlspecialchars(trim($_POST['typedoc']));

            // Insert the data into the database
            $typeModel = new typeModel(); // Instantiate the model
            if ($typeModel->typeExists($typedoc)) {
                // Error message if the department type already exists
                $_SESSION['error'] = "ប្រភេទឯកសារមានរួចហើយ!";
            } else {
                // Insert the data into the database
                if ($typeModel->createtype($typedoc)) {
                    // Success message
                    $_SESSION['success'] = "ប្រភេទឯកសារត្រូវបានបង្កើតដោយជោគជ័យ!";
                } else {
                    // Error message
                    $_SESSION['error'] = "មានបញ្ហាក្នុងការបង្កើតប្រភេទឯកសារ!";
                }
            }
        }

        $typeController = new typeModel();
        $gettypedoc = $typeController->gettype();
        require 'src/views/admin/createtype.php';
    }
    public function editType()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $typeId = $_POST['id'];
            $typeDoc = $_POST['typedoc'];

            $typeController = new typeModel();
            $editType = $typeController->editType($typeId, $typeDoc);

            if ($editType) {
                $_SESSION['success'] = 'កែប្រែបានជោគជ័យ';
                header('location: /dbs/createtype');
            } else {
                $_SESSION['error'] = 'កែប្រែមិនបានជោគជ័យ';
                header('location: /dbs/createtype');
            }
        }

    }
    public function deleteType()
    {
        // Retrieve the department ID from the POST data
        $typeId = $_POST['id'];

        // Call the delete method from the model
        $typeController = new typeModel();
        $isDeleted = $typeController->deleteType($typeId);

        if ($isDeleted) {
            // Success message
            $_SESSION['success'] = "លុបបានជោគជ័យ";
        } else {
            // Error message
            $_SESSION['error'] = "លុបមិនបានជោគជ័យ";
        }

        // Redirect back to the department listing page
        header("location: /dbs/createtype");
        exit();
    }


}
