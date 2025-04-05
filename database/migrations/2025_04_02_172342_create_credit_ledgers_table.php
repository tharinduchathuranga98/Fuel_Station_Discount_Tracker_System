<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('credit_ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('number_plate');                        // Vehicle number plate
            $table->string('owner_phone');                         // Vehicle owner's phone number
            $table->decimal('amount', 10, 2);                      // Credit amount (refueling total price)
            $table->enum('transaction_type', ['credit', 'debit']); // Credit or Debit type
            $table->timestamps();
        });
    }

};
