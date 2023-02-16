<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\Response;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Invoice::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $idGen = Str::random(2).mt_rand(1000,9999);

        $invoice = Invoice::create([
            'invoiceId' => $request->old('invoiceId',strtoupper($idGen)),
            'createdAt' => $request->createdAt,
            'paymentDue' => $request->paymentDue,
            'description' => $request->description,
            'paymentTerms' => $request->paymentTerms,
            'clientName' => $request->clientName,
            'clientEmail' => $request->clientEmail,
            'senderStreet' => $request->senderStreet,
            'senderCity' => $request->senderCity,
            'senderPostCode' => $request->senderPostCode,
            'senderCountry' => $request->senderCountry,
            'clientStreet' => $request->clientStreet,
            'clientCity' => $request->clientCity,
            'clientPostCode' => $request->clientPostCode,
            'clientCountry' => $request->clientCountry,
            'item' => $request->item
        ]);

        // $item = Item::create([
        //     'invoice_id' => $request->old('invoice_id', mt_rand(1, count(Invoice::all()))),
        //     'name' => $request->name,
        //     'quantity' => $request->quantity,
        //     'price' => $request->price,
        //     'total' => $request->old('total', floatval($request->quantity * $request->price))
        // ]);


        // foreach ($request->item as $item) {
        //     Item::create([
        //         'invoice_id' => $item->old('invoice_id', mt_rand(1, count(Invoice::all()))),
        //         'name' => $item->name,
        //         'quantity' => $item->quantity,
        //         'price' => $item->price,
        //         'total' => $item->old('total', floatval($item->quantity * $item->price))
        //     ]);
        // }


        // foreach($invoice->item as $item){
        //     $item = Item::create([
        //         'name' => $item->name,
        //         'quantity' => $item->quantity,
        //         'price' => $item->price,
        //         'total' => $item->total
        //     ]);

        //     dd($item);
        // }
        // foreach($invoice->items as $item) {
        //     dd($item);
        //     // $invoice->items()->create([
        //     //     'name' => $item->name,
        //     //     'quantity' => $item->quantity,
        //     //     'price' => $item->price,
        //     //     'total' => $item->total
        //     // ]);
        // }

        return response()->json([
            'invoiceId' => $invoice->invoiceId,
            'items' => $invoice->item
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return response()->json([
            $invoice,
            $invoice->item
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  Invoice $invoice)
    {
        $invoice->update($request->all());

        return response()->json($invoice);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        return $invoice->delete();
    }

}
