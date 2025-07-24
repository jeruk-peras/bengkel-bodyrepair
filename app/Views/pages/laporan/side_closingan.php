  <div style="max-width:1000px;margin:auto;">
      <table style="width:100%;border-collapse:collapse;font-family:Arial,sans-serif;">
          <tr>
              <td colspan="4" style="text-align:center;font-weight:bold;font-size:20px;">
                  PT. NUR LISAN SAKTI<br>
                  PERHITUNGAN CLOSNG<br>
                  PERIODE <?= strtoupper(date('F Y')); ?>
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
              <td style="text-align:right;"><?= number_format($spp['total_harga_spp']); ?></td>
          </tr>
          <tr>
              <?php $diskon = ($spp['total_harga_spp'] * $percent_diskon);  ?>
              <td>SPP DISC 15%</td>
              <td style="text-align:right;"><?= number_format($diskon); ?></td>
          </tr>
          <tr>
              <?php $sharing = (($diskon) * $percent_sharing);  ?>
              <td>SHARING</td>
              <td style="text-align:right;"><?= number_format($sharing); ?></td>
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
                  <td style="text-align:right;"><?= number_format($m['total']); ?></td>
              </tr>
          <?php $total += $m['total'];
            endforeach;  ?>
          <tr>
              <td style="font-weight:bold;">JUMLAH PEMAKAIAN BAHAN</td>
              <td style="text-align:right;font-weight:bold;"><?= number_format($total); ?></td>
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
              <td style="text-align:right;"><?= number_format(($total / $sharing) * 1, 2) ?>%</td>
          </tr>
          <tr>
              <td>Cost Perpanel</td>
              <td style="text-align:right;"><?= number_format(($total / $spp['total_panel'])); ?></td>
          </tr>
          <tr>
              <td colspan="4" style="height:20px;"></td>
          </tr>
          <tr>
              <td colspan="4" style="border-top:2px solid #000;border-bottom:2px solid #000;text-align:center;font-weight:bold;">MEKANIK</td>
          </tr>
          <tr>
              <td>UPAH MEKANIK</td>
              <td style="text-align:right;"><?= number_format($spp['total_upah_mekanik']) ?></td>
          </tr>
          <?php $total = 0;
            foreach ($mekanik as $row): ?>
              <tr>
                  <td><?= strtoupper($row['nama_status']); ?></td>
                  <td style="text-align:right;"><?= number_format($row['total_harga_status']) ?></td>
              </tr>
          <?php $total += $row['total_harga_status'];
            endforeach;  ?>

          <tr>
              <td style="font-weight:bold;">TOTAL UPAH MEKANIK</td>
              <td style="text-align:right;font-weight:bold;"><?= number_format($total); ?></td>
          </tr>
      </table>
  </div>