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
        Schema::create('inventory_history', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('inventory_id')->unsigned();
            $table->foreign('inventory_id')->references('id')->on('inventory');
            $table->enum("type", ["initial", "add", "remove"]);
            $table->integer('amount')->unsigned()->default(0);
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_history');
    }
};
