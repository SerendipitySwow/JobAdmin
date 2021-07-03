<?php

declare(strict_types = 1);
namespace App\System\Controller\Permission;


use App\System\Request\Menu\SystemMenuCreateRequest;
use App\System\Service\SystemDeptService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Mine\Annotation\Auth;
use Mine\Annotation\OperationLog;
use Mine\Annotation\Permission;
use Mine\MineController;
use Psr\Http\Message\ResponseInterface;

/**
 * Class DeptController
 * @package App\System\Controller
 * @Controller(prefix="system/dept")
 * @Auth
 */
class DeptController extends MineController
{
    /**
     * @Inject
     * @var SystemDeptService
     */
    protected $service;

    /**
     * 获取部门树
     * @GetMapping("index")
     * @Permission("system:dept:index")
     */
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getTreeList($this->request->all()));
    }

    /**
     * 从回收站获取部门树
     * @GetMapping("recycleTree")
     * @Permission("system:dept:recycle")
     */
    public function recycleTree():ResponseInterface
    {
        return $this->success($this->service->getTreeListByRecycle($this->request->all()));
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
     * 新增部门
     * @PostMapping("save")
     * @param SystemMenuCreateRequest $request
     * @return ResponseInterface
     * @Permission("system:dept:save")
     * @OperationLog
     */
    public function save(SystemMenuCreateRequest $request): ResponseInterface
    {
        return $this->success(['id' => $this->service->save($request->all())]);
    }

    /**
     * 更新部门
     * @PutMapping("update/{id}")
     * @Permission("system:dept:update")
     * @param int $id
     * @param SystemMenuCreateRequest $request
     * @return ResponseInterface
     */
    public function update(int $id, SystemMenuCreateRequest $request): ResponseInterface
    {
        return $this->service->update($id, $request->all()) ? $this->success() : $this->error();
    }

    /**
     * 单个或批量删除部门到回收站
     * @DeleteMapping("delete/{ids}")
     * @param String $ids
     * @return ResponseInterface
     * @Permission("system:dept:delete")
     */
    public function delete(String $ids): ResponseInterface
    {
        return $this->service->delete($ids) ? $this->success() : $this->error();
    }

    /**
     * 单个或批量真实删除部门 （清空回收站）
     * @DeleteMapping("realDelete/{ids}")
     * @param String $ids
     * @return ResponseInterface
     * @Permission("system:dept:realDelete")
     * @OperationLog
     */
    public function realDelete(String $ids): ResponseInterface
    {
        $menus = $this->service->realDel($ids);
        return is_null($menus) ?
            $this->success() :
            $this->success(__('system.exists_children_ctu', ['names' => implode(',', $menus)]));
    }

    /**
     * 单个或批量恢复在回收站的部门
     * @PutMapping("recovery/{ids}")
     * @param String $ids
     * @return ResponseInterface
     * @Permission("system:dept:recovery")
     * @OperationLog
     */
    public function recovery(String $ids): ResponseInterface
    {
        return $this->service->recovery($ids) ? $this->success() : $this->error();
    }
}