<?php

declare(strict_types = 1);
namespace Mine\Traits;

use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Mine\Abstracts\AbstractService;
use Mine\Annotation\Permission;
use Psr\Http\Message\ResponseInterface;

trait ControllerTrait
{
    /**
     * @var AbstractService
     */
    protected $service;

    /**
     * 获取列表数据
     * @GetMapping("index")
     * @return ResponseInterface
     * @Permission
     */
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getPageList());
    }

    /**
     * 获取树型数据
     * @GetMapping("tree")
     * @return ResponseInterface
     * @Permission
     */
    public function tree()
    {
        return $this->success($this->service->getTreeList());
    }

    /**
     * 保存数据
     * @PostMapping("save")
     * @return ResponseInterface
     * @Permission
     */
    public function save(): ResponseInterface
    {
        return $this->success(['id' => $this->service->save($this->request->all())]);
    }

    /**
     * 获取一条数据信息
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
     * 更新数据
     * @PutMapping("update/{id}")
     * @param int $id
     * @return ResponseInterface
     * @Permission
     */
    public function update(int $id)
    {
        return $this->service->update($id, $this->request->all()) ? $this->success() : $this->error();
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