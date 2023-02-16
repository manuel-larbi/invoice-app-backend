<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $fillable = [
        'createdAt',
        'paymentDue',
        'description',
        'paymentTerms',
        'clientName',
        'clientEmail',
        'status',
        'senderStreet',
        'senderCity',
        'senderPostCode',
        'senderCountry',
        'clientStreet',
        'clientCity',
        'clientPostCode',
        'clientCountry',
    ];
}
