<?php

declare(strict_types=1);
namespace App\System\Controller\DataCenter;

use App\System\Request\DictType\DictTypeCreateRequest;
use App\System\Service\SystemDictTypeService;
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
 * 字典类型控制器
 * Class LogsController
 * @package App\System\Controller\Logs
 * @Controller(prefix="system/dicktype")
 * @Auth
 */
class DictTypeController extends MineController
{
    /**
     * 登录日志服务
     * @Inject
     * @var SystemDictTypeService
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
     * 新增字典类型
     * @PostMapping("save")
     * @param DictTypeCreateRequest $request
     * @return ResponseInterface
     * @Permission()
     */
    public function save(DictTypeCreateRequest $request): ResponseInterface
    {
        return $this->success(['id' => $this->service->save($request->all())]);
    }

    /**
     * 获取一个字典类型数据
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
     * 更新一个字典类型
     * @PutMapping("update/{id}")
     * @param int $id
     * @param DictTypeCreateRequest $request
     * @return ResponseInterface
     * @Permission()
     */
    public function update(int $id, DictTypeCreateRequest $request): ResponseInterface
    {
        return $this->service->update($id, $request->all()) ? $this->success() : $this->error();
    }

    /**
     * 单个或批量字典数据
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

//    /**
//     * 更改用户状态
//     * @PutMapping("changeUserStatus")
//     * @param SystemUserStatusRequest $request
//     * @return ResponseInterface
//     */
//    public function changeUserStatus(SystemUserStatusRequest $request): ResponseInterface
//    {
//        $id = $request->input('id');
//        $status = $request->input('status');
//        return $this->success($this->service->changeUserStatus((int) $id, (string) $status));
//    }
}
