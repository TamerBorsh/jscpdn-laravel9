<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('problems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->constrained('admins')->onDelete('cascade');
            $table->string('title')->index();
            $table->string('number_call')->index();
            $table->enum('category', ['1', '2', '3'])->nullable();
            $table->enum('importance', ['1', '2', '3'])->nullable();
            $table->enum('status', ['1', '2', '3', '4', '5', '6'])->default('1');
            $table->string('photo')->nullable();
            $table->text('content')->nullable();
            $table->text('reply')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('problems');
    }
};
