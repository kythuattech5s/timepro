<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_types', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name')->nullable();
            $table->datetime('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->datetime('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_types');
    }
}
