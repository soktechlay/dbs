<?php
require_once 'src/models/User.php';
require_once 'src/models/departments/departmentModel.php';

class Departmentcontroller
{
    public function createdepartment()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize input
            $typedepartment = htmlspecialchars(trim($_POST['typedepartment']));

            // Handle file upload (logo)
            $logo = $_FILES['logo'];
            $targetDir = "public/img/logo/"; // Corrected path
            $uniqueFileName = basename($logo['name']); // Ensure file uniqueness
            $targetFile = $targetDir . $uniqueFileName;
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if the directory exists, if not, create it
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Check if image file is a valid image
            $check = getimagesize($logo["tmp_name"]);
            if ($check === false) {
                $_SESSION['error'] = "ឯកសារដែលបានជ្រើសមិនមែនជារូបភាព!";
                $uploadOk = 0;
            }

            // Check file size (5MB max)
            if ($logo["size"] > 5000000) {
                $_SESSION['error'] = "ឯកសារទំហំធំពេក!";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $_SESSION['error'] = "ត្រូវបានអនុញ្ញាតតែឯកសារ JPG, JPEG, PNG និង GIF ប៉ុណ្ណោះ!";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $_SESSION['error'] = "ការផ្ទុកឯកសារបរាជ័យ!";
            } else {
                // Try to upload the file
                if (move_uploaded_file($logo["tmp_name"], $targetFile)) {
                    // Instantiate the model
                    $departmentModel = new departmentModel();

                    if ($departmentModel->typedepartmentExists($typedepartment)) {
                        // Error message if the department type already exists
                        $_SESSION['error'] = "ប្រភេទអង្គភាពមានរួចហើយ!";
                    } else {
                        // Insert the data into the database
                        if ($departmentModel->createdepartment($typedepartment, $uniqueFileName)) {
                            // Success message
                            $_SESSION['success'] = "ប្រភេទអង្គភាពត្រូវបានបង្កើតដោយជោគជ័យ!";
                        } else {
                            // Error message
                            $_SESSION['error'] = "មានបញ្ហាក្នុងការបង្កើតប្រភេទអង្គភាព!";
                        }
                    }
                } else {
                    $_SESSION['error'] = "មានបញ្ហាក្នុងការផ្ទុកឡូហ្គូ!";
                }
            }
        }

        // Fetch department types
        $departmentModel = new departmentModel();
        $gettypedepartment = $departmentModel->gettypedepartment();

        // Load the view file
        require 'src/views/admin/createdepartment.php';
    }
    public function editDepartment()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $departmentId = $_POST['id'];
            $departmentName = $_POST['typedepartment'];
            $logo = null; // Initialize logo

            // Fetch current department details to get the existing logo
            $departmentModel = new departmentModel();
            $department = $departmentModel->getDepartmentById($departmentId);

            // Handle file upload for the logo
            if (!empty($_FILES['logo']['name'])) {
                $logoFile = $_FILES['logo'];
                $targetDir = "public/img/logo/"; // Ensure this path is correct and writable
                $imageFileType = strtolower(pathinfo($logoFile['name'], PATHINFO_EXTENSION)); // Get the file extension
            
                // Use the original file name
                $targetFile = $targetDir . basename($logoFile['name']);
                $uploadOk = 1;
            
                // Validate the file
                if ($logoFile['error'] !== UPLOAD_ERR_OK) {
                    $_SESSION['error'] = "Upload error code: " . $logoFile['error'];
                    $uploadOk = 0;
                } elseif ($logoFile['size'] > 5000000) {
                    $_SESSION['error'] = "File size exceeds limit.";
                    $uploadOk = 0;
                } elseif (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $_SESSION['error'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                } elseif (!getimagesize($logoFile["tmp_name"])) {
                    $_SESSION['error'] = "File is not an image.";
                    $uploadOk = 0;
                }
            
                // Move the file if all checks are passed
                if ($uploadOk) {
                    // Delete old logo file (optional)
                    if (!empty($department['logo']) && file_exists($targetDir . $department['logo'])) {
                        unlink($targetDir . $department['logo']); // Delete old logo file
                    }
            
                    // Move the new file
                    if (move_uploaded_file($logoFile["tmp_name"], $targetFile)) {
                        $logo = basename($logoFile['name']); // Store the new logo file name for the database
                    } else {
                        $_SESSION['error'] = "Error moving uploaded file.";
                    }
                }
            } else {
                // If no new file is uploaded, retain the existing logo
                $logo = $department['logo'];
            }
            

            // Instantiate the model and update the department
            $editDepartment = $departmentModel->editDepartment($departmentId, $departmentName, $logo);

            if ($editDepartment) {
                $_SESSION['success'] = 'កែប្រែបានជោគជ័យ';
                header('location: /dbs/createdepartment');
                exit();
            } else {
                $_SESSION['error'] = 'កែប្រែមិនបានជោគជ័យ';
                header('location: /dbs/createdepartment');
                exit();
            }
        }
    }
    public function deleteDepartment()
    {
        // Retrieve the department ID from the POST data
        $departmentId = $_POST['id'];

        // Call the delete method from the model
        $departmentController = new departmentModel();
        $isDeleted = $departmentController->deleteDepartment($departmentId);

        if ($isDeleted) {
            // Success message
            $_SESSION['success'] = "លុបបានជោគជ័យ";
        } else {
            // Error message
            $_SESSION['error'] = "លុបមិនបានជោគជ័យ";
        }

        // Redirect back to the department listing page
        header("location: /dbs/createdepartment");
        exit();
    }




}
