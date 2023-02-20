<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Http\Requests\SaveAsDraftRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Support\Js;
use PHPUnit\Framework\MockObject\Invocation;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

use function GuzzleHttp\Promise\all;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $invoice = Invoice::query();

        // filter invoices by status
        if($request->has('status') && $request->status != ""){
            $status = json_decode($request->status);

            foreach ($status as $stat) {
                $invoice->where('status', $stat);
            }
        }

        return InvoiceResource::collection($invoice->paginate(2));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceRequest $request)
    {
        // Generate a random ID, add items and save invoice data

        $idGen = Str::random(2).mt_rand(1000,9999);
        $request->merge([
            'invoiceId' => $request->old('invoiceId',strtoupper($idGen)),
        ]);
        $invoice = Invoice::create($request->except('items'));;
        // Add items to invoice
        foreach($request->items as $item){
            $item['total'] = $item['quantity'] * $item['price'];
            $invoice->items()->create($item);
        }

        return new InvoiceResource($invoice);
    }


    public function saveAsDraft(Request $request)
    {
        // Generate a random ID, add items and save invoice data
        $idGen = Str::random(2).mt_rand(1000,9999);
        $request->merge([
            'invoiceId' => $request->old('invoiceId',strtoupper($idGen)),
            'status' => $request->old('status', 'draft')
        ]);
        $invoice = Invoice::create($request->except('items'));

        foreach($request->items as $item){
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
    public function update(Request $request,  Invoice $invoice)
    {
        $invoice->update($request->all());

        return new InvoiceResource($invoice);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        return $invoice->delete();
    }

    public function status(Request $request, $id)
    {
       return Invoice::find($id)->update([ 'status' => $request->old('status', 'paid') ]);
    }

}
