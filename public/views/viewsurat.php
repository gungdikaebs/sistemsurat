<?php
// session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login');
    exit;
}
$level_user = $_SESSION['leveluser'];
include VIEW_PATH . 'template/header.php';
?>
<div class="bg-gray-100 flex-1 p-6 md:mt-16">
    <!-- General Report -->
    <div class="grid">
        <!-- card -->
        <div class="card">
            <div class="card-body">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Detail Surat</h2>
                <?php if ($surat) : ?>
                    <table class="table-auto w-full mt-5">
                        <tbody>
                            <tr>
                                <td class="border px-4 py-2 font-semibold">No Surat:</td>
                                <td class="border px-4 py-2"><?= $surat['no_surat']; ?></td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2 font-semibold">Judul Surat:</td>
                                <td class="border px-4 py-2"><?= $surat['judul_surat']; ?></td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2 font-semibold">Tanggal Surat:</td>
                                <td class="border px-4 py-2"><?= $surat['tanggal_surat']; ?></td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2 font-semibold">Divisi Tujuan:</td>
                                <td class="border px-4 py-2"><?= $surat['nama_divisi']; ?></td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2 font-semibold">Pengirim:</td>
                                <td class="border px-4 py-2"><?= $surat['username']; ?></td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2 font-semibold">Perihal:</td>
                                <td class="border px-4 py-2"><?= $surat['perihal']; ?></td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2 font-semibold">File:</td>
                                <td class="border px-4 py-2">
                                    <a href="<?= BASE_URL . $surat['file_path']; ?>" class="btn bg-blue-500 text-white px-4 py-2 text-center w-32" target="_blank">Download</a>
                                </td>
                            </tr>
                            <?php if ($level_user == '1' && $surat['status_approve'] == 0) : ?>
                                <tr>
                                    <td class="border px-4 py-2" colspan="2">
                                        <a href="<?= BASE_URL; ?>approve/<?= $surat['id_surat']; ?>" class="m-auto btn bg-red-500 text-white text-md p-3 rounded text-center"> <i class="fad fa-times text-m"></i> approve </a>
                                    </td>
                                </tr>
                            <?php elseif ($level_user == '1' && $surat['status_approve'] == 1) : ?>
                                <tr>
                                    <td class="border px-4 py-2 font-semibold">Status:</td>
                                    <td class="border px-4 py-2">Approved</td>
                                </tr>

                            <?php endif; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <div class="alert alert-danger">Detail surat tidak ditemukan.</div>
                <?php endif; ?>
            </div>
        </div>
        <!-- end card -->
    </div>
    <!-- end quick Info -->
</div>
<!-- end content -->

<?php
include VIEW_PATH . 'template/footer.php';
?>