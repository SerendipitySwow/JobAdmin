<?php

declare(strict_types=1);
namespace App\System\Mapper;

use App\System\Model\SystemLoginLog;
use Hyperf\Database\Model\ModelNotFoundException;
use Mine\MineModelMapper;

/**
 * Class SystemUserMapper
 * @package App\System\Mapper
 */
class SystemLoginLogMapper extends MineModelMapper
{
    public function __construct(SystemLoginLog $model)
    {
        parent::__construct($model);
    }
}