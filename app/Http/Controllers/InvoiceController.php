<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $invoice = Invoice::query()->latest();

        // filter invoices by status
        if ($request->has('status') && $request->status != '') {
            $status = json_decode($request->status);

            foreach ($status as $stat) {
                $invoice->where('status', $stat);
            }
        }

        return InvoiceResource::collection($invoice->paginate(7));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceRequest $request)
    {
        // Generate a random ID, add items and save invoice data

        $request->merge([
            'invoiceId' => $request->old('invoiceId', strtoupper($this->idGenerate())),
            'status' => $request->old('status', 'pending'),
        ]);
        $invoice = Invoice::create($request->except('items'));
        // Add items to invoice
        foreach ($request->items as $item) {
            $item['total'] = $item['quantity'] * $item['price'];
            $invoice->items()->create($item);
        }

        return new InvoiceResource($invoice);
    }

    public function saveAsDraft(Request $request)
    {
        // Generate a random ID, add items and save invoice data

        $request->merge([
            'invoiceId' => $request->old('invoiceId', strtoupper($this->idGenerate())),
            'status' => $request->old('status', 'draft'),
        ]);
        $invoice = Invoice::create($request->except('items'));

        foreach ($request->items as $item) {
            $item['total'] = $item['quantity'] * $item['price'];
            $invoice->items()->create($item);
        }

        return new InvoiceResource($invoice);
    }

    /**
     * Display the specified resource.
     */
    public function show($invoiceId)
    {
        $invoiceDetails = Invoice::where('invoiceId',$invoiceId)->first();
        return new InvoiceResource($invoiceDetails);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $invoiceId)
    {
        $request->merge([
            'status' => $request->old('status', 'pending'),
            'invoiceId' => $request->old('invoiceId',$invoiceId),
        ]);

        Invoice::where('invoiceId', $invoiceId)->update(
            $request->except(['items', 'invoiceId',])
        );

        $invoice = Invoice::firstWhere('invoiceId', $invoiceId);

        $invoice->items()->delete();

        try {
            foreach ($request->items as $item) {
                $item['total'] = round(($item['quantity'] * $item['price']), 2);
                $invoice->items()->create($item);
            }
            return new InvoiceResource($invoice);
        } catch (\Throwable $th) {
            return response()->json([
                    new InvoiceResource($invoice)
            ],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($invoiceId)
    {
        return Invoice::where('invoiceId', $invoiceId)
            ->first()
            ->delete();
    }

    public function status(Request $request, $invoiceId)
    {
        return Invoice::where('invoiceId', $invoiceId)
            ->first()
            ->update(['status' => $request->old('status', 'paid')]);
    }

    public function idGenerate(){
        $length = 2;
        $result = '';
        // Generate a random string of alphabets
        for ($i = 0; $i < $length; $i++) {
            $code = rand(65, 90) > rand(0, 1) ? rand(65, 90) : rand(97, 122);
            $result .= chr($code);
        }
        return $result.mt_rand(1000, 9999);
    }
}
