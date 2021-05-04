<?php
declare(strict_types=1);
namespace App\System\Service;


use App\System\Mapper\SystemMenuMapper;
use Mine\Abstracts\AbstractService;

class SystemMenuService extends AbstractService
{
    /**
     * @var SystemMenuMapper
     */
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