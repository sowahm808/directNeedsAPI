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
    Schema::create('first_contacts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
        $table->foreignId('processor_id')->constrained('users')->onDelete('cascade');
        $table->dateTime('contact_date');
        $table->enum('contact_method', ['call', 'meeting']);
        $table->enum('status', ['scheduled', 'completed'])->default('scheduled');
        $table->enum('decision_outcome', ['approved', 'denied', 'rmi'])->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('first_contacts');
    }
};
