<?php

declare(strict_types=1);
namespace App\System\Service;

use App\System\Mapper\SystemAppGroupMapper;
use Mine\Abstracts\AbstractService;

/**
 * app应用分组业务
 * Class SystemAppGroupService
 * @package App\System\Service
 */
class SystemAppGroupService extends AbstractService
{
    /**
     * @var SystemAppGroupMapper
     */
    public $mapper;

    public function __construct(SystemAppGroupMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}