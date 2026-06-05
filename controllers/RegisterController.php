<?php
class RegisterController {
    private $koneksi;

    public function __construct($db) {
        $this->koneksi = $db;
    }

    public function showRegisterForm() {
        include __DIR__ . "/../views/auth/register.php";
    }

    public function register() {
        require_once __DIR__ . "/../models/User.php";
        $user = new UserModel($this->koneksi);

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if (!$this->isValidUsername($username)) {
                header("Location: index.php?action=show-register&error=Username hanya boleh berisi huruf, tanpa spasi, simbol, atau angka");
                exit();
            }

            if (!$this->isValidPassword($password)) {
                header("Location: index.php?action=show-register&error=Password harus minimal 8 karakter dan mengandung huruf besar, huruf kecil, serta simbol");
                exit();
            }

            $user->username = $username;
            $user->email = $_POST['email'];
            $user->password = password_hash($password, PASSWORD_DEFAULT);

            if ($user->register()) {
                header("Location: index.php?action=show-login&success=Registrasi Berhasil");
                exit();
            } else {
                header("Location: index.php?action=show-register&error=Registrasi Gagal");
                exit();
            }
        }
    }

    private function isValidPassword($password) {
        return strlen($password) >= 8
            && preg_match('/[A-Z]/', $password)
            && preg_match('/[a-z]/', $password)
            && preg_match('/[^A-Za-z0-9]/', $password);
    }

    private function isValidUsername($username) {
        return preg_match('/^[A-Za-z]+$/', $username);
    }
}