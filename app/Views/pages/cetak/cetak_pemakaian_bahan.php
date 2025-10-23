<?= $this->extend('layout/index'); ?>
<?= $this->section('content'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active">Cetak</li>
                    <li class="breadcrumb-item active">Pemakaian Bahan</li>
                    <li class="breadcrumb-item active" aria-current="page">Cetak Pemakaian Material</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="row mb-3">
        <div class="col-8 col-sm-8 col-md-6 col-lg-12 text-end">
            <a class="btn btn-sm btn-primary" onclick="window.history.back(-1);"><i class="bx bx-left-arrow-alt"></i> Kembali</a>
            <button class="btn btn-sm btn-primary" id="btn-print"><i class="bx bx-printer"></i> Print</button>
        </div>
    </div>

    <input type="hidden" value="<?= $data['id_unit']; ?>" id="id_unit">

    <div id="print-data" class="m-3">
        <style>
            .table-header {
                border-collapse: collapse;
                width: 100%;
                margin-bottom: 20px;
            }

            .table-header td {
                border: 1px solid #000;
                padding: 3px;
                color: #000;
            }

            .table-header th {
                border: 1px solid #000;
                padding: 1px;
                color: #000 !important;
                text-align: center;
                font-weight: bold !important;
            }

            .photo-grid {
                width: 100%;
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                grid-gap: 10px;
            }

            .photo-grid div {
                border: 2px solid #000;
                height: 350px;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
            }

            @media print {

                @page {
                    size: A4;
                    orientation: portrait;
                    margin: 2cm;
                    /* Atau margin yang berbeda untuk setiap sisi */
                }

              
            }

            h2 {
                text-align: center;
                margin-bottom: 10px;
            }

            .kop-surat {
                text-align: center;
                /* border-bottom: 2px solid #000; */
                padding-bottom: 10px;
                /* margin-bottom: 20px; */
            }

            .kop-surat h2 {
                margin-top: 0;
                margin-bottom: 0;
            }

            .kop-surat img {
                max-height: 70px;
                /* margin-bottom: 10px; */
            }
        </style>

        <div class="kop-surat">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center;">
                    <img src="<?= base_url('assets/images/logo-icon.png') ?>" alt="Logo Perusahaan" style="max-height:90px; margin-right:20px;">
                </div>
                <div style="display: flex; align-items: center;">
                    <div>
                        <h2 class="text-black text-end" style="margin:0; font-size: 48px; font-weight: 700; text-align: left;">PT. NUR LISAN SAKTI</h2>
                        <p style="width: 500px; margin: 0; text-align: end;">Jalan Daan Mogot Km. 10, Komp. Departemen Agama No.36-37, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11710</p>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="fw-bold text-black">PEMAKAIAN BAHAN</h2>

        <table class="table-header">
            <tr>
                <td class="text-black" style="width: 20%;">&nbsp;Nomor SPP</td>
                <td class="text-black" style="width: 30%;">&nbsp;<?= $data['nomor_spp']; ?></td>
                <td class="text-black" style="width: 20%;">&nbsp;Type Unit</td>
                <td class="text-black" style="width: 30%;">&nbsp;<?= $data['model_unit']; ?></td>
            </tr>

            <tr>
                <td class="text-black">&nbsp;Nomor POLISI</td>
                <td class="text-black">&nbsp;<?= $data['nomor_polisi']; ?></td>
                <td class="text-black">&nbsp;Warna Unit</td>
                <td class="text-black">&nbsp;<?= $data['warna_unit']; ?></td>
            </tr>
            <tr>
                <td class="text-black">&nbsp;Nilai Panel</td>
                <td class="text-black">&nbsp;<?= $data['harga_panel']; ?></td>
                <td class="text-black">&nbsp;Panel</td>
                <td class="text-black">&nbsp;<?= $data['jumlah_panel']; ?></td>
            </tr>
        </table>

        <table class="table-header" id="data-pemakaian-material"></table>

        <table style="text-align: center; width: 100%;">
            <thead>
                <tr>
                    <th style="width: 30% !important;">Admin Cabang</th>
                    <th>Group Head</th>
                    <th>Mixing</th>
                </tr>
        </table>

    </div>
</div>

<script src="<?= base_url('/assets/js/jquery.PrintArea.js'); ?>"></script>
<script>
    $(document).ready(function() {
        $('#btn-print').click(function() {
            // Disable tombol
            $('#btn-print').prop('disabled', true).html('<i class="bx bx-printer"></i> Printing...');

            // Jalankan PrintArea
            $('#print-data').printArea();

            // Re-enable tombol setelah delay (estimasi proses print)
            setTimeout(function() {
                $('#btn-print').prop('disabled', false).html('<i class="bx bx-printer"></i> Print');
            }, 2000); // 2 detik, bisa disesuaikan
        });
    });


    fetchDataPemakaianMaterial();

    function fetchDataPemakaianMaterial() {
        const id = $('#id_unit').val();
        $.ajax({
            url: '/cetak/' + id + '/pemakaian-bahan-detail',
            method: 'GET',
            success: function(response) {
                $('#data-pemakaian-material').html(response.data.html);
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                alertMesage(response.status, response.message);
            }
        });
    }
</script>
<?= $this->endSection(); ?>