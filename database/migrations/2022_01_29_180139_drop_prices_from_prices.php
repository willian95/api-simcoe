<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropPricesFromPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->float('shared_price', 4, 2)->nullable();	
            $table->float('private_price', 4, 2)->nullable();	
            $table->float('unique_price', 4, 2)->nullable();	
            $table->float('base_borden_price', 4, 2)->nullable();	
            $table->float('extra_passnger_fee', 4, 2)->nullable();	
            $table->float('extra_family_price', 4, 2)->nullable();	
            $table->float('parking_day_price', 4, 2);	
            $table->float('price_per_stop', 4, 2);	
        });
    }
}
