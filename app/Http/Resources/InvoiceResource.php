<?php

namespace App\Http\Resources;

use App\Models\Invoice;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->invoiceId,
            'createdAt' => date('Y-m-d',strtotime($this->created_at)),
            'paymentDue' => $this->paymentDue,
            'description' => $this->description,
            'paymentTerms' => $this->paymentTerms,
            'clientName' => $this->clientName,
            'clientEmail' => $this->clientEmail,
            'status' => $this->status,
            'senderStreet' => $this->senderStreet,
            'senderCity' => $this->senderCity,
            'senderPostCode' => $this->senderPostCode,
            'senderCountry' => $this->senderCountry,
            'clientStreet' => $this->clientStreet,
            'clientCity' => $this->clientCity,
            'clientPostCode' => $this->clientPostCode,
            'clientCountry' => $this->clientCountry,
            'items' => $this->items,
            'total' => $this->total
        ];
    }
}
