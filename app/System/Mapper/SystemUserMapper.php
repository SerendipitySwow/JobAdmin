<?php

declare(strict_types=1);
namespace App\System\Mapper;

use App\System\Model\SystemUser;
use Hyperf\Database\Model\ModelNotFoundException;
use Mine\MineModelMapper;

/**
 * Class SystemUserMapper
 * @package App\System\Mapper
 */
class SystemUserMapper extends MineModelMapper
{
    /**
     * 通过用户名检查用户
     * @param string $username
     * @return array
     * @throws ModelNotFoundException
     */
    public function checkUserByUsername(string $username): array
    {
        return SystemUser::query()->where('username', $username)->firstOrFail()->toArray();
    }

    /**
     * 检查用户密码
     * @param String $password
     * @param $hash
     * @return bool
     */
    public function checkPass(String $password, string $hash): bool
    {
        return SystemUser::passwordVerify($password, $hash);
    }
}