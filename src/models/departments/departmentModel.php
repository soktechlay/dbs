<?php
// models/UserModel.php
class departmentModel
{
    private $dbh;
    public $url = "http://127.0.0.1:8000";

    private $departments = "departments";

    public function getapi()
    {

        $this->url = "http://127.0.0.1:8000";
    }

    public function __construct()
    {
        global $dbh;
        $this->dbh = $dbh;
    }

    public function editDepartment($departmentId, $departmentName, $logo = null)
    {
        try {
            $this->dbh->beginTransaction();

            // Prepare the SQL query to update the department
            $sql = "UPDATE $this->departments 
                SET typedepartment = :departmentName, logo = :logo, updated_at = NOW() 
                WHERE id = :departmentId";
            $stmt = $this->dbh->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
            $stmt->bindParam(':departmentName', $departmentName, PDO::PARAM_STR);
            $stmt->bindParam(':logo', $logo); // Save only the filename in the database

            // Execute the query
            $stmt->execute();

            // Commit the transaction
            $this->dbh->commit();
            return true;
        } catch (PDOException $e) {
            $this->dbh->rollBack();
            $_SESSION['error'] = "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getDepartmentById($departmentId)
    {
        try {
            $sql = "SELECT * FROM $this->departments WHERE id = :departmentId";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
            $stmt->execute();

            // Fetch the department details
            $department = $stmt->fetch(PDO::FETCH_ASSOC);

            return $department;
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error fetching department: " . $e->getMessage();
            return false;
        }
    }

    public function createdepartment($typedepartment, $logo)
    {
        try {
            // Insert department data and logo path into database
            $sql = "INSERT INTO $this->departments (typedepartment, logo) VALUES (:typedepartment, :logo)";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(':typedepartment', $typedepartment);
            $stmt->bindParam(':logo', $logo); // Save only the filename in the database
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function gettypedepartment()
    {
        try {
            // Prepare the SQL query to fetch all departments
            $sql = "SELECT * FROM $this->departments ORDER BY created_at";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute();

            // Fetch all results
            $gettypedepartment = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $gettypedepartment;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function deleteDepartment($departmentId)
    {
        try {
            // Prepare SQL query
            $sql = "DELETE FROM $this->departments WHERE id = :id";
            $stmt = $this->dbh->prepare($sql);
            // Bind the department ID parameter
            $stmt->bindParam(':id', $departmentId, PDO::PARAM_INT);
            // Execute the query
            if ($stmt->execute()) {
                return true;
            } else {
                // Log error for debugging
                print_r($stmt->errorInfo()); // This will print detailed error info
                return false;
            }
        } catch (PDOException $e) {
            // Handle exceptions
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function typedepartmentExists($typedepartment)
    {
        try {
            // Prepare SQL query to check if the typedepartment already exists
            $sql = "SELECT COUNT(*) FROM $this->departments WHERE typedepartment = :typedepartment";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(':typedepartment', $typedepartment, PDO::PARAM_STR);
            $stmt->execute();

            // Fetch the count (if count > 0, the department already exists)
            $count = $stmt->fetchColumn();

            return $count > 0;
        } catch (PDOException $e) {
            // Handle exception
            echo "Error: " . $e->getMessage();
            return false;
        }
    }



}