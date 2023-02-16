<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('createdAt');
            $table->dateTime('paymentDue');
            $table->string('description');
            $table->integer('paymentTerms');
            $table->string('clientName');
            $table->string('clientEmail');
            $table->string('status');
            $table->string('senderStreet');
            $table->string('senderCity');
            $table->string('senderPostCode');
            $table->string('senderCountry');
            $table->string('clientStreet');
            $table->string('clientCity');
            $table->string('clientPostCode');
            $table->string('clientCountry');
            // $table->json('items');
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
