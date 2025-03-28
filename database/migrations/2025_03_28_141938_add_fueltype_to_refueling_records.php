<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('refueling_records', function (Blueprint $table) {
            $table->string('fuel_type')->nullable()->after('number_plate');
        });
    }

    public function down()
    {
        Schema::table('refueling_records', function (Blueprint $table) {
            $table->dropColumn(['fuel_type']);
        });
    }
};
