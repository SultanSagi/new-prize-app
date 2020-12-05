<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prizes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('lottery_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('prize_type_id');
            $table->unsignedBigInteger('prize_item_id')->nullable();
            $table->unsignedInteger('prize_amount')->nullable();
            $table->boolean('is_rejected')->default(false);
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('converted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prizes');
    }
}
