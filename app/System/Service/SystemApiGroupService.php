<?php

declare(strict_types=1);
namespace App\System\Service;

use App\System\Mapper\SystemApiGroupMapper;
use App\System\Model\SystemApiGroup;
use Mine\Abstracts\AbstractService;

/**
 * api接口分组业务
 * Class SystemApiGroupService
 * @package App\System\Service
 */
class SystemApiGroupService extends AbstractService
{
    /**
     * @var SystemApiGroupMapper
     */
    public $mapper;

    public function __construct(SystemApiGroupMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * 获取分组列表 无分页
     * @param array|null $params
     * @return array
     */
    public function getList(?array $params = null): array
    {
//        $params['select'] = 'id, name';
//        $params['status'] = '0';
        $ok = SystemApiGroup::query()->where('status', '0')->with(['apis' => function($query){
            $query->select(['id', 'name']);
        }])->get();

        foreach ($ok as $v) {
            print_r($v);
        }
        return parent::getList($params);
    }
}