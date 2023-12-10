<?php
session_start();

require '../middleware/auth.php';
require '../middleware/admin.php';
require('../config.php');

$id = $_GET['id'];
if (hapusPengeluaran($id) > 0) {
    echo "
    <script>
        alert('Data berhasil dihapus');
        document.location.href = 'pengeluaran.php';
    </script>;";
} else {
    echo "
    <script>
        alert('Data gagal dihapus');
        document.location.href = 'pengeluaran.php';
    </script>;";
}
