<?php
session_start();

require '../middleware/auth.php';
require '../middleware/admin.php';
require('../config.php');

$id = $_GET['id'];
if (hapusTransaksi($id) > 0) {
    echo "
    <script>
        alert('Data berhasil dihapus');
        document.location.href = 'transaksi.php';
    </script>;";
} else {
    echo "
    <script>
        alert('Data gagal dihapus');
        document.location.href = 'transaksi.php';
    </script>;";
}
