<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $append = [
        'total'
    ];

    protected $fillable = [
        'invoiceId',
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

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function getTotalAttribute() {
        return $this->items->sum('total');
    }
}
