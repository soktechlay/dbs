<?php
// models/UserModel.php
class typeModel
{
    private $dbh;
    public $url = "http://127.0.0.1:8000";

    private $types = "types";

    public function getapi()
    {

        $this->url = "http://127.0.0.1:8000";
    }

    public function __construct()
    {
        global $dbh;
        $this->dbh = $dbh;
    }

    public function createtype($typedoc)
    {
        try {
            $sql = "INSERT INTO $this->types (typedoc) VALUES (:typedoc)";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(':typedoc', $typedoc);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function gettype()
    {
        try {
            // Prepare the SQL query to fetch all departments
            $sql = "SELECT * FROM $this->types ORDER BY created_at";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute();

            // Fetch all results
            $gettype = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $gettype;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function typeExists($typedoc)
    {
        try {
            // Prepare SQL query to check if the typedepartment already exists
            $sql = "SELECT COUNT(*) FROM $this->types WHERE typedoc = :typedoc";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(':typedoc', $typedoc, PDO::PARAM_STR);
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
    public function editType($typeId, $typeDoc)
    {
        try {
            // Start a transaction
            $this->dbh->beginTransaction();
            // Prepare the SQL query to update the department
            $sql = "UPDATE $this->types SET typedoc = :typedoc, updated_at = NOW() WHERE id = :typeId";
            $stmt = $this->dbh->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':typeId', $typeId, PDO::PARAM_INT);
            $stmt->bindParam(':typedoc', $typeDoc, PDO::PARAM_STR);

            // Execute the query
            if ($stmt->execute()) {
                // Commit the transaction if successful
                $this->dbh->commit();
                return true;
            } else {
                // Rollback the transaction if there was a failure
                $this->dbh->rollBack();
                return false;
            }
        } catch (PDOException $e) {
            // Rollback the transaction if an exception occurs
            $this->dbh->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function deleteType($typeId)
    {
        try {
            // Prepare SQL query
            $sql = "DELETE FROM $this->types WHERE id = :id";
            $stmt = $this->dbh->prepare($sql);
            // Bind the department ID parameter
            $stmt->bindParam(':id', $typeId, PDO::PARAM_INT);
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
}