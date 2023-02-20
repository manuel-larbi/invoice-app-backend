<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
return new class extends Migration
{
    /**
     * Run the migrations.in
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoiceId')->nullable();
            $table->date('paymentDue')->nullable();
            $table->string('description')->nullable();
            $table->integer('paymentTerms')->nullable();
            $table->string('clientName')->nullable();
            $table->string('clientEmail')->nullable();
            $table->string('status')->default('pending');
            $table->string('senderStreet')->nullable();
            $table->string('senderCity')->nullable();
            $table->string('senderPostCode')->nullable();
            $table->string('senderCountry')->nullable();
            $table->string('clientStreet')->nullable();
            $table->string('clientCity')->nullable();
            $table->string('clientPostCode')->nullable();
            $table->string('clientCountry')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
