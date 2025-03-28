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
        $table->decimal('total_discount', 10, 2)->default(0)->after('total_price');
    });
}

public function down()
{
    Schema::table('refueling_records', function (Blueprint $table) {
        $table->dropColumn('total_discount');
    });
}

};
