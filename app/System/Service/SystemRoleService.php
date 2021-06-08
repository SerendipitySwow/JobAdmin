<?php


namespace App\System\Service;


use App\System\Mapper\SystemRoleMapper;
use Mine\Abstracts\AbstractService;
use Mine\Exception\NormalStatusException;

class SystemRoleService extends AbstractService
{
    public $mapper;

    public function __construct(SystemRoleMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function save(array $data): int
    {
        if ($this->mapper->checkRoleCode($data['code'])) {
            throw new NormalStatusException(__('system.rolecode_exists'));
        }
        if (!empty($data['dept_ids']) && !is_array($data['dept_ids'])) {
            $data['dept_ids'] = explode(',', $data['dept_ids']);
        }
        if (!empty($data['menu_ids']) && !is_array($data['menu_ids'])) {
            $data['menu_ids'] = explode(',', $data['menu_ids']);
        }
        return $this->mapper->save($data);
    }

    /**
     * 更新角色信息
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        if (!empty($data['dept_ids']) && !is_array($data['dept_ids'])) {
            $data['dept_ids'] = explode(',', $data['dept_ids']);
        }
        if (!empty($data['menu_ids']) && !is_array($data['menu_ids'])) {
            $data['menu_ids'] = explode(',', $data['menu_ids']);
        }
        return $this->mapper->update($id, $data);
    }

    /**
     * 修改用户状态
     * @param int $id
     * @param string $value
     * @return bool
     */
    public function changeRoleStatus(int $id, string $value): bool
    {
        if ($value === '0') {
            $this->mapper->enable([$id]);
            return true;
        } else if ($value === '1') {
            $this->mapper->disable([$id]);
            return true;
        } else {
            return false;
        }
    }
}