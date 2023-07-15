<?php
session_start();

require 'function.php';

?>
<!DOCTYPE html>
<html>

<head>
    <title>Halaman Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>

<body style="background: linear-gradient(to right, #C9D6FF, #E2E2E2);">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="d-flex flex-column">
                    <div class="p-2"><img src="./img/fever.png" class="img-fluid" width="300" alt="..."></div>
                    <div class="p-2">
                        <h2 class="text-primary">
                            <a href="login.php">Silahkan daftar</a> <span class="text-dark">untuk cek kesehatan kucing
                                kesayangan anda</span>
                        </h2>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="card shadow mb-3 mt-10">
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="nama_user">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_user" name="nama_user"
                                    placeholder="Masukkan nama Anda" autocomplete="off" required />
                            </div>
                            <!-- <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat"
                                    placeholder="Masukkan alamat Anda" autocomplete="off" required />
                            </div>
                            <div class="form-group">
                                <label for="nama_kucing">Nama Kucing</label>
                                <input type="text" class="form-control" id="nama_kucing" name="nama_kucing"
                                    placeholder="Masukkan nama kucing Anda" autocomplete="off" required />
                            </div> -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Masukkan password" autocomplete="off">
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-primary" type="submit" name="login">Daftar</button>
                                <p>Belum punya akun? <a href="register.php">Daftar disini</a></p>
                            </div>
                            <!-- login -->
                            <div class="class mt-1" style="width: 350px">
                                <?php
                                if (isset($_POST["login"])) {
                                    $nama_user = htmlspecialchars($_POST["nama_user"]);
                                    /* $nama_kucing = htmlspecialchars($_POST["nama_kucing"]);
                                    $alamat = htmlspecialchars($_POST["alamat"]); */
                                    $password = htmlspecialchars($_POST["password"]);

                                    $query = mysqli_query($conn, "SELECT * FROM user WHERE nama_user = '$nama_user' ");
                                    $countdata = mysqli_num_rows($query);
                                    $data = mysqli_fetch_array($query);

                                    if ($countdata > 0) {
                                        if (password_verify($password, $data['password'])) {
                                            $_SESSION['nama_user'] = $data['nama_user'];
                                            $_SESSION['nama_kucing'] = $data['nama_kucing'];
                                            $_SESSION['alamat'] = $data['alamat'];
                                            $_SESSION["daftar"] = true;
                                            header('location: diagnosa.php');
                                        } else {
                                            ?>
                                            <div class="alert alert-danger" role="alert">
                                                Password salah
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="alert alert-danger" role="alert">
                                            Akun tidak tersedia
                                        </div>
                                        <?php
                                    }
                                } ?>
                            </div>
                            <!-- login -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>