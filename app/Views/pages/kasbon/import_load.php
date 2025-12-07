<table class="table align-middle mb-0" style="width: 100%;">
    <thead class="table-light">
        <tr>
            <th>No</th>
            <th>Cabang</th>
            <th>NIP</th>
            <th>Karyawan</th>
            <th>Jabatan</th>
            <th>Pengajuan Kasbon</th>
            <th>Alasan</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1;
        foreach ($pengajuan as $row): ?>
            <input type="hidden" name="karyawan_id[]" value="<?= $row['karyawan_id']; ?>">
            <input type="hidden" name="jumlah[]" value="<?= $row['jumlah']; ?>">
            <input type="hidden" name="alasan[]" value="<?= $row['alasan']; ?>">
            <tr>
                <td><?= $i++; ?></td>
                <td><?= $row['nama_cabang']; ?></td>
                <td><?= $row['nip']; ?></td>
                <td><?= $row['nama_lengkap']; ?></td>
                <td><?= $row['jabatan']; ?></td>
                <td>Rp<?= number_format(str_replace('-', '', $row['jumlah'])); ?></td>
                <td><?= $row['alasan']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>