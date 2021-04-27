<?php

declare(strict_types=1);
namespace App\System\Mapper;

use App\System\Model\SystemUser;
use Hyperf\Database\Model\ModelNotFoundException;

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
     * 通过用户名检查是否存在
     * @param string $username
     * @return bool
     */
    public function existsByUsername(string $username): bool
    {
        return SystemUser::query()->where('username', $username)->exists();
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
     * 新增用户
     * @param array $data
     * @return int
     */
    public function create(array $data): int
    {
        $user = SystemUser::create($data);
        $user->roles()->sync($data['role_ids'], false);
        !empty($data['post_ids']) && $user->posts()->sync($data['post_ids'], false);
        return $user->id;
    }

    /**
     * 批量软删除用户
     * @param array $ids
     * @return bool
     */
    public function delete(array $ids): bool
    {
        SystemUser::destroy($ids);
        return true;
    }

    /**
     * 真实批量删除用户
     * @param array $ids
     * @return bool
     */
    public function realDelete(array $ids): bool
    {
        foreach ($ids as $id) {
            $user = SystemUser::withTrashed()->find($id);
            $user->roles()->detach();
            $user->posts()->detach();
            $user->forceDelete();
        }
        return true;
    }

    /**
     * 批量恢复软删除的用户
     * @param array $ids
     * @return bool
     */
    public function recovery(array $ids): bool
    {
        return SystemUser::withTrashed()->whereIn('id', $ids)->restore();
    }

    /**
     * 获取用户信息
     * @param int $id
     * @return SystemUser
     */
    public function read(int $id): SystemUser
    {
        $user = SystemUser::find($id);
        $user->jobs  = $user->posts()->get();
        $user->roles = $user->roles()->get();
        return $user;
    }

    /**
     * @param array $data
     * @return int
     */
    public function update(array $data): int
    {
        return SystemUser::query()->update($data);
    }
}