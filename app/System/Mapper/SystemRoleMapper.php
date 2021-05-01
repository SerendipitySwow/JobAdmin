<?php


namespace App\System\Mapper;


use App\System\Model\SystemMenu;
use App\System\Model\SystemRole;
use Mine\Abstracts\AbstractMapper;

class SystemRoleMapper extends AbstractMapper
{
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

        $menuField = [
            'id', 'parent_id', 'level', 'name', 'code', 'icon', 'route', 'is_hidden',
            'component', 'is_out', 'is_cache', 'is_quick', 'type'
        ];
        return $this->model::query()->whereIn('id', $ids)->with(['menus' => function($query) use($menuField) {
            $query->select('id')->where('status', $this->model::ENABLE)->orderBy('sort', 'desc');
        }])->get(['id']);
    }
}