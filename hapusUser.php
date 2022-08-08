<?php
session_start();

require 'middleware/auth.php';
require 'middleware/admin.php';
require('config.php');

$id = $_GET['id'];
if( hapusUser($id) > 0 ) {
    echo "
    <script>
            alert('User berhasil dihapus');
            document.location.href = 'users.php';
    </script>;";
} else {
    echo "
    <script>
            alert('User gagal dihapus');
            document.location.href = 'users.php';
    </script>;";
}
