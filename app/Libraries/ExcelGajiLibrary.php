<?php

namespace App\Libraries;

use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception as ReaderException;

class ExcelGajiLibrary
{
    /** @var Spreadsheet|null */
    protected $spreadsheet = null;

    public function sheetdata($data)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Sheet1');

        // judul 
        $sheet->setCellValue('A1', 'Data Gaji Karyawan ' . $data['periode']);
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize('14');

        // header
        $sheet->setCellValue('A4', 'No');
        $sheet->setCellValue('B4', 'Cabang');
        $sheet->setCellValue('C4', 'NIP');
        $sheet->setCellValue('D4', 'Nama Karyawan');

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);

        $col = 'E';
        $row = '4';

        foreach ($data['komponen']['pendapatan'] as $key => $pen) {
            $sheet->setCellValue($col . $row, $key . '|' . $pen);
            $sheet->getColumnDimension($col)->setWidth('15');

            $col++;
        };

        foreach ($data['komponen']['potongan'] as $key => $pen) {
            $sheet->setCellValue($col . $row, $key . '|' . $pen);
            $sheet->getColumnDimension($col)->setWidth('15');

            $col++;
        };
        $sheet->getStyle('4:4')->getFont()->setBold(true);

        $row++;
        $i = 1;
        foreach ($data['karyawan'] as $key => $kar) {
            $col = 'E';
            $sheet->setCellValue('A' . $row, $i++);
            $sheet->setCellValue('B' . $row, $kar['cabang']);
            $sheet->setCellValue('C' . $row, $kar['nip']);
            $sheet->setCellValue('D' . $row, $key . '|' . $kar['nama_lengkap']);

            foreach ($kar['pendapatan'] as $pen) {
                $sheet->setCellValue($col . $row, $pen);
                $sheet->getStyle($col . $row)->getNumberFormat()->setFormatCode('"Rp"#,##0');
                $col++;
            };

            foreach ($kar['potongan'] as $pen) {
                $sheet->setCellValue($col . $row, $pen);
                $sheet->getStyle($col . $row)->getNumberFormat()->setFormatCode('"Rp"#,##0');

                $col++;
            };
            $row++;
        }

        return $spreadsheet;
    }

    public function export(array $data, string $filename = 'export.xlsx', string $writerType = 'Xlsx')
    {
        $spreadsheet = $this->sheetdata($data);
        $writer = IOFactory::createWriter($spreadsheet, $writerType);

        // send correct headers
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (!$ext) {
            $filename .= ($writerType === 'Csv') ? '.csv' : '.xlsx';
        }

        // common headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        if ($writerType === 'Csv') {
            header('Content-Type: text/csv');
        }
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        // ensure script stops after streaming
        exit;
    }

    public function toArrayFromFile(int $id_gaji, string $filePath, int $sheetIndex = 0, $nullValue = null, bool $calculateFormulas = true, bool $formatData = true, bool $returnCellRef = false)
    {
        $this->loadSpreadsheet($filePath);
        $rows = $this->toArray($sheetIndex, $nullValue, $calculateFormulas, $formatData, $returnCellRef);

        // set data header komponen // untuk acuan loop
        $komponen = [];
        foreach ($rows[3] as $key => $value) {

            if ($key < 4) continue;
            $rawData = explode('|', $value);

            $komponen[$rawData[0]] = $rawData[1];
        }

        $data = [];
        foreach ($rows as $key => $value) {
            if ($key < 4) continue;

            $coll = 4;
            foreach ($komponen as $key => $row) {

                // ambil id karyawan
                $id_karyawan = explode('|', $value[3]);

                // menghapus format number excel
                $nilai = str_replace(['Rp', ',', '.', ' '], '', $value[$coll]);

                $data[] = [
                    'gaji_id' => $id_gaji,
                    // 'karyawan' => $id_karyawan[1],
                    'karyawan_id' => $id_karyawan[0],
                    // 'komponen' => $row,
                    'komponen_gaji_id' => $key,
                    'nilai' => $nilai,
                ];

                $coll++;
            }
        }

        // d($rows, $rows[3]);
        // d($komponen);
        // d($data);

        return $data;
    }

    public function loadSpreadsheet(string $filePath): Spreadsheet
    {
        // IOFactory will detect the reader type automatically
        $this->spreadsheet = IOFactory::load($filePath);
        return $this->spreadsheet;
    }


    public function toArray(int $sheetIndex = 0, $nullValue = null, bool $calculateFormulas = true, bool $formatData = true, bool $returnCellRef = false): array
    {
        if (!$this->spreadsheet instanceof Spreadsheet) {
            throw new \RuntimeException('Spreadsheet not loaded. Call loadSpreadsheet() first or use toArrayFromFile().');
        }

        $sheets = $this->spreadsheet->getAllSheets();
        if (!isset($sheets[$sheetIndex])) {
            throw new \OutOfBoundsException('Sheet index not found: ' . $sheetIndex);
        }

        $sheet = $sheets[$sheetIndex];
        return $sheet->toArray($nullValue, $calculateFormulas, $formatData, $returnCellRef);
    }
}
