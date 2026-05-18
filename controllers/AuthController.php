<?php
class AuthController {
    private $koneksi;

    public function __construct($db) {
        $this->koneksi = $db;
    }

    public function showLoginForm() {
        include __DIR__ . "/../views/auth/login.php"; 
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $login = trim($_POST['login']);
            $password = $_POST['password'];

            $stmt = mysqli_prepare($this->koneksi, "SELECT * FROM users WHERE BINARY username = ? OR BINARY email = ?");
            mysqli_stmt_bind_param($stmt, "ss", $login, $login);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $data = mysqli_fetch_assoc($result);

            if ($data && password_verify($password, $data['password'])) {
                $_SESSION['id_user'] = $data['id_user'];
                $_SESSION['username'] = $data['username'];
                header("Location: index.php?action=index");
                exit();
            } else {
                header("Location: index.php?action=show-login&error=Login Gagal");
                exit();
            }
        }
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?action=show-login");
        exit();
    }
}