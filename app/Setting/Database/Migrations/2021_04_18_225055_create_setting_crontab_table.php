<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSettingCrontabTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('setting_crontab', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('定时任务信息表');
            $table->addColumn('bigInteger', 'id', ['unsigned' => true, 'comment' => '主键']);
            $table->addColumn('string', 'name', ['length' => 100, 'comment' => '任务名称'])->nullable();
            $table->addColumn(
                'char', 'type',
                ['length' => 1, 'default' => '0', 'comment' => '任务类型 (1 command, 2 class, 3 url)']
            )->nullable();
            $table->addColumn('string', 'target', ['length' => 500, 'comment' => '调用任务字符串'])->nullable();
            $table->addColumn('string', 'rule', ['length' => 15, 'comment' => '任务执行表达式'])->nullable();
            $table->addColumn(
                'char', 'fail_policy',
                ['length' => 1, 'default' => '3', 'comment' => '失败策略 (1 执行，2 尝试执行一次，3 放弃执行)']
            )->nullable();
            $table->addColumn('char', 'status', ['length' => 1, 'default' => '0', 'comment' => '状态 (0正常 1停用)'])->nullable();
            $table->addColumn('bigInteger', 'created_by', ['comment' => '创建者'])->nullable();
            $table->addColumn('bigInteger', 'updated_by', ['comment' => '更新者'])->nullable();
            $table->addColumn('timestamp', 'created_at', ['precision' => 0, 'comment' => '创建时间'])->nullable();
            $table->addColumn('timestamp', 'updated_at', ['precision' => 0, 'comment' => '更新时间'])->nullable();
            $table->addColumn('timestamp', 'deleted_at', ['precision' => 0, 'comment' => '删除时间'])->nullable();
            $table->addColumn('string', 'remark', ['length' => 255, 'comment' => '备注'])->nullable();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_task');
    }
}
