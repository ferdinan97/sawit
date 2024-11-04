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
        Schema::create('expense_detail', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->integer('total');
            $table->unsignedBigInteger('expense_id');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('expense_id')->references('id')->on('expense');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
