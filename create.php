<!DOCTYPE html>
<html>
<head>
    <title>Form Pendaftaran Peserta</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <?php
    // Include file koneksi, untuk koneksikan ke database
    include "koneksi.php";

    // Fungsi untuk mencegah inputan karakter yang tidak sesuai
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Cek apakah ada kiriman form dari method post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama = input($_POST["nama"]);
        $sekolah = input($_POST["sekolah"]);
        $jurusan = input($_POST["jurusan"]);
        $no_hp = input($_POST["no_hp"]);
        $alamat = input($_POST["alamat"]);

        // Penanganan upload gambar
        $uploadFolder = 'uploads/';
        $uploadFile = $uploadFolder . basename($_FILES['photo']['name']);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

        // Cek apakah file gambar adalah gambar sebenarnya
        $check = getimagesize($_FILES['photo']['tmp_name']);
        if($check === false) {
            echo "<div class='alert alert-danger'>File yang diupload bukan gambar.</div>";
            $uploadOk = 0;
        }

        // Cek ukuran file
        if ($_FILES['photo']['size'] > 50000000) { // 50MB
            echo "<div class='alert alert-danger'>Maaf, ukuran file terlalu besar.</div>";
            $uploadOk = 0;
        }

        // Cek format file
        if(!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            echo "<div class='alert alert-danger'>Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.</div>";
            $uploadOk = 0;
        }

        // Cek apakah $uploadOk di-set ke 0 oleh kesalahan
        if ($uploadOk == 0) {
            echo "<div class='alert alert-danger'>Maaf, file tidak dapat diupload.</div>";
        } else {
            // Jika semua cek lolos, coba upload file
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
                // Query input menginput data kedalam tabel peserta
                $sql = "INSERT INTO peserta (nama, sekolah, jurusan, no_hp, alamat, gambar) VALUES ('$nama', '$sekolah', '$jurusan', '$no_hp', '$alamat', '$uploadFile')";

                // Mengeksekusi/menjalankan query diatas
                $hasil = mysqli_query($kon, $sql);

                // Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
                if ($hasil) {
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                } else {
                    echo "<div class='alert alert-danger'>Data Gagal disimpan.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Maaf, terjadi kesalahan saat mengupload file.</div>";
            }
        }
    }

    // Cek apakah ada kiriman form untuk menghapus data
    if (isset($_GET['id_peserta'])) {
        $id_peserta = htmlspecialchars($_GET["id_peserta"]);
        $sql = "DELETE FROM peserta WHERE id_peserta='$id_peserta'";
        $hasil = mysqli_query($kon, $sql);
        if ($hasil) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
 } else {
            echo "<div class='alert alert-danger'>Data Gagal dihapus.</div>";
        }
    }
    ?>

    <h2>Input Data</h2>

    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama:</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukan Nama" required />
        </div>
        <div class="form-group">
            <label>Sekolah:</label>
            <input type="text" name="sekolah" class="form-control" placeholder="Masukan Nama Sekolah" required />
        </div>
        <div class="form-group">
            <label>Jurusan:</label>
            <input type="text" name="jurusan" class="form-control" placeholder="Masukan Jurusan" required />
        </div>
        <div class="form-group">
            <label>No HP:</label>
            <input type="text" name="no_hp" class="form-control" placeholder="Masukan No HP" required />
        </div>
        <div class="form-group">
            <label>Alamat:</label>
            <textarea name="alamat" class="form-control" rows="5" placeholder="Masukan Alamat" required></textarea>
        </div>
        <div class="form-group">
            <label>Gambar:</label>
            <input type="file" id="photo" name="photo" accept="image/*" required><br><br>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>

    <h2 class="mt-5">Data Peserta</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Sekolah</th>
                <th>Jurusan</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query untuk mengambil data peserta dari database
            $query = "SELECT * FROM peserta";
            $result = mysqli_query($kon, $query);

            // Menampilkan data peserta
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['nama']}</td>
                            <td>{$row['sekolah']}</td>
                            <td>{$row['jurusan']}</td>
                            <td>{$row['no_hp']}</td>
                            <td>{$row['alamat']}</td>
                            <td><img src='{$row['gambar']}' alt='Gambar' style='width: 100px; height: auto;'></td>
                            <td>
                                <a href='update.php?id_peserta={$row['id_peserta']}' class='btn btn-warning btn-sm'>Update</a>
                                <a href='?id_peserta={$row['id_peserta']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Delete</a>
                                <a href='view.php?id_peserta={$row['id_peserta']}' class='btn btn-info btn-sm'>View</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>Tidak ada data peserta.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>