<?php

declare(strict_types=1);
namespace App\System\Controller;

use App\System\Request\User\SystemUserCreateRequest;
use App\System\Request\User\SystemUserStatusRequest;
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
    protected $service;

    /**
     * @GetMapping("index")
     * @return ResponseInterface
     * @Permission()
     */
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getPageList($this->request->all()));
    }

    /**
     * @GetMapping("recycle")
     * @return ResponseInterface
     * @Permission()
     */
    public function recycle(): ResponseInterface
    {
        return $this->success($this->service->getPageListByRecycle($this->request->all()));
    }

    /**
     * 新增一个用户
     * @PostMapping("save")
     * @param SystemUserCreateRequest $request
     * @return ResponseInterface
     * @Permission()
     */
    public function save(SystemUserCreateRequest $request): ResponseInterface
    {
        return $this->success(['id' => $this->service->save($request->all())]);
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
        return $this->success($this->service->read($id));
    }

    /**
     * 更新一个用户信息
     * @PutMapping("update/{id}")
     * @param int $id
     * @param SystemUserUpdateRequest $request
     * @return ResponseInterface
     * @Permission()
     */
    public function update(int $id, SystemUserUpdateRequest $request): ResponseInterface
    {
        return $this->service->update($id, $request->all()) ? $this->success() : $this->error();
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
        return $this->service->delete($ids) ? $this->success() : $this->error();
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
        return $this->service->realDelete($ids) ? $this->success() : $this->error();
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
        return $this->service->recovery($ids) ? $this->success() : $this->error();
    }

    /**
     * 更改用户状态
     * @PutMapping("changeUserStatus")
     * @param SystemUserStatusRequest $request
     * @return ResponseInterface
     */
    public function changeUserStatus(SystemUserStatusRequest $request): ResponseInterface
    {
        $id = $request->input('id');
        $status = $request->input('status');
        return $this->success($this->service->changeUserStatus((int) $id, (string) $status));
    }

    /**
     * 初始化用户密码
     * @PutMapping("initUserPassword/{id}")
     * @param String $id
     * @return ResponseInterface
     */
    public function initUserPassword(String $id): ResponseInterface
    {
        return $this->service->initUserPassword((int) $id) ? $this->success() : $this->error();
    }
}