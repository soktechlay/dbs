<?php
// models/UserModel.php
class UserModel
{
  private $dbh;
  public $url = "http://127.0.0.1:8000";

  public function getapi()
  {

    $this->url = "http://127.0.0.1:8000";
  }


  public function __construct()
  {
    global $dbh;
    $this->dbh = $dbh;
  }

  // Method to retrieve user details by username

  public function getAllUserApi($token)
  {
    $url = 'http://127.0.0.1:8000/api/v1/users/';

    // Initialize cURL session
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Authorization: Bearer ' . $token
    ));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ignore SSL certificate verification

    // Execute cURL request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);

    // Close the cURL session
    curl_close($ch);

    // Check for cURL errors
    if ($response === false) {
      error_log("CURL Error: $error");
      echo "CURL Error: $error";
      return null;
    }

    // Decode the JSON response
    $responseData = json_decode($response, true);

    // Handle JSON decoding errors
    if (json_last_error() !== JSON_ERROR_NONE) {
      error_log("JSON Decode Error: " . json_last_error_msg());
      echo "JSON Decode Error: " . json_last_error_msg();
      return null;
    }

    // Check if the response is successful and contains the expected data
    if ($httpCode === 200 && isset($responseData['data'])) {
      $users = $responseData['data'];
      $usersWithRoles = [];

      // Fetch role information for each user
      foreach ($users as $user) {
        $roleResponse = $this->getRoleApi($user['roleId'], $token);
        $user['role'] = ($roleResponse && $roleResponse['http_code'] === 200) ? $roleResponse['data']['roleNameKh'] : 'Unknown';
        $usersWithRoles[] = $user;
      }

      return [
        'http_code' => $httpCode,
        'data' => $usersWithRoles,
      ];
    } else {
      error_log("Unexpected API Response: " . print_r($responseData, true));
      echo "Unexpected API Response: " . print_r($responseData, true);
      return [
        'http_code' => $httpCode,
        'response' => $responseData
      ];
    }
  }

  public function authenticateUser($email, $password)
  {
    $url = 'http://127.0.0.1:8000/api/login';
    $data = json_encode(['email' => $email, 'password' => $password]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Content-Type: application/json',
      'Content-Length: ' . strlen($data)
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    // Ignore SSL certificate verification (only for development)
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    // Debugging output
    if ($response === false) {
      error_log("CURL Error: $error");
      return null;
    }

    $responseData = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
      error_log("JSON Decode Error: " . json_last_error_msg());
      return null;
    }

    if ($httpCode === 200 && isset($responseData['user'], $responseData['token'])) {
      // Password is assumed to be hashed and verified internally by the API
      return [
        'http_code' => $httpCode,
        'user' => $responseData['user'],
        'token' => $responseData['token']
      ];
    } else {
      error_log("Unexpected API Response: " . print_r($responseData, true));
      return [
        'http_code' => $httpCode,
        'response' => $responseData
      ];
    }
  }

  public function getRoleApi($roleId, $token)
  {
    // Construct the API URL using the roleId
    $url = $this->url . "/api/v1/roles/";

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Authorization: Bearer ' . $token,  // Pass the token for authentication
      'Content-Type: application/json'
    ]);

    // Execute the cURL request
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Check for cURL errors
    if (curl_errno($ch)) {
      $error_msg = curl_error($ch);
      curl_close($ch);
      return ['error' => 'cURL error: ' . $error_msg]; // Handle cURL errors
    }

    // Close the cURL session
    curl_close($ch);

    // Process the response
    if ($httpcode == 200) {
      $result = json_decode($response, true);
      if (isset($result['data']['roleNameKh'])) {
        return $result; // Return the role data
      } else {
        return ['error' => 'API response format is incorrect'];
      }
    } else {
      return ['error' => 'HTTP error: ' . $httpcode . ' - Failed to fetch role from API'];
    }
  }

  // public function editdoc($id, $codedoc, $namedoc, $typedoc, $sourcedoc, $file)


}
