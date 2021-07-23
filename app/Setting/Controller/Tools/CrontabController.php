<?php

declare(strict_types=1);
namespace App\Setting\Controller\Tools;

use App\Setting\Request\Tool\SettingCrontabCreateRequest;
use App\Setting\Service\SettingCrontabService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Mine\Annotation\OperationLog;
use Mine\Annotation\Permission;
use Mine\MineController;
use Psr\Http\Message\ResponseInterface;

/**
 * 定时任务控制器
 * Class CrontabController
 * @package App\Setting\Controller\Tools
 * @Controller(prefix="setting/crontab")
 */
class CrontabController extends MineController
{
    /**
     * @Inject
     * @var SettingCrontabService
     */
    protected $service;

    /**
     * 获取列表分页数据
     * @GetMapping("index")
     * @return ResponseInterface
     * @Permission("system:crontab:index")
     */
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getPageList($this->request->all()));
    }

    /**
     * @GetMapping("recycle")
     * @return ResponseInterface
     * @Permission("system:crontab:recycle")
     */
    public function recycle(): ResponseInterface
    {
        return $this->success($this->service->getPageListByRecycle($this->request->all()));
    }

    /**
     * 保存数据
     * @PostMapping("save")
     * @param SettingCrontabCreateRequest $request
     * @return ResponseInterface
     * @Permission("system:crontab:save")
     * @OperationLog
     */
    public function save(SettingCrontabCreateRequest $request): ResponseInterface
    {
        return $this->success(['id' => $this->service->save($request->all())]);
    }

    /**
     * 获取一条数据信息
     * @GetMapping("read/{id}")
     * @param int $id
     * @return ResponseInterface
     * @Permission("system:crontab:read")
     */
    public function read(int $id): ResponseInterface
    {
        return $this->success($this->service->read($id));
    }

    /**
     * 更新数据
     * @PutMapping("update/{id}")
     * @param int $id
     * @param SettingCrontabCreateRequest $request
     * @return ResponseInterface
     * @Permission("system:crontab:update")
     */
    public function update(int $id, SettingCrontabCreateRequest $request): ResponseInterface
    {
        return $this->service->update($id, $request->all()) ? $this->success() : $this->error();
    }

    /**
     * 单个或批量删除数据到回收站
     * @DeleteMapping("delete/{ids}")
     * @param String $ids
     * @return ResponseInterface
     * @Permission("system:crontab:delete")
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
     * @Permission("system:crontab:realDelete")
     * @OperationLog
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
     * @Permission("system:crontab:recovery")
     */
    public function recovery(String $ids): ResponseInterface
    {
        return $this->service->recovery($ids) ? $this->success() : $this->error();
    }
}