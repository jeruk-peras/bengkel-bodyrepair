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

        <?php if (session('role') != 'Finance'):  ?>
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
        <?php endif;  ?>


        <li>
            <a href="<?= base_url('closing'); ?>">
                <div class="parent-icon"><i class='bx bx-cabinet'></i></div>
                <div class="menu-title">Data Closing</div>
            </a>
        </li>
        <?php if (session('role') != 'Finance'):  ?>
            <li>
                <a href="<?= base_url('inventory/assets'); ?>">
                    <div class="parent-icon"><i class='bx bx-cube'></i></div>
                    <div class="menu-title">Data Inventory</div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-box"></i></div>
                    <div class="menu-title">Material</div>
                </a>
                <ul class="mm-collapse">
                    <li><a href="<?= base_url('material'); ?>"><i class='bx bx-radio-circle'></i>Data Material</a></li>
                    <li><a href="<?= base_url('material-masuk'); ?>"><i class='bx bx-radio-circle'></i>Material Masuk</a></li>
                    <li><a href="<?= base_url('material-keluar'); ?>"><i class='bx bx-radio-circle'></i>Material Keluar</a></li>
                    <li><a href="<?= base_url('material-mixing'); ?>"><i class='bx bx-radio-circle'></i>Mixing</a></li>
                </ul>
            </li>
        <?php endif;  ?>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i></div>
                <div class="menu-title">Referensi</div>
            </a>
            <ul class="mm-collapse">
                <?php if (session('user_type') == 'admin' && session('role') != 'Finance'):  ?>
                    <li><a href="<?= base_url('inventory'); ?>"><i class='bx bx-radio-circle'></i>Inventory</a></li>
                    <li><a href="<?= base_url('asuransi'); ?>"><i class='bx bx-radio-circle'></i>Asuransi</a></li>
                    <li><a href="<?= base_url('satuan'); ?>"><i class='bx bx-radio-circle'></i>Satuan</a></li>
                    <li><a href="<?= base_url('jenis'); ?>"><i class='bx bx-radio-circle'></i>Jenis</a></li>
                    <li><a href="<?= base_url('biaya'); ?>"><i class='bx bx-radio-circle'></i>Biaya</a></li>
                    <li><a href="<?= base_url('status'); ?>"><i class='bx bx-radio-circle'></i>Status</a></li>
                    <li><a href="<?= base_url('komponen-gaji'); ?>"><i class='bx bx-radio-circle'></i>Komponen Gaji</a></li>
                    <li><a href="<?= base_url('transfer/meterial'); ?>"><i class='bx bx-radio-circle'></i>Transfer Material</a></li>
                <?php endif; ?>
                <?php if (session('user_type') == 'admin' && session('role') == 'Finance'):  ?>
                    <li><a href="<?= base_url('biaya'); ?>"><i class='bx bx-radio-circle'></i>Biaya</a></li>
                    <li><a href="<?= base_url('status'); ?>"><i class='bx bx-radio-circle'></i>Status</a></li>
                    <li><a href="<?= base_url('komponen-gaji'); ?>"><i class='bx bx-radio-circle'></i>Komponen Gaji</a></li>
                <?php endif; ?>
                <?php if (session('role') == 'Super Admin' || session('user_type') == 'admin_cabang'):  ?>
                    <li><a href="<?= base_url('mekanik'); ?>"><i class='bx bx-radio-circle'></i>Mekanik</a></li>
                <?php endif; ?>
            </ul>
        </li>

        <li>
            <a href="<?= base_url('karyawan'); ?>">
                <div class="parent-icon"><i class='bx bx-briefcase-alt-2'></i></div>
                <div class="menu-title">Data Karyawan</div>
            </a>
        </li>
        <?php if (session('role') == 'Finance' || session('user_type') == 'admin'):  ?>
            <li>
                <a href="<?= base_url('gaji-karyawan'); ?>">
                    <div class="parent-icon"><i class='bx bx-food-menu'></i></div>
                    <div class="menu-title">Gaji Karyawan</div>
                </a>
            </li>
            <li>
                <a href="<?= base_url('persetujuan-kasbon'); ?>">
                    <div class="parent-icon"><i class='bx bx-check-double'></i></div>
                    <div class="menu-title">Persetujuan Kasbon</div>
                </a>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="left: 90%!important;">
                    <?= countPengajuan(); ?><span class="visually-hidden">unread messages</span>
                </span>
            </li>
        <?php endif; ?>
        <li>
            <a href="<?= base_url('kasbon'); ?>">
                <div class="parent-icon"><i class='bx bx-notepad'></i></div>
                <div class="menu-title">Kasbon Karyawan</div>
            </a>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-file"></i></div>
                <div class="menu-title">Cetak</div>
            </a>
            <ul class="mm-collapse">
                <?php if (session('role') == 'Finance' || session('role') == 'Super Admin'):  ?>
                    <li><a href="<?= base_url('gaji-karyawan/slip-gaji'); ?>"><i class='bx bx-radio-circle'></i>Slip Gaji</a></li>
                <?php endif; ?>

                <?php if (session('role') != 'Finance'):  ?>
                    <li><a href="<?= base_url('cetak/epoxy'); ?>"><i class='bx bx-radio-circle'></i>Foto Epoxy</a></li>
                    <li><a href="<?= base_url('cetak/gandeng'); ?>"><i class='bx bx-radio-circle'></i>Foto Gandeng</a></li>
                    <li><a href="<?= base_url('cetak/pemakaian-bahan'); ?>"><i class='bx bx-radio-circle'></i>Pemakaian Bahan</a></li>
                <?php endif; ?>
            </ul>
        </li>

        <?php if (session('user_type') == 'admin' && session('role') != 'Finance'):  ?>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-user-circle"></i></div>
                    <div class="menu-title">Manajemen User</div>
                </a>
                <ul class="mm-collapse">
                    <li><a href="<?= base_url('users'); ?>"><i class='bx bx-radio-circle'></i>Users</a></li>
                    <li><a href="<?= base_url('users/akses'); ?>"><i class='bx bx-radio-circle'></i>Users Akses</a></li>
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