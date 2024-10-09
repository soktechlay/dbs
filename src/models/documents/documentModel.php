<?php

class documentModel
{
    private $dbh;
    // public $url = "https://hrms.iauoffsa.us";

    // public function getapi()
    // {

    //     $this->url = "https://hrms.iauoffsa.us";
    // }
    private $documents = "documents";

    public function __construct()
    {
        global $dbh;
        $this->dbh = $dbh;
    }
    // Method to retrieve user details by username
    public function createdocument($data)
    {
        $stmt = $this->dbh->prepare("
        INSERT INTO $this->documents (codedoc, namedoc, typedoc, sourcedoc, file) 
        VALUES (:codedoc, :namedoc, :typedoc, :sourcedoc, :file)
    ");
        $stmt->bindParam(':codedoc', $data['codedoc']);
        $stmt->bindParam(':namedoc', $data['namedoc']);
        $stmt->bindParam(':typedoc', $data['typedoc']);
        $stmt->bindParam(':sourcedoc', $data['sourcedoc']);
        $stmt->bindParam(':file', $data['file']);

        try {
            // Execute the prepared statement
            return $stmt->execute();
        } catch (PDOException $e) {
            // Log the error for debugging
            error_log("Database error: " . $e->getMessage());
            return false; // Return false to indicate failure
        }
    }
    public function getdoc($sourcedoc_filter = null, $typedoc_filter = null, $search_query = null, $date_range = null)
{
    try {
        $sql = "
        SELECT d.*, 
               t.id AS typedoc_id, t.typedoc AS typedoc, 
               dep.id AS sourcedoc_id, dep.typedepartment AS sourcedoc, dep.logo AS department_logo
        FROM documents d
        JOIN types t ON d.typedoc = t.id
        JOIN departments dep ON d.sourcedoc = dep.id
        WHERE 1=1";

        if (!empty($sourcedoc_filter)) {
            $sql .= " AND dep.id = :sourcedoc_filter";
        }

        if (!empty($typedoc_filter)) {
            $sql .= " AND t.id = :typedoc_filter";
        }

        if (!empty($search_query)) {
            $sql .= " AND (d.codedoc LIKE :search_query OR d.namedoc LIKE :search_query)";
        }

        // Handle date range filtering
        if (!empty($date_range)) {
            $date_parts = explode(' to ', $date_range);
            if (count($date_parts) == 2) {
                $start_date = trim($date_parts[0]);
                $end_date = trim($date_parts[1]);

                // Validate the date format
                if (DateTime::createFromFormat('Y-m-d', $start_date) && DateTime::createFromFormat('Y-m-d', $end_date)) {
                    if ($start_date === $end_date) {
                        // If start and end dates are the same, filter for that specific date
                        $sql .= " AND DATE(d.created_at) = :specific_date";
                        $stmt = $this->dbh->prepare($sql);
                        $stmt->bindParam(':specific_date', $start_date, PDO::PARAM_STR);
                    } else {
                        // If date range is valid
                        $sql .= " AND d.created_at BETWEEN :start_date AND :end_date";
                        $stmt = $this->dbh->prepare($sql);
                        $stmt->bindParam(':start_date', $start_date, PDO::PARAM_STR);
                        $stmt->bindParam(':end_date', $end_date, PDO::PARAM_STR);
                    }
                } else {
                    error_log("Invalid date format for date_range: " . $date_range);
                }
            }
        }

        $sql .= " ORDER BY d.created_at DESC";

        if (!isset($stmt)) {
            // If no binding occurred, prepare the statement here
            $stmt = $this->dbh->prepare($sql);
        }

        if (!empty($sourcedoc_filter)) {
            $stmt->bindParam(':sourcedoc_filter', $sourcedoc_filter, PDO::PARAM_INT);
        }

        if (!empty($typedoc_filter)) {
            $stmt->bindParam(':typedoc_filter', $typedoc_filter, PDO::PARAM_INT);
        }

        if (!empty($search_query)) {
            $search_query = "%" . $search_query . "%";
            $stmt->bindParam(':search_query', $search_query, PDO::PARAM_STR);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return [];
    }
}

    public function codedocExists($codedoc)
    {
        $stmt = $this->dbh->prepare("SELECT COUNT(*) FROM $this->documents WHERE codedoc = :codedoc");
        $stmt->bindParam(':codedoc', $codedoc);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    public function editDocument($data)
    {
        // Prepare the SQL query to update the document with typedoc_id, sourcedoc_id, codedoc, namedoc, and file
        $sql = "UPDATE documents SET typedoc = :typedocId, sourcedoc = :sourcedocId, codedoc = :codedoc, namedoc = :namedoc, file = :file WHERE id = :documentId";
        $stmt = $this->dbh->prepare($sql);

        // Execute the query with the provided data
        return $stmt->execute([
            ':typedocId' => $data['typedoc_id'],
            ':sourcedocId' => $data['sourcedoc_id'],
            ':codedoc' => $data['codedoc'],
            ':namedoc' => $data['namedoc'],
            ':file' => $data['file'],
            ':documentId' => $data['id']
        ]);
    }
    public function deleteDocument($documentId)
    {
        try {
            // Prepare SQL query
            $sql = "DELETE FROM $this->documents WHERE id = :id";
            $stmt = $this->dbh->prepare($sql);
            // Bind the department ID parameter
            $stmt->bindParam(':id', $documentId, PDO::PARAM_INT);
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

    public function countRecordsBySourcedoc()
    {
        try {
            // Prepare the query to count records and fetch department details (name and logo)
            $stmt = $this->dbh->prepare("
                SELECT dep.id, dep.typedepartment, dep.logo, COUNT(d.id) AS document_count
                FROM departments dep
                LEFT JOIN documents d ON d.sourcedoc = dep.id
                GROUP BY dep.id, dep.typedepartment, dep.logo
            ");

            // Execute the query
            $stmt->execute();

            // Fetch all results
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Return the results, which includes department details and the count of documents
            return $results;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }




}
