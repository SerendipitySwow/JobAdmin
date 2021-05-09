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
use Mine\Traits\ControllerTrait;
use Psr\Http\Message\ResponseInterface;

/**
 * Class UserController
 * @package App\System\Controller
 * @Controller(prefix="system/user")
 * @Auth
 */
class UserController extends MineController
{
    use ControllerTrait;
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
        return $this->success($this->service->getPageList());
    }

    /**
     * 新增一个用户
     * @PostMapping("create")
     * @param SystemUserCreateRequest $request
     * @return ResponseInterface
     * @Permission()
     */
    public function save(SystemUserCreateRequest $request): ResponseInterface
    {
        return $this->success(['id' => $this->service->save($request->all())]);
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
}