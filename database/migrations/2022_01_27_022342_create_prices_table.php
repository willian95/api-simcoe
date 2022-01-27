<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('airport_id');
            $table->unsignedBigInteger('service_id')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->float('shared_price', 4, 2)->nullable();	
            $table->float('private_price', 4, 2)->nullable();	
            $table->float('unique_price', 4, 2)->nullable();	
            $table->float('base_borden_price', 4, 2)->nullable();	
            $table->float('extra_passnger_fee', 4, 2)->nullable();	
            $table->float('extra_family_price', 4, 2)->nullable();	
            $table->float('parking_day_price', 4, 2);	
            $table->float('price_per_stop', 4, 2);	
            $table->timestamps();
            $table->softDeletes();
            //relations
            $table->foreign('airport_id')->references('id')->on('airports')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
}
