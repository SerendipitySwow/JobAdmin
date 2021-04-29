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
     */
    public function getList()
    {
        $this->mapper->getList();
    }

    /**
     * 获取列表数据（带分页）
     */
    public function getPageList()
    {
        $this->mapper->getPageList();
    }

    /**
     * 获取树列表
     */
    public function getTreeList()
    {
        $this->mapper->getTreeList();
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
     * @param int $ids
     * @return bool
     */
    public function delete(int $ids): bool
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