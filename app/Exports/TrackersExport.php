<?php

namespace App\Exports;

use App\Tracker;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TrackersExport implements FromCollection, WithHeadingRow
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Tracker::all();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Status',
            'Influencer',
            'Meduim',
            'Created At',
        ];
    }
}
