<?php
session_start();

require 'middleware/auth.php';
require 'middleware/admin.php';
require 'config.php';

$users = queryData("SELECT * FROM users WHERE id =" . $_SESSION['login']['id']);

// $allUser = queryData('SELECT * FROM users');
$allUser = queryData("SELECT * FROM users WHERE role = 'user'");

$thisPage = 'users';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/9fcca3cd45.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
                        <a class="nav-link" href="index.php">Karyawan</a>
                    </li>
                    <li class="nav-item me-5">
                        <?php if ($_SESSION["login"]["role"] == 'admin') : ?>
                            <a class="nav-link <?php if ($thisPage == "users") echo "active"; ?>" href="users.php">Users</a>
                        <?php endif ?>
                    </li>
                    <li class="nav-item dropdown">
                        <?php foreach ($users as $user) : ?>
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="fotoProfile/<?= $user['foto_profile']; ?>" width="30" height="30" class="rounded-circle">
                            </a>
                        <?php endforeach ?>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#profile"><i class=" fa-solid fa-user"></i> Profile</a></li>
                            <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="logout.php"><i class="fa-solid fa-person-running"></i> Logout</a></li>
                </ul>
                </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4 text-center">
        <h2 class="mb-5">Seluruh User Terdaftar</h2>

        <table id="table_id" class="table table-striped text-center mt-3 display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <?php $no = 1; ?>
            <tbody>
                <?php foreach ($allUser as $user) : ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td>
                            <img src="fotoProfile/<?= $user['foto_profile'] ?>" class="rounded-circle" width="40" height="40">
                        </td>
                        <td><?= $user['username'] ?></td>
                        <td><?= $user['role'] ?></td>
                        <td>
                            <?php if ($_SESSION["login"]["role"] == 'admin') : ?>
                                <a href="hapusUser.php?id=<?= $user['id']; ?>" onclick="return confirm('Yakin Hapus User?');" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                            <?php endif ?>
                        </td>
                    </tr>
                    <?php $no++ ?>
                <?php endforeach ?>
            </tbody>
        </table>

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
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#table_id').DataTable();
        });
    </script>
</body>

</html>