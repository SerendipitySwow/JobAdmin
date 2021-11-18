<?php

declare(strict_types=1);
namespace App\System\Service;

use App\System\Mapper\SystemAppMapper;
use Mine\Abstracts\AbstractService;
use Mine\Helper\Str;

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

    /**
     * 生成新的app id
     * @return string
     */
    public function getAppId(): string
    {
        return Str::random(4, 0) . Str::random(4, 1).Str::random(2, 0);
    }

    /**
     * 生成新的app secret
     * @return string
     */
    public function getAppSecret(): string
    {

        return '';
    }
}