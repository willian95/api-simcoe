<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPricesToPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->double('shared_price', 10, 2)->nullable();	
            $table->double('private_price', 10, 2)->nullable();	
            $table->double('unique_price', 10, 2)->nullable();	
            $table->double('base_borden_price', 10, 2)->nullable();	
            $table->double('extra_passnger_fee', 10, 2)->nullable();	
            $table->double('extra_family_price', 10, 2)->nullable();	
            $table->double('parking_day_price', 10, 2);	
            $table->double('price_per_stop', 10, 2);	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->dropColumn('shared_price');	
            $table->dropColumn('private_price');	
            $table->dropColumn('unique_price');	
            $table->dropColumn('base_borden_price');	
            $table->dropColumn('extra_passnger_fee');	
            $table->dropColumn('extra_family_price');	
            $table->dropColumn('parking_day_price');	
            $table->dropColumn('price_per_stop');	
        });
    }
}
