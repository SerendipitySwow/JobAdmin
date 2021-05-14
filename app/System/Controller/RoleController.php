<?php

declare(strict_types = 1);
namespace App\System\Controller;

use App\System\Request\Role\SystemRoleCreateRequest;
use App\System\Service\SystemRoleService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Mine\Annotation\Auth;
use Mine\Annotation\Permission;
use Mine\MineController;
use Mine\Traits\ControllerTrait;
use Psr\Http\Message\ResponseInterface;

/**
 * Class RoleController
 * @package App\System\Controller
 * @Controller(prefix="system/role")
 * @Auth
 */
class RoleController extends MineController
{
    use ControllerTrait;

    /**
     * @Inject
     * @var SystemRoleService
     */
    protected $service;

    /**
     * 获取角色列表
     * @GetMapping("index")
     * @Permission
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getPageList());
    }

    /**
     * 新增角色
     * @PostMapping("save")
     * @param SystemRoleCreateRequest $request
     * @return ResponseInterface
     * @Permission
     */
    public function save(SystemRoleCreateRequest $request): ResponseInterface
    {
        return $this->success(['id' => $this->service->save($request->all())]);
    }

    /**
     * 更新角色
     * @PutMapping("update/{id}")
     * @param int $id
     * @param SystemRoleCreateRequest $request
     * @return ResponseInterface
     * @Permission
     */
    public function update(int $id, SystemRoleCreateRequest $request): ResponseInterface
    {
        return $this->service->update($id, $request->all()) ? $this->success() : $this->error();
    }

    /**
     * 单个或批量删除数据到回收站
     * @DeleteMapping("delete/{ids}")
     * @param String $ids
     * @return ResponseInterface
     * @Permission()
     */
    public function delete(String $ids): ResponseInterface
    {
        return $this->service->delete($ids) ? $this->success() : $this->error();
    }

    /**
     * 单个或批量真实删除数据 （清空回收站）
     * @DeleteMapping("realDelete/{ids}")
     * @param String $ids
     * @return ResponseInterface
     * @Permission()
     */
    public function realDelete(String $ids): ResponseInterface
    {
        return $this->service->realDelete($ids) ? $this->success() : $this->error();
    }

    /**
     * 单个或批量恢复在回收站的数据
     * @PutMapping("recovery/{ids}")
     * @param String $ids
     * @return ResponseInterface
     * @Permission()
     */
    public function recovery(String $ids): ResponseInterface
    {
        return $this->service->recovery($ids) ? $this->success() : $this->error();
    }
}