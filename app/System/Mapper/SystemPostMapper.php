<?php

declare(strict_types = 1);
namespace App\System\Mapper;


use App\System\Model\SystemPost;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

class SystemPostMapper extends AbstractMapper
{
    /**
     * @var SystemPost
     */
    public $model;

    public function assignModel()
    {
        $this->model = SystemPost::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if (isset($params['name'])) {
            $query->where('name', 'like', '%'.$params['name'].'%');
        }
        if (isset($params['code'])) {
            $query->where('code', $params['code']);
        }
        if (isset($params['status'])) {
            $query->where('status', $params['status']);
        } else {
            $query->where('status', $this->model::ENABLE);
        }
        return $query;
    }
}