<?php
declare(strict_types=1);
namespace App\System\Mapper;

use App\System\Model\SystemDictType;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * Class SystemUserMapper
 * @package App\System\Mapper
 */
class SystemDictTypeMapper extends AbstractMapper
{
    /**
     * @var SystemDictType
     */
    public $model;

    public function assignModel()
    {
        $this->model = SystemDictType::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if (isset($params['code'])) {
            $query->where('code', 'like', '%'.$params['code'].'%');
        }
        if (isset($params['name'])) {
            $query->where('name', 'like', '%'.$params['name'].'%');
        }
        if (isset($params['status'])) {
            $query->where('status', $params['status']);
        }
        return $query;
    }
}