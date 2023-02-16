<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MarkAsPaidController extends Controller
{

    public function update(Request $request, $id)
    {
        $markAsPaid = Invoice::find($id)->update([ 'status' => $request->old('status', 'paid') ]);

        return response()->json([
            'status' => $markAsPaid
        ]);
    }
}
