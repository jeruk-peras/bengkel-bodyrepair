 <table class="table table-hover align-middle mb-0" id="material-table" style="width: 100%;">
     <thead class="table-light">
         <tr>
             <th>No</th>
             <?= is_array(session('selected_akses')) ? "<th>Cabang</th>" : "" ?>
             <th>Nomor SPP</th>
             <th>Nomor Polisi</th>
             <th>Model/Warna</th>
             <th>Jenis</th>
             <th>Material</th>
             <th>Harga</th>
             <th>Satuan</th>
             <th>Jumlah</th>
             <th>Total</th>
             <th>Mekanik</th>
             <th>Tanggal</th>
            </tr>
        </thead>
     <tbody>
        <?php $i=1; foreach($data as $row): ?>
            <tr class="row-material" data-id="<?= $row['id_unit_material']; ?>">
                <td><?= $i++; ?></td>
                <?= is_array(session('selected_akses')) ? "<td>{$row['nama_cabang']}</td>" : "" ?>
                <td><?= $row['nomor_spp']; ?></td>
                <td><?= $row['nomor_polisi']; ?></td>
                <td><?= $row['model_unit']; ?>/<?= $row['warna_unit']; ?></td>
                <td><?= $row['nama_jenis']; ?></td>
                <td><?= $row['nama_material']; ?></td>
                <td>Rp<?= number_format($row['harga'], 0, '', '.'); ?></td>
                <td><?= $row['nama_satuan']; ?></td>
                <td><?= $row['jumlah']; ?></td>
                <td>Rp<?= number_format($row['total_harga'], 0, '', '.'); ?></td>
                <td><?= $row['nama_mekanik']; ?></td>
                <td><?= $row['tanggal']; ?></td>
            </tr>
            <?php endforeach;  ?>
     </tbody>
 </table>