<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicePurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_purchase', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_type_id');
            $table->unsignedBigInteger('to_airport_group_id');
            $table->unsignedBigInteger('to_return_group_id');
            $table->unsignedBigInteger('airport_id');
            $table->unsignedBigInteger('payment_type_id');
            $table->date('init_date_park')->nullable();
            $table->date('end_date_park')->nullable();
            $table->integer('to_airport_passengers')->nullable();
            $table->integer('to_airport_bags')->nullable();
            $table->integer('to_airport_pets')->nullable();
            $table->string('to_airport_flight_number')->nullable();
            $table->boolean('to_airport_is_private')->nullable();
            $table->boolean('to_airport_is_shared')->nullable();
            $table->time('departure_time')->nullable();
            $table->date('departure_date')->nullable();
            $table->integer('to_airport_stops')->nullable();
            $table->integer('to_return_passengers')->nullable();
            $table->integer('to_return_bags')->nullable();
            $table->integer('to_return_pets')->nullable();
            $table->string('to_return_flight_number')->nullable();
            $table->boolean('to_return_is_private')->nullable();
            $table->boolean('to_return_is_shared')->nullable();
            $table->time('to_return_time')->nullable();
            $table->date('to_return_date')->nullable();
            $table->integer('to_return_stops')->nullable();
            $table->boolean('pickup_base_borden');
            $table->boolean('return_base_borden');
            $table->string('name');
            $table->string('email');
            $table->string('phone_number');
            $table->string('destination');
            $table->string('pickup_postal_code');
            $table->string('pickup_street');
            $table->string('pickup_unit');
            $table->string('dropoff_postal_code');
            $table->string('dropoff_street');
            $table->string('dropoff_unit');
            $table->string('purchase_status')->default('pending');
            $table->float('total', 10, 2);	
            $table->timestamps();
            $table->softDeletes();
            //relations
            $table->foreign('service_type_id')->references('id')->on('service_types')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('to_airport_group_id')->references('id')->on('groups')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('to_return_group_id')->references('id')->on('groups')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('airport_id')->references('id')->on('airports')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('payment_type_id')->references('id')->on('payment_type')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_purchase');
    }
}
