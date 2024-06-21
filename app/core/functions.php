<?php
global $koneksi;
function isGuest()
{
    return !isset($_SESSION['superAdmin']);
}

function isSuperAdmin()
{
    return isset($_SESSION['superAdmin']);
}

function login()
{
    global $koneksi;

    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['leveluser'] = $user['leveluser'];
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['id_divisi'] = $user['id_divisi'];


            header('Location: ' . BASE_URL);
            exit;
        } else {

            echo "<script>alert('password salah')</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan.')</script>";
    }
}


function logout()
{
    // Hancurkan sesi
    session_destroy();

    // Redirect ke halaman login atau halaman utama
    header("Location:" . BASE_URL . "login"); // Ganti dengan lokasi halaman login Anda
    exit;
}


function generateNoSurat($koneksi, $divisiPengirim, $divisiPenerima)
{
    $bulanRomawi = [1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
    $bulan = date('n');
    $tahun = date('Y');

    $query = "SELECT COUNT(*) as total FROM surat WHERE YEAR(tanggal_surat) = $tahun";
    $result = $koneksi->query($query);
    $row = $result->fetch_assoc();
    $noUrut = $row['total'] + 1;

    $queryDivisiPengirim = "SELECT singkatan FROM divisi WHERE id_divisi = $divisiPengirim";
    $resultDivisiPengirim = $koneksi->query($queryDivisiPengirim);
    $rowDivisiPengirim = $resultDivisiPengirim->fetch_assoc();
    $singkatanPengirim = $rowDivisiPengirim['singkatan'];

    $queryDivisiPenerima = "SELECT singkatan FROM divisi WHERE id_divisi = $divisiPenerima";
    $resultDivisiPenerima = $koneksi->query($queryDivisiPenerima);
    $rowDivisiPenerima = $resultDivisiPenerima->fetch_assoc();
    $singkatanPenerima = $rowDivisiPenerima['singkatan'];

    $noSurat = "0$noUrut/$singkatanPengirim/$singkatanPenerima/{$bulanRomawi[$bulan]}/$tahun";
    return $noSurat;
}

function tambahSuratMasuk($koneksi, $judul_surat, $tanggal_surat, $id_divisi, $id_user, $perihal, $file)
{

    global $koneksi;
    $divisi_pengirim = $_SESSION['id_divisi'];
    $status_approve = 0;
    $no_surat = generateNoSurat($koneksi, $divisi_pengirim, $id_divisi);

    $filePath = 'public/uploads/' . basename($file['name']);
    move_uploaded_file($file['tmp_name'], $filePath);

    $query = "INSERT INTO surat (no_surat, judul_surat, tanggal_surat, id_divisi, id_user, perihal, file_path, status_approve)
                VALUES ('$no_surat', '$judul_surat', '$tanggal_surat', $id_divisi, $id_user, '$perihal', '$filePath','$status_approve')";
    if (mysqli_query($koneksi, $query)) {
        return "Surat berhasil disimpan dengan nomor surat: $no_surat";
    } else {
        return "Terjadi kesalahan saat menyimpan surat.";
    }
}

function prosesSubmitSurat()
{
    global $koneksi;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $judul_surat = $_POST['judul_surat'];
        $tanggal_surat = $_POST['tanggal_surat'];
        $id_divisi = $_POST['divisi_tujuan'];
        $id_user = $_SESSION['id_user'];
        $perihal = $_POST['perihal'];
        $file = $_FILES['file'];
        $status_approve = 0;

        // Validasi untuk memeriksa apakah data yang sama sudah ada sebelumnya
        $queryCheck = "SELECT COUNT(*) AS total FROM surat WHERE judul_surat = '$judul_surat' AND tanggal_surat = '$tanggal_surat' AND id_divisi = $id_divisi AND perihal = '$perihal'";
        $resultCheck = mysqli_query($koneksi, $queryCheck);
        $data = mysqli_fetch_assoc($resultCheck);

        if ($data['total'] > 0) {
            return "Data dengan judul, tanggal, divisi, dan perihal yang sama sudah tersimpan sebelumnya.";
        } else {
            // Lakukan transaksi database
            mysqli_begin_transaction($koneksi);

            try {
                // Masukkan data ke dalam database
                $pesan = tambahSuratMasuk($koneksi, $judul_surat, $tanggal_surat, $id_divisi, $id_user, $perihal, $file, $status_approve);

                // Commit transaksi jika berhasil
                mysqli_commit($koneksi);
                return header("Location: " . BASE_URL . "suratkeluar");
            } catch (Exception $e) {
                // Rollback transaksi jika terjadi kesalahan
                mysqli_rollback($koneksi);
                return "Terjadi kesalahan saat menyimpan data.";
            }
        }
    }
}

