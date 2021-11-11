<?php

declare(strict_types=1);
namespace App\System\Service;

use App\System\Mapper\SystemAppMapper;
use Mine\Abstracts\AbstractService;

/**
 * app应用业务
 * Class SystemAppService
 * @package App\System\Service
 */
class SystemAppService extends AbstractService
{
    /**
     * @var SystemAppMapper
     */
    public $mapper;

    public function __construct(SystemAppMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}