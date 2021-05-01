<?php
declare(strict_types=1);
namespace Mine;

use Hyperf\Database\Model\Collection;

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
        if (isset($data[0]['menus'])) {
            foreach ($data as $value) {
                foreach ($value['menus'] as $menu) {
                    $tempRoute = [
                        // 权限标识
                        'name' => $menu['code'],
                        'component' => $menu['component'],
                        'path' => $menu['route'],
                        'redirect' => $menu['is_out'] == 0 ? 'noRedirect' : $menu['route'],
                        'hidden' => $menu['is_hidden'] == 0,
                        'meta' => [
                            'keepAlive' => $menu['is_cache'] == 0,
                            'icon' => $menu['icon'],
                            'title' => $menu['name'],
                        ]
                    ];
                    array_push($routers, $tempRoute);
                }
            }
            unset($data);
        }
        return $this->toTree(array_unique($routers));
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
                $tree = $this->toTree($data, $value[$id]);
                if (!empty($tree)) {
                    $value[$children] = $tree;
                }
                array_push($tree, $value);
            }
        }

        return $tree;
    }
}