function getSuratKeluar($koneksi, $user_id, $level_user)
{
    if ($level_user == 1) {
        $query = "
            SELECT surat.*, user.username, divisi.nama_divisi
            FROM surat
            INNER JOIN user ON surat.id_user = user.id_user
            INNER JOIN divisi ON surat.id_divisi = divisi.id_divisi
        ";
    } else {
        $query = "
            SELECT surat.*, user.username, divisi.nama_divisi
            FROM surat
            INNER JOIN user ON surat.id_user = user.id_user
            INNER JOIN divisi ON surat.id_divisi = divisi.id_divisi
            WHERE surat.id_user = $user_id
        ";
    }

    $result = mysqli_query($koneksi, $query);
    $surat = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $surat[] = $row;
    }
    return $surat;
}

function getSuratMasuk($koneksi, $divisi_id, $level_user)
{
    if ($level_user == 1) {
        $query = "
            SELECT surat.*, user.username, divisi.nama_divisi
            FROM surat
            INNER JOIN user ON surat.id_user = user.id_user
            INNER JOIN divisi ON surat.id_divisi = divisi.id_divisi
        ";
    } else {
        $query = "
            SELECT surat.*, user.username, divisi.nama_divisi
            FROM surat
            INNER JOIN user ON surat.id_user = user.id_user
            INNER JOIN divisi ON surat.id_divisi = divisi.id_divisi
            WHERE surat.id_divisi = $divisi_id
            
        ";
    }

    $result = mysqli_query($koneksi, $query);
    $surat = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $surat[] = $row;
    }
    return $surat;
}

function approveSurat($koneksi, $id_surat)
{
    $query = "UPDATE surat SET status_approve = 1 WHERE id_surat = $id_surat";
    return mysqli_query($koneksi, $query);
    header("Location: " . BASE_URL . "suratkeluar");
}

// Function untuk menghapus surat dari database berdasarkan ID
function deleteSurat($koneksi, $id_surat)
{
    // Hapus surat dari database berdasarkan ID
    $query = "DELETE FROM surat WHERE id_surat = $id_surat";

    if (mysqli_query($koneksi, $query)) {
        return "Surat berhasil dihapus.";
    } else {
        return "Terjadi kesalahan saat menghapus surat.";
    }
}

// Function untuk menangani routing delete surat
function handleDeleteSuratKeluar($koneksi, $id_surat)
{
    // Query untuk menghapus surat dari database berdasarkan id_surat
    $query = "DELETE FROM surat WHERE id_surat = $id_surat";
    $result = mysqli_query($koneksi, $query);

    // Mengatur pesan berdasarkan hasil operasi
    if ($result) {
        $pesan = "Surat keluar berhasil dihapus.";
    } else {
        $pesan = "Gagal menghapus surat keluar. Kesalahan: " . mysqli_error($koneksi);
    }

    // Redirect ke halaman surat keluar dengan pesan hasil operasi
    header("Location: " . BASE_URL . "suratkeluar");
    exit;
}

function getDetailSurat($koneksi, $id_surat)
{
    $query = "
        SELECT surat.*, user.username, divisi.nama_divisi
        FROM surat
        INNER JOIN user ON surat.id_user = user.id_user
        INNER JOIN divisi ON surat.id_divisi = divisi.id_divisi
        WHERE surat.id_surat = $id_surat
    ";

    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return null;
    }
}

