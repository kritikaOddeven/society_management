<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommonAreaBill;
use App\Models\BillType;

class CommonAreaBillController extends Controller
{
    public function index()
    {
        $commonBills = CommonAreaBill::with('billType')->latest()->get();

        return view('bills.common_area.index', compact('commonBills'));
    }

    public function create()
    {
        $billTypes = $this->getCommonBillTypes();

        return view('bills.common_area.create', compact('billTypes'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('bill_image')) {
            $file = $request->file('bill_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('common_area_bills');

            if (! is_dir($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $data['bill_image'] = 'common_area_bills/' . $filename;
        }

        CommonAreaBill::create($data);

        return redirect()
            ->route('bills.common_area.index')
            ->with('success', 'Common area bill created successfully.');
    }

    public function show(CommonAreaBill $common_area)
    {
        $common_area->load('billType');

        return view('bills.common_area.show', ['bill' => $common_area]);
    }

    public function edit(CommonAreaBill $common_area)
    {
        $billTypes = $this->getCommonBillTypes();

        return view('bills.common_area.edit', [
            'bill' => $common_area,
            'billTypes' => $billTypes,
        ]);
    }

    public function update(Request $request, CommonAreaBill $common_area)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('bill_image')) {
            if ($common_area->bill_image && file_exists(public_path($common_area->bill_image))) {
                @unlink(public_path($common_area->bill_image));
            }

            $file = $request->file('bill_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('common_area_bills');

            if (! is_dir($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $data['bill_image'] = 'common_area_bills/' . $filename;
        } else {
            $data['bill_image'] = $common_area->bill_image;
        }

        $common_area->update($data);

        return redirect()
            ->route('bills.common_area.index')
            ->with('success', 'Common area bill updated successfully.');
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'bill_type_id' => ['required', 'exists:bill_types,id'],
            'bill_amount' => ['required', 'numeric', 'min:0'],
            'payment_mode' => ['required', 'string', 'max:50'],
            'bill_date' => ['required', 'date'],
            'bill_due_date' => ['required', 'date', 'after_or_equal:bill_date'],
            'bill_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'status' => ['required', 'in:Unpaid,Paid'],
        ]);
    }

    protected function getCommonBillTypes()
    {
        return BillType::where('type_category', 'common_bill')
            ->where('status', 'active')
            ->orderBy('bill_type')
            ->get();
    }
}
