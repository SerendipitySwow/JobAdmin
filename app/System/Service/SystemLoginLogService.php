<?php

declare(strict_types=1);
namespace App\System\Service;

use App\System\Mapper\SystemLoginLogMapper;
use Mine\MineModelService;

/**
 * 登录日志业务
 * Class SystemLoginLogService
 * @package App\System\Service
 */
class SystemLoginLogService
{
    public $mapper;

    public function __construct(SystemLoginLogMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function save(array $data)
    {
        return $this->mapper->save($data);
    }
}