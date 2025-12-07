<table class="table align-middle mb-0" id="datatable" style="width: 100%;">
    <thead class="table-light">
        <tr>
            <th>No</th>
            <?php if ($hide_karyawan): ?>
                <th>Cabang</th>
                <th>Karyawan</th>
            <?php endif;  ?>
            <th>Tanggal</th>
            <th>Jenis</th>
            <th>Jumlah</th>
            <th>Disetujui</th>
            <th>Status</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1;
        foreach ($pengajuan as $row): ?>
            <tr>
                <td><?= $i++; ?></td>
                <?php if ($hide_karyawan): ?>
                    <td><?= $row['nama_cabang']; ?></td>
                    <td><?= $row['nama_lengkap']; ?></td>
                <?php endif;  ?>
                <td><?= $row['tanggal']; ?></td>
                <td><?= strtoupper($row['jenis']); ?></td>
                <td>Rp<?= number_format(str_replace('-', '', $row['jumlah'])); ?></td>
                <td>Rp<?= number_format(str_replace('-', '', $row['disetujui'])); ?></td>
                <?php
                $status = strtolower($row['status']);
                $badgeClass = 'bg-secondary';
                if ($status === 'pengajuan') {
                    $badgeClass = 'bg-warning';
                } elseif ($status === 'tolak') {
                    $badgeClass = 'bg-danger';
                } elseif ($status === 'terima') {
                    $badgeClass = 'bg-success';
                }
                ?>
                <td><span class="badge <?= $badgeClass ?> px-3"><?= strtoupper($row['status']); ?></span></td>
                <td><?= $row['alasan']; ?></td>
            </tr>
        <?php endforeach;  ?>
    </tbody>
</table>