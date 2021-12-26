<?php

declare(strict_types = 1);
namespace App\System\Service;

use App\System\Mapper\SystemQueueLogMapper;
use Mine\Abstracts\AbstractService;

/**
 * 队列管理服务类
 */
class SystemQueueLogService extends AbstractService
{
    /**
     * @var SystemQueueLogMapper
     */
    public $mapper;

    public function __construct(SystemQueueLogMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * 修改队列日志的生产状态
     * @param string $ids
     * @return bool
     */
    public function updateProduceStatus(string $ids): bool
    {
        // TODO...
        return true;
    }
}