<?php
declare(strict_types=1);
namespace App\Setting\Controller\Tools;

use App\Setting\Service\TableService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Mine\MineController;

/**
 * Class TableController
 * @package App\Setting\Controller\Tools
 * @Controller(prefix="setting/table")
 */
class TableController extends MineController
{
    /**
     * @Inject
     * @var TableService
     */
    public $service;

    /**
     * 获取系统信息
     * @GetMapping("getSystemInfo")
     */
    public function getSystemInfo(): \Psr\Http\Message\ResponseInterface
    {
        $this->mine->scanModule();
        return $this->success([
            'tablePrefix' => $this->service->getTablePrefix(),
            'modulesList' => $this->mine->getModuleInfo()
        ]);
    }
}