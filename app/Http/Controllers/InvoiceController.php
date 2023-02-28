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
        $invoice = Invoice::query();

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
        $idGen = Str::random(2);
        while (ctype_alpha($idGen)) {
            $string = Str::random(2)  . mt_rand(1000, 9999);
        }

        $request->merge([
            'invoiceId' => $request->old('invoiceId', strtoupper($string)),
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
        $idGen = Str::random(2) . mt_rand(1000, 9999);
        $request->merge([
            'invoiceId' => $request->old('invoiceId', strtoupper($idGen)),
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
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $invoiceId)
    {
        // dd($invoiceId);
        $request->merge([
            'status' => $request->old('status', 'pending'),
            'invoiceId' => $request->old('invoiceId',$invoiceId),
        ]);

        Invoice::where('invoiceId', $invoiceId)->update(
            $request->except(['items', 'invoiceId',])
        );

        $invoice = Invoice::where('invoiceId', $invoiceId)->first();

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


}
