<?php

declare(strict_types = 1);
namespace App\System\Service;


use App\System\Mapper\SystemDeptMapper;
use App\System\Model\SystemMenu;
use Mine\Abstracts\AbstractService;

class SystemDeptService extends AbstractService
{
    /**
     * @var SystemDeptMapper
     */
    public $mapper;

    public function __construct(SystemDeptMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @param array|null $params
     * @return array
     */
    public function getTreeList(?array $params = null): array
    {
        $params = array_merge(['order_by' => 'sort', 'order_type' => 'desc'], $params);
        return parent::getTreeList($params);
    }

    /**
     * 获取前端选择树
     * @return array
     */
    public function getSelectTree(): array
    {
        return $this->mapper->getSelectTree();
    }

    /**
     * 新增部门
     * @param array $data
     * @return int
     */
    public function save(array $data): int
    {
        $pid = $data['parent_id'] ?? 0;

        if ($pid === 0) {
            $data['level'] = $data['parent_id'] = '0';
        } else {
            array_unshift($pid, '0');
            $data['level'] = implode(',', $pid);
            $data['parent_id'] = array_pop($pid);
        }

        return $this->mapper->save($data);
    }

    /**
     * 更新部门
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $pid = $data['parent_id'] ?? 0;

        if ($pid === 0) {
            $data['level'] = $data['parent_id'] = '0';
        } else {
            $pid = explode(',', $pid);
            array_unshift($pid, '0');
            $data['level'] = implode(',', $pid);
            $data['parent_id'] = array_pop($pid);
        }

        return $this->mapper->update($id, $data);
    }

    /**
     * 真实删除部门
     * @param string $ids
     * @return array
     */
    public function realDel(string $ids): ?array
    {
        $ids = explode(',', $ids);
        // 跳过的部门
        $ctuIds = [];
        if (count($ids)) foreach ($ids as $id) {
            if (!$this->checkChildrenExists( (int) $id)) {
                $this->mapper->realDelete([$id]);
            } else {
                array_push($ctuIds, $id);
            }
        }
        return count($ctuIds) ? $this->mapper->getDeptName($ctuIds) : null;
    }

    /**
     * 检查子部门是否存在
     * @param int $id
     * @return bool
     */
    public function checkChildrenExists(int $id): bool
    {
        return $this->mapper->checkChildrenExists($id);
    }
}