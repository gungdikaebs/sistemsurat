<?php
// session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login');
    exit;
}

global $koneksi;

$user_id = $_SESSION['id_user'];
$divisi_id = $_SESSION['id_divisi'];
$level_user = $_SESSION['leveluser'];
$surat = getsuratMasuk($koneksi, $divisi_id, $level_user);
include VIEW_PATH . 'template/header.php';

?>

<div class="bg-gray-100 flex-1 p-6 md:mt-16">
    <div class="flex flex-col">
        <div class="card">
            <div class="card-body flex flex-col">
                <div class="flex flex-row justify-between items-center">
                    <div class="flex align-items-center">
                        <i class="fad fa-envelope-open m-auto"></i>
                        <div class="text-l ml-3 ">Surat Masuk</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body flex flex-col">
                <table>
                    <tr class="py-2 border-b w-full">
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No Surat</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tgl Surat</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Perihal</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pengirim</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                    </tr>
                    <?php foreach ($surat as $row) { ?>
                        <tr>
                            <?php if ($row['status_approve'] == 1) { ?>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?= $row['no_surat']; ?></td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?= $row['tanggal_surat']; ?></td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?= $row['perihal']; ?></td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?= $row['username']; ?></td>
                                <td class="py-5 ">
                                    <a href="<?= BASE_URL; ?>viewsurat/<?= $row['id_surat']; ?>" class="badge bg-teal-700 text-white text-xs p-2"><i class="fad fa-eye text-m"></i> view</a>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>

<?php

include VIEW_PATH . 'template/footer.php';
?>