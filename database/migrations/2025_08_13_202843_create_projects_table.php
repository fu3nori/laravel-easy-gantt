<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * プロジェクトテーブルの作成
     * 
     * このマイグレーションは、ガントチャートアプリケーションのプロジェクト管理機能に必要な
     * projectsテーブルを作成します。
     * 
     * テーブル構造:
     * - id: 主キー（自動インクリメント）
     * - user_id: ユーザーID（外部キー、インデックス付き）
     * - project_name: プロジェクト名
     * - created_at: 作成日時
     * - updated_at: 更新日時
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id(); // 主キー（自動インクリメント）
            $table->integer('user_id')->index(); // ユーザーID（インデックス付き）
            $table->string('project_name'); // プロジェクト名
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * マイグレーションのロールバック
     * 
     * projectsテーブルを削除します。
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
