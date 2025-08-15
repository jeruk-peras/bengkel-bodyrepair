<?php foreach ($data as $row):  ?>
    <div class="col">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Pemakaian <?= $row['nama']; ?></p>
                        <h5 class="my-1">Rp<?= number_format($row['total'], 0, '', '.'); ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach;  ?>