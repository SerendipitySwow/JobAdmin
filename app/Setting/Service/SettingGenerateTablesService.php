<?php

declare(strict_types=1);
namespace App\Setting\Service;


use App\Setting\Mapper\SettingGenerateTablesMapper;
use Mine\Abstracts\AbstractService;

/**
 * 业务生成信息表业务处理类
 * Class SettingGenerateTablesService
 * @package App\Setting\Service
 */
class SettingGenerateTablesService extends AbstractService
{
    /**
     * @var SettingGenerateTablesMapper
     */
    public $mapper;

    /**
     * SettingGenerateTablesService constructor.
     * @param SettingGenerateTablesMapper $mapper
     */
    public function __construct(SettingGenerateTablesMapper $mapper)
    {
        $this->mapper = $mapper;
    }


}