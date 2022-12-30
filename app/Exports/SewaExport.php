<?php

namespace App\Exports;

use App\Models\Sewa;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SewaExport implements FromCollection, WithHeadings
{
    use Exportable;
    private $min;
    private $max;

    public function __construct($min,$max)
    {
        $this->min = $min;
        $this->max = $max;
    }
    public function headings(): array
    {
        return [
            'Kode',
            'No. Kendaraan',
            'Unit',
            'NIK',
            'nama',
            'No. HP',
            'Tanggal Sewa',
            'Tanggal Kembali',
            'Lama Sewa',
            'Denda',
            'Harga',
            'Sub_total',
            'pdf_url',
        ];
    }
    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection()
    {
        $date['min'] = $this->min ?? null;
        $date['max'] = $this->max ?? null;
        return Sewa::query()
        ->with(['waktusewa','pengguna','user'])
        ->join('waktu_sewas','sewas.id', '=', 'waktu_sewas.sewa_id')
        ->join('penggunas','sewas.nik', '=', 'penggunas.nik')
        ->select('kode', 'nopol as NoKendaraan', 'unit','sewas.nik', 'nama', 'no_hp','tgl_sewa','tgl_kembali', 'lama_sewa', 'denda','harga','total as sub_total', 'pdf_url')
        ->where('status', '=', 'Selesai')
        ->dateFilter($date)
        ->get();
    }
}
