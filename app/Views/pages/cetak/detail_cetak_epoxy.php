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
                    <li class="breadcrumb-item active">Cetak Foto Epoxy</li>
                    <li class="breadcrumb-item active" aria-current="page">Add Foto Epoxy</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="card radius-10">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="nomor_polisi" class="form-label required">Nomor Polisi</label>
                    <input type="text" class="form-control" id="nomor_polisi" readonly disabled value="<?= $cetak['nomor_polisi']; ?>" />
                </div>
                <div class="col-md-4">
                    <label for="nama_asuransi" class="form-label required">Nama Asuransi</label>
                    <input type="text" class="form-control" id="nama_asuransi" readonly disabled value="<?= $cetak['nama_asuransi']; ?>" />
                </div>
                <div class="col-md-4">
                    <label for="type_unit" class="form-label required">Type Kendaraan</label>
                    <input type="text" class="form-control" id="type_unit" readonly disabled value="<?= $cetak['model_unit']; ?>" />
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-8 col-sm-8 col-md-6 col-lg-12 text-end">
            <a href="<?= base_url('cetak/epoxy'); ?>" class="btn btn-sm btn-primary"><i class="bx bx-left-arrow-alt"></i> Kembali</a>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#form-data-modal"><i class="bx bx-plus"></i> Tambah Gambar</button>
            <button class="btn btn-sm btn-primary" id="btn-print"><i class="bx bx-printer"></i> Print</button>
        </div>
    </div>

    <div id="print-data" class="m-3">
        <style>
            .table-header {
                border-collapse: collapse;
                width: 100%;
                margin-bottom: 20px;
            }

            .table-header td {
                border: 1px solid #000;
                padding: 1px;
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

                .photo-grid div {
                    height: 250px;
                }
            }

            h2 {
                text-align: center;
                margin-bottom: 10px;
            }
        </style>

        <h2 class="fw-bolder text-black">FOTO EPOXY</h2>

        <table class="table-header">
            <tr>
                <td class="text-black" style="width: 50%;">&nbsp;Nomor SPP</td>
                <td class="text-black" style="width: 50%;">&nbsp;<?= $cetak['nomor_spp']; ?></td>
            </tr>

            <tr>
                <td class="text-black">&nbsp;Nomor POLISI</td>
                <td class="text-black">&nbsp;<?= $cetak['nomor_polisi']; ?></td>
            </tr>
            <tr>
                <td class="text-black">&nbsp;NAMA ASURANSI</td>
                <td class="text-black">&nbsp;<?= $cetak['nama_asuransi']; ?></td>
            </tr>
            <tr>
                <td class="text-black">&nbsp;TYPE KENDARAAN</td>
                <td class="text-black">&nbsp;<?= $cetak['model_unit']; ?></td>
            </tr>
            <tr>
                <td class="text-black">&nbsp;GROUP</td>
                <td></td>
            </tr>
        </table>

        <div class="photo-grid" id="photo-grid"></div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="form-data-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" id="form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="id_cetak" id="id_cetak" value="<?= $cetak['id_cetak']; ?>">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="nama_material" class="form-label required">Upload Foto</label>
                            <input type="file" id="imageInput" name="nama_material" class="form-control" />
                        </div>

                        <div class="row g-3 justify-content-center">
                            <div class="col-md-9">
                                <img id="image" style="max-width: 100%;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="cropButton">Crop dan Simpan Data</button>
                </div>
            </form>
        </div>
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

        let cropper;

        // set cropper saat input file berubah
        $('#imageInput').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const url = URL.createObjectURL(file);
                $('#image').attr('src', url);

                if (cropper) {
                    cropper.destroy();
                }

                cropper = new Cropper(document.getElementById('image'), {
                    aspectRatio: 6 / 4,
                    viewMode: 1,
                    dragMode: 'none',
                    zoomable: true,
                    scalable: true,
                    rotatable: false,
                    cropBoxResizable: false,
                    cropBoxMovable: true
                });
            }
        });

        // tombol crop dan upload
        $('#cropButton').on('click', function() {
            if (!cropper) return;

            const canvas = cropper.getCroppedCanvas({
                width: 300,
                height: 300,
            });

            canvas.toBlob(function(blob) {
                const formData = new FormData();
                formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
                formData.append('gambar', blob, 'cropped-image.png');
                formData.append('id_cetak', $('#id_cetak').val());

                $.ajax({
                    url: '<?= base_url('cetak/uploadfoto'); ?>',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alertMesage(response.status, response.message);
                        loadFotoEpoxy();
                        $('#form-data-modal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        var response = JSON.parse(xhr.responseText);
                        alertMesage(response.status, response.message);
                    }
                });
            });
        });

        // delete foto epoxy
        $(document).on('click', '.photo-item', function() {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus data ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/api/' + id + '/cetak-foto/delete',
                        method: 'POST',
                        success: function(response) {
                            alertMesage(response.status, response.message);
                            loadFotoEpoxy();
                        },
                        error: function(xhr, status, error) {
                            var response = JSON.parse(xhr.responseText);
                            alertMesage(response.status, response.message);
                        }
                    });
                }
            });
        });

        // load data foto epoxy
        loadFotoEpoxy();

        function loadFotoEpoxy() {
            const id = $('#id_cetak').val();
            $.ajax({
                url: '/api/' + id + '/cetak-foto',
                method: 'GET',
                success: function(response) {
                    if (response.status) {
                        const url = response.data.url;
                        const foto = response.data.foto;
                        const photoGrid = $('#photo-grid');
                        photoGrid.empty();

                        $.each(foto, function(index, photo) {
                            // Cek apakah index = 5,6,7,8 (karena index dimulai dari 0)
                            let extraMargin = (index === 6 || index === 7 || index === 14 || index === 15 || index === 22 || index === 23) ? 'margin-top: 20px;' : '';
                            photoGrid.append(`
                                 <div class="photo-item" data-id="${photo.id_cetak_gambar}" style="${extraMargin}">
                                    <img src="${url + photo.gambar}" style="width: 100%; height: 100%; object-fit: cover;" />
                                </div>
                            `);
                        });
                    } else {
                        alertMesage(response.status, response.message);
                    }
                },
                error: function(xhr, status, error) {
                    var response = JSON.parse(xhr.responseText);
                    alertMesage(response.status, response.message);
                }
            });
        }

    });
</script>
<?= $this->endSection(); ?>