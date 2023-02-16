<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
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
        $invoice = Invoice::create($request->all());

        return response()->json([
            "data" => $invoice
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return $invoice;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  Invoice $invoice)
    {
        $invoice->update($request->all());

        return response()->json([ $invoice ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        return $invoice->delete();
    }
}
