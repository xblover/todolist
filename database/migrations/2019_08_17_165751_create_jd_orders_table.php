<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJdOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jd_orders', function (Blueprint $table) {
            $table->bigInteger('order_id');
            $table->dateTime('updated_at');
            $table->text('full_json');
            $table->dateTime('fetched_at')->nullable();
            $table->dateTime('fetch_confirmed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jd_orders');
    }
}
