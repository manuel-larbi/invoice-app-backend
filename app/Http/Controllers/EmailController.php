<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Support\Facades\Mail;
use PDF;
class EmailController extends Controller
{
    public function sendEmail($invoiceId)
    {
        $invoiceDetails = Invoice::where('invoiceId', $invoiceId)->first();

        $data['id'] = $invoiceDetails->invoiceId;
        $data['email'] = $invoiceDetails->clientEmail;
        $data['description'] = $invoiceDetails->description;
        $data['name'] = $invoiceDetails->clientName;
        $data['status'] = $invoiceDetails->status;
        $data['clientStreet'] = $invoiceDetails->clientStreet;
        $data['clientCity'] = $invoiceDetails->clientCity;
        $data['clientCountry'] = $invoiceDetails->clientCountry;
        $data['clientPostCode'] = $invoiceDetails->clientPostCode;
        $data['items'] = $invoiceDetails->items;
        $data['total'] = number_format(($invoiceDetails->total),2,'.','');
        // dd($data['items']);
        $pdf = PDF::loadView('testPDF', $data);

        if ($invoiceDetails->status == 'paid') {
            Mail::send('testMail', $data, function ($message) use (
                $data,
                $pdf
            ) {
                $message
                    ->to($data['email'], $data['email'])
                    ->subject($data['description'])
                    ->attachData($pdf->output(), 'invoice.pdf');
            });

            return response()->json([
                'status' => true,
                'message' => 'Email Sent',
            ]);
        }

        return response()->json(
            [
                'status' => false,
                'message' => 'Invoice not marked as paid',
            ],
            422
        );
    }
}
