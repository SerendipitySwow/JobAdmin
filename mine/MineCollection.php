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
        return $this->toArray();
    }
}