<?php
declare (strict_types=1);
namespace App\System\Mapper;

use App\System\Model\SystemMenu;
use Mine\Abstracts\AbstractMapper;

class SystemMenuMapper extends AbstractMapper
{

    /**
     * @var SystemMenu
     */
    public $model;

    /**
     * 查询的菜单字段
     * @var string[]
     */
    public $menuField = [
        'id', 'parent_id', 'name', 'code', 'icon', 'route', 'is_hidden', 'component', 'is_out', 'is_cache', 'type'
    ];

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
        return $this->model::query()
            ->select(...$this->menuField)
            ->where('status', $this->model::ENABLE)
            ->where('type', '!=', $this->model::BUTTON)
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
        return $this->model::query()
            ->whereIn('id', $ids)
            ->where('status', $this->model::ENABLE)
            ->where('type', '!=', $this->model::BUTTON)
            ->orderBy('sort', 'desc')
            ->select(...$this->menuField)
            ->get()->sysMenuToRouterTree();
    }

    /**
     * 获取快捷菜单
     * @param array|null $ids
     * @return array
     */
    public function getQuickMenu(array $ids = null): array
    {
        $query = $this->model::query()
            ->where('is_quick', $this->model::ENABLE)
            ->where('status', $this->model::ENABLE)
            ->where('type', $this->model::MENUS_LIST)
            ->orderBy('sort', 'desc');
        if (is_array($ids) && count($ids)) {
            return $query->whereIn('id', $ids)->select(...$this->menuField)->get()->toArray();
        } else {
            return $query->select(...$this->menuField)->get()->toArray();
        }
    }

    /**
     * 查询菜单code
     * @param array|null $ids
     * @return array
     */
    public function getMenuCode(array $ids = null)
    {
        return $this->model::query()->whereIn('id', $ids)->pluck('code')->toArray();
    }

    /**
     * 通过 code 查询菜单名称
     * @param string $code
     * @return string
     */
    public function findNameByCode(string $code): ?string
    {
        return $this->model::query()->where('code', $code)->value('name');
    }

    /**
     * 通过 route 查询菜单
     * @param string $route
     * @return array|\Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model|object
     */
    public function findMenuByRoute(string $route)
    {
        return $this->model::query()->where('route', $route)->first();
    }
}