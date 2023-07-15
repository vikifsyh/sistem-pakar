<?php
session_start();

if (!isset($_SESSION["daftar"])) {
    header("Location: daftar.php");
    exit;
}

require 'function.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pakar - Diagnosa Penyakit</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        ul a li:hover {
            background-color: #eaeaea;
            opacity: 0.5;
            border-radius: 5px;
        }

        a:hover {
            opacity: 0.5;
            border-radius: 5px;
        }
    </style>

</head>

<body style="background: linear-gradient(to bottom, #E2E2E2, #C9D6FF);">
    <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary w-100">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="./img/Group 7.png" width="250" alt="">
            </a>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="diagnosa.php">Diagnosa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Kontak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tentang</a>
                    </li>
                </ul>
            </div>
            <form class="d-flex">
                <a class="text-decoration-none text-reset" href="logout.php"><i
                        class="fa-solid fa-right-from-bracket"></i> Logout</a>
            </form>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <?php
    // Proses input form jika ada
    if (isset($_POST['diagnosa'])) {
        if (isset($_POST['gejala'])) {
            $gejala_terpilih = $_POST['gejala'];
            $hasil_diagnosa = forwardChaining($gejala_terpilih, $conn);
        } else {
            // Jika tidak ada gejala yang dipilih, kembalikan pesan error atau lakukan tindakan lain
            ?>
            <div class="alert alert-danger d-flex align-items-center d-grid gap-2 col-6 mx-auto mt-3" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img"
                    aria-label="Warning:">
                    <path
                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                </svg>
                <div>
                    Tidak ada gejala yang anda pilih
                </div>
            </div>
            <?php
            header("refresh:3;url=diagnosa.php");
        }
    }
    ?>
    <div class="container">
        <form method="POST">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card mt-3 shadow">
                        <h5 class="card-header bg-primary d-flex justify-content-center text-light">Hasil Diagnosa
                            Penyakit Kucing
                        </h5>
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">BIODATA PEMILIK</th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Nama</strong></td>
                                        <td>:</td>
                                        <td class="text-uppercase">
                                            <?= $_SESSION['nama_user']; ?>
                                        </td>
                                    </tr>

                                    <tr class="border-bottom">
                                        <td><strong>Alamat</strong></td>
                                        <td>:</td>
                                        <td class="text-uppercase">
                                            <?= $_SESSION['alamat']; ?>
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td><strong>Nama Kucing</strong></td>
                                        <td>:</td>
                                        <td class="text-uppercase">
                                            <?= $_SESSION['nama_kucing']; ?>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            <table>
                                <thead>
                                    <th scope="col">SILAHKAN CHECKLIST GEJALA-GEJALA DIBAWAH INI</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <?php $i = 1; ?>
                                            <?php foreach ($gejala as $g): ?>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="gejala[]"
                                                        value="<?= $g['id'] ?>" id="<?= $g['id'] ?>">
                                                    <label class="form-check-label" for="<?= $g['id'] ?>">
                                                        <?= $g['nama'] ?>
                                                    </label>
                                                </div>
                                                <?php $i++; ?>
                                            <?php endforeach; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table>
                                <thead>
                                    <th scope="col">HASIL ANALISA PENYAKIT</th>
                                </thead>
                                <?php if (isset($hasil_diagnosa)): ?>
                                    <?php if (count($hasil_diagnosa) > 0): ?>
                                        <?php foreach ($hasil_diagnosa as $penyakit): ?>
                                            <tbody>
                                                <tr>
                                                    <td>Penyakit:</td>
                                                    <td>
                                                        <strong>
                                                            <?= $penyakit['nama'] ?>
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Solusi:</td>
                                                    <td>
                                                        <?= $penyakit['solusi'] ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p>Tidak ada penyakit yang terdiagnosis.</p>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </table>
                            <br>
                            <button type="submit" name="diagnosa" class="btn btn-primary">Diagnosa</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
    <footer class="footer bg-dark text-light mt-3">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-6">
                    <h5>About Us</h5>
                    <p>Sistem pakar ini membantu Anda mendiagnosa penyakit yang dialami oleh kucing berdasarkan
                        gejala-gejala yang ditampilkan.</p>
                </div>
                <div class="col-md-6">
                    <h5>Contact Us</h5>
                    <ul class="list-unstyled">
                        <li>Email: vfsyah@gmail.com</li>
                        <li>WhatsApp: 0812-2566-1530</li>
                        <li>Alamat: Jalan Penatusan No 17 Binangun, Cilacap</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="bg-dark text-center py-3">
            <p class="mb-0">© 2023 Viki Flendiansyah. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>