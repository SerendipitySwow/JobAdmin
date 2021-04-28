<?php

declare(strict_types=1);
namespace App\System\Controller;

use App\System\Request\User\SystemUserCreateRequest;
use App\System\Request\User\SystemUserUpdateRequest;
use App\System\Service\SystemUserService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Mine\Annotation\Auth;
use Mine\Annotation\Permission;
use Mine\MineController;
use Psr\Http\Message\ResponseInterface;

/**
 * Class UserController
 * @package App\System\Controller
 * @Controller(prefix="system/user")
 * @Auth
 */
class UserController extends MineController
{

    /**
     * @Inject
     * @var SystemUserService
     */
    protected $systemUserService;

    /**
     * @GetMapping("getListPage")
     * @return ResponseInterface
     * @Permission()
     */
    public function getListPage(): ResponseInterface
    {
        return $this->success();
    }

    /**
     * 新增一个用户
     * @PostMapping("create")
     * @param SystemUserCreateRequest $request
     * @return ResponseInterface
     * @Permission()
     */
    public function create(SystemUserCreateRequest $request): ResponseInterface
    {
        return $this->success(['id' => $this->systemUserService->create($request->validated())]);
    }

    /**
     * 获取一个用户信息
     * @GetMapping("read/{id}")
     * @param int $id
     * @return ResponseInterface
     * @Permission()
     */
    public function read(int $id): ResponseInterface
    {
        $this->systemUserService->read($id);
        return $this->success();
    }

    /**
     * 更新一个用户信息
     * @PutMapping("update}")
     * @param SystemUserUpdateRequest $request
     * @return ResponseInterface
     * @Permission()
     */
    public function update(SystemUserUpdateRequest $request): ResponseInterface
    {
        return $this->success($this->systemUserService->update($request->validated()));
    }

    /**
     * 单个或批量删除用户到回收站
     * @DeleteMapping("delete/{ids}")
     * @param String $ids
     * @return ResponseInterface
     * @Permission()
     */
    public function delete(String $ids): ResponseInterface
    {
        return $this->systemUserService->delete($ids) ? $this->success() : $this->error();
    }

    /**
     * 单个或批量真实删除用户 （清空回收站）
     * @DeleteMapping("realDelete/{ids}")
     * @param String $ids
     * @return ResponseInterface
     * @Permission()
     */
    public function realDelete(String $ids): ResponseInterface
    {
        return $this->systemUserService->realDelete($ids) ? $this->success() : $this->error();
    }

    /**
     * 单个或批量恢复在回收站的用户
     * @PutMapping("recovery/{ids}")
     * @param String $ids
     * @return ResponseInterface
     * @Permission()
     */
    public function recovery(String $ids): ResponseInterface
    {
        return $this->systemUserService->recovery($ids) ? $this->success() : $this->error();
    }
}