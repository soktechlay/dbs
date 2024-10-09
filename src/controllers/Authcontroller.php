<?php
require_once 'src/models/User.php';

class Authcontroller
{

    public function login()
    {
        // Check if the user is already logged in
        if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])) {
            header('Location: /dbs/dashboard'); // Redirect to the dashboard
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = htmlspecialchars($_POST['password']);

            if ($email && $password) {
                $userModel = new UserModel();
                $authResult = $userModel->authenticateUser($email, $password);

                if (!$authResult || $authResult['http_code'] !== 200) {
                    $_SESSION['error'] = [
                        'title' => "Authentication Error",
                        'message' => "Invalid email or password"
                    ];
                } else {
                    $user = $authResult['user'];
                    $token = $authResult['token'];

                    if ($user['active'] === '0') {
                        $_SESSION['blocked_user'] = true;
                        $_SESSION['user_khmer_name'] = $user['khmer_name'];
                        $_SESSION['user_profile'] = $user['profile_picture'];
                        require 'src/views/errors/block_page.php';
                        exit;
                    } else {
                        // Store user data and token in session
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['email'] = $user['email'];
                        $_SESSION['user_khmer_name'] = $user['lastNameKh'] . ' ' . $user['firstNameKh'];
                        $_SESSION['user_eng_name'] = $user['engName'];
                        $_SESSION['token'] = $token;
                        $_SESSION['user_profile'] = 'https://hrms.iauoffsa.us/images/' . $user['image'];

                        // Fetch position_name and store it in session
                        $position = $userModel->getRoleApi($user['roleId'], $token);
                        $_SESSION['position'] = $position['data']['roleNameKh'] ;

                        if ($user['isAdmin'] === 'SUPER_ADMIN') {
                            // Admin-specific session variables
                            $_SESSION['admin_id'] = $user['id'];
                            $_SESSION['admin_email'] = $user['email'];
                            $_SESSION['admin_name'] = $user['engName'];
                            $_SESSION['admin_profile'] = 'https://hrms.iauoffsa.us/images/' . $user['image'];
                        }

                        header('Location: /dbs/dashboard');
                        exit;
                    }
                }
            } else {
                $_SESSION['error'] = [
                    'title' => "អ៊ីម៉ែល និងពាក្យសម្ងាត់",
                    'message' => "សូមបញ្ចូលអាសយដ្ឋានអ៊ីម៉ែល និងពាក្យសម្ងាត់។"
                ];
            }
        }

        require 'src/views/auth/login.php';
    }
    public function logout()
    {
        // Unset all session variables
        session_unset();

        // Destroy the session
        session_destroy();

        // Redirect to the login page
        header('Location: /dbs/login');
        exit;
    }
}
