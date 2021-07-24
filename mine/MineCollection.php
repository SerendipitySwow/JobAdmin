<?php
declare(strict_types=1);
namespace Mine;

use Hyperf\Database\Model\Collection;
use Mine\Helper\Str;

class MineCollection extends Collection
{
    /**
     * 系统菜单转前端路由树
     * @return array
     */
    public function sysMenuToRouterTree(): array
    {
        $data = $this->toArray();
        if (empty($data)) return [];

        $routers = [];
        foreach ($data as $menu) {
            array_push($routers, $this->setRouter($menu));
        }
        return $this->toTree($routers);
    }

    /**
     * @param $menu
     * @return array
     */
    public function setRouter(&$menu): array
    {
        $route = [
            'id' => $menu['id'],
            'parent_id' => $menu['parent_id'],
            'name' => $menu['code'],
            'component' => $menu['component'],
            'path' => $menu['route'],
            'redirect' => $menu['redirect'],
            'meta' => [
                'type'   => $menu['type'],
                'icon'   => $menu['icon'],
                'title'  => $menu['name'],
                'hidden' => ($menu['is_hidden'] == 0),
                'hiddenBreadcrumb' => ($menu['is_hidden_breadcrumb'] == 0)
            ]
        ];
        return $route;
    }

    /**
     * @param array $data
     * @param int $parentId
     * @param string $id
     * @param string $parentField
     * @param string $children
     * @return array
     */
    public function toTree(array $data = [], int $parentId = 0, string $id = 'id', string $parentField = 'parent_id', string $children='children'): array
    {
        $data = $data ?: $this->toArray();

        if (empty($data)) return [];

        $tree = [];

        foreach ($data as $value) {
            if ($value[$parentField] == $parentId) {
                $child = $this->toTree($data, $value[$id]);
                if (!empty($child)) {
                    $value[$children] = $child;
                }
                array_push($tree, $value);
            }
        }

        unset($data);
        return $tree;
    }
}