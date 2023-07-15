<?php
// koneksi
$conn = mysqli_connect("localhost", "root", "", "sistem_pakar_db");

// Ambil daftar gejala dari database
$query = "SELECT * FROM gejala";
$result = mysqli_query($conn, $query);
$gejala = array();

while ($row = mysqli_fetch_assoc($result)) {
    $gejala[] = $row;
}

// Ambil daftar penyakit dari database
$query = "SELECT * FROM penyakit";
$result = mysqli_query($conn, $query);
$penyakit = array();

while ($row = mysqli_fetch_assoc($result)) {
    $penyakit[] = $row;
}


function forwardChaining($gejala_terpilih, $conn)
{
    if (empty($gejala_terpilih)) {
        // Jika tidak ada gejala yang dipilih, kembalikan array kosong
        return array();
    }

    $penyakit_terdiagnosis = array(); // Array penyakit yang terdiagnosis
    $rule_changed = true; // Flag untuk menandakan adanya perubahan aturan

    // Looping sampai tidak ada perubahan aturan lagi atau sudah mencapai penyakit terakhir
    while ($rule_changed) {
        $rule_changed = false;

        // Ubah $gejala_terpilih menjadi string dengan koma sebagai pemisah
        $gejala_str = implode(",", $gejala_terpilih);

        // Ambil aturan yang memiliki gejala di antara gejala-gejala yang terpilih
        $query = "SELECT * FROM aturan WHERE id_gejala IN ($gejala_str)";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            // Jika penyakit belum terdiagnosis, tambahkan ke array penyakit terdiagnosis
            if (!in_array($row['id_penyakit'], $penyakit_terdiagnosis)) {
                $penyakit_terdiagnosis[] = $row['id_penyakit'];
                $rule_changed = true;
            }
        }
    }

    // Ambil nama-nama penyakit terdiagnosis dan solusinya dari database
    $hasil_diagnosa = array();

    foreach ($penyakit_terdiagnosis as $id_penyakit) {
        $query = "SELECT nama FROM penyakit WHERE id = $id_penyakit";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        $nama_penyakit = $row['nama'];

        $query = "SELECT solusi FROM solusi WHERE id_penyakit = $id_penyakit";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        $solusi_penyakit = $row['solusi'];

        $hasil_diagnosa[] = array(
            'nama' => $nama_penyakit,
            'solusi' => $solusi_penyakit
        );
    }

    return $hasil_diagnosa;
}

function registrasi($data)
{
    global $conn;
    $nama_user = strtolower(stripcslashes($data["nama_user"]));
    $nama_kucing = strtolower(stripcslashes($data["nama_kucing"]));
    $alamat = strtolower(stripcslashes($data["alamat"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    //cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT nama_user FROM user WHERE nama_user = '$nama_user'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>alert('Terimakasih username anda sudah terdaftar');</script>";
        return false;
    }

    //cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>alert('konfirmasi password tidak sesuai');</script>";
        return false;
    }

    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //tambahkan userbaru ke database
    mysqli_query($conn, "INSERT INTO user(nama_user, nama_kucing, alamat, password) VALUES('$nama_user', '$nama_kucing', '$alamat', '$password')");

    return mysqli_affected_rows($conn);
}

?>