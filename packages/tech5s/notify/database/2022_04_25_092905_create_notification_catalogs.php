<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationCatalogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_catalogs', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name');
            $table->integer('notification_type_id');
            $table->tinyInteger('act')->nullable();
            $table->string('icon')->nullable();
            $table->text('img')->nullable();
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
        Schema::dropIfExists('notification_catalogs');
    }
}
