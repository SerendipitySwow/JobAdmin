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
        return $query;
    }
}