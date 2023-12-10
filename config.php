<?php

require_once __DIR__ . '/vendor/autoload.php';

// koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$db = 'warkop_cahya';
$conn = mysqli_connect($host, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function query all data
function queryData($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// ========== Pengeluaran ==========
// Function tambah pengeluaran
function createPengeluaran($data)
{
    global $conn;
    $keperluan = htmlspecialchars($data['keperluan']);
    $tanggal_keluar = htmlspecialchars($data['tanggal_keluar']);
    $jumlah_keluar = htmlspecialchars($data['jumlah_keluar']);

    $sql = "INSERT INTO pengeluarans VALUES('','$keperluan', '$tanggal_keluar', '$jumlah_keluar')";

    mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}

// Function update
function updatePengeluaran($data)
{
    global $conn;
    $id = $data['id'];
    $keperluan = htmlspecialchars($data['keperluan']);
    $tanggal_keluar = htmlspecialchars($data['tanggal_keluar']);
    $jumlah_keluar = htmlspecialchars($data['jumlah_keluar']);

    $sql = "UPDATE pengeluarans SET keperluan = '$keperluan', tanggal_keluar = '$tanggal_keluar', jumlah_keluar = '$jumlah_keluar' WHERE id = $id";

    mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}

// Function hapus
function hapusPengeluaran($id)
{
    global $conn;
    $sql = "DELETE FROM pengeluarans WHERE id = $id";
    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
}


// ========== List Menu ==========
// Function tambah menu
function createMenu($data)
{
    global $conn;
    $nama_menu = htmlspecialchars($data['nama_menu']);
    $harga = htmlspecialchars($data['harga']);
    $kategori = htmlspecialchars($data['kategori']);

    $foto = uploadFoto();
    if (!$foto) {
        return false;
    }

    $sql = "INSERT INTO menus VALUES('','$nama_menu', '$harga', '$kategori', '$foto')";

    mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}

function uploadFoto()
{
    $namaFoto = $_FILES['foto']['name'];
    $ukuranFoto = $_FILES['foto']['size'];
    $penyimpanan = $_FILES['foto']['tmp_name'];
    $error = $_FILES['foto']['error'];

    // Cek foto sudah dipilih
    if ($error === 4) {
        echo "
        <script>
            alert('Pilih foto terlebih dahulu!');
        </script>";
        return false;
    }

    // cek kesesuaian ekstensi foto
    $ekstensiFotoValid = ['jpg', 'jpeg', 'png'];
    $pecahNamaFoto = explode('.', $namaFoto);
    $ekstensiFoto = strtolower(end($pecahNamaFoto));
    if (!in_array($ekstensiFoto, $ekstensiFotoValid)) {
        echo "
        <script>
            alert('File/foto yang anda kirim tidak valid!');
        </script>";
        return false;
    }

    // cek ukuran foto
    if ($ukuranFoto > 1000000) {
        echo "
        <script>
            alert('Foto yang anda kirim melebihi batas ukuran!');
        </script>";
        return false;
    }

    // rubah ke nama baru
    $namaFotoBaru = uniqid();
    $namaFotoBaru .= '.';
    $namaFotoBaru .= $ekstensiFoto;

    move_uploaded_file($penyimpanan, '../list_menu/' . $namaFotoBaru);

    return $namaFotoBaru;
}

// Function update
function updateMenu($data)
{
    global $conn;
    $id = $data['id'];
    $nama_menu = htmlspecialchars($data['nama_menu']);
    $harga = htmlspecialchars($data['harga']);
    $kategori = htmlspecialchars($data['kategori']);
    $fotoLama = htmlspecialchars($data['fotoLama']);

    // cek user pilih gambar baru
    if ($_FILES['foto']['error'] === 4) {
        $foto = $fotoLama;
    } else {
        $sqlAll = "SELECT * FROM menus WHERE id = $id";
        $delFoto = mysqli_query($conn, $sqlAll);
        $execute = mysqli_fetch_assoc($delFoto);
        unlink("../list_menu/" . $execute['foto']);
        $foto = uploadFoto();
    }

    $sql = "UPDATE menus SET nama_menu = '$nama_menu', harga = '$harga', kategori = '$kategori', foto = '$foto' WHERE id = $id";

    mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}

// Function hapus
function hapusMenu($id)
{
    global $conn;
    $sql = "DELETE FROM menus WHERE id = $id";
    $sqlAll = "SELECT * FROM menus WHERE id = $id";
    $delFoto = mysqli_query($conn, $sqlAll);
    $execute = mysqli_fetch_assoc($delFoto);
    unlink("../list_menu/" . $execute['foto']);
    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
}


// ========== tambah barang ==========
// Function tambah barang
function createBarang($data)
{
    global $conn;
    $nama = htmlspecialchars($data['nama']);
    $harga = htmlspecialchars($data['harga']);
    $stok = htmlspecialchars($data['stok']);

    $kode_barang = "BRG" . rand(100, 999);

    $sql = "INSERT INTO barangs VALUES('', '$kode_barang', '$nama', '$harga', '$stok')";

    mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}

// Function update
function updateBarang($data)
{
    global $conn;
    $id = $data['id'];
    $nama = htmlspecialchars($data['nama']);
    $harga = htmlspecialchars($data['harga']);
    $stok = htmlspecialchars($data['stok']);

    $sql = "UPDATE barangs SET nama = '$nama', harga = '$harga', stok = '$stok' WHERE id = $id";

    mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}

// Function hapus
function hapusBarang($id)
{
    global $conn;
    $sql = "DELETE FROM barangs WHERE id = $id";
    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
}

// ========== Pemasukan ==========
// Function hapus
function hapusPemasukan($id)
{
    global $conn;
    $sql = "DELETE FROM pemasukans WHERE id = $id";
    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
}

// ========== Transaksi ==========
// Function tambah transaksi
function createTransaksi($data)
{
    global $conn;
    $tanggal_transaksi = htmlspecialchars($data['tanggal_transaksi']);

    $jumlah_transaksi = 0;

    $menus = queryData("SELECT * FROM menus");

    foreach ($data['list_menu'] as $key => $value) {
        $jumlah_transaksi += $menus[$key]['harga'] * $value;
    }

    $kode_transaksi = "TSK" . rand(100, 999);

    $sql = "INSERT INTO transaksis VALUES('', '$kode_transaksi', '$jumlah_transaksi', '$tanggal_transaksi')";
    mysqli_query($conn, $sql);

    $transaksi = queryData("SELECT * FROM transaksis ORDER BY id DESC LIMIT 1");
    $transaksi_id = $transaksi[0]['id'];

    $sql_pemasukan = "INSERT INTO pemasukans VALUES('', '$transaksi_id', '$tanggal_transaksi', '$jumlah_transaksi')";
    mysqli_query($conn, $sql_pemasukan);

    return mysqli_affected_rows($conn);
}

// Function hapus
function hapusTransaksi($id)
{
    global $conn;
    $sql = "DELETE FROM transaksis WHERE id = $id";
    $sql_pemasukan = "DELETE FROM pemasukans WHERE transaksi_id = $id";

    mysqli_query($conn, $sql);
    mysqli_query($conn, $sql_pemasukan);
    return mysqli_affected_rows($conn);
}

// ========== Laba Rugi ==========
// cetak laporan
function cetakLaporan($data)
{
    global $conn;
    $tahun = htmlspecialchars($data['tahun']);
    $bulan = htmlspecialchars($data['bulan']);

    $date = $tahun . "-" . $bulan;

    $pemasukans = queryData("SELECT * FROM pemasukans WHERE tanggal_masuk LIKE '%$date%'");
    $pengeluarans = queryData("SELECT * FROM pengeluarans WHERE tanggal_keluar LIKE '%$date%'");

    $total_pemasukan = 0;
    $total_pengeluaran = 0;

    foreach ($pemasukans as $pemasukan) {
        $total_pemasukan += $pemasukan['jumlah_masuk'];
    }

    foreach ($pengeluarans as $pengeluaran) {
        $total_pengeluaran += $pengeluaran['jumlah_keluar'];
    }

    $laba_rugi = $total_pemasukan - $total_pengeluaran;
    $deposito = $laba_rugi * 0.1;
    $total_laba_rugi = $laba_rugi - $deposito;

    $mpdf = new \Mpdf\Mpdf();
    $html = '
    <style>
        
    </style>
    <h1 style="text-align: center;">Laporan Laba Rugi</h1>
    <h3 style="text-align: center;">Warkop Cahya</h3>
    <h4 style="text-align: center;">Periode ' . $bulan . ' ' . $tahun . '</h4>
    <hr style="">
    <p>Total Pemasukan : Rp. ' . number_format($total_pemasukan, 0, ',', '.') . '</p>
    <p>Total Pengeluaran : Rp. ' . number_format($total_pengeluaran, 0, ',', '.') . '</p>
    <p>Laba Rugi : Rp. ' . number_format($laba_rugi, 0, ',', '.') . '</p>
    <p>Deposit : Rp. ' . number_format($deposito, 0, ',', '.') . '</p>
    <p>Total Laba Rugi : Rp. ' . number_format($total_laba_rugi, 0, ',', '.') . '</p>
    ';
    $mpdf->WriteHTML($html);
    $mpdf->Output();
}
