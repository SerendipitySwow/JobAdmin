<?php

declare(strict_types = 1);
namespace App\System\Service;


use App\System\Mapper\SystemDeptMapper;
use Mine\Abstracts\AbstractService;

class SystemDeptService extends AbstractService
{
    /**
     * @var SystemDeptMapper
     */
    public $mapper;

    public function __construct(SystemDeptMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}