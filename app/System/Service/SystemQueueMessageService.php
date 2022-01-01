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
        unset($params['getSend']);
        return $this->mapper->getPageList($params, false);
    }

    /**
     * 获取已发送列表数据
     */
    public function getSendMessage(array $params = []): array
    {
        $params['getSend'] = true;
        unset($params['getReceive']);
        return $this->mapper->getPageList($params, false);
    }

    /**
     * 获取接收人列表
     * @param int $id
     * @return array
     */
    public function getReceiveUserList(int $id): array
    {
        return $this->mapper->getReceiveUserList($id);
    }
}
