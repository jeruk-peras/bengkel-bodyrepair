  <div style="max-width:1000px;margin:auto;">
      <table style="width:100%;border-collapse:collapse;font-family:Arial,sans-serif;">
          <tr>
              <td colspan="4" style="text-align:center;font-weight:bold;font-size:20px;">
                  PT. NUR LISAN SAKTI<br>
                  PERHITUNGAN CLOSNG PERIODE <?= strtoupper($periode); ?>
              </td>
          </tr>
          <tr>
              <td colspan="4" style="height:20px;"></td>
          </tr>
          <tr>
              <td colspan="4" style="border-top:2px solid #000;border-bottom:2px solid #000;text-align:center;font-weight:bold;">PANEL</td>
          </tr>
          <tr>
              <td style="width:40%;">NILAI SPP</td>
              <td style="text-align:right;"> Rp<?= number_format($spp['total_harga_spp'], 0, '', '.'); ?></td>
          </tr>
          <tr>
              <?php $diskon = $spp['total_harga_spp_diskon'];  ?>
              <td>SPP DISC <?= $diskon_percent; ?>%</td>
              <td style="text-align:right;">Rp<?= number_format($diskon, 0, '', '.'); ?></td>
          </tr>
          <tr>
              <?php $sharing = ($diskon * $percent_sharing);  ?>
              <td>SHARING <?= $sharing_percent; ?>%</td>
              <td style="text-align:right;"><span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="(<?= number_format($spp['total_harga_spp'] - $diskon) ?> x <?= $percent_sharing ?>)"> Rp<?= number_format($sharing); ?> </span></td>
          </tr>
          <tr>
              <td colspan="4" style="height:20px;"></td>
          </tr>
          <tr>
              <td colspan="4" style="border-top:2px solid #000;border-bottom:2px solid #000;text-align:center;font-weight:bold;">BAHAN</td>
          </tr>
          <?php $total = 0;
            foreach ($material as $m):  ?>
              <tr>
                  <td>PEMAKAIAN BAHAN <?= strtoupper($m['nama_jenis']); ?></td>
                  <td style="text-align:right;"> Rp<?= number_format($m['total']); ?> </td>
              </tr>
          <?php $total += $m['total'];
            endforeach;  ?>
          <tr>
              <td style="font-weight:bold;">JUMLAH PEMAKAIAN BAHAN</td>
              <td style="text-align:right;font-weight:bold;"> Rp<?= number_format($total); ?> </td>
          </tr>
          <tr>
              <td colspan="4" style="height:20px;"></td>
          </tr>
          <tr>
              <td>Panel</td>
              <td style="text-align:right;"><?= number_format($spp['total_panel'], 2); ?></td>
          </tr>
          <tr>
              <td>% Pemakaian Bahan</td>
              <?php $pemakaian_bahan = ($sharing > 0) ? ($total / $sharing) * 1 : 0; ?>
              <td style="text-align:right;"><?= number_format($pemakaian_bahan ?? 0, 2) ?>%</td>
          </tr>
          <tr>
              <td>Cost Perpanel</td>
              <?php $cost_panel = ($spp['total_panel'] > 0) ? ($total / $spp['total_panel']) : 0; ?>
              <td style="text-align:right;"> Rp<?= number_format($cost_panel); ?></td>
          </tr>
          <tr>
              <td colspan="4" style="height:20px;"></td>
          </tr>
          <tr>
              <td colspan="4" style="border-top:2px solid #000;border-bottom:2px solid #000;text-align:center;font-weight:bold;">MEKANIK</td>
          </tr>
          <tr>
              <td>UPAH MEKANIK</td>
              <td style="text-align:right;"> Rp<?= number_format($spp['total_upah_mekanik']) ?></td>
          </tr>
          <?php $total = 0;
            foreach ($mekanik as $row): ?>
              <tr>
                  <td><?= strtoupper($row['nama_status']); ?></td>
                  <td style="text-align:right;"> Rp<?= number_format($row['total_harga_status']) ?></td>
              </tr>
          <?php $total += $row['total_harga_status'];
            endforeach;  ?>

          <tr>
              <td style="font-weight:bold;">TOTAL UPAH MEKANIK</td>
              <td style="text-align:right;font-weight:bold;"> Rp<?= number_format($total); ?></td>
          </tr>
      </table>
  </div>