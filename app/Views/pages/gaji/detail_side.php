    <table class="table align-middle mb-0" style="width: 100%;">
        <thead class="table-light">
            <tr class="text-uppercase align-middle">
                <th rowspan="2">No</th>
                <th rowspan="2">#</th>
                <th rowspan="2">Cabang</th>
                <th rowspan="2">NIP</th>
                <th rowspan="2">Nama Lengkap</th>
                <th rowspan="2">TOTAL</th>
                <th class="text-center" colspan="<?= count($komponen['pendapatan']) + 1; ?>">PENDAPATAN</th>
                <th class="text-center border-start" colspan="<?= count($komponen['potongan'])  + 1; ?>">potongan</th>
            </tr>
            <tr>
                <?php foreach ($komponen['pendapatan'] as $k): ?>
                    <th><?= $k; ?></th>
                <?php endforeach; ?>
                <th>TOTAL</th>
                <?php foreach ($komponen['potongan'] as $k): ?>
                    <th><?= $k; ?></th>
                <?php endforeach; ?>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = '1';
            foreach ($karyawan as $k):
                $totalpen = 0;
                $totalpot = 0; ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><a href="/gaji-karyawan/<?= $id_gaji ?>/<?= $k['id_karyawan']; ?>/printgaji" target="_blank" class="me-2 btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Print Data"><i class="bx bx-printer me-0"></i></a></td>
                    <td><?= $k['cabang']; ?></td>
                    <td><?= $k['nip']; ?></td>
                    <td><?= $k['nama_lengkap']; ?><br><small><?= $k['jabatan']; ?></small></td>
                    <td class="text-end fw-bold">Rp<?= number_format($k['total_gaji']); ?></td>
                    <?php foreach ($k['pendapatan'] as $pen): ?>
                        <td class="text-end"><?= $pen > 0 ? "Rp" . number_format($pen) : '-'; ?></td>
                    <?php $totalpen += $pen;
                    endforeach; ?>
                    <td class="text-end fw-bold">Rp<?= number_format($totalpen); ?></td>
                    <?php foreach ($k['potongan'] as $pot): ?>
                        <td class="text-end"><?= $pot > 0 ? "Rp" . number_format($pot) : '-'; ?></td>
                    <?php $totalpot += $pot;
                    endforeach; ?>
                    <td class="text-end fw-bold">Rp<?= number_format($totalpot); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>