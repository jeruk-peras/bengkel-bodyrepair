<?php

namespace App\Libraries;

use App\Models\KaryawanModel;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception as ReaderException;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PHPUnit\Util\Color;

class ExcelKasbonLibrary
{
    /** @var Spreadsheet|null */
    protected $spreadsheet = null;

    public function sheetdata($data)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Sheet1');

        // judul 
        $sheet->setCellValue('A1', 'PT. NUR LISAN SAKTI');
        $sheet->setCellValue('A2', 'Ruko Permata Regency Blok D No. 37, Jln Haji Kelik, RT.006 RW.006, Srengseng');
        $sheet->setCellValue('A3', 'Kembangan, Kota Administrasi, Jakarta Barat, DKI Jakarta 11630');

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize('24');
        $sheet->getStyle('A:L')->getFont()->setName('Apatos Narrow');

        $sheet->setCellValue('A6', 'PENGAJUAN KASBON MEKANIK');
        $sheet->mergeCells('A6:F6');
        $sheet->getStyle('A6')->getFont()->setBold(true)->setSize('18');
        $sheet->getStyle('A6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


        // header
        $sheet->setCellValue('A7', 'No');
        $sheet->setCellValue('B7', 'Cabang');
        $sheet->setCellValue('C7', 'NIP');
        $sheet->setCellValue('D7', 'Nama Karyawan');
        $sheet->setCellValue('E7', 'Jabatan');
        $sheet->setCellValue('F7', 'Pengajuan Kasbon');
        $sheet->setCellValue('G7', 'Alasan');

        $sheet->getColumnDimension('A')->setWidth('5');
        $sheet->getColumnDimension('B')->setWidth('18');
        $sheet->getColumnDimension('C')->setWidth('15');
        $sheet->getColumnDimension('D')->setWidth('35');
        $sheet->getColumnDimension('E')->setWidth('15');
        $sheet->getColumnDimension('F')->setWidth('25');
        $sheet->getColumnDimension('G')->setWidth('30');
        $sheet->getStyle('A7:G7')->getFont()->setBold(true);
        $sheet->getStyle('A7:G7')->getFont()->getColor()->setARGB('#008cff');
        $sheet->getStyle('A7:G7')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('77a6cd');
        $sheet->getStyle('A7:G7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


        $row = '8';
        $i = 1;
        $sum = "=SUM(F8:";
        foreach ($data as $kar) {
            $sheet->setCellValue('A' . $row, $i++);
            $sheet->setCellValue('B' . $row, $kar['nama_cabang']);
            $sheet->setCellValue('C' . $row, $kar['nip']);
            $sheet->setCellValue('D' . $row, $kar['nama_lengkap']);
            $sheet->setCellValue('E' . $row, $kar['jabatan']);


            $row++;
        }

        $sheet->setCellValue('A' . $row, 'TOTAL');
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->mergeCells('A' . $row . ':E' . $row);

        $sum .= 'F' . ($row - 1) . ')';
        $sheet->setCellValue('F' . $row, $sum);
        $sheet->getStyle('F8:' . 'F' . $row)->getNumberFormat()->setFormatCode('"Rp"#,##0');

        $sheet->getStyle('A7:G' . $row)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->getColor()->setARGB('00000');

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

        $modelKaryawan = new KaryawanModel();

        $data = [];
        foreach ($rows as $key => $value) {
            if ($key < 7 || $key == count($rows) - 1) continue; // mulai dari row ke 7 // tidak mengambil data total

            $data[] = [
                'karyawan_id' => $modelKaryawan->select('id_karyawan')->where('nip', $value[2])->first()['id_karyawan'],
                'nama_cabang' => $value[1],
                'nip' => $value[2],
                'nama_lengkap' => $value[3],
                'jabatan' => $value[4],
                'alasan' => $value[6] ?? '-',
                'jumlah' => str_replace(['Rp', ',', '.', ' '], '', $value[5]),
            ];
        }

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
