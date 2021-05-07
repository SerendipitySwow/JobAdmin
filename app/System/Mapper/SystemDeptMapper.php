<?php

declare(strict_types = 1);
namespace App\System\Mapper;


use App\System\Model\SystemDept;
use Mine\Abstracts\AbstractMapper;

class SystemDeptMapper extends AbstractMapper
{
    /**
     * @var SystemDept
     */
    public $model;

    public function assignModel()
    {
        $this->model = SystemDept::class;
    }
}