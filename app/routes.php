<?php

route('', function () {
    return view('home');
});

route('about', function () {
    return view('about');
});

route('login', function () {

    if (isset($_POST['submit_login'])) {
        login();
    }
    return view('login');
});

route('logout', function () {
    logout();
});

route('suratmasuk', function () {
    global $koneksi;
    return view('suratmasuk');
});

route('suratkeluar', function () {
    return view('suratkeluar');
});


route('suratkeluar/tambah', function () {
    return view('tambahsuratkeluar');
});

route('viewsurat/{id}', function ($id) {
    global $koneksi;

    $level_user = $_SESSION['leveluser'];
    $suratDetail = getDetailSurat($koneksi, $id);

    return view('viewsurat', ['surat' => $suratDetail, 'leveluser' => $level_user]);
});

route('suratkeluar/hapus/{id}', function ($id) {
    global $koneksi;
    handleDeleteSuratKeluar($koneksi, $id);
});

route('suratkeluar/update/{id}', function ($id) {
    global $koneksi;

    // Panggil fungsi untuk mendapatkan detail surat berdasarkan ID
    $surat = getDetailSurat($koneksi, $id);

    // Ambil daftar divisi untuk dropdown
    $queryDivisi = "SELECT id_divisi, nama_divisi FROM divisi";
    $resultDivisi = mysqli_query($koneksi, $queryDivisi);
    $divisiList = [];
    while ($row = mysqli_fetch_assoc($resultDivisi)) {
        $divisiList[] = $row;
    }

    // Panggil view untuk formulir pembaruan surat
    return view('updatesuratkeluar', ['surat' => $surat, 'divisiList' => $divisiList]);
});

route('prosesupdatesurat/{id}', function ($id) {
    global $koneksi;
    // Panggil fungsi untuk memproses pembaruan surat
    handleUpdateSuratKeluar($koneksi, $id);
});



route('approve/{id}', function ($id) {
    global $koneksi;
    approveSurat($koneksi, $id);
    header("location:" . BASE_URL . "suratkeluar");
    exit;
});

route('get/user', function () {
    return view('user', ['users' => getAllUser()]);
});

route('get/user/{id}', function ($id) {
    return view('user', ['id' => $id, 'users' => getUser($id)]);
});

route('user', function () {
    return view('user');
});

route('user/tambah', function () {
    // Jika form submit dengan method POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        global $koneksi;

        // Ambil data dari form
        $username = $_POST['username'];
        $password = $_POST['password'];
        $id_divisi = $_POST['divisi'];
        $level_user = $_POST['leveluser'];

        // Panggil fungsi tambahUser untuk menyimpan user baru
        $result = tambahUser($koneksi, $username, $password, $id_divisi, $level_user);

        // Redirect ke halaman user setelah proses selesai
        if ($result) {
            header('Location: ' . BASE_URL . 'user');
            exit;
        } else {
            // Handle error jika gagal menambah user
            echo "Gagal menambah user.";
        }
    } else {
        // Jika bukan method POST, tampilkan halaman tambah user
        return view('tambahuser');
    }
});

route('user/delete/{id}', function ($id) {
    global $koneksi;

    // Panggil fungsi hapusUser untuk menghapus user
    $result = hapusUser($koneksi, $id);

    // Redirect kembali ke halaman user setelah proses selesai
    if ($result) {
        header('Location: ' . BASE_URL . 'user');
        exit;
    } else {
        // Handle error jika gagal menghapus user
        echo "Gagal menghapus user.";
    }
});

route('user/update/{id}', function ($id) {
    global $koneksi;

    // Ambil data user berdasarkan ID
    $user = getUserById($koneksi, $id);

    if (!$user) {
        // Handle jika user tidak ditemukan
        echo "User tidak ditemukan.";
        return;
    }

    // Query untuk mengambil data divisi
    $query = "SELECT * FROM divisi";
    $result = mysqli_query($koneksi, $query);

    // Pastikan divisi tersedia
    if (!$result) {
        echo "Data divisi tidak tersedia.";
        return;
    }

    // Memasukkan hasil query ke dalam array $divisi
    $divisiList = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $divisiList[] = $row;
    }

    // Load view untuk halaman update user
    return view('updateuser', ['user' => $user, 'divisiList' => $divisiList]);
});

// Rute untuk menangani proses update user
route('user/prosesupdate/{id}', function ($id) {
    global $koneksi;

    // Ambil data yang dikirimkan melalui form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $leveluser = $_POST['leveluser'];
    $divisi = $_POST['divisi'];

    // Hash password baru jika diisi
    $password_hashed = password_hash($password, PASSWORD_BCRYPT);


    // Panggil fungsi updateUserData untuk melakukan update
    $result = updateUserData($koneksi, $id, $username, $password_hashed, $leveluser, $divisi);

    // Redirect kembali ke halaman user setelah proses selesai
    if ($result) {
        header('Location: ' . BASE_URL . 'user');
        exit;
    } else {
        // Handle error jika gagal melakukan update
        echo "Gagal melakukan update user.";
    }
});


handleRoute();
