<?php
declare(strict_types = 1);
namespace App\System\Mapper;

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

        return $this->model::query()->whereIn('id', $ids)->with(['menus' => function($query) {
            $query->select('id')->where('status', $this->model::ENABLE)->orderBy('sort', 'desc');
        }])->get(['id'])->toArray();
    }
}