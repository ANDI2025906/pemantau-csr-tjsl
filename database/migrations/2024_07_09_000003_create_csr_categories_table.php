<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsrCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('csr_categories', function (Blueprint $table) {
            $table->id();
            $table->string('code'); // A, B, C, dst
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('csr_categories');
    }
}
