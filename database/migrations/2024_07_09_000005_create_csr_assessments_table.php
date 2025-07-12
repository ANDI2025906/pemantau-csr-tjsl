<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsrAssessmentsTable extends Migration
{
    public function up()
    {
    Schema::create('csr_assessments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('company_id')->constrained('company_profiles');
        $table->foreignId('indicator_id')->constrained('csr_indicators');
        $table->integer('score')->default(0); // 0-3
        $table->text('notes')->nullable();
        $table->json('uploaded_documents')->nullable();
        $table->string('status')->default('draft'); // draft, submitted, reviewed
        $table->foreignId('reviewed_by')->nullable()->constrained('users');
        $table->timestamp('reviewed_at')->nullable();
        $table->timestamps();

        // Prevent duplicate assessments for same company and indicator
        $table->unique(['company_id', 'indicator_id']);
    });
    }


    public function down()
    {
        Schema::dropIfExists('csr_assessments');
    }
}
