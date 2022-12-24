<?php

namespace App\Exports;

use App\Models\Sewa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class SewaExport implements FromCollection
{
    use Exportable;
    private $min;
    private $max;

    public function __construct($min,$max)
    {
        $this->min = $min;
        $this->max = $max;
    }
    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection()
    {
        $date['min'] = $this->min ?? null;
        $date['max'] = $this->max ?? null;
        return Sewa::query()->with(['waktusewa','pengguna','user'])->where('status', '=', 'Selesai')
        ->dateFilter($date)->get();
    }
}
