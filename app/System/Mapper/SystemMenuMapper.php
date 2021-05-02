<?php
declare (strict_types=1);
namespace App\System\Mapper;

use App\System\Model\SystemMenu;
use App\System\Model\SystemRole;
use Mine\Abstracts\AbstractMapper;
use Mine\MineCollection;

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
            'id', 'parent_id', 'name', 'code', 'icon', 'route', 'is_hidden',
            'component', 'is_out', 'is_cache', 'type'
        ];
        return $this->model::query()->select(...$menuField)
            ->where('status', $this->model::ENABLE)
            ->where('type', '!=', 'B')
            ->orderBy('sort', 'desc')
            ->get()->sysMenuToRouterTree();
    }

    /**
     * 通过菜单ID列表获取菜单数据
     * @param array $ids
     * @return array
     */
    public function getRoutersByIds(array $ids): array
    {
        $menuField = [
            'id', 'parent_id', 'name', 'code', 'icon', 'route', 'is_hidden',
            'component', 'is_out', 'is_cache', 'type'
        ];
        return $this->model::query()->whereIn('id', $ids)->where('status', $this->model::ENABLE)
            ->where('type', '!=', 'B')
            ->orderBy('sort', 'desc')
            ->select(...$menuField)->get()->sysMenuToRouterTree();
    }

    /**
     * 获取快捷菜单
     * @param array|null $ids
     * @return array
     */
    public function getQuickMenu(array $ids = null): array
    {
        $menuField = [
            'id', 'parent_id', 'name', 'code', 'icon', 'route', 'is_hidden',
            'component', 'is_out', 'is_cache', 'type'
        ];
        $query = $this->model::query()->where('status', $this->model::ENABLE)->where('type', 'M')
            ->orderBy('sort', 'desc');
        if (is_array($ids) && count($ids)) {
            return $query->whereIn('id', $ids)->select(...$menuField)->get()->toArray();
        } else {
            return $query->select(...$menuField)->get()->toArray();
        }
    }
}