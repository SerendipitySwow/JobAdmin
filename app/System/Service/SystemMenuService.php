<?php
declare(strict_types=1);
namespace App\System\Service;


use App\System\Mapper\SystemMenuMapper;

class SystemMenuService
{
    public $mapper;
    /**
     * SystemMenuMapper constructor.
     * @param SystemMenuMapper $mapper
     */
    public function __construct(SystemMenuMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}