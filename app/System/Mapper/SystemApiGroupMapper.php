<?php
declare(strict_types=1);
namespace App\System\Mapper;

use App\System\Model\SystemApiColumn;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * Class SystemApiGroupMapper
 * @package App\System\Mapper
 */
class SystemApiGroupMapper extends AbstractMapper
{
    /**
     * @var SystemApiColumn
     */
    public $model;

    public function assignModel()
    {
        $this->model = SystemApiColumn::class;
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