<?php

declare(strict_types=1);
namespace App\Setting\Service;

use App\Setting\Mapper\SettingCrontabMapper;
use Mine\Abstracts\AbstractService;

class SettingCrontabService extends AbstractService
{
    /**
     * @var SettingCrontabMapper
     */
    public $mapper;

    public function __construct(SettingCrontabMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}