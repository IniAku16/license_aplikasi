<?php
class ForgotPasswordController {
    private $koneksi;

    public function __construct($db) {
        $this->koneksi = $db;
    }

    public function showForgetForm() {
        include __DIR__ . "/../views/auth/forget_password.php";
    }

    public function process() {
        require_once __DIR__ . "/../models/User.php";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $identifier = $_POST['identifier']; 
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            if ($newPassword !== $confirmPassword) {
                header("Location: index.php?action=show-forget&error=Password tidak cocok");
                exit();
            }

            if (!$this->isValidPassword($newPassword)) {
                header("Location: index.php?action=show-forget&error=Password harus minimal 8 karakter dan mengandung huruf besar, huruf kecil, serta simbol");
                exit();
            }

            $userModel = new UserModel($this->koneksi);
            if ($userModel->updatePassword($identifier, $newPassword)) {
                header("Location: index.php?action=show-login&success=Password berhasil diupdate");
            } else {
                header("Location: index.php?action=show-forget&error=Email tidak ditemukan");
            }
            exit();
        }
    }

    private function isValidPassword($password) {
        return strlen($password) >= 8
            && preg_match('/[A-Z]/', $password)
            && preg_match('/[a-z]/', $password)
            && preg_match('/[^A-Za-z0-9]/', $password);
    }
}