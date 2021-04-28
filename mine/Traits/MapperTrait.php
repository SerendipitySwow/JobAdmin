<?php

declare (strict_types = 1);
namespace Mine\Traits;

use Mine\MineModel;

trait MapperTrait
{
    /**
     * @var MineModel
     */
    public $model;

    /**
     * 新增数据
     * @param array $data
     * @return int
     */
    public function save(array $data): int
    {
        $model = $this->model::create($data);
        return $model->{$model->getKeyName()};
    }

    /**
     * 读取一条数据
     * @param int $id
     * @return MineModel
     */
    public function read(int $id): MineModel
    {
        return $this->model::find($id);
    }

    /**
     * 从回收站读取一条数据
     * @param int $id
     * @return MineModel
     * @noinspection PhpUnused
     */
    public function readByRecycle(int $id): MineModel
    {
        return $this->model::withTrashed()->find($id);
    }

    /**
     * 单个或批量软删除数据
     * @param array $ids
     * @return bool
     */
    public function delete(array $ids): bool
    {
        $this->model::destroy($ids);
        return true;
    }

    /**
     * 更新一条数据
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $this->model->where((new $this->model)->getKeyName(), $id)->update($data);
        return true;
    }

    /**
     * 单个或批量真实删除数据
     * @param array $ids
     * @return bool
     */
    public function realDelete(array $ids): bool
    {
        foreach ($ids as $id) {
            $model = $this->model::withTrashed()->find($id);
            $model->forceDelete();
        }
        return true;
    }

    /**
     * 单个或批量从回收站恢复数据
     * @param array $ids
     * @return bool
     */
    public function recovery(array $ids): bool
    {
        $this->model::withTrashed()->whereIn((new $this->model)->getKeyName(), $ids)->restore();
        return true;
    }

    /**
     * 单个或批量禁用数据
     * @param array $ids
     * @param string $field
     * @return bool
     */
    public function disable(array $ids, string $field = 'status'): bool
    {
        $this->model::query()->whereIn((new $this->model)->getKeyName(), $ids)->update([$field => $this->model::DISABLE]);
        return true;
    }

    /**
     * 单个或批量启用数据
     * @param array $ids
     * @param string $field
     * @return bool
     */
    public function enable(array $ids, string $field = 'status'): bool
    {
        $this->model::query()->whereIn((new $this->model)->getKeyName(), $ids)->update([$field => $this->model::ENABLE]);
        return true;
    }
}