function updateSurat($koneksi, $id_surat, $judul_surat, $tanggal_surat, $id_divisi, $perihal, $file)
{
    $setClauses = [];

    // Cek apakah ada file yang diupload
    if ($file && isset($file['name']) && $file['name'] !== '') {
        // Lakukan proses upload file
        $filePath = 'public/uploads/' . basename($file['name']);
        move_uploaded_file($file['tmp_name'], $filePath);
        $setClauses[] = "file_path = '$filePath'";
    }

    // Tambahkan klausa untuk mengupdate judul_surat, tanggal_surat, id_divisi, dan perihal
    if (!empty($judul_surat)) {
        $setClauses[] = "judul_surat = '$judul_surat'";
    }
    if (!empty($tanggal_surat)) {
        $setClauses[] = "tanggal_surat = '$tanggal_surat'";
    }
    if (!empty($id_divisi)) {
        $setClauses[] = "id_divisi = $id_divisi";
    }
    if (!empty($perihal)) {
        $setClauses[] = "perihal = '$perihal'";
    }

    // Gabungkan klausa-klausa yang sudah disiapkan
    $setClause = implode(", ", $setClauses);

    // Jika ada klausa yang disiapkan, lakukan proses update
    if (!empty($setClause)) {
        $query = "UPDATE surat SET $setClause WHERE id_surat = $id_surat";
        return mysqli_query($koneksi, $query);
    }

    // Kembalikan false jika tidak ada klausa yang disiapkan atau terjadi kesalahan
    return false;
}


function handleUpdateSuratKeluar($koneksi, $id_surat)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $judul_surat = $_POST['judul_surat'];
        $tanggal_surat = $_POST['tanggal_surat'];
        $id_divisi = $_POST['divisi_tujuan'];
        $perihal = $_POST['perihal'];
        $file = $_FILES['file'];

        $result = updateSurat($koneksi, $id_surat, $judul_surat, $tanggal_surat, $id_divisi, $perihal, $file);

        if ($result) {
            header("Location: " . BASE_URL . "suratkeluar");
            exit;
        } else {
            echo "Terjadi kesalahan saat memperbarui surat.";
        }
    }
}

// Fungsi untuk menambah user baru
function tambahUser($koneksi, $username, $password, $id_divisi, $leveluser)
{
    $username = mysqli_real_escape_string($koneksi, $username);
    $password_hashed = password_hash($password, PASSWORD_BCRYPT);
    $id_divisi = intval($id_divisi);
    $leveluser = intval($leveluser);

    $query = "INSERT INTO user (username, password, id_divisi, leveluser) VALUES ('$username', '$password_hashed', $id_divisi, $leveluser)";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        return true; // Berhasil menambah user
    } else {
        return false; // Gagal menambah user
    }
}

// Fungsi untuk menghapus user berdasarkan ID
function hapusUser($koneksi, $id_user)
{
    $id_user = intval($id_user); // Pastikan integer untuk keamanan

    $query = "DELETE FROM user WHERE id_user = $id_user";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        return true; // Berhasil menghapus user
    } else {
        return false; // Gagal menghapus user
    }
}

// Fungsi untuk mengambil data user berdasarkan ID
function getUserById($koneksi, $id_user)
{
    $id_user = intval($id_user); // Pastikan integer untuk keamanan

    $query = "SELECT * FROM user WHERE id_user = $id_user";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result); // Mengembalikan data user
    } else {
        return null; // User tidak ditemukan
    }
}

// Fungsi untuk melakukan update data user
function updateUserData($koneksi, $id_user, $username, $password, $leveluser, $divisi)
{
    $id_user = intval($id_user); // Pastikan integer untuk keamanan
    $username = mysqli_real_escape_string($koneksi, $username);
    $password = mysqli_real_escape_string($koneksi, $password);
    $leveluser = intval($leveluser); // Pastikan integer untuk keamanan
    $divisi = intval($divisi); // Pastikan integer untuk keamanan

    $query = "UPDATE user SET username = '$username', password = '$password', leveluser = $leveluser, id_divisi = $divisi WHERE id_user = $id_user";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        return true; // Berhasil melakukan update
    } else {
        return false; // Gagal melakukan update
    }
}
