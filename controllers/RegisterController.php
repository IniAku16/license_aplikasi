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
            $user->username = $_POST['username'];
            $user->email = $_POST['email'];
            $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            if ($user->register()) {
                header("Location: index.php?action=show-login&success=Registrasi Berhasil");
                exit();
            } else {
                header("Location: index.php?action=show-register&error=Registrasi Gagal");
                exit();
            }
        }
    }
}