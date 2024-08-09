<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Admin;
use App\Models\Subject;
use App\Models\Course;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Admin::class);
            $table->foreignIdFor(Subject::class);
            $table->foreignIdFor(Course::class);
            $table->string('title');
            $table->text('description');
            $table->string('video');
            $table->string('video_40s');
            $table->string('video_name');
            $table->integer("duration")->default(0);
            $table->integer("size")->default(0);
            $table->integer("order")->default(0);
            $table->enum('status', ['created', 'deleted'])->default('created');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lectures');
    }
};
