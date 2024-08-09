<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Admin;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teacher_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Admin::class);
            $table->integer('amount')->default(0);
            $table->enum('state', ["PENDING", "SUCCESS"]);
            $table->string('create_date')->default('')->nullable();
            $table->string('completed_date')->default('')->nullable();
            $table->string('payout_batch_id')->default('')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_transactions');
    }
};
