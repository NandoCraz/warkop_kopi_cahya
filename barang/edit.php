<?php
session_start();

require '../middleware/auth.php';
require '../middleware/admin.php';
require('../config.php');

// tangkap id
$id = $_GET['id'];

$user = queryData("SELECT * FROM users WHERE id =" . $_SESSION['login']['id'])[0];

// query data karyawan
$barang = queryData("SELECT * FROM barangs WHERE id = $id")[0];

// cek submit sudah ditekan
if (isset($_POST['submit'])) {
    if (updateBarang($_POST) > 0) {
        echo "
        <script>
            alert('Data berhasil diubah');
            document.location.href = 'barang.php';
        </script>";
    } else {
        mysqli_error($conn);
        echo "
        <script>
            alert('Data gagal diubah');
            document.location.href = 'edit.php?id=$id';
        </script>";
    }
};

$thisPage = 'barang';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Warkop Cahaya | List Barang</title>

    <!-- Custom fonts for this template-->
    <link href="../assets_admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/9fcca3cd45.js" crossorigin="anonymous"></script>

    <!-- Custom styles for this template-->
    <link href="../assets_admin/css/sb-admin-2.min.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="../assets_admin/css/trix.css" />
    <script type="text/javascript" src="../assets_admin/js/trix.js"></script>

    <style>
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../index.php">
                <div class="sidebar-brand-icon">
                    Warkop Cahaya
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0" />

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="../index.php">
                    <i class="fas fa-fw fa-th-large"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <div class="sidebar-heading mt-3">Admin</div>

            <li class="nav-item">
                <a class="nav-link" href="../pemasukan/pemasukan.php">
                    <i class="fa fa-line-chart" aria-hidden="true"></i>
                    <span>Pemasukan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../pengeluaran/pengeluaran.php">
                    <i class="fa fa-area-chart" aria-hidden="true"></i>
                    <span>Pengeluaran</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../transaksi/transaksi.php">
                    <i class="fa fa-handshake-o" aria-hidden="true"></i>
                    <span>Transaksi</span>
                </a>
            </li>

            <div class="sidebar-heading mt-3">Feature</div>

            <li class="nav-item <?php if ($thisPage == 'barang') echo "active" ?>">
                <a class="nav-link" href="../barang/barang.php">
                    <i class="fa fa-list-ol" aria-hidden="true"></i>
                    <span>List Barang</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../menu/menu.php">
                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                    <span>List Menu</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../laba_rugi/laba_rugi.php">
                    <i class="fa fa-newspaper-o" aria-hidden="true"></i>
                    <span>Laba Rugi</span>
                </a>
            </li>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $user['username'] ?></span>
                                <img class="img-profile rounded-circle" src="../fotoProfile/defaultFoto.jpeg" />
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#profileModal">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="../logout.php" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                    <!-- @include('adminPage.partials.modals.profileAdmin') -->
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="barang.php">List Barang</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Ubah</li>
                        </ol>
                    </nav>

                    <form action="" method="post" enctype="multipart/form-data" class="mb-4">
                        <input type="hidden" name="id" value="<?= $barang['id'] ?>">
                        <div class="mb-3">
                            <label for="kode_barang" class="form-label">Kode Barang</label>
                            <input type="text" class="form-control" name="kode_barang" id="kode_barang" required autocomplete="off" value="<?= $barang['kode_barang']; ?>" readonly disabled>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" name="nama" id="nama" required autocomplete="off" value="<?= $barang['nama']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" name="harga" id="harga" required autocomplete="off" value="<?= $barang['harga']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" name="stok" id="stok" required autocomplete="off" value="<?= $barang['stok']; ?>">
                        </div>
                        <div class="mt-3 float-end">
                            <button type="submit" name="submit" class="btn btn-dark mb-3">Ubah</button>
                        </div>
                    </form>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Warkop Cahaya</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">User Profile</h5>
                </div>
                <div class="modal-body">
                    <div class="container-xl px-4 mt-4">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card mb-4 mb-xl-0">
                                    <div class="card-header">Foto Profile</div>
                                    <div class="card-body text-center">
                                        <img class="imgPreviewProfile img-profile mb-2" src="../fotoProfile/defaultFoto.jpeg" width="170" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8">
                                <!-- Account details card-->
                                <div class="card mb-4">
                                    <div class="card-header">Admin Details</div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="small mb-1" for="username">Username</label>
                                            <input class="form-control" name="username" id="username" type="text" value="<?= $user['username'] ?>" readonly disabled />
                                        </div>

                                        <div class="mb-3">
                                            <label class="small mb-1" for="no_hp">Role</label>
                                            <input class="form-control" name="no_hp" id="no_hp" type="text" value="<?= $user['role'] ?>" readonly disabled />
                                        </div>

                                        <!-- Submit button-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../assets_admin/vendor/jquery/jquery.min.js"></script>
    <script src="../assets_admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets_admin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets_admin/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(document).ready(function() {
            $("#table_id").DataTable();
            $(".dataTable").DataTable();
        });
    </script>
</body>

</html>