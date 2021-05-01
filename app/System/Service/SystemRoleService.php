<?php


namespace App\System\Service;


use App\System\Mapper\SystemRoleMapper;
use Mine\Abstracts\AbstractService;

class SystemRoleService extends AbstractService
{
    public $mapper;

    public function __construct(SystemRoleMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}