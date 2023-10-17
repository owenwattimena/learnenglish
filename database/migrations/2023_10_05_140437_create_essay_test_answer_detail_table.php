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
        Schema::create('essay_test_answer_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_answer_id');
            $table->unsignedBigInteger('questions_id');
            $table->mediumText('answer');
            $table->boolean('is_correct')->nullable();
            $table->timestamps();

            $table->foreign('user_answer_id')->references('id')->on('user_answers');
            $table->foreign('questions_id')->references('id')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('essay_test_answer_detail');
    }
};
