<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSystemUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_user', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->addColumn('bigInteger', 'id', ['unsigned' => true, 'comment' => '用户ID，主键']);
            $table->addColumn('string', 'username', ['length' => 20, 'comment' => '用户名']);
            $table->addColumn('string', 'password', ['length' => 100, 'comment' => '密码']);
            $table->addColumn('string', 'user_type', ['length' => 3, 'comment' => '用户类型：(100系统用户)', 'default' => '100'])->nullable();
            $table->addColumn('string', 'email', ['length' => 50, 'comment' => '用户邮箱'])->nullable();
            $table->addColumn('string', 'avatar', ['length' => 100, 'comment' => '用户头像'])->nullable();
            $table->addColumn('bigInteger', 'dept_id', ['unsigned' => true, 'comment' => '部门ID'])->nullable();
            $table->addColumn('string', 'remember_token', ['length' => 100, 'comment' => '用户Token'])->nullable();
            $table->addColumn('tinyInteger', 'status', ['unsigned' => true, 'default' => 0, 'comment' => '状态 (0正常 1停用)'])->nullable();
            $table->addColumn('ipAddress', 'login_ip', ['comment' => '最后登陆IP'])->nullable();
            $table->addColumn('timestamp', 'login_time', ['comment' => '最后登陆时间'])->nullable();
            $table->addColumn('bigInteger', 'created_by', ['comment' => '创建者'])->nullable();
            $table->addColumn('bigInteger', 'updated_by', ['comment' => '更新者'])->nullable();
            $table->addColumn('timestamp', 'created_at', ['precision' => 0, 'comment' => '创建时间'])->nullable();
            $table->addColumn('timestamp', 'updated_at', ['precision' => 0, 'comment' => '更新时间'])->nullable();
            $table->addColumn('timestamp', 'deleted_at', ['precision' => 0, 'comment' => '删除时间'])->nullable();
            $table->addColumn('string', 'remark', ['length' => 255, 'comment' => '备注'])->nullable();
            $table->primary('id');
            $table->unique('username');
            $table->index('dept_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_user');
    }
}
