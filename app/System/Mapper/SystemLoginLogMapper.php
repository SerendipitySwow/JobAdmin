<?php
declare(strict_types=1);
namespace App\System\Mapper;

use App\System\Model\SystemLoginLog;

/**
 * Class SystemUserMapper
 * @package App\System\Mapper
 */
class SystemLoginLogMapper
{
    /**
     * @param array $data
     * @return SystemLoginLog|\Hyperf\Database\Model\Model
     */
    public function save(array $data)
    {
        return SystemLoginLog::create($data);
    }
}