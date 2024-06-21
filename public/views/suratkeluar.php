<?php
if (!isset($_SESSION['username'])) {
    header('Location: login');
    exit;
}

global $koneksi;

$user_id = $_SESSION['id_user'];
$divisi_id = $_SESSION['id_divisi'];

$user_id = $_SESSION['id_user'];
$level_user = $_SESSION['leveluser'];
$surat = getSuratKeluar($koneksi, $user_id, $level_user);

// Menangani aksi approve surat
if (isset($_GET['approve']) && $level_user === 'admin') {
    $id_surat = $_GET['approve'];
    if (approveSurat($koneksi, $id_surat)) {
        header('Location: suratkeluar.php');
        exit;
    } else {
        echo "Gagal meng-approve surat.";
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
                        <i class="fad fa-envelope-open m-auto"></i>
                        <div class="text-l ml-3 ">Surat Keluar</div>
                    </div>
                    <a href="<?= BASE_URL ?>suratkeluar/tambah" class="rounded text-white badge bg-teal-900 text-xs p-2">
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
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No Surat</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tgl Surat</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Perihal</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pengirim</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Divisi Tujuan</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($surat as $row) { ?>
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?= $row['no_surat']; ?></td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?= $row['tanggal_surat']; ?></td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?= $row['perihal']; ?></td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?= $row['username']; ?></td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?= $row['nama_divisi']; ?></td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <?php if ($row['status_approve'] == 1) { ?>
                                        <span class="text-green-500">Approved</span>
                                    <?php } else { ?>
                                        <span class="text-red-500">Pending</span>
                                    <?php } ?>
                                </td>
                                <td class="flex px-5 py-5">
                                    <a href="<?= BASE_URL; ?>viewsurat/<?= $row['id_surat']; ?>" class="badge bg-teal-700 text-white text-xs p-2 mx-1"><i class="fad fa-eye text-m"></i>view
                                    </a>

                                    <?php if ($level_user == 1) { // Jika user adalah admin 
                                    ?>
                                        <?php
                                        if ($row['status_approve'] == 0) { ?>
                                            <a href="<?= BASE_URL; ?>approve/<?= $row['id_surat']; ?>" class="badge bg-red-500 text-white text-xs p-2"> <i class="fad fa-times text-m"></i> approve </a>
                                        <?php } else { ?>
                                            <span class=" badge bg-green-500 text-white text-xs p-2"> approved </span>
                                        <?php } ?>
                                    <?php } ?>

                                    <?php if ($level_user == 0) { ?>
                                        <a href="<?= BASE_URL; ?>suratkeluar/update/<?= $row['id_surat']; ?>" class="badge bg-gray-600 text-white text-xs p-2 mx-1">
                                            <i class="fad fa-edit text-m"></i>
                                        </a>
                                    <?php } ?>

                                    <a href="<?= BASE_URL; ?>suratkeluar/hapus/<?= $row['id_surat']; ?>" class="badge bg-red-400 text-white text-xs p-2 mx-1" onclick="return confirm('yakin ingin menghapus?')">
                                        <i class="fad fa-trash-alt text-m"></i>
                                    </a>

                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include VIEW_PATH . 'template/footer.php'; ?>