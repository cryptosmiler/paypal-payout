<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Admin;
use App\Models\User;
use App\Models\Lecture;
use App\Models\Course;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Admin::class);
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Course::class)->default(0);
            $table->foreignIdFor(Lecture::class)->default(0);
            $table->string('transaction_id');
            $table->enum("type", ["Video", "Question", "Paid", "Promo Code", "Gift"]);
            $table->string('title');
            $table->string('content');
            $table->integer('amount')->default(0);
            $table->string('date');
            $table->integer('videos')->default(0);
            $table->integer('mins')->default(0);
            $table->integer('questions')->default(0);
            $table->json('question_ids');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
