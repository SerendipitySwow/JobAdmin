<?php

declare(strict_types=1);
namespace App\System\Service;

use App\System\Mapper\SystemUserMapper;
use Mine\MineModelService;

/**
 * 登录日志业务
 * Class SystemLoginLogService
 * @package App\System\Service
 */
class SystemLoginLogService extends MineModelService
{
    public function __construct(SystemUserMapper $mapper)
    {
        parent::__construct($mapper);
    }
}