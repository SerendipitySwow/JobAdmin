<?php

declare(strict_types=1);
namespace App\System\Mapper;

use App\System\Model\SystemUser;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\ModelNotFoundException;
use Mine\Abstracts\AbstractMapper;

/**
 * Class SystemUserMapper
 * @package App\System\Mapper
 */
class SystemUserMapper extends AbstractMapper
{
    /**
     * @var SystemUser
     */
    public $model;

    public function assignModel()
    {
        $this->model = SystemUser::class;
    }

    /**
     * 通过用户名检查用户
     * @param string $username
     * @return array
     * @throws ModelNotFoundException
     */
    public function checkUserByUsername(string $username): array
    {
        return $this->model::query()->where('username', $username)->firstOrFail()->toArray();
    }

    /**
     * 通过用户名检查是否存在
     * @param string $username
     * @return bool
     */
    public function existsByUsername(string $username): bool
    {
        return $this->model::query()->where('username', $username)->exists();
    }

    /**
     * 检查用户密码
     * @param String $password
     * @param $hash
     * @return bool
     */
    public function checkPass(String $password, string $hash): bool
    {
        return $this->model::passwordVerify($password, $hash);
    }

    /**
     * 新增用户
     * @param array $data
     * @return int
     */
    public function save(array $data): int
    {
        $user = $this->model::create($data);
        $user->roles()->sync($data['role_ids'], false);
        empty($data['post_ids']) || $user->posts()->sync($data['post_ids'], false);
        return $user->id;
    }

    /**
     * 更新用户
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $this->model::query()->where('id', $id)->update($data);
        $user = $this->model::find($id);
        $user->roles()->sync($data['role_ids']);
        empty($data['post_ids']) || $user->posts()->sync($data['post_ids']);
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
            $user = $this->model::withTrashed()->find($id);
            $user->roles()->detach();
            $user->posts()->detach();
            $user->forceDelete();
        }
        return true;
    }

    /**
     * 获取用户信息
     * @param int $id
     * @return SystemUser
     */
    public function read(int $id): SystemUser
    {
        $user = $this->model::find($id);
        $user->postList = $user->posts()->get();
        $user->roleList = $user->roles()->get();
        return $user;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if (isset($params['dept_id'])) {
            $query->where('dept_id', $params['dept_id']);
        }
        if (isset($params['username'])) {
            $query->where('username', 'like', '%'.$params['username'].'%');
        }
        if (isset($params['status'])) {
            $query->where('status', $params['status']);
        }
        return $query;
    }
}