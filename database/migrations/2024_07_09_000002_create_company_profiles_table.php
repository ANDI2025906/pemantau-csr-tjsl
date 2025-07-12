<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category'); // BUMN, BUMD, SWASTA
            $table->string('business_type');
            
            // Menggunakan unsignedBigInteger terlebih dahulu
            $table->unsignedBigInteger('province_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('operational_province_id');
            $table->unsignedBigInteger('operational_city_id');
            
            $table->integer('employee_count');
            $table->integer('established_year');
            $table->string('contact_name');
            $table->string('contact_position');
            $table->string('contact_phone');
            $table->string('contact_email');
            $table->timestamps();

            // Menambahkan foreign key constraints setelah kolom dibuat
            $table->foreign('province_id')
                  ->references('id')
                  ->on('provinces')
                  ->onDelete('cascade');

            $table->foreign('city_id')
                  ->references('id')
                  ->on('cities')
                  ->onDelete('cascade');

            $table->foreign('operational_province_id')
                  ->references('id')
                  ->on('provinces')
                  ->onDelete('cascade');

            $table->foreign('operational_city_id')
                  ->references('id')
                  ->on('cities')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        // Menghapus foreign key constraints terlebih dahulu
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->dropForeign(['province_id']);
            $table->dropForeign(['city_id']);
            $table->dropForeign(['operational_province_id']);
            $table->dropForeign(['operational_city_id']);
        });

        Schema::dropIfExists('company_profiles');
    }
}
