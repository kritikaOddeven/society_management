<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UtilityBill;
use App\Models\Apartment;
use App\Models\BillType;

class UtilityBillController extends Controller
{
    public function index()
    {
        $utilityBills = UtilityBill::with([
            'apartment.tower',
            'apartment.floor',
            'billType',
        ])->latest()->get();

        return view('bills.utility.index', compact('utilityBills'));
    }

    public function create()
    {
        $apartments = Apartment::orderBy('apartment_number')->get();
        $billTypes = BillType::where('type_category', 'utility_bill')
            ->where('status', 'active')
            ->orderBy('bill_type')
            ->get();

        return view('bills.utility.create', compact('apartments', 'billTypes'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('bill_image')) {
            $file = $request->file('bill_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('utility_bills');

            if (! is_dir($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $data['bill_image'] = 'utility_bills/' . $filename;
        }

        UtilityBill::create($data);

        return redirect()
            ->route('bills.utility.index')
            ->with('success', 'Utility bill created successfully.');
    }

    public function edit(UtilityBill $utility)
    {
        $apartments = Apartment::orderBy('apartment_number')->get();
        $billTypes = BillType::where('type_category', 'utility_bill')
            ->where('status', 'active')
            ->orderBy('bill_type')
            ->get();

        return view('bills.utility.edit', compact('utility', 'apartments', 'billTypes'));
    }

    public function update(Request $request, UtilityBill $utility)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('bill_image')) {
            if ($utility->bill_image && file_exists(public_path($utility->bill_image))) {
                @unlink(public_path($utility->bill_image));
            }

            $file = $request->file('bill_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('utility_bills');

            if (! is_dir($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $data['bill_image'] = 'utility_bills/' . $filename;
        } else {
            $data['bill_image'] = $utility->bill_image;
        }

        $utility->update($data);

        return redirect()
            ->route('bills.utility.index')
            ->with('success', 'Utility bill updated successfully.');
    }

    public function show(UtilityBill $utility)
    {
        $utility->load([
            'apartment.tower',
            'apartment.floor',
            'billType',
        ]);

        return view('bills.utility.show', compact('utility'));
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'apartment_id' => ['required', 'exists:apartments,id'],
            'bill_type' => ['required', 'exists:bill_types,id'],
            'bill_amount' => ['required', 'numeric', 'min:0'],
            'payment_mode' => ['required', 'string', 'max:50'],
            'bill_date' => ['required', 'date'],
            'bill_due_date' => ['required', 'date', 'after_or_equal:bill_date'],
            'bill_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'status' => ['required', 'in:Unpaid,Paid'],
        ]);
    }
}
