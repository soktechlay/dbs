<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define your base URL
$base_url = '/dbs';

// Include necessary controllers
require_once 'src/controllers/Authcontroller.php';
require_once 'src/controllers/Usercontroller.php';
require_once 'src/controllers/Departmentcontroller.php';
require_once 'src/controllers/Typecontroller.php';
require_once 'src/controllers/Dashboard.php';
require_once 'src/controllers/Documentcontroller.php';


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case $base_url . '/':
    case $base_url . '/login';
        $controller = new Authcontroller();
        $controller->login();
        break;
    // case $base_url . '/logout':
    //     session_destroy();
    //     header("Location: $base_url/login");
    //     exit();

    case $base_url . '/dashboard';
        $controller = new Dashboard();
        $controller->dashboard();
        break;

    case $base_url . '/logout':
        // Create an instance of the controller and call the logout method
        $controller = new AuthController();
        $controller->logout();
        break;
    case $base_url . '/createdepartment';
        $controller = new Departmentcontroller();
        $controller->createdepartment();
        break;
    case $base_url . '/editDepartment';
        $controller = new Departmentcontroller();
        $controller->editDepartment();
        break;
    case $base_url . '/deleteDepartment';
        $controller = new Departmentcontroller();
        $controller->deleteDepartment();
        break;
    case $base_url . '/createtype';
        $controller = new Typecontroller();
        $controller->createTpye();
        break;
    case $base_url . '/editType';
        $controller = new Typecontroller();
        $controller->editType();
        break;
    case $base_url . '/deleteType';
        $controller = new Typecontroller();
        $controller->deleteType();
        break;
    // case $base_url . '/createdocument';
    //     $controller = new Documentcontroller();
    //     $controller->createdocument();
    //     break;
    case $base_url . '/editDocument';
        $controller = new Documentcontroller();
        $controller->editDocument();
        break;
    case $base_url . '/createdocument':
        $controller = new Documentcontroller();
        $controller->manageDocuments();  // Updated method name
        break;
        case $base_url . '/deleteDocument';
        $controller = new Documentcontroller();
        $controller->deleteDocument();
        break;


    default:
        // You can add a default case or handle 404 not found here
        header("HTTP/1.0 404 Not Found");
        echo "Page not found";
        break;
}
