<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSystemRoleTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_role', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('角色信息表');
            $table->addColumn('bigInteger', 'id', ['unsigned' => true, 'comment' => '主键，角色ID']);
            $table->addColumn('string', 'name', ['length' => 30, 'comment' => '角色名称']);
            $table->addColumn('string', 'code', ['length' => 100, 'comment' => '角色代码']);
            $table->addColumn('tinyInteger', 'data_scope', ['default' => 0, 'comment' => '数据范围（0：全部数据权限 1：自定数据权限 2：本部门数据权限 3：本部门及以下数据权限）']);
            $table->addColumn('tinyInteger', 'status', ['unsigned' => true, 'default' => 0, 'comment' => '状态 (0正常 1停用)'])->nullable();
            $table->addColumn('tinyInteger', 'sort', ['unsigned' => true, 'default' => 0, 'comment' => '排序'])->nullable();
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
        Schema::dropIfExists('system_role');
    }
}
