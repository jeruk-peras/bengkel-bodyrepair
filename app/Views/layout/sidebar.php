<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="<?= base_url(); ?>assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">BENGKEL MANAJEMEN</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-menu'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">

        <li>
            <div class="menu-title">
                <?php $aksesCabang = count(aksesCabang()); ?>
                <select class="form-select mb-2" <?= $aksesCabang == 1 ? 'disabled' : ''; ?> id="select-akses-cabang">

                    <?php if ($aksesCabang > 1): ?>

                        <option value="all"> Semua Cabang</option>
                        <?php foreach (aksesCabang() as $row):  ?>
                            <option
                                value="<?= $row['id_cabang']; ?>"
                                <?= ($aksesCabang == 1 ? 'selected' : (session('selected_akses') == $row['id_cabang'] ? 'selected' : '')); ?>>
                                <?= $row['nama_cabang']; ?>
                            </option>
                        <?php endforeach; ?>

                    <?php else: ?>

                        <?php foreach (aksesCabang() as $row):  ?>
                            <option value="<?= $row['id_cabang']; ?>"><?= $row['nama_cabang']; ?></option>
                        <?php endforeach; ?>

                    <?php endif;  ?>

                </select>
            </div>
        </li>

        <li>
            <a href="<?= base_url('dashboard'); ?>">
                <div class="parent-icon"><i class='bx bx-home-alt'></i></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        <li class="btn btn-primary">
            <a href="<?= base_url('unit/add'); ?>">
                <div class="parent-icon text-light"><i class='bx bx-plus'></i></div>
                <div class="menu-title text-light">Unit Baru</div>
            </a>
        </li>

        <li>
            <a href="<?= base_url('unit'); ?>">
                <div class="parent-icon"><i class='bx bx-customize'></i></div>
                <div class="menu-title">Data Unit</div>
            </a>
        </li>

        <?php if (session('user_type') == 'admin'):  ?>
            <li>
                <a href="<?= base_url('cabang'); ?>">
                    <div class="parent-icon"><i class='bx bx-store'></i></div>
                    <div class="menu-title">Cabang</div>
                </a>
            </li>
        <?php endif;  ?>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-box"></i></div>
                <div class="menu-title">Material</div>
            </a>
            <ul class="mm-collapse">
                <li><a href="<?= base_url('material'); ?>"><i class='bx bx-radio-circle'></i>Data Material</a></li>
                <li><a href="<?= base_url('material-masuk'); ?>"><i class='bx bx-radio-circle'></i>Material Masuk</a></li>
                <li><a href="<?= base_url('material-keluar'); ?>"><i class='bx bx-radio-circle'></i>Material Keluar</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i></div>
                <div class="menu-title">Referensi</div>
            </a>
            <ul class="mm-collapse">
                <?php if (session('user_type') == 'admin'):  ?>
                    <li><a href="<?= base_url('asuransi'); ?>"><i class='bx bx-radio-circle'></i>Asuransi</a></li>
                    <li><a href="<?= base_url('satuan'); ?>"><i class='bx bx-radio-circle'></i>Satuan</a></li>
                    <li><a href="<?= base_url('jenis'); ?>"><i class='bx bx-radio-circle'></i>Jenis</a></li>
                    <li><a href="<?= base_url('biaya'); ?>"><i class='bx bx-radio-circle'></i>Biaya</a></li>
                    <li><a href="<?= base_url('status'); ?>"><i class='bx bx-radio-circle'></i>Status</a></li>
                <?php endif;  ?>
                <li><a href="<?= base_url('mekanik'); ?>"><i class='bx bx-radio-circle'></i>Mekanik</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-file"></i></div>
                <div class="menu-title">Cetak</div>
            </a>
            <ul class="mm-collapse">
                <li><a href="<?= base_url('cetak/epoxy'); ?>"><i class='bx bx-radio-circle'></i>Foto Epoxy</a></li>
                <li><a href="<?= base_url('cetak/gandeng'); ?>"><i class='bx bx-radio-circle'></i>Foto Gandeng</a></li>
                <li><a href="<?= base_url('cetak/pemakaian-bahan'); ?>"><i class='bx bx-radio-circle'></i>Pemakaian Bahan</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-file"></i></div>
                <div class="menu-title">Laporan</div>
            </a>
            <ul class="mm-collapse">
                <li><a href="<?= base_url('laporan/closing-mekanik'); ?>"><i class='bx bx-radio-circle'></i>Closing Mekanik</a></li>
                <li><a href="<?= base_url('laporan/closingan'); ?>"><i class='bx bx-radio-circle'></i>Closingan</a></li>
            </ul>
        </li>

        <?php if (session('user_type') == 'admin'):  ?>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-user-circle"></i></div>
                    <div class="menu-title">Manajemen User</div>
                </a>
                <ul class="mm-collapse">
                    <?php if (session('user_type') == 'admin' && session('role') == 'Super Admin'):  ?>
                        <li><a href="<?= base_url('users'); ?>"><i class='bx bx-radio-circle'></i>Users</a></li>
                        <li><a href="<?= base_url('users/akses'); ?>"><i class='bx bx-radio-circle'></i>Users Akses</a></li>
                    <?php endif;  ?>
                    <li><a href="<?= base_url('admin'); ?>"><i class='bx bx-radio-circle'></i>Admin Cabang</a></li>
                </ul>
            </li>
        <?php endif; ?>
        <!--end navigation-->
</div>
<script>
    $('#select-akses-cabang').on('change', function() {
        var id = $(this).val();
        $.ajax({
            url: '/users/akses/select',
            type: 'POST',
            data: {
                <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                key: id
            },
            success: function(response) {
                alertMesage(response.status, response.message);
                // set data localStorage data diskon dan sharing
                if (response.data.biaya) {
                    localStorage.setItem('diskon', response.data.biaya.diskon);
                    localStorage.setItem('sharing', response.data.biaya.sharing);
                } else {
                    localStorage.removeItem('diskon');
                    localStorage.removeItem('sharing');
                }

                // reload page
                window.location.reload();
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                alertMesage(response.status, response.message);
                window.location.reload()
            }
        })
    })
</script>