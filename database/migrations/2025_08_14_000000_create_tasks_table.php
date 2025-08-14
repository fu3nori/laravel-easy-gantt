<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * タスクテーブルの作成
     * 
     * このマイグレーションは、ガントチャートアプリケーションのタスク管理機能に必要な
     * tasksテーブルを作成します。
     * 
     * テーブル構造:
     * - id: 主キー（自動インクリメント）
     * - user_id: ユーザーID（外部キー、インデックス付き）
     * - projects_id: プロジェクトID（外部キー、インデックス付き）
     * - task_name: タスク名
     * - fix: タスクの固定状態（0: 未固定, 1: 固定）
     * - start_day: タスク開始日
     * - end_day: タスク終了日
     * - created_at: 作成日時
     * - updated_at: 更新日時
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // 主キー（自動インクリメント）
            $table->integer('user_id')->index(); // ユーザーID（インデックス付き）
            $table->integer('projects_id')->index(); // プロジェクトID（インデックス付き）
            $table->text('task_name'); // タスク名
            $table->string('fix')->default('0'); // タスクの固定状態（デフォルト: 未固定）
            $table->date('start_day'); // タスク開始日
            $table->date('end_day'); // タスク終了日
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * マイグレーションのロールバック
     * 
     * tasksテーブルを削除します。
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
