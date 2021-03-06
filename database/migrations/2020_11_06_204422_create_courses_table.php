<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->string('title')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('position');
            $table->boolean('visible')->default(false);
            $table->float('price');
            $table->float('price_three_months');
            $table->float('price_six_months');
            $table->foreignId('chapter_id')->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('courses');
    }
}
