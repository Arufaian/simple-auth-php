

<?php
// dosen.php

// PENTING: Kode ini menggunakan ekstensi 'mysql_' yang sudah usang (deprecated). 
// Untuk proyek nyata, GANTI SEMUA 'mysql_query' dengan 'mysqli_query' atau gunakan PDO.

session_start();
include "./koneksi.php"; // Asumsi file koneksi ada

// Cek login
if (!isset($_SESSION['username'])) {
    header('location:index.php'); // Arahkan ke halaman login
    exit;
}

// -----------------------------------------------------
// 1. Tambah data (CREATE)
// -----------------------------------------------------
if (isset($_POST['tambah'])) {
    $nidn = $_POST['nidn'];
    $nama = $_POST['nama'];

    // Catatan: Pastikan $koneksi adalah objek koneksi yang valid (dari file koneksi.php)
    $query = "INSERT INTO dosen (nidn, nama) VALUES ('$nidn', '$nama')";
    mysqli_query($koneksi, $query); // Asumsi $koneksi variabel koneksi

    header('location:dosen.php');
    exit;
}

// -----------------------------------------------------
// 2. Hapus data (DELETE)
// -----------------------------------------------------
if (isset($_GET['hapus'])) {
    $nidn = $_GET['hapus'];

    $query = "DELETE FROM dosen WHERE nidn='$nidn'";
    mysqli_query($koneksi, $query);

    header('location:dosen.php');
    exit;
}

// -----------------------------------------------------
// 3. Update data (UPDATE)
// -----------------------------------------------------
if (isset($_POST['update'])) {
    $nidn = $_POST['nidn'];
    $nama = $_POST['nama'];

    $query = "UPDATE dosen SET nama='$nama' WHERE nidn='$nidn'";
    mysqli_query($koneksi, $query);

    header('location:dosen.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data Dosen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f6f6f6;
        }
        .table-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
        }
        .btn-add {
            margin-bottom: 15px;
        }
        .nav-link {
            color: white !important; /* Agar link di navbar terlihat */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">SIA</a>
        <div class="d-flex">
            <a href="dashboard.php" class="btn btn-light btn-sm me-2">Dashboard</a>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="table-container">
        <h3>Data Dosen</h3>
        
        <button class="btn btn-success btn-sm btn-add" 
                data-bs-toggle="modal" 
                data-bs-target="#modalTambah">
            + Tambah Dosen
        </button>

        <table class="table table-striped table-bordered">
            <thead class="table-primary text-center">
                <tr>
                    <th>NIDN</th>
                    <th>Nama Dosen</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            
            <?php
            // -----------------------------------------------------
            // 4. Tampilkan data (READ)
            // -----------------------------------------------------
            $query = mysqli_query($koneksi, "SELECT * FROM dosen ORDER BY nama ASC");
            while ($row = mysqli_fetch_assoc($query)) {
                echo "<tr>";
                echo "<td>" . $row['nidn'] . "</td>";
                echo "<td>" . $row['nama'] . "</td>";
                echo "<td class='text-center'>";
                
                // Tombol Edit
                echo "<button class='btn btn-warning btn-sm me-2' 
                              data-bs-toggle='modal' 
                              data-bs-target='#modalEdit{$row['nidn']}'>
                            Edit
                      </button>";
                
                // Tombol Hapus
                echo "<a href='?hapus={$row['nidn']}' 
                         onclick=\"return confirm('Yakin hapus data?')\" 
                         class='btn btn-danger btn-sm'>
                            Hapus
                      </a>";
                echo "</td>";
                echo "</tr>";

                // ===================================================
                // MODAL EDIT (Diulang untuk setiap baris data)
                // ===================================================
                echo "<div class='modal fade' id='modalEdit{$row['nidn']}' tabindex='-1'>";
                    echo "<div class='modal-dialog'>";
                        echo "<div class='modal-content'>";
                            echo "<div class='modal-header bg-warning'>";
                                echo "<h5 class='modal-title'>Edit Data Dosen</h5>";
                                echo "<button type='button' class='btn-close' data-bs-dismiss='modal'></button>";
                            echo "</div>";
                            echo "<form method='POST'>";
                                echo "<div class='modal-body'>";
                                    // Hidden Input untuk NIDN yang akan diupdate
                                    echo "<input type='hidden' name='nidn' value='{$row['nidn']}'>";
                                    
                                    // Input Nama Dosen
                                    echo "<div class='mb-3'>";
                                        echo "<label for='nama' class='form-label'>Nama Dosen</label>";
                                        echo "<input type='text' name='nama' class='form-control' value='{$row['nama']}' required>";
                                    echo "</div>";
                                echo "</div>";
                                echo "<div class='modal-footer'>";
                                    echo "<button type='submit' name='update' class='btn btn-primary'>Simpan</button>";
                                echo "</div>";
                            echo "</form>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            }
            ?>
            
            </tbody>
        </table>
    </div>
</div>

<div class='modal fade' id='modalTambah' tabindex='-1'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header bg-success text-white'>
                <h5 class='modal-title' id='modalTambahTitle'>Tambah Dosen</h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
            </div>
            <form method="POST">
                <div class='modal-body'>
                    <div class='mb-3'>
                        <label for='nidn' class='form-label'>NIDN</label>
                        <input type='text' name='nidn' class='form-control' required>
                    </div>
                    <div class='mb-3'>
                        <label for='nama' class='form-label'>Nama Dosen</label>
                        <input type='text' name='nama' class='form-control' required>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='submit' name='tambah' class='btn btn-success'>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>