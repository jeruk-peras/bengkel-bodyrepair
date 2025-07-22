<table class="table align-middle text-center mb-0">
    <thead>
        <tr>
            <th>#</th>
            <?php foreach ($status as $row):  ?>
                <th><?= $row['nama_status']; ?></th>
            <?php endforeach;  ?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>JML Panel</th>
            <?php foreach ($status as $row):  ?>
                <th><?= round($total_panel[$row['nama_status']], 2); ?></th>
            <?php endforeach;  ?>
        </tr>
        <tr>
            <th>JML Upah</th>
           <?php foreach ($status as $row):  ?>
                <th><?= number_format($total_upah[$row['nama_status']]); ?></th>
            <?php endforeach;  ?>
        </tr>
    </tbody>
</table>