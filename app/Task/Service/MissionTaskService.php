<?php

declare(strict_types = 1);
namespace App\Task\Service;

use App\Task\Mapper\MissionTaskMapper;
use Mine\Abstracts\AbstractService;

/**
 * 任务列表服务类
 */
class MissionTaskService extends AbstractService
{
    /**
     * @var MissionTaskMapper
     */
    public $mapper;

    public function __construct(MissionTaskMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}