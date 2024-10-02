<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */


    protected $connection = 'user_db';
    protected $table = 'todo';

    public function up(): void
    {
        Schema::create('todo', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('isFinish');
            $table->string('todo');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todo');
    }
};
