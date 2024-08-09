<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Admin;
use App\Models\User;
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
        Schema::create('free_users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Admin::class)->nullable();
            $table->foreignIdFor(User::class)->nullable();
            $table->foreignIdFor(Subject::class);
            $table->foreignIdFor(Course::class);
            $table->foreignIdFor(Lecture::class);
            $table->string("phone_prefix")->nullable();
            $table->string("phone_number")->nullable();
            $table->string("phone")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('free_users');
    }
};
