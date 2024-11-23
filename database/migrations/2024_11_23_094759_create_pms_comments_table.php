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
        Schema::create('pms_comments', function (Blueprint $table) {
            $table->id();
            $table->integer('task_id');  // Foreign key to pms_tasks table
            $table->integer('user_id');  // Foreign key to users table
            $table->text('comment');  // Comment text
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pms_comments');
    }
};
