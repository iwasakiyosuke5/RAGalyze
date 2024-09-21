<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hplc_results', function (Blueprint $table) {
            $table->id();
            $table->text('content'); // テキストデータを保存
            $table->json('vector')->nullable(); // ベクトルデータを保存
            $table->string('file_path')->nullable(); // ファイルパスを保存
            $table->foreignId('user_id'); // ユーザーIDを保存
            $table->timestamps(); // 作成日時と更新日時を保存
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hplc_results');
    }
};
