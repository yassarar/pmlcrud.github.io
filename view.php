<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF -8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peserta</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <span class="navbar-brand mb-0 h1">Detail Peserta</span>
    </nav>
    
    <div class="container">
        <br>
        <?php
        include "koneksi.php";

        if (isset($_GET['id_peserta'])) {
            $id_peserta = htmlspecialchars($_GET["id_peserta"]);
            $sql = "SELECT * FROM peserta WHERE id_peserta='$id_peserta'";
            $hasil = mysqli_query($kon, $sql);
            $data = mysqli_fetch_assoc($hasil);

            if ($data) {
                echo "<h4 class='text-center'>Detail Peserta</h4>";
                echo "<p><strong>Nama:</strong> " . $data['nama'] . "</p>";
                echo "<p><strong>Sekolah:</strong> " . $data['sekolah'] . "</p>";
                echo "<p><strong>Jurusan:</strong> " . $data['jurusan'] . "</p>";
                echo "<p><strong>No HP:</strong> " . $data['no_hp'] . "</p>";
                echo "<p><strong>Alamat:</strong> " . $data['alamat'] . "</p>";
                echo "<p><strong>Gambar:</strong></p>";
                echo "<img src='" . $data['gambar'] . "' alt='Gambar' style='width: 200px; height: auto;'>";
            } else {
                echo "<div class='alert alert-danger'>Data tidak ditemukan.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>ID peserta tidak valid.</div>";
        }
        ?>
        <a href="index.php" class="btn btn-primary" role="button">Kembali</a>
    </div>
</body>
</html>