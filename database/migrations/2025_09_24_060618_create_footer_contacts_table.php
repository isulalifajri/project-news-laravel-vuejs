<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('footer_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // address / phone / email / social
            $table->string('label')->nullable(); // GET IN TOUCH / FOLLOW US
            $table->string('value')->nullable(); // isi kontak / url sosial
            $table->string('icon')->nullable(); // nama icon social (twitter, instagram)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footer_contacts');
    }
};
