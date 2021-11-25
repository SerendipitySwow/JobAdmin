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

namespace Api\InterfaceApi\v1;

use App\System\Mapper\SystemUserMapper;

/**
 * 演示，测试专用
 */
class UserApi
{
    protected $user;

    public function __construct(SystemUserMapper $user)
    {
        $this->user = $user;
    }

    public function getList(): array
    {
        // 第二个参数，不进行数据权限检查，否则会拉起检测是否登录。
        return $this->user->getList([], false);
    }
}