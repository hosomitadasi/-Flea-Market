<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{

    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price');
            $table->string('brand')->nullable();
            $table->text('description');
            $table->string('img_url');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('condition_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
}
