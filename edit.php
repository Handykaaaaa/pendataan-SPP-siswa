<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "spp_siswa_baru";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data siswa berdasarkan id
$id = $_GET["id"];
$sql = "SELECT * FROM siswa WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $kelas = $_POST["kelas"];
    $tahun_ajaran = $_POST["tahun_ajaran"];
    $total_spp = $_POST["total_spp"];
    $status_pembayaran = $_POST["status_pembayaran"];

    $sql = "UPDATE siswa SET nama='$nama', kelas='$kelas', tahun_ajaran='$tahun_ajaran', total_spp='$total_spp', status_pembayaran='$status_pembayaran' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data SPP Siswa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Data SPP Siswa</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id);?>">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $row["nama"]; ?>" required>
            </div>
            <div class="form-group">
                <label for="kelas">Kelas:</label>
                <input type="text" class="form-control" id="kelas" name="kelas" value="<?php echo $row["kelas"]; ?>" required>
            </div>
            <div class="form-group">
                <label for="tahun_ajaran">Tahun Ajaran:</label>
                <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" value="<?php echo $row["tahun_ajaran"]; ?>" required>
            </div>
            <div class="form-group">
                <label for="total_spp">Total SPP:</label>
                <input type="number" class="form-control" id="total_spp" name="total_spp" step="0.01" value="<?php echo $row["total_spp"]; ?>" required>
            </div>

            <div class="form-group">
                <label for="status_pembayaran">Status Pembayaran:</label>
                <select class="form-control" id="status_pembayaran" name="status_pembayaran" required>
                    <option value="Lunas" <?php if ($row["status_pembayaran"] == "Lunas") echo "selected"; ?>>Lunas</option>
                    <option value="Belum Lunas" <?php if ($row["status_pembayaran"] == "Belum Lunas") echo "selected"; ?>>Belum Lunas</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
