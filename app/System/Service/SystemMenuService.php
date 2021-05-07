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

    /**
     * @param array|null $params
     * @return array
     */
    public function getTreeList(?array $params = null): array
    {
        return parent::getTreeList(['order_by' => 'sort', 'order_type' => 'desc']);
    }

    /**
     * @param array|null $params
     * @return array
     */
    public function getTreeListByRecycle(?array $params = null): array
    {
        return parent::getTreeListByRecycle(['order_by' => 'sort', 'order_type' => 'desc']);
    }

    /**
     * @param string $code
     * @return string
     */
    public function findNameByCode(string $code): string
    {
        if (strlen($code) < 1) {
            return __('system.undefined_menu');
        }
        $name = $this->mapper->findNameByCode($code);
        return $name ? $name : __('system.undefined_menu');
    }
}