<?php

if (!isset($_SESSION['username'])) {
    header('Location: login');
    exit;
}

error_reporting(0);

global $koneksi;
$query = "SELECT * FROM divisi";
$result = mysqli_query($koneksi, $query);
$pesan = prosesSubmitSurat();

$disableSubmit = isset($_POST['submit_surat']) ? 'disabled' : '';

include VIEW_PATH . 'template/header.php';
?>



<!-- start content -->
<div class="bg-gray-100 flex-1 p-6 md:mt-16">
    <!-- General Report -->
    <div class="grid">
        <!-- card -->
        <a href="<?= BASE_URL; ?>suratkeluar" class="text-blue-400 mb-5 text-sm"><i class="fas fa-chevron-left  text-blue-400 "></i> Back</a>
        <div class="card">

            <div class="card-body flex flex-col">

                <h2 class="text-base font-semibold leading-7 text-gray-900">Pengajuan Surat</h2>
                <form action="<?= BASE_URL; ?>suratkeluar/tambah" method="post" enctype="multipart/form-data" class="my-5">

                    <div class="my-5">
                        <label for="judul_surat" class="block text-sm font-medium leading-6 text-gray-900">Judul Surat</label>
                        <div class="mt-2">
                            <input id="judul_surat" name="judul_surat" type="text" class="block w-full pl-3 text-sm border-2 p-2">
                        </div>
                    </div>

                    <div class="my-5">
                        <label for="tanggal_surat" class="block text-sm font-medium leading-6 text-gray-900">Tanggal Surat</label>
                        <div class="mt-2">
                            <input id="tanggal_surat" name="tanggal_surat" type="date" class="block w-full pl-3 text-sm border-2 p-2" value="<?= date("Y-m-d"); ?>">
                        </div>
                    </div>

                    <div class="my-5 ">
                        <label for="divisi_tujuan" class="block text-sm font-medium leading-6 text-gray-900">Divisi Tujuan</label>
                        <div class="mt-2 ">
                            <select id="divisi_tujuan" name="divisi_tujuan" class="block rounded border-2 py-1.5 text-gray-900 shadow-sm w-full pl-3 text-sm sm:text-sm p-2">
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option class='text-sm' value='$row[id_divisi]'>$row[nama_divisi]</option> ";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class=" form-control mb-3 hidden">
                        <label for="pengirim">Pengirim :</label>
                        <input type="" name="pengirim" id="pengirim" class="border-2 px-3 p-2" value="<?= $_SESSION['username'];  ?>">
                    </div>

                    <div class="my-5">
                        <label for="perihal" class="block text-sm font-medium  text-gray-900">Perihal</label>
                        <div class="mt-2 border-2">
                            <input id="perihal" name="perihal" type="text" class="block w-full pl-3 text-sm p-2">
                        </div>
                    </div>
                    <div class="col-span-full">
                        <label for="file" class="block text-sm font-medium leading-6 text-gray-900">Upload File</label>
                        <div class="mt-2 flex justify-center rounded-lg border-2 border-dashed border-gray-900/25 px-6 py-10">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                </svg>
                                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                    <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                        <span>Upload a file</span>
                                        <input id="file-upload" name="file" type="file" class="sr-only">
                                    </label>
                                </div>
                                <p class="text-xs leading-5 text-gray-600">WORD or PDF</p>
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="simpan" name="submit_surat" class="btn bg-teal-500 text-white mt-4">
                </form>
                <?php
                // Menampilkan pesan sesuai dengan hasil proses
                if (strpos($pesan, 'berhasil') !== false) {
                    echo '<div class="alert alert-success">' . $pesan . '</div>';
                } else {
                    echo '<div class="alert alert-danger">' . $pesan . '</div>';
                } ?>
            </div>
        </div>
        <!-- end card -->
    </div>
    <!-- end quick Info -->

    <?php
    include VIEW_PATH . 'template/footer.php';

    ?>