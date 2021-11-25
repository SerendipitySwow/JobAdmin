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

namespace Api\v1\Controller;

use App\System\Mapper\SystemUserMapper;

class UserApi
{
    protected $user;

    public function __construct(SystemUserMapper $user)
    {
        $this->user = $user;
    }

    public function getList(): array
    {
        return $this->user->getList([], false);
    }
}