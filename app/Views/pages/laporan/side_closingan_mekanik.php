<table style="width:100%;border-collapse:collapse;font-family:Arial,sans-serif;">
    <tr>
        <td colspan="4" style="text-align:center;font-weight:bold;font-size:20px;">
            PT. NUR LISAN SAKTI<br>
            PERHITUNGAN CLOSING MEKANIK PERIODE <?= strtoupper($periode); ?><br>
        </td>
    </tr>
</table>

<table class="table align-middle mb-0" id="datatable" style="width: 100%;">
    <thead class="table-light">
        <tr>
            <th class="align-middle" rowspan="3">No</th>
            <th class="align-middle" rowspan="3">No SPP</th>
            <th class="align-middle" rowspan="3">No Polisi</th>
            <th class="align-middle" rowspan="3">Model/Warna</th>
            <th class="align-middle" rowspan="3">Total Harga</th>
            <th class="align-middle" rowspan="3">Upah Mekanik</th>
            <th class="align-middle" rowspan="3">Panel</th>
            <th class="text-center" colspan="<?= count($status) ?>">STATUS</th>
        </tr>
        <!-- status -->
        <tr>
            <?php foreach ($status as $row):  ?>
                <th class="text-center" data-pp="<?= $harga_status_total[$row['nama_status']]; ?>"><?= $row['nama_status']; ?></th>
            <?php endforeach;  ?>
        </tr>
    </thead>
    <tbody>
        <?php $total_panel = 0; $jumlah_diskon = 0; ?>
        <?php foreach ($units as $row):  ?>
            <tr>
                <td><?= $row['no']; ?></td>
                <td><span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?= $row['cabang_id']; ?>"><?= $row['nomor_spp']; ?></span></td>
                <td><?= $row['nomor_polisi']; ?></td>
                <td><?= $row['model_unit'] . '/' . $row['warna_unit']; ?></td>
                <td><span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="(<?= $row['diskon']; ?>/100 x <?= number_format($row['harga_spp']); ?>) - <?= number_format($row['harga_spp']); ?>">Rp<?= number_format($row['jumlah_diskon']); ?></span></td>
                <td><span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?= $row['upah_mekanik']; ?> * jml panel">Rp<?= number_format($row['total_upah_mekanik']); ?></span></td>
                <td class="text-center"><span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?= $row['jumlah_panel']; ?>"><?= round($row['jumlah_panel'], 2) ?></span></td>
                <?php foreach ($row['status'] as $s):  ?>
                    <td class="text-end"><span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?= $s['harga_status'] ?> * jml panel">Rp<?= number_format($s['total_harga_status']); ?></span></td>
                <?php endforeach  ?>
            </tr>
            <?php $total_panel += $row['jumlah_panel']; $jumlah_diskon += $row['jumlah_diskon']; ?>
        <?php endforeach; ?>
        <tr>
            <th class="text-end" colspan="4">TOTAL</th>
            <th class="text-center">Rp<?= number_format($jumlah_diskon) ?></th>
            <th class="text-center"></th>
            <th class="text-center"><?= number_format($total_panel, 2) ?></th>
            <?php foreach ($status as $r):  ?>
                <th class="text-end">Rp<?= number_format($harga_status_total[$r['nama_status']]); ?></th>
            <?php endforeach;  ?>
        </tr>
    </tbody>
</table>