<?php

declare(strict_types=1);
namespace App\Setting\Service;

use App\Setting\Mapper\SettingGenerateColumnsMapper;
use Mine\Abstracts\AbstractService;

/**
 * 业务生成字段信息表业务处理类
 * Class SettingGenerateColumnsService
 * @package App\Setting\Service
 */
class SettingGenerateColumnsService extends AbstractService
{
    /**
     * @var SettingGenerateColumnsMapper
     */
    public $mapper;

    /**
     * SettingGenerateColumnsService constructor.
     * @param SettingGenerateColumnsMapper $mapper
     */
    public function __construct(SettingGenerateColumnsMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}