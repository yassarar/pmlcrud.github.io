<?php
session_start(); // Memulai session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    // Cek apakah file users.txt ada
    $file = 'data/users.txt';
    if (file_exists($file)) {
        $users = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($users as $user) {
            list($stored_username, $stored_password) = explode(':', $user);
            if ($stored_username === $username && password_verify($password, $stored_password)) {
                // Jika login berhasil, simpan informasi pengguna di session
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;

                // Redirect ke halaman index
                header("Location: index.php");
                exit();
            }
        }
    }
    echo "<div class='alert alert-danger'>Username atau password salah.</div>";
    echo "<a href='login.php' class='btn btn-primary'>Kembali ke Login</a>";
} else {
    // Jika tidak ada POST request, redirect ke halaman login
    header("Location: login.php");
    exit();
}
?>