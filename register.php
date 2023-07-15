<?php
require 'function.php';
session_start();

if (isset($_POST["register"])) {
    if (registrasi($_POST) > 0) {
        echo "<script>alert('user baru ditambahkan');</script>";
        header("Location: diagnosa.php");
    } else {
        echo mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Halaman Registrasi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body style="background: linear-gradient(to right, #C9D6FF, #E2E2E2);">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow mb-5">
                    <div class="card-body">
                        <h4 class="card-title">
                            Registrasi
                        </h4>
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="nama_user" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_user" name="nama_user">
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat">
                            </div>
                            <div class="mb-3">
                                <label for="nama_kucing" class="form-label">Nama Kucing</label>
                                <input type="text" class="form-control" id="nama_kucing" name="nama_kucing">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="mb-3">
                                <label for="password2" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="password2" name="password2">
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-primary" type="submit" name="register">Register</button>
                            </div>
                            <div class="paragraf">
                                <p>Sudah punya akun? <a href="daftar.php">Login</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>