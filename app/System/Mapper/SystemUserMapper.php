<?php

declare(strict_types=1);
namespace App\System\Mapper;

use App\System\Model\SystemDept;
use App\System\Model\SystemUser;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\ModelNotFoundException;
use Mine\Abstracts\AbstractMapper;
use Mine\Annotation\Transaction;
use Mine\MineModel;

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
     * @param string $hash
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
     * @Transaction
     */
    public function save(array $data): int
    {
        $role_ids = $data['role_ids'] ?? [];
        $post_ids = $data['post_ids'] ?? [];
        $this->filterExecuteAttributes($data, true);

        $user = $this->model::create($data);
        $user->roles()->sync($role_ids, false);
        $user->posts()->sync($post_ids, false);
        return $user->id;
    }

    /**
     * 更新用户
     * @param int $id
     * @param array $data
     * @return bool
     * @Transaction
     */
    public function update(int $id, array $data): bool
    {
        $role_ids = $data['role_ids'] ?? [];
        $post_ids = $data['post_ids'] ?? [];
        $this->filterExecuteAttributes($data, true);

        $result = parent::update($id, $data);
        $user = $this->model::find($id);
        if ($user && $result) {
            !empty($role_ids) && $user->roles()->sync($role_ids);
            $user->posts()->sync($post_ids);
            return true;
        }
        return false;
    }

    /**
     * 真实批量删除用户
     * @param array $ids
     * @return bool
     * @Transaction
     */
    public function realDelete(array $ids): bool
    {
        foreach ($ids as $id) {
            $user = $this->model::withTrashed()->find($id);
            if ($user) {
                $user->roles()->detach();
                $user->posts()->detach();
                $user->forceDelete();
            }
        }
        return true;
    }

    /**
     * 获取用户信息
     * @param int $id
     * @return MineModel
     */
    public function read(int $id): ?MineModel
    {
        $user = $this->model::find($id);
        if ($user) {
            $user->setAttribute('roleList', $user->roles()->get() ?: []);
            $user->setAttribute('postList', $user->posts()->get() ?: []);
        }
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
            $query->whereIn('dept_id', explode(',', $params['dept_id']));
        }
        if (isset($params['username'])) {
            $query->where('username', 'like', '%'.$params['username'].'%');
        }
        if (isset($params['status'])) {
            $query->where('status', $params['status']);
        } else {
            $query->where('status', $this->model::ENABLE);
        }

        if (isset($params['filterSuperAdmin'])) {
            $query->whereNotIn('id', [env('SUPER_ADMIN')]);
        }

        if (isset($params['minDate']) && isset($params['maxDate'])) {
            $query->whereBetween(
                'created_at',
                [$params['minDate'] . ' 00:00:00', $params['maxDate'] . ' 23:59:59']
            );
        }
        if (isset($params['userIds'])) {
            $query->whereIn('id', $params['userIds']);
        }

        if (isset($params['showDept'])) {
            $isAll = $params['showDeptAll'] ?? false;

            $query->with(['dept' => function($query) use($isAll){
                /* @var Builder $query*/
                $query->where('status', SystemDept::ENABLE);
                return $isAll ? $query->select(['*']) : $query->select(['id', 'name']);
            }]);
        }
        return $query;
    }

    /**
     * 初始化用户密码
     * @param int $id
     * @param string $password
     * @return bool
     */
    public function initUserPassword(int $id, string $password): bool
    {
        $model = $this->model::find($id);
        if ($model) {
            $model->password = $password;
            return $model->save();
        }
        return false;
    }
}