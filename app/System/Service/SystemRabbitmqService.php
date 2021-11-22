<?php

declare(strict_types = 1);
namespace App\System\Service;

use App\System\Mapper\SystemRabbitmqMapper;
use Mine\Abstracts\AbstractService;

/**
 * 队列管理服务类
 */
class SystemRabbitmqService extends AbstractService
{
    /**
     * @var SystemRabbitmqMapper
     */
    public $mapper;

    public function __construct(SystemRabbitmqMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}