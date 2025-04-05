<?php
namespace App\Http\Controllers;

use App\Models\CreditLedger;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    public function storeDebit(Request $request)
    {
        // Validate the input
        $request->validate([
            'number_plate' => 'required|string',
            'debit_amount' => 'required|numeric|min:0',
        ]);

        // Get the vehicle associated with the given number plate
        $vehicle = Vehicle::where('number_plate', $request->number_plate)->first();

        // If the vehicle is not found, return an error
        if (! $vehicle) {
            return redirect()->route('credit-list')->with('error', 'Vehicle not found');
        }

        // Create the debit record in the CreditLedger table
        CreditLedger::create([
            'number_plate'     => $request->number_plate,
            'owner_phone'      => $vehicle->owner_phone, // Add the owner_phone here
            'amount'           => $request->debit_amount,
            'transaction_type' => 'debit',
        ]);

        // Redirect back with success message
        return redirect()->route('credit-list')->with('success', 'Debit recorded successfully');
    }

    public function showCreditList(Request $request)
    {
        // Get the vehicles that have credit or debit transactions in the credit_ledgers table
        $vehicles = Vehicle::whereIn('number_plate', function ($query) {
            $query->select('number_plate')
                ->from('credit_ledgers')
                ->whereIn('transaction_type', ['credit', 'debit']);
        })
            ->when($request->search, function ($query) use ($request) {
                $query->where('number_plate', 'like', '%' . $request->search . '%')
                    ->orWhere('owner_name', 'like', '%' . $request->search . '%');
            })
            ->paginate(10); // Paginate results

        // Calculate the remaining balance for each vehicle
        foreach ($vehicles as $vehicle) {
            // Fetch sum of credit for the vehicle
            $totalCredit = CreditLedger::where('number_plate', $vehicle->number_plate)
                ->where('transaction_type', 'credit')
                ->sum('amount');

            // Fetch sum of debit for the vehicle
            $totalDebit = CreditLedger::where('number_plate', $vehicle->number_plate)
                ->where('transaction_type', 'debit')
                ->sum('amount');

            // Calculate the remaining balance (credit - debit)
            $vehicle->remaining_balance = $totalCredit - $totalDebit;
        }

        return view('credits.credit-management', compact('vehicles'));
    }
}
