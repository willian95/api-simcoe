<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_shared_and_private');
            $table->boolean('has_groups');
            $table->string('icon');
            $table->string('depot_address')->nullable();
            $table->text('description');
            $table->string('advice')->nullable();
            $table->string('second_advice')->nullable();
            $table->boolean('apply_sold_out')->default(false);
            $table->boolean('is_sold_out')->default(false);
            $table->string('purchase_advice')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
