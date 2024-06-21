<!-- views/updateuser.php -->

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

$query = "SELECT * FROM divisi";
$result = mysqli_query($koneksi, $query);
$pesan = prosesSubmitSurat();

$disableSubmit = isset($_POST['submit_user']) ? 'disabled' : '';

include VIEW_PATH . 'template/header.php';
?>

<!-- start content -->
<div class="bg-gray-100 flex-1 p-6 md:mt-16">
    <!-- General Report -->
    <div class="grid">
        <a href="<?= BASE_URL; ?>user" class="text-blue-400 mb-5 text-sm"><i class="fas fa-chevron-left  text-blue-400 "></i> Back</a>
        <!-- card -->
        <div class="card">

            <div class="card-body flex flex-col">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Update User</h2>
                <form action="<?= BASE_URL; ?>user/prosesupdate/<?= $user['id_user']; ?>" method="post" enctype="multipart/form-data" class="my-5">

                    <div class="my-5">
                        <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                        <div class="mt-2">
                            <input id="username" name="username" type="text" class="block w-full pl-3 text-sm border-2 p-2" value="<?= $user['username']; ?>">
                        </div>
                    </div>

                    <div class="my-5">
                        <label for="password" class="block text-sm font-medium  text-gray-900">Password</label>
                        <div class="mt-2">
                            <input id="password" name="password" type="password" class="block w-full pl-3 text-sm p-2" value="<?= $user['password']; ?>">
                        </div>
                    </div>

                    <div class="my-5">
                        <label for="divisi" class="block text-sm font-medium leading-6 text-gray-900">Divisi</label>
                        <div class="mt-2">
                            <select id="divisi" name="divisi" class="block rounded border-2 py-1.5 text-gray-900 shadow-sm w-full pl-3 text-sm sm:text-sm p-2">
                                <?php
                                foreach ($divisiList as $divisi) {
                                    $selected = ($divisi['id_divisi'] == $user['id_divisi']) ? 'selected' : '';
                                    echo "<option class='text-sm' value='$divisi[id_divisi]' $selected>$divisi[nama_divisi]</option> ";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="my-5">
                        <label for="leveluser" class="block text-sm font-medium leading-6 text-gray-900">Level User</label>
                        <div class="mt-2">
                            <select id="leveluser" name="leveluser" class="block rounded border-2 py-1.5 text-gray-900 shadow-sm w-full pl-3 text-sm sm:text-sm p-2">
                                <option value="1" <?= ($user['leveluser'] == 1) ? 'selected' : ''; ?>>Admin</option>
                                <option value="0" <?= ($user['leveluser'] == 0) ? 'selected' : ''; ?>>User</option>
                            </select>
                        </div>
                    </div>

                    <input type="submit" value="Simpan" name="submit_user" class="btn bg-teal-500 text-white mt-4">
                </form>
            </div>
        </div>
        <!-- end card -->
    </div>
    <!-- end quick Info -->

    <?php include VIEW_PATH . 'template/footer.php'; ?>