<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    // Cek apakah file users.txt ada
    $file = 'data/users.txt'; // Update path ke users.txt
    $users = file_exists($file) ? file($file) : [];

    // Cek apakah username sudah ada
    foreach ($users as $user) {
        list($stored_username) = explode(':', trim($user));
        if ($stored_username === $username) {
            echo "<div class='alert alert-danger'>Username sudah terdaftar.</div>";
            echo "<a href='register.php' class='btn btn-primary'>Kembali ke Registrasi</a>";
            exit();
        }
    }

    // Simpan pengguna baru
    file_put_contents($file, "$username:$password\n", FILE_APPEND);
    echo "<div class='alert alert-success'>Registrasi berhasil! Silakan login.</div>";
    echo "<a href='login.php' class='btn btn-primary'>Login</a>";
}
?>