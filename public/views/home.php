<?php
global $koneksi;
// session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login');
    exit;
}
$queryJmlSurat = "SELECT COUNT(*) as jml_surat FROM surat";
$resultJmlSurat = mysqli_query($koneksi, $queryJmlSurat);
$jmlSurat = mysqli_fetch_assoc($resultJmlSurat);



$queryJmlUser = "SELECT COUNT(id_user) as jml_user FROM user";
$resultJmlUser = mysqli_query($koneksi, $queryJmlUser);
$jmlUser = mysqli_fetch_assoc($resultJmlUser);

include VIEW_PATH . 'template/header.php';
?>

<!-- start content -->
<div class="bg-gray-100 flex-1 p-6 md:mt-16">

    <!-- General Report -->
    <div class="grid grid-cols-4 gap-6 xl:grid-cols-1">

        <!-- card -->
        <div class="report-card">
            <div class="card">
                <div class="card-body flex flex-col">
                    <!-- top -->
                    <div class="flex flex-row justify-between items-center">
                        <div class="h6 text-red-700 fad fa-envelope"></div>
                        <span class="rounded-full px-3 text-white text-md badge bg-red-400">
                            <?= $jmlSurat['jml_surat']; ?>
                        </span>
                    </div>
                    <!-- end top -->

                    <!-- bottom -->
                    <div class="mt-8">
                        <h1 class="h5 num-4"></h1>
                        <p>Jumlah Surat</p>
                    </div>
                    <!-- end bottom -->

                </div>
            </div>
            <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
        </div>
        <!-- end card -->


        <!-- card -->
        <div class="report-card">
            <div class="card">
                <div class="card-body flex flex-col">

                    <!-- top -->
                    <div class="flex flex-row justify-between items-center">
                        <div class="h6 text-green-700 fad fa-users"></div>
                        <span class="rounded-full px-3 text-white text-md badge bg-teal-400">
                            <?= $jmlUser['jml_user']; ?>
                        </span>
                    </div>
                    <!-- end top -->

                    <!-- bottom -->
                    <div class="mt-8">
                        <h1 class="h5 num-4"></h1>
                        <p>Jumlah User</p>
                    </div>
                    <!-- end bottom -->

                </div>
            </div>
            <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
        </div>
        <!-- end card -->

    </div>
    <!-- end quick Info -->

</div>
<!-- end content -->

<?php
include VIEW_PATH . 'template/footer.php';
?>