<?php
session_start();

require '../middleware/auth.php';
require '../middleware/admin.php';
require('../config.php');

$id = $_GET['id'];
if (hapusMenu($id) > 0) {
    echo "
    <script>
        alert('Data berhasil dihapus');
        document.location.href = 'menu.php';
    </script>;";
} else {
    echo "
    <script>
        alert('Data gagal dihapus');
        document.location.href = 'menu.php';
    </script>;";
}
