    <?php
    global $koneksi;
    if (!isset($_SESSION['username'])) {
        header('Location: login');
        exit;
    }
    if ($_SESSION['leveluser'] == 0) {
        header('Location:' . BASE_URL);
        exit;
    }

    // Query untuk mengambil data user dari database
    $query = "SELECT user.*, divisi.nama_divisi FROM user
          INNER JOIN divisi ON user.id_divisi = divisi.id_divisi";;
    $result = mysqli_query($koneksi, $query);

    // Inisialisasi array untuk menyimpan hasil query
    $users = [];

    // Memasukkan hasil query ke dalam array $users
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    }

    include VIEW_PATH . 'template/header.php';
    ?>

    <div class="bg-gray-100 flex-1 p-6 md:mt-16">
        <div class="flex flex-col">
            <div class="card">
                <div class="card-body flex flex-col">
                    <div class="flex flex-row justify-between items-center">
                        <div class="flex align-items-center">
                            <i class="fad fa-user m-auto"></i>
                            <div class="text-l ml-3 ">User</div>
                        </div>
                        <a href="<?= BASE_URL ?>user/tambah" class="rounded text-white badge bg-teal-900 text-xs p-2">
                            Tambah Data
                            <i class="fal fa-chevron-up ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body flex flex-col">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"> Username</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"> Password</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"> Divisi</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"> Level User</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"> Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?= $user['username']; ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?= $user['password']; ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?= $user['nama_divisi']; ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?= $user['leveluser'] == 1 ? 'Admin' : 'User'; ?></td>
                                    <td class="flex">
                                        <a href="<?= BASE_URL; ?>user/update/<?= $user['id_user']; ?>" class="badge bg-gray-600 text-white text-xs p-2 mx-1">
                                            <i class="fad fa-edit text-m"></i>
                                        </a>
                                        <a href="<?= BASE_URL; ?>user/delete/<?= $user['id_user']; ?>" class="badge bg-red-400 text-white text-xs p-2 mx-1" onclick="return confirm('yakin ingin menghapus?')">
                                            <i class="fad fa-trash-alt text-m"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php include VIEW_PATH . 'template/footer.php'; ?>