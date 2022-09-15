<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTech5sCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(config('tech5sCart.database.table_item'), function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->integer('id')->autoIncrement();
            $table->integer('tech5s_cart_id');
            $table->string('row_id');
            $table->integer('map_id');
            $table->string('name');
            $table->decimal('price',16,4);
            $table->decimal('weight',16,4);
            $table->longText('options');
            $table->integer('qty');
            $table->decimal('taxRate',16,4);
            $table->string('associatedModel');
            $table->decimal('discountRate',16,4);
            $table->foreign('tech5s_cart_id')
                ->references('id')
                ->on(config('tech5sCart.database.table'))
                ->onDelete('cascade');

            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop(config('tech5sCart.database.table_item'));
    }
}
