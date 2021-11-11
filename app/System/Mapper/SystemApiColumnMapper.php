<?php
declare(strict_types=1);
namespace App\System\Mapper;

use App\System\Model\SystemApiGroup;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * Class SystemApiColumnMapper
 * @package App\System\Mapper
 */
class SystemApiColumnMapper extends AbstractMapper
{
    /**
     * @var SystemApiGroup
     */
    public $model;

    public function assignModel()
    {
        $this->model = SystemApiGroup::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        return $query;
    }
}