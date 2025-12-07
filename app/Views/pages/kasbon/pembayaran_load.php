<table class="table align-middle mb-0" style="width: 100%;">
    <thead class="table-light">
        <tr>
            <th>No</th>
            <th>Cabang</th>
            <th>NIP</th>
            <th>Karyawan</th>
            <th>Jabatan</th>
            <th>Pembayaran</th>
            <th>Komponen Gaji</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1;
        foreach ($data as $row): ?>
            <tr>
                <input type="hidden" name="id_karyawan[]" value="<?= $row['id_karyawan']; ?>">
                <input type="hidden" name="jumlah[]" value="<?= $row['nilai']; ?>">
                <td><?= $i++; ?></td>
                <td><?= $row['nama_cabang']; ?></td>
                <td><?= $row['nip']; ?></td>
                <td><?= $row['nama_lengkap']; ?></td>
                <td><?= $row['jabatan']; ?></td>
                <td>Rp<?= number_format(str_replace('-', '', $row['nilai'])); ?></td>
                <td><?= $row['nama_komponen_gaji']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>