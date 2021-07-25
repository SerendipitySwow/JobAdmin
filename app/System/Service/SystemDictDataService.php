<?php

declare(strict_types=1);
namespace App\System\Service;

use App\System\Mapper\SystemDictDataMapper;
use Mine\Abstracts\AbstractService;

/**
 * 字典类型业务
 * Class SystemLoginLogService
 * @package App\System\Service
 */
class SystemDictDataService extends AbstractService
{
    /**
     * @var SystemDictDataMapper
     */
    public $mapper;


    public function __construct(SystemDictDataMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function getList(?array $params = null): array
    {
        if (!isset($params['code'])) {
            return [];
        }
        $args = [
            'select' => 'id, label, value',
            'status' => '0',
            'orderBy' => 'sort',
            'orderType' => 'desc'
        ];
        return parent::getList(array_merge($args, $params));
    }
}
