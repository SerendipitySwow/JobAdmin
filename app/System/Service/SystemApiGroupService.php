<?php

declare(strict_types=1);
namespace App\System\Service;

use App\System\Mapper\SystemApiGroupMapper;
use Mine\Abstracts\AbstractService;

/**
 * api接口分组业务
 * Class SystemApiGroupService
 * @package App\System\Service
 */
class SystemApiGroupService extends AbstractService
{
    /**
     * @var SystemApiGroupMapper
     */
    public $mapper;

    public function __construct(SystemApiGroupMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}