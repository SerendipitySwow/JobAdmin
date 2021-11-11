<?php

declare(strict_types=1);
namespace App\System\Service;

use App\System\Mapper\SystemApiMapper;
use Mine\Abstracts\AbstractService;

/**
 * api接口业务
 * Class SystemAppService
 * @package App\System\Service
 */
class SystemApiService extends AbstractService
{
    /**
     * @var SystemApiMapper
     */
    public $mapper;

    public function __construct(SystemApiMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}