<?php
global $koneksi;
if (!isset($_SESSION['username'])) {
    header('Location: login');
    exit;
}
include VIEW_PATH . 'template/header.php';
?>

<!-- start content -->
<div class="bg-gray-100 flex-1 p-6 md:mt-16">
    <a href="<?= BASE_URL; ?>suratkeluar" class="text-blue-400 mb-5 text-sm"><i class="fas fa-chevron-left  text-blue-400 "></i> Back</a>
    <!-- card -->
    <div class="card">
        <div class="card-body flex flex-col">
            <h2 class="text-base font-semibold leading-7 text-gray-900">Update Surat</h2>
            <form action="<?= BASE_URL; ?>prosesupdatesurat/<?= $surat['id_surat']; ?>" method="POST" enctype="multipart/form-data" class="my-5">
                <table class="table-auto w-full">
                    <tbody>
                        <tr class="py-5">
                            <td>
                                <label for=" judul_surat">Judul Surat:</label>
                            </td>
                            <td>
                                <input type="text" id="judul_surat" name="judul_surat" value="<?= $surat['judul_surat']; ?>" class="p-3 border-2 w-96">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="tanggal_surat">Tanggal Surat:</label></td>
                            <td><input type="date" id="tanggal_surat" name="tanggal_surat" value="<?= $surat['tanggal_surat']; ?>" class="p-3 border-2 w-96"></td>
                        </tr>
                        <tr>
                            <td><label for="divisi_tujuan">Divisi Tujuan:</label></td>
                            <td>
                                <select id="divisi_tujuan" name="divisi_tujuan" class="p-3 border-2 w-96">
                                    <?php foreach ($divisiList as $divisi) : ?>
                                        <option class="p-3" value="<?= $divisi['id_divisi']; ?>" <?php if ($divisi['id_divisi'] == $surat['id_divisi']) echo "selected"; ?>>
                                            <?= $divisi['nama_divisi']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="perihal">Perihal:</label></td>
                            <!-- <td><textarea id="perihal" name="perihal"><?= $surat['perihal']; ?></textarea></td> -->
                            <td>
                                <input type="text" id="perihal" name="perihal" value="<?= $surat['perihal']; ?>" class="p-3 border-2 w-96">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="file">File:</label></td>
                            <td><input type="file" id="file" name="file" class="p-3 border-2 w-96"></td>
                        </tr>



                    </tbody>
                </table>

                <button type="submit" class="btn bg-gray-800 text-white flex my-5">
                    Update
                </button>

            </form>
        </div>
    </div>
</div>

<?php include VIEW_PATH . 'template/footer.php'; ?>