<!doctype html>
<html lang="id">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <!-- <link rel="icon" href="<?= base_url(); ?>assets/images/favicon-32x32.png" type="image/png" /> -->
    <!-- Bootstrap CSS -->
    <link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <title>Slip Gaji - Sistem Manajemen Bengkel Bodyrepair</title>

    <style>
        @page {
            size: A5 landscape;
            margin: 8mm;
        }

        @media print {

            .page,
            .page-break {
                break-after: page;
            }
        }
    </style>
</head>

<body>

    <?php $i = 1;
    foreach ($gaji['karyawan'] as $row): ?>

        <img src="/assets/images/KOPSURAT.jpg" class="img-fluid" alt="">

        <div class="p-2 row" style="font-size: 12px;">
            <div class="col-12 mb-1">
                <div class="text-start text-uppercase">
                    <table class="w-100">
                        <tr>
                            <td style="width: 20%;">NAMA</td>
                            <td style="width: 41%;"><?= $row['nama_lengkap']; ?></td>

                            <td style="width: 20%;">JABATAN</td>
                            <td style="width: 20%;"><?= $row['jabatan']; ?></td>
                        </tr>

                        <tr>
                            <td>NIP</td>
                            <td><?= $row['nip']; ?></td>

                            <td>STATUS</td>
                            <td><?= $row['status'] ? 'Aktif' : 'Non Aktif'; ?></td>
                        </tr>

                        <tr>
                            <td>DAPARTEMEN</td>
                            <td><?= $row['dapartemen']; ?></td>

                            <td>PEIODE</td>
                            <td><?= $row['periode']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="col-6">
                <table style="width: 80%;">
                    <tr>
                        <th style="width: 60%;">PENDAPATAN</th>
                        <th style="width: 10%;"></th>
                        <th style="width: 40%;"></th>
                    </tr>

                    <?php $total_pendapatan = 0; ?>
                    <?php foreach ($gaji['komponen']['pendapatan'] as $key => $pen): ?>
                        <?php $total_pendapatan += $row['pendapatan'][$key]; ?>
                        <tr>
                            <td><?= $pen; ?></td>
                            <td>RP</td>
                            <td><?= $row['pendapatan'][$key] > 0 ? number_format($row['pendapatan'][$key]) : '-'; ?></td>
                        </tr>
                    <?php endforeach;  ?>
                    <tr>
                        <td class="fw-bolder">TOTAL PENDAPATAN</td>
                        <td class="fw-bolder">RP</td>
                        <td class="fw-bolder"><?= number_format($total_pendapatan); ?></td>
                    </tr>
                </table>
            </div>

            <div class="col-6">
                <div class="d-flex justify-content-end">
                    <table style="width: 80%;">
                        <tr>
                            <th style="width: 60%;">POTONGAN</th>
                            <th style="width: 10%;"></th>
                            <th style="width: 40%;"></th>
                        </tr>

                        <?php $total_potongan = 0; ?>
                        <?php foreach ($gaji['komponen']['potongan'] as $key => $pen):  ?>
                            <?php $total_potongan += $row['potongan'][$key]; ?>
                            <tr>
                                <td><?= $pen; ?></td>
                                <td>RP</td>
                                <td><?= $row['potongan'][$key] > 0 ? number_format($row['potongan'][$key]) : '-'; ?></td>
                            </tr>
                        <?php endforeach;  ?>
                        <tr>
                            <td class="fw-bolder">TOTAL POTONGAN</td>
                            <td class="fw-bolder">RP</td>
                            <td class="fw-bolder"><?= number_format($total_potongan); ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="col-8">
                <table style="width: 100%;">
                    <tr>
                        <th class="h6 fw-bolder">TAKE HOME PAY</th>
                        <th class="h6 fw-bolder">RP</th>
                        <th class="h6 fw-bolder"><?= number_format($total_pendapatan - $total_potongan) ?></th>
                        <th></th>
                        <th></th>

                    </tr>
                </table>
            </div>
        </div>

        <?php if (isset($gaji['karyawan'][$i])):  ?>
            <div class="page-break"></div>
        <?php endif;  ?>
    <?php $i++;
    endforeach; ?>

</body>

<script>
    window.print();
    setTimeout(()=> {
        window.close();
    }, 500);
</script>

</html>