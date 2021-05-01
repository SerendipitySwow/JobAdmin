<?php
declare (strict_types=1);
namespace App\System\Mapper;

use App\System\Model\SystemMenu;
use App\System\Model\SystemRole;
use Mine\Abstracts\AbstractMapper;

class SystemMenuMapper extends AbstractMapper
{

    /**
     * @var SystemMenu
     */
    public $model;

    public function assignModel()
    {
        $this->model = SystemMenu::class;
    }


    /**
     * 获取超级管理员（创始人）的路由菜单
     * @return array
     */
    public function getSuperAdminRouters(): array
    {
        $menuField = [
            'id', 'parent_id', 'level', 'name', 'code', 'icon', 'route', 'is_hidden',
            'component', 'is_out', 'is_cache', 'is_quick', 'type'
        ];
        return $this->model::query()->select(...$menuField)
            ->where('status', $this->model::ENABLE)->orderBy('sort', 'desc')
            ->get()->sysMenuToRouterTree();
    }

    /**
     * 通过角色ID列表获取菜单权限
     * @param array $ids
     * @return array
     */
    public function getRoutersByRoleIds(array $ids): array
    {
        if (empty($ids)) return [];

        $menuField = [
            'id', 'parent_id', 'level', 'name', 'code', 'icon', 'route', 'is_hidden',
            'component', 'is_out', 'is_cache', 'is_quick', 'type'
        ];
        return SystemRole::query()->whereIn('id', $ids)->with(['menus' => function($query) use($menuField) {
            $query->select(...$menuField)->where('status', $this->model::ENABLE)->orderBy('sort', 'desc');
        }])->get(['id'])->sysMenuToRouterTree();
    }
}