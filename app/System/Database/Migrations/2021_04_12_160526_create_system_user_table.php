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
//            $table->engine = 'Innodb';
            $table->unsignedBigInteger('id');
            $table->string('username', 20);
            $table->string('password');
            $table->string('email', 100);
            $table->string('avatar');
            $table->unsignedBigInteger('dept_id');
            $table->rememberToken();
            $table->unsignedTinyInteger('status');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();
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
