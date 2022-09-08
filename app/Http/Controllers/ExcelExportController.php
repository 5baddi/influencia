<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Exports\TrackersExport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelExportController extends Controller
{
    /**
     * Export trackers to Excel
     *
     * @param \App\Brand $brand
     */
    public function trackers(Brand $brand)
    {
        return Excel::download(new TrackersExport(), $brand->name . "_trackers.xlsx");
    }
}
