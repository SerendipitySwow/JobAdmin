<?php
declare(strict_types = 1);
namespace App\System\Controller;

use App\System\Request\Menu\SystemMenuCreateRequest;
use App\System\Service\SystemMenuService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Mine\Annotation\Auth;
use Mine\Annotation\Permission;
use Mine\MineController;
use Psr\Http\Message\ResponseInterface;

/**
 * Class MenuController
 * @package App\System\Controller
 * @Controller(prefix="system/menu")
 * @Auth
 */
class MenuController extends MineController
{
    /**
     * @Inject
     * @var SystemMenuService
     */
    protected $service;

    /**
     * 获取菜单树
     * @GetMapping("index")
     * @Permission
     */
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getTreeList());
    }

    /**
     * 前端选择树（不需要权限）
     * @GetMapping("selectTree")
     */
    public function selectTree(): ResponseInterface
    {
        return $this->success($this->service->getSelectTree());
    }

    /**
     * 新增菜单
     * @PostMapping("save")
     * @param SystemMenuCreateRequest $request
     * @return ResponseInterface
     * @Permission
     */
    public function save(SystemMenuCreateRequest $request): ResponseInterface
    {
        return $this->success(['id' => $this->service->save($request->all())]);
    }

    /**
     * 从回收站获取菜单树
     * @GetMapping("getRecycle")
     * @Permission
     */
    public function getRecycle():ResponseInterface
    {
        return $this->success($this->service->getTreeListByRecycle());
    }
}