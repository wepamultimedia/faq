<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if(!Schema::hasTable('faq_categories')) {
            Schema::create('faq_categories', function (Blueprint $table) {
                $table->id();
                $table->integer('position');
                $table->timestamps();
            });
        }

        if(!Schema::hasTable('faq_categories_translations')) {
            Schema::create('faq_categories_translations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id');
                $table->string('name');

                $table->string('locale');
                $table->unique(['locale', 'category_id']);

                $table->foreign('category_id')
                    ->references('id')
                    ->on('faq_categories')
                    ->cascadeOnDelete();
            });
        }

        if(!Schema::hasTable('faq_qas')) {
            Schema::create('faq_qas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id');
                $table->boolean('draft')->default(false);
                $table->integer('position');
                $table->timestamps();
            });
        }

        if(!Schema::hasTable('faq_qas_translations')) {
            Schema::create('faq_qas_translations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('qa_id');
                $table->string('question');
                $table->text('answer');

                $table->string('locale');
                $table->unique(['locale', 'qa_id']);

                $table->foreign('qa_id')
                    ->references('id')
                    ->on('faq_qas')
                    ->cascadeOnDelete();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('faq_categories');
        Schema::dropIfExists('faq_categories_translations');
        Schema::dropIfExists('faq_qas');
        Schema::dropIfExists('faq_qas_translations');
    }
};
