<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->references('id')->on('invoices')->cascadeOnDelete();
            $table->string('invoice_number',50);
            $table->string('section',50);
            $table->string('product',50);
            $table->string('status',50);
            $table->integer('status_value');
            $table->date('payment_date')->nullable();
            $table->text('note')->nullable();
            $table->string('user',50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_details');
    }
};
