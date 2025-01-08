<!DOCTYPE html>
<html>
<head>
    <title>Form Pendaftaran Anggota</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
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

    // Cek apakah ada nilai yang dikirim menggunakan method GET dengan nama id_peserta
    if (isset($_GET['id_peserta'])) {
        $id_peserta = input($_GET["id_peserta"]);

        $sql = "SELECT * FROM peserta WHERE id_peserta = $id_peserta";
        $hasil = mysqli_query($kon, $sql);
        $data = mysqli_fetch_assoc($hasil);
    }

    // Cek apakah ada kiriman form dari method POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_peserta = htmlspecialchars($_POST["id_peserta"]);
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
        if ($check === false) {
            echo "<div class='alert alert-danger'>File yang diupload bukan gambar.</div>";
            $uploadOk = 0;
        }

        // Cek ukuran file
        if ($_FILES['photo']['size'] > 900000) { // 900KB
            echo "<div class='alert alert-danger'>Maaf, ukuran file terlalu besar.</div>";
            $uploadOk = 0;
        }

        // Cek format file
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            echo "<div class='alert alert-danger'>Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.</div>";
            $uploadOk = 0;
        }

        // Cek apakah $uploadOk di-set ke 0 oleh kesalahan
        if ($uploadOk == 0) {
            echo "<div class='alert alert-danger'>Maaf, file tidak dapat diupload.</div>";
        } else {
            // Jika semua cek lolos, coba upload file
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
                // Query update data pada tabel anggota
                $sql = "UPDATE peserta SET
                    nama = '$nama',
                    sekolah = '$sekolah',
                    jurusan = '$jurusan',
                    no_hp = '$no_hp',
                    alamat = '$alamat',
                    gambar = '$uploadFile' 
                    WHERE id_peserta = $id_peserta";

                // Mengeksekusi atau menjalankan query diatas
                $hasil = mysqli_query($kon, $sql);

                // Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
                if ($hasil) {
                    header("Location:index.php");
                    exit();
                } else {
                    echo "<div class='alert alert-danger'>Data Gagal disimpan.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Maaf, terjadi kesalahan saat mengupload file.</div>";
            }
        }
    }
    ?>
    <h2>Update Data</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama:</label>
            <input type="text ```php
            " name="nama" class="form-control" placeholder="Masukan Nama" required />
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
        <input type="hidden" name="id_peserta" value="<?php echo $data['id_peserta']; ?>" />
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>