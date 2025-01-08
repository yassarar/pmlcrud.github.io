<!DOCTYPE html>
<html>
<head>
    <title>Data Peserta</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h2>Data Peserta</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Sekolah</th>
                <th>Jurusan</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th>Gambar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Include file koneksi
            include "koneksi.php";

            // Query untuk mengambil data dari tabel peserta
            $sql = "SELECT * FROM peserta";
            $result = mysqli_query($kon, $sql);

            // Cek apakah ada data
            if (mysqli_num_rows($result) > 0) {
                $no = 1; // Untuk nomor urut
                // Output data setiap baris
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . $row['nama'] . "</td>";
                    echo "<td>" . $row['sekolah'] . "</td>";
                    echo "<td>" . $row['jurusan'] . "</td>";
                    echo "<td>" . $row['no_hp'] . "</td>";
                    echo "<td>" . $row['alamat'] . "</td>";
                    echo "<td><img src='" . $row['gambar'] . "' alt='Gambar' style='width: 100px; height: auto;'></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>Tidak ada data peserta.</td></tr>";
            }

            // Tutup koneksi
            mysqli_close($kon);
            ?>
        </tbody>
    </table>
    <a href="form_pendaftaran.php" class="btn btn-primary">Tambah Peserta</a>
</div>
</body>
</html>