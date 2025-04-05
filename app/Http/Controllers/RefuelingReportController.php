<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RefuelingRecord;

class RefuelingReportController extends Controller
{
    public function generateMonthlyReport(Request $request)
    {
        // Validate the month parameter (for example, "2025-03")
        $validated = $request->validate([
            'month' => 'required|date_format:Y-m',
        ]);

        // Get the start and end of the month
        $startDate = Carbon::createFromFormat('Y-m', $validated['month'])->startOfMonth();
        $endDate   = Carbon::createFromFormat('Y-m', $validated['month'])->endOfMonth();

        // Get the refueling records for the specified month
        $refuelingRecords = DB::table('refueling_records')
            ->whereBetween('refueled_at', [$startDate, $endDate])
            ->get();

        // Initialize an array to store the fuel type data
        $fuelData = [];

        // Loop through each refueling record
        foreach ($refuelingRecords as $record) {
            // Fetch the fuel type name from the fuel_types table based on the fuel_type code
            $fuelType = DB::table('fuel_types')
                ->where('code', $record->fuel_type)
                ->first();

            // If fuel type not found, skip this record
            if (! $fuelType) {
                continue;
            }

            // Group by fuel type
            if (! isset($fuelData[$record->fuel_type])) {
                $fuelData[$record->fuel_type] = [
                    'fuel_type'      => $fuelType->name, // Fuel type name
                    'total_sales'    => 0,
                    'total_discount' => 0,
                    'total_liters'   => 0,
                ];
            }

            // Add the sales, discount, and liters to the fuel type totals
            $fuelData[$record->fuel_type]['total_sales'] += $record->total_price;
            $fuelData[$record->fuel_type]['total_discount'] += $record->total_discount;
            $fuelData[$record->fuel_type]['total_liters'] += $record->liters;
        }

        // Initialize Dompdf for PDF generation
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        // Prepare HTML for the report
        $html = view('reports.monthly_report', [
            'month'     => $validated['month'],
            'fuelData'  => $fuelData,
            'startDate' => $startDate->format('F j, Y'),
            'endDate'   => $endDate->format('F j, Y'),
        ])->render();

        // Load the HTML into Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Set paper size if needed
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF (first pass)
        $dompdf->render();

        // Stream the file to the browser for download
        return $dompdf->stream("monthly_report_{$validated['month']}.pdf");
    }


}
