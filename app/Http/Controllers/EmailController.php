<?php

namespace App\Http\Controllers;

use App\Mail\MyTestMail;
use App\Models\Invoice;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail($invoiceId)
    {
        $invoiceDetails = Invoice::where('invoiceId', $invoiceId)->first();

        // $pdf = PDF::loadView('testMail', $invoiceDetails);

        Mail::to($invoiceDetails->clientEmail)->send(
            new MyTestMail($invoiceDetails)
        );

        return response()->json([
            'message' => 'Email Sent'
        ]);
        
        // dd('Email sent');
        // $data = [
        //     'title' => 'Welcome to LaravelTuts.com',
        //     'date' => date('m/d/Y'),
        //     'users' => $users
        // ];
        // PDF::loadView();


        // return $pdf->download('testPDF.pdf');
    }


}
