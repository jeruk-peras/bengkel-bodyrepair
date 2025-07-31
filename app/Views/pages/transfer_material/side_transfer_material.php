<table class="table align-middle mb-0" id="datatable" style="width: 100%;">
    <thead class="table-light">
        <tr>
            <th>No</th>
            <th>Jenis</th>
            <th>Nama Material</th>
            <th>Merek</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Satuan</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1; foreach ($material as $row):  ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= $row['nama_jenis']; ?></td>
                <td><?= $row['nama_material']; ?></td>
                <td><?= $row['merek']; ?></td>
                <td>Rp <?= number_format($row['harga']); ?></td>
                <td>0</td>
                <td><?= $row['nama_satuan']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>