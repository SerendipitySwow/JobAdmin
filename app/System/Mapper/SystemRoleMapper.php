<?php
declare(strict_types = 1);
namespace App\System\Mapper;

use App\System\Model\SystemRole;
use Mine\Abstracts\AbstractMapper;

class SystemRoleMapper extends AbstractMapper
{
    /**
     * @var SystemRole
     */
    public $model;

    public function assignModel()
    {
        $this->model = SystemRole::class;
    }

    /**
     * 通过角色ID列表获取菜单ID
     * @param array $ids
     * @return array
     */
    public function getMenuIdsByRoleIds(array $ids): array
    {
        if (empty($ids)) return [];

        return $this->model::query()->whereIn('id', $ids)->with(['menus' => function($query) {
            $query->select('id')->where('status', $this->model::ENABLE)->orderBy('sort', 'desc');
        }])->get(['id'])->toArray();
    }

    /**
     * 检查角色code是否已存在
     * @param string $code
     * @return bool
     */
    public function checkRoleCode(string $code): bool
    {
        return $this->model::query()->where('code', $code)->exists();
    }

    /**
     * 新建角色
     * @param array $data
     * @return int
     */
    public function save(array $data): int
    {
        $role = $this->model::create($data);
        $role->menus()->sync(array_unique($data['menu_ids']), false);
        $role->depts()->sync($data['dept_ids'], false);
        return $role->id;
    }

    /**
     * 更新角色
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $this->model::query()->where('id', $id)->update($data);
        $role = $this->model::find($id);
        $role->menus()->sync(array_unique($data['menu_ids']));
        $role->depts()->sync($data['dept_ids']);
        return true;
    }

    /**
     * 批量真实删除角色
     * @param array $ids
     * @return bool
     */
    public function realDelete(array $ids): bool
    {
        foreach ($ids as $id) {
            $role = $this->model::withTrashed()->find($id);
            // 删除关联菜单
            $role->menus()->detach();
            // 删除关联部门
            $role->depts()->detach();
            // 删除关联用户
            $role->users()->detach();
            // 删除角色数据
            $role->forceDelete();
        }
        return true;
    }
}