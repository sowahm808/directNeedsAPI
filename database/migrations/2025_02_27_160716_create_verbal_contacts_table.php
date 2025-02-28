<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('verbal_contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('processor_id');
            $table->boolean('contact_successful')->default(false);
            $table->text('contact_notes')->nullable();
            $table->timestamps();
    
            $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade');
            $table->foreign('processor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verbal_contacts');
    }
};
