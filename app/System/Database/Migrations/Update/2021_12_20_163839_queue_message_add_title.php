<?php
/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class QueueMessageAddTitle extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('system_queue_message', function (Blueprint $table) {
            if (! Schema::hasColumn('system_queue_message','title')) {
                $table->addColumn('string', 'title', ['length' => 255])
                    ->comment('消息标题')
                    ->after('content_type')
                    ->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('system_queue_message', function (Blueprint $table) {
            $table->dropColumn(['title']);
        });
    }
}
