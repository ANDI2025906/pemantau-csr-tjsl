<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsrIndicatorsTable extends Migration
{
    public function up()
    {
        Schema::create('csr_indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('csr_categories')->onDelete('cascade');
            $table->string('indicator');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('csr_indicators');
    }
}
