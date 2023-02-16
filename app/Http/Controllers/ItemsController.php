<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'items' => Item::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $item = Item::create([
            'invoice_id' => $request->old('invoice_id', mt_rand(1, count(Invoice::all()))),
            'name' => $request->name,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'total' => $request->old('total', floatval($request->quantity * $request->price))
        ]);
        
        return $item;
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
    }
}
