<?php
declare (strict_types=1);
namespace App\System\Mapper;

use App\System\Model\SystemMenu;
use App\System\Model\SystemRole;

class SystemMenuMapper
{
    /**
     * 获取超级管理员（创始人）的路由菜单
     * @return array
     */
    public function getSuperAdminRouters(): array
    {
        $menuField = [
            'id', 'parent_id', 'level', 'name', 'code', 'icon', 'route',
            'component', 'is_out', 'is_cache', 'is_quick', 'type'
        ];
        return SystemMenu::query()->select(...$menuField)->get()->toArray();
    }

    /**
     * 通过角色ID列表获取菜单权限
     * @param array $ids
     * @return array
     */
    public function getRoutersByRoleIds(array $ids): array
    {
        if (empty($ids)) return [];

        return SystemRole::query()->whereIn('id', $ids)->with('menus')->get()->sysMenuToRouterTree();
    }
}