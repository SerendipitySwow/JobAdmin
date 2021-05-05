<?php


namespace Mine\Traits;


use Mine\Abstracts\AbstractMapper;
use Mine\MineModel;

trait ServiceTrait
{
    /**
     * @var AbstractMapper
     */
    public $mapper;

    /**
     * 获取列表数据
     * @param array|null $params
     * @return array
     */
    public function getList(?array $params = null): array
    {
        if ($params['select'] ?? null) {
            $params['select'] = explode(',', $params['select']);
        }
        return $this->mapper->getList($params);
    }

    /**
     * 获取列表数据（带分页）
     * @param array|null $params
     * @return array
     */
    public function getPageList(?array $params = null): array
    {
        if ($params['select'] ?? null) {
            $params['select'] = explode(',', $params['select']);
        }
        return $this->mapper->getPageList($params);
    }

    /**
     * 获取树列表
     * @param array|null $params
     * @param array $setting
     * @return array
     */
    public function getTreeList(?array $params = null, array $setting = []): array
    {
        if ($params['select'] ?? null) {
            $params['select'] = explode(',', $params['select']);
        }
        $treeSetting = [
            'parentId' => $setting['parentId'] ?? 0,
            'id' => $setting['id'] ?? 'id',
            'parentField' => $setting['parentField'] ?? 'parent_id',
            'children' => $setting['children'] ?? 'children'
        ];
        return $this->mapper->getTreeList($params, ...$treeSetting);
    }

    /**
     * 新增数据
     * @param array $data
     * @return int
     */
    public function save(array $data): int
    {
        return $this->mapper->save($data);
    }

    /**
     * 读取一条数据
     * @param int $id
     * @return MineModel
     */
    public function read(int $id): MineModel
    {
        return $this->mapper->read($id);
    }

    /**
     * 从回收站读取一条数据
     * @param int $id
     * @return MineModel
     * @noinspection PhpUnused
     */
    public function readByRecycle(int $id): MineModel
    {
        return $this->mapper->readByRecycle($id);
    }

    /**
     * 单个或批量软删除数据
     * @param string $ids
     * @return bool
     */
    public function delete(String $ids): bool
    {
        return empty($ids) ? false : $this->mapper->delete(explode(',', $ids));
    }

    /**
     * 更新一条数据
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->mapper->update($id, $data);
    }

    /**
     * 单个或批量真实删除数据
     * @param string $ids
     * @return bool
     */
    public function realDelete(string $ids): bool
    {
        return empty($ids) ? false : $this->realDelete(explode(',', $ids));
    }

    /**
     * 单个或批量从回收站恢复数据
     * @param string $ids
     * @return bool
     */
    public function recovery(string $ids): bool
    {
        return empty($ids) ? false : $this->mapper->recovery(explode(',', $ids));
    }

    /**
     * 单个或批量禁用数据
     * @param string $ids
     * @param string $field
     * @return bool
     */
    public function disable(string $ids, string $field = 'status'): bool
    {
        return empty($ids) ? false : $this->disable(explode(',', $ids), $field);
    }

    /**
     * 单个或批量启用数据
     * @param string $ids
     * @param string $field
     * @return bool
     */
    public function enable(string $ids, string $field = 'status'): bool
    {
        return empty($ids) ? false : $this->enable(explode(',', $ids), $field);
    }
}