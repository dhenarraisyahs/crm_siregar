<?php

namespace App\Exports;

use App\Models\Infrastructure;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WarrantyExport implements FromQuery, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Infrastructure::all();
    // }
    public function query()
    {
        return Infrastructure
            ::query()
            ->where('warranty', '<', date("Y-m-d", strtotime(now())));
    }

    public function map($infra_data): array
    {
        return [
            $infra_data->brand,
            $infra_data->function,
            $infra_data->serialnum,
            $infra_data->warranty,
            $infra_data->condition,
            "Expired"
        ];
    }

    public function headings(): array
    {
        return [
            'Merek & Tipe',
            'Fungsi',
            'Serial Number',
            'Masa Aktif Warranty',
            'Kondisi',
            'Status',
        ];
    }
}
