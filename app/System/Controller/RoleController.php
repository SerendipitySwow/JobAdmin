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
     * @GetMapping("index")
     * @Permission
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getPageList());
    }

    /**
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
     */
    public function update(int $id, SystemRoleCreateRequest $request): ResponseInterface
    {
        return $this->service->update($id, $request->all()) ? $this->success() : $this->error();
    }
}