<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('description');
            $table->string('email')->nullable();
            $table->float('hours')->nullable();;
            $table->float('rate')->nullable();
            $table->float('price')->nullable();
            $table->boolean('paid')->nullable();
            $table->softDeletes();
            $table->JSON('itemized')->nullable();

            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
