<?php

namespace App\Exports;

use App\Tracker;
use App\Influencer;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class TrackersExport implements FromCollection, WithHeadingRow, WithMapping, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Tracker::all();
    }

    /**
    * @var \App\Tracker $tracker
    */
    public function map($tracker): array
    {
        // Get influencer
        $influencer = Influencer::find($tracker->influencer_id);

        return [
            ucfirst($tracker->name),
            !is_null($influencer) ? ($influencer->name ? $influencer->name : $influencer->username) : '---',
            $tracker->status ? ucfirst($tracker->queued) : "Inactive",
            $tracker->platform ? ucfirst($tracker->platform) : ucfirst($tracker->type),
            Date::dateTimeToExcel($tracker->created_at),
        ];
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

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY
        ];
    }
}
