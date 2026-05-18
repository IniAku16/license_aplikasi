<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("X-Frame-Options: DENY"); 
header("X-Content-Type-Options: nosniff");

require_once __DIR__ . "/../config/koneksi.php";
require_once __DIR__ . "/../controllers/ProductController.php";
require_once __DIR__ . "/../controllers/AuthController.php";
require_once __DIR__ . "/../controllers/RegisterController.php";
require_once __DIR__ . "/../controllers/ForgotPasswordController.php";

$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

$public_actions = ['show-login', 'login-process', 'show-register', 'register-process', 'show-forget', 'forget-process'];

if (!isset($_SESSION['id_user']) && !in_array($action, $public_actions)) {
    header("Location: index.php?action=show-login");
    exit();
}

$productController = new ProductController($koneksi);
$authController = new AuthController($koneksi);
$registerController = new RegisterController($koneksi);
$forgotPasswordController = new ForgotPasswordController($koneksi);

switch ($action) {
     case 'show-login':
        $authController->showLoginForm(); 
        break;
    case 'login-process':
        $authController->login();
        break;
    case 'show-register':
        $registerController->showRegisterForm(); 
        break;
    case 'register-process':
        $registerController->register();
        break;
    case 'show-forget':
        $forgotPasswordController->showForgetForm(); 
        break;
    case 'forget-process':
        $forgotPasswordController->process();
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'create':
        $productController->create();
        break;
    case 'update':
        $productController->update($id);
        break;
    case 'delete':
        $productController->delete($id);
        break;
    case 'history':
        $productController->history();
        break;
    default:
        $productController->index();
        break;
}