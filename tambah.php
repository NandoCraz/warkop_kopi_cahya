<?php
session_start();

require 'middleware/auth.php';
require 'middleware/admin.php';
require('config.php');

$users = queryData("SELECT * FROM users WHERE id =" . $_SESSION['login']['id']);

// cek submit sudah ditekan
if (isset($_POST['submit'])) {
    if (create($_POST) > 0) {
        echo "
        <script>
            alert('Data berhasil ditambahkan');
            document.location.href = 'index.php';
        </script>";
    } else {
        echo "
        <script>
            alert('Data gagal ditambahkan');
            document.location.href = 'tambah.php';
        </script>";
    }
};

$thisPage = 'index';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/9fcca3cd45.js" crossorigin="anonymous"></script>
    <style>
        .label-grup {
            margin-bottom: 10px;
        }

        form {
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="logo/logo.jpg" alt="" width="40" height="40" class="rounded-circle">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($thisPage == "index") echo "active"; ?>" href="index.php">Karyawan</a>
                    </li>
                    <li class="nav-item me-5">
                        <?php if ($_SESSION["login"]["role"] == 'admin') : ?>
                            <a class="nav-link" href="users.php">Users</a>
                        <?php endif ?>
                    </li>
                    <li class="nav-item dropdown">
                        <?php foreach ($users as $user) : ?>
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="fotoProfile/<?= $user['foto_profile']; ?>" width="30" height="30" class="rounded-circle">
                            </a>
                        <?php endforeach ?>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#profile"><i class=" fa-solid fa-user"></i> Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="logout.php"><i class="fa-solid fa-person-running"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-2">
        <h2>Tambah Data Karyawan</h2>
        <a href="index.php" class="btn btn-secondary mt-3" style="color: white;">Kembali</a>

        <form action="" method="post" enctype="multipart/form-data" class="mb-4">
            <div class="mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" class="form-control" name="nip" id="nip" required autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" name="nama" id="nama" required autocomplete="off">
            </div>
            <div class="mb-3">
                <label class="form-label">Kelamin</label>
                <div class="row">
                    <div class="col-sm-2">
                        <input type="radio" name="gender" id="pria" value="PRIA" checked>
                        <label for="pria">PRIA</label>
                    </div>
                    <div class="col-sm-2">
                        <input type="radio" name="gender" id="wanita" value="WANITA">
                        <label for="wanita">Wanita</label>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" name="alamat" id="alamat" required autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" required autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" required autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Pilih Foto</label>
                <input class="form-control" type="file" name="foto" id="foto" autocomplete="off" required>
            </div>
            <div class="mt-3 float-end">
                <button type="reset" class="btn btn-secondary mb-3">Clear</button>
                <button type="submit" name="submit" class="btn btn-dark mb-3">Tambah</button>
            </div>
        </form>
    </div>

    <div class="modal fade" id="profile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <?php foreach ($users as $user) : ?>
                        <img src="fotoProfile/<?= $user['foto_profile']; ?>" width="300" height="300" class="mb-3 rounded-circle">
                    <?php endforeach ?>
                    <h3 class="mx-auto mt-3"><?= $_SESSION["login"]["username"]; ?></h3>
                    <h5><?= $_SESSION["login"]["role"]; ?></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>