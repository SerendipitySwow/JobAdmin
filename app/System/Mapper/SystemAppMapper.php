<?php
declare(strict_types=1);
namespace App\System\Mapper;

use App\System\Model\SystemApp;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * Class SystemAppMapper
 * @package App\System\Mapper
 */
class SystemAppMapper extends AbstractMapper
{
    /**
     * @var SystemApp
     */
    public $model;

    public function assignModel()
    {
        $this->model = SystemApp::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if (isset($params['app_name'])) {
            $query->where('app_name', $params['app_name']);
        }

        if (isset($params['app_id'])) {
            $query->where('app_id', $params['app_id']);
        }

        if (isset($params['group_id'])) {
            $query->where('group_id', $params['group_id']);
        }

        if (isset($params['status'])) {
            $query->where('status', $params['status']);
        }
        return $query;
    }

    /**
     * 绑定接口
     * @param int $id
     * @param array $ids
     * @return bool
     */
    public function bind(int $id, array $ids): bool
    {
        $model = $this->read($id);
        $model && $model->apis()->sync($ids);
        return true;
    }
}