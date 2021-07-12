<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSettingGenerateTablesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('setting_generate_tables', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('代码生成业务信息表');
            $table->addColumn('bigInteger', 'id', ['unsigned' => true, 'comment' => '主键']);
            $table->addColumn('string', 'table_name', ['length' => 200, 'comment' => '表名称'])->nullable();
            $table->addColumn('string', 'table_comment', ['length' => 500, 'comment' => '表注释'])->nullable();
            $table->addColumn('string', 'module_name', ['length' => 100, 'comment' => '所属模块'])->nullable();
            $table->addColumn('string', 'namespace', ['length' => 255, 'comment' => '命名空间'])->nullable();
            $table->addColumn('string', 'menu_name', ['length' => 100, 'comment' => '生成菜单名'])->nullable();
            $table->addColumn('bigInteger', 'belong_menu_id', ['length' => 100, 'comment' => '所属菜单'])->nullable();
            $table->addColumn('string', 'package_name', ['length' => 100, 'comment' => '控制器包名'])->nullable();
            $table->addColumn(
                'string', 'type',
                ['length' => 100, 'comment' => '生成类型，single 单表CRUD，tree 树表CRUD，parent_sub父子表CRUD'])
                ->nullable();
            $table->addColumn('string', 'options', ['length' => 2000, 'comment' => '其他业务选项'])->nullable();
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
        Schema::dropIfExists('system_task_log');
    }
}
