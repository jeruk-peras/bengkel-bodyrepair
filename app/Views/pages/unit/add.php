<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item" aria-current="page">Unit</li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Unit Baru</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="card radius-10">
        <div class="card-header border-0 bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h5 class="mb-0">Form Unit Baru</h5>
                </div>
                <div class="ms-auto">
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="" method="post" id="form-data">
                <?= csrf_field(); ?>
                <h6 class="mb-1">Informasi Customer</h6>
                <p class="mb-2">Silakan lengkapi data customer bengkel pada form berikut.</p>
                <div class="row g-3 mb-3">
                    <div class="col-sm-6 col-md-6 col-6">
                        <label for="nama_customer" class="form-label required">Nama Customer</label>
                        <input type="text" name="nama_customer" class="form-control" id="nama_customer" placeholder="Nama Customer">
                        <div class="invalid-feedback" id="invalid_nama_customer"></div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-6">
                        <label for="no_handphone" class="form-label required">No Handphone</label>
                        <input type="text" name="no_handphone" class="form-control" id="no_handphone" placeholder="No Handphone">
                        <div class="invalid-feedback" id="invalid_no_handphone"></div>
                    </div>
                    <div class="col-md-12">
                        <label for="alamat" class="form-label required">Alamat</label>
                        <textarea name="alamat" class="form-control" id="alamat"></textarea>
                        <div class="invalid-feedback" id="invalid_alamat"></div>
                    </div>
                </div>

                <h6 class="mb-1">Informasi Unit</h6>
                <p class="mb-2">Silakan lengkapi data Unit bengkel pada form berikut.</p>
                <div class="row g-3 mb-4">
                    <div class="col-sm-6 col-md-3 col-6">
                        <label for="nomor_polisi" class="form-label required">Nomor Polisi</label>
                        <input type="text" name="nomor_polisi" class="form-control" id="nomor_polisi" placeholder="Nomor Polisi">
                        <div class="invalid-feedback" id="invalid_nomor_polisi"></div>
                    </div>
                    <div class="col-sm-6 col-md-3 col-6">
                        <label for="model_unit" class="form-label required">Model Unit</label>
                        <input type="text" name="model_unit" class="form-control" id="model_unit" placeholder="Model Unit">
                        <div class="invalid-feedback" id="invalid_model_unit"></div>
                    </div>
                    <div class="col-sm-6 col-md-3 col-6">
                        <label for="warna_unit" class="form-label required">Warna Unit</label>
                        <input type="text" name="warna_unit" class="form-control" id="warna_unit" placeholder="Warna Unit">
                        <div class="invalid-feedback" id="invalid_warna_unit"></div>
                    </div>

                    <div class="col-sm-6 col-md-3 col-6">
                        <label for="asuransi" class="form-label required">Asuransi</label>
                        <input type="text" name="asuransi" class="form-control" id="asuransi" placeholder="Asuransi">
                        <div class="invalid-feedback" id="invalid_asuransi"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="nomor_mesin" class="form-label required">Nomor Mesin</label>
                        <input type="text" name="nomor_mesin" class="form-control" id="nomor_mesin" placeholder="Nomor Mesin">
                        <div class="invalid-feedback" id="invalid_nomor_mesin"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="nomor_rangka" class="form-label required">Nomor Rangka</label>
                        <input type="text" name="nomor_rangka" class="form-control" id="nomor_rangka" placeholder="Nomor Rangka">
                        <div class="invalid-feedback" id="invalid_nomor_rangka"></div>
                    </div>
                </div>


                <h6 class="mb-1">Informasi Pengerjaan</h6>
                <p class="mb-2">Silakan lengkapi Informasi Pengerjaan Unit bengkel pada form berikut.</p>
                <div class="row g-3 mb-4">
                    <div class="col-12 col-sm-12 col-md-4">
                        <label for="nomor_spp" class="form-label required">Nomor SPP</label>
                        <input type="text" name="nomor_spp" class="form-control" id="nomor_spp" placeholder="No SPP">
                        <div class="invalid-feedback" id="invalid_nomor_spp"></div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4">
                        <label for="tanggal_masuk" class="form-label required">Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" class="form-control" id="tanggal_masuk" placeholder="Tanggal Masuk" value="<?= date('Y-m-d'); ?>" readonly>
                        <div class="invalid-feedback" id="invalid_tanggal_masuk"></div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4">
                        <label for="estimasi_selesai" class="form-label required">Estimasi Selesai</label>
                        <input type="date" name="estimasi_selesai" class="form-control" id="estimasi_selesai" placeholder="Estimasi Selesai">
                        <div class="invalid-feedback" id="invalid_estimasi_selesai"></div>
                    </div>
                    <div class="col-md-12">
                        <label for="detail_pengerjaan" class="form-label required">Detail Pengerjaan</label>
                        <textarea name="detail_pengerjaan" class="form-control" rows="4" id="detail_pengerjaan"></textarea>
                        <div class="invalid-feedback" id="invalid_detail_pengerjaan"></div>
                    </div>
                </div>

                <h6 class="mb-1">Informasi Harga</h6>
                <p class="mb-2">Silakan lengkapi Harga Pengerjaan Unit bengkel pada form berikut.</p>
                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-6">
                        <label for="harga_spp" class="form-label required">Harga SPP</label>
                        <div class="position-relative input-icon">
                            <input type="text" inputmode="numeric" name="harga_spp" class="form-control" id="harga_spp" placeholder="Harga SPP">
                            <span class="position-absolute top-50 translate-middle-y">Rp </span>
                        </div>
                        <div class="invalid-feedback" id="invalid_harga_spp"></div>
                    </div>
                    <div class="col-3 col-md-1">
                        <label for="diskon" class="form-label">Diskon</label>
                        <div class="position-relative input-icon">
                            <input type="text" inputmode="numeric" maxlength="3" name="diskon" class="form-control" value="<?= biayaCabang(session('selected_akses'), 'diskon'); ?>" style="padding-left: 0.75rem; padding-right: 1.90rem;" id="diskon" readonly>
                            <span class="position-absolute top-50 translate-middle-y" style="right: 15px !important; left: unset;">%</span>
                        </div>
                        <div class="invalid-feedback" id="invalid_diskon"></div>
                    </div>
                    <div class="col-9 col-md-5">
                        <label for="jumlah_diskon" class="form-label">Total Harga SPP</label>
                        <div class="position-relative input-icon">
                            <input type="text" inputmode="numeric" name="jumlah_diskon" class="form-control" id="jumlah_diskon" readonly placeholder="Total Harga">
                            <span class="position-absolute top-50 translate-middle-y">Rp </span>
                        </div>
                        <div class="invalid-feedback" id="invalid_jumlah_diskon"></div>
                    </div>
                    <div class="col-9 col-sm-8 col-md-4">
                        <label for="harga_panel" class="form-label">Harga Panel</label>
                        <div class="position-relative input-icon">
                            <input type="text" inputmode="numeric" name="harga_panel" class="form-control" id="harga_panel" value="<?= biayaCabang(session('selected_akses'), 'harga_panel'); ?>" readonly placeholder="Harga Panel">
                            <span class="position-absolute top-50 translate-middle-y">Rp </span>
                        </div>
                    </div>
                    <div class="col-3 col-sm-4 col-md-1">
                        <label for="jumlah_panel" class="form-label">Panel</label>
                        <input type="text" class="form-control" readonly id="jumlah_panel">
                        <input type="hidden" name="jumlah_panel" id="jumlah_panel_act">
                    </div>

                    <div class="col-6 col-sm-6 col-md-3">
                        <label for="upah_mekanik" class="form-label">Upah Mekanik</label>
                        <div class="position-relative input-icon">
                            <input type="text" inputmode="numeric" name="upah_mekanik" class="form-control" id="upah_mekanik" value="<?= biayaCabang(session('selected_akses'), 'upah_mekanik'); ?>" placeholder="Upah Mekanik" readonly>
                            <span class="position-absolute top-50 translate-middle-y">Rp </span>
                        </div>
                    </div>

                    <div class="col-6 col-sm-6 col-md-4">
                        <label for="total_upah_mekanik" class="form-label">Total Upah Mekanik</label>
                        <div class="position-relative input-icon">
                            <input type="text" inputmode="numeric" name="total_upah_mekanik" class="form-control" id="total_upah_mekanik" readonly placeholder="Total Upah Mekanik">
                            <span class="position-absolute top-50 translate-middle-y">Rp </span>
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-12 text-end">
                        <a href="<?= base_url('material-masuk/'); ?>" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary" id="btn-simpan">Simpan Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // hendle save data
    $('#form-data').submit(function(e) {
        e.preventDefault();
        if (typeof tinymce !== 'undefined') {
            tinymce.triggerSave();
        }
        var url, formData;
        url = $(this).attr('action');
        formData = $(this).serializeArray();
        $('#btn-simpan').attr('disabled', true).text('Menyimpan...');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                alertMesage(response.status, response.message);
                window.location.href = response.data.redirect;
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                $('#form-data .form-control').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                $('#btn-simpan').attr('disabled', false).text('Simpan data');
                $.each(response.data, function(key, value) {
                    $('#' + key).addClass('is-invalid');
                    $('#invalid_' + key).text(value).show();
                });
                alertMesage(response.status, response.message);
            }
        })
    })

    // hendle perhitungan 
    function hitungDiskon() {
        var harga = parseInt($('#harga_spp').val());
        var diskon = parseInt($('#diskon').val()) || 0;
        var total = harga - (harga * diskon / 100);
        total = Math.round(total);
        $('#jumlah_diskon').val(harga ? total : '');
    }

    function hitungPanel() {
        var jumlah_diskon = parseInt($('#jumlah_diskon').val());
        var harga_panel = parseInt($('#harga_panel').val());
        var jumlah_panel = 0;
        if (jumlah_diskon && harga_panel && harga_panel > 0) {
            jumlah_panel = jumlah_diskon / harga_panel;
            jumlah_panel_act = jumlah_panel
            jumlah_panel = Math.round(jumlah_panel * 100) / 100;
        }
        $('#jumlah_panel_act').val(jumlah_panel_act);
        $('#jumlah_panel').val(jumlah_panel > 0 ? jumlah_panel.toFixed(2) : '');
    }

    function hitungUpahMekanik() {
        var upah_mekanik = parseInt($('#upah_mekanik').val());
        var jumlah_panel = parseFloat($('#jumlah_panel_act').val());

        var total_upah = 0;
        if (!isNaN(upah_mekanik) && !isNaN(jumlah_panel)) {
            total_upah = upah_mekanik * jumlah_panel;
            total_upah = Math.round(total_upah);
            // total_upah = total_upah;
        }
        $('#total_upah_mekanik').val((total_upah > 0) ? total_upah : '');
    }
    $('#harga_spp, #diskon, #harga_panel, #upah_mekanik').on('keyup change', function() {
        hitungDiskon();
        hitungPanel();
        hitungUpahMekanik();
    });
</script>
<?= $this->endSection(); ?>