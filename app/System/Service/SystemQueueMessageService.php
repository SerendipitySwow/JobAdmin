<?php

declare(strict_types = 1);

namespace App\System\Service;

use App\System\Mapper\SystemQueueMessageMapper;
use Mine\Abstracts\AbstractService;

/**
 * 信息管理服务类
 */
class SystemQueueMessageService extends AbstractService
{
    /**
     * @var SystemQueueMessageMapper
     */
    public $mapper;

    public function __construct(SystemQueueMessageMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * 获取收信箱列表数据
     */
    public function getReceiveMessage(array $params = []): array
    {
        $params['getReceive'] = true;
        return $this->mapper->getPageList($params, false);
    }
}
