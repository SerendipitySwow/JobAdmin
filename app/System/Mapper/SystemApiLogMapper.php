<?php
declare(strict_types=1);
namespace App\System\Mapper;

use App\System\Model\SystemApiLog;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * Class SystemApiMapper
 * @package App\System\Mapper
 */
class SystemApiLogMapper extends AbstractMapper
{
    /**
     * @var SystemApiLog
     */
    public $model;

    public function assignModel()
    {
        $this->model = SystemApiLog::class;
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