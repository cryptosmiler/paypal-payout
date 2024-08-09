<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Admin;
use App\Models\Subject;
use App\Models\Course;
use App\Models\Lecture;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Admin::class);
            $table->foreignIdFor(Subject::class);
            $table->foreignIdFor(Course::class);
            $table->foreignIdFor(Lecture::class);
            $table->string('question');
            $table->text('answer');
            $table->enum('status', ['created', 'deleted'])->default('created');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
