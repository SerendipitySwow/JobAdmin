<?php

declare(strict_types=1);
namespace App\System\Mapper;

use App\System\Model\SystemUser;
use Hyperf\Database\Model\ModelNotFoundException;
use Hyperf\Utils\Collection;

/**
 * Class SystemUserMapper
 * @package App\System\Mapper
 */
class SystemUserMapper
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

    /**
     * @param int $id
     * @param array $data
     * @return int
     */
    public function updateById(int $id, array $data): int
    {
        return SystemUser::query()->where('id', $id)->update($data);
    }

    public function findById(int $id, bool $isArray = false)
    {
        $user = SystemUser::query()->find($id);
        return $isArray ? $user->toArray() : $user;
    }
}