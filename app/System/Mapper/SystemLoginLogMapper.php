<?php
declare(strict_types=1);
namespace App\System\Mapper;

use App\System\Model\SystemLoginLog;
use App\System\Model\SystemUser;
use Mine\Abstracts\AbstractMapper;

/**
 * Class SystemUserMapper
 * @package App\System\Mapper
 */
class SystemLoginLogMapper extends AbstractMapper
{
    /**
     * @var SystemLoginLog
     */
    public $model;

    public function assignModel()
    {
        $this->model = SystemLoginLog::class;
    }
}