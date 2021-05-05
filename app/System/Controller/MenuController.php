<?php
declare(strict_types = 1);
namespace App\System\Controller;

use App\System\Service\SystemMenuService;
use Hyperf\HttpServer\Annotation\Controller;
use Mine\Annotation\Auth;
use Mine\MineController;
use Psr\Http\Message\ResponseInterface;

/**
 * Class MenuController
 * @package App\System\Controller
 * @Controller(perfix="system/menu")
 * @Auth
 */
class MenuController extends MineController
{
    /**
     * @Inject
     * @var SystemMenuService
     */
    protected $systemMenuService;

    /**
     * 获取菜单树
     * @GetMapping("getTree")
     * @Permission
     */
    public function getTree(): ResponseInterface
    {
        return $this->success($this->systemMenuService->getTreeList());
    }
}