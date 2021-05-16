<?php

declare (strict_types = 1);
namespace Mine\Traits;

use Hyperf\Database\Model\Builder;
use Mine\MineModel;

trait MapperTrait
{
    /**
     * @var MineModel
     */
    public $model;

    /**
     * 获取列表数据
     * @param array|null $params
     * @return array
     */
    public function getList(?array $params): array
    {
        return $this->listQuerySetting($params)->get()->toArray();
    }

    /**
     * 获取列表数据（带分页）
     * @param array|null $params
     * @param string $pageName
     * @return array
     */
    public function getPageList(?array $params, string $pageName = 'page'): array
    {
        $paginate = $this->listQuerySetting($params)->paginate(
            $params['page_size'] ?? $this->model::PAGE_SIZE, ['*'], $pageName, $params[$pageName] ?? 1
        );
        return [
            'total' => $paginate->total(),
            'current_page' => $paginate->currentPage(),
            'total_page' => ceil($paginate->total() / ($params['page_size'] ?? $this->model::PAGE_SIZE)),
            'items' => $paginate->items()
        ];
    }

    /**
     * 获取树列表
     * @param array|null $params
     * @param int $parentId
     * @param string $id
     * @param string $parentField
     * @param string $children
     * @return array
     */
    public function getTreeList(
        ?array $params = null,
        int $parentId = 0,
        string $id = 'id',
        string $parentField = 'parent_id',
        string $children='children'
    ): array
    {
        return $this->listQuerySetting($params)->get()
            ->toTree([], $parentId, $id, $parentField, $children);
    }

    /**
     * 返回模型查询构造器
     * @param array|null $params
     * @return Builder
     */
    protected function listQuerySetting(?array $params = null): Builder
    {
        $query = (($params['recycle'] ?? false) === true) ? $this->model::onlyTrashed() : $this->model::query();

        if ($params['select'] ?? false) {
            $query = $query->select($this->filterAttributes($params['select']));
        }

        if ($params['order_by'] ?? false) {
            $query = $query->orderBy($params['order_by'], $params['order_type'] ?? 'asc');
        }

        if ($params['query_raw'] ?? false) {
            $query = $query->whereRaw($params['query_raw']);
        }

        return $query;
    }

    /**
     * 过滤属性
     * @param array $fields
     * @param bool $removePk
     * @return array
     */
    protected function filterAttributes(array $fields, bool $removePk = false): array
    {
        $model = new $this->model;
        $attrs = $model->getFillable();
        foreach ($fields as $key => $field) {
            if (!in_array(trim($field), $attrs)) {
                unset($fields[$key]);
            } else {
                $fields[$key] = trim($field);
            }
        }
        if ($removePk && in_array($model->getKeyName(), $fields)) {
            unset($fields[array_search($model->getKeyName(), $fields)]);
        }
        $model = null;
        return ( count($fields) < 1 ) ? ['*'] : $fields;
    }

    /**
     * 新增数据
     * @param array $data
     * @return int
     */
    public function save(array $data)
    {
        $model = $this->model::create($data);
        return $model->{$model->getKeyName()};
    }

    /**
     * 读取一条数据
     * @param int $id
     * @return MineModel
     */
    public function read(int $id)
    {
        return $this->model::find($id);
    }

    /**
     * 从回收站读取一条数据
     * @param int $id
     * @return MineModel
     * @noinspection PhpUnused
     */
    public function readByRecycle(int $id)
    {
        return $this->model::withTrashed()->find($id);
    }

    /**
     * 单个或批量软删除数据
     * @param array $ids
     * @return bool
     */
    public function delete(array $ids)
    {
        $this->model::destroy($ids);
        return true;
    }

    /**
     * 更新一条数据
     * @param int $id
     * @param array $data
     * @return boolm
     */
    public function update(int $id, array $data)
    {
        $this->filterPk($data);
        return $this->model->where((new $this->model)->getKeyName(), $id)->update($data);
    }

    /**
     * 过滤主键
     */
    public function filterPk(&$data)
    {
        $model = new $this->model;
        if (isset($data[$model->getKeyName()])) {
            unset($data[$model->getKeyName()]);
        }
        $model = null;
    }

    /**
     * 单个或批量真实删除数据
     * @param array $ids
     * @return bool
     */
    public function realDelete(array $ids)
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
    public function recovery(array $ids)
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
    public function disable(array $ids, string $field = 'status')
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
    public function enable(array $ids, string $field = 'status')
    {
        $this->model::query()->whereIn((new $this->model)->getKeyName(), $ids)->update([$field => $this->model::ENABLE]);
        return true;
    }

    /**
     * @return MineModel
     */
    public function getModel(): MineModel
    {
        return $this->model;
    }
}