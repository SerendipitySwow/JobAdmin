<?php

declare(strict_types = 1);
namespace App\Task\Controller;

use App\Task\Service\MissionTaskService;
use App\Task\Request\MissionTaskCreateRequest;
use App\Task\Request\MissionTaskUpdateRequest;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Guzzle\ClientFactory;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use JetBrains\PhpStorm\ArrayShape;
use Mine\Annotation\Auth;
use Mine\Annotation\OperationLog;
use Mine\Annotation\Permission;
use Mine\MineController;
use Psr\Http\Message\ResponseInterface;

/**
 * 任务列表控制器
 * Class MissionTaskController
 * @Controller(prefix="task/mission")
 * @Auth
 */
class MissionTaskController extends MineController
{
    /**
     * @Inject
     * @var MissionTaskService
     */
    protected $service;

    /**
     * 列表
     * @GetMapping("index")
     * @return ResponseInterface
     * @Permission("task:mission:index")
     */
    public function index() : ResponseInterface
    {
        return $this->success($this->service->getPageList($this->request->all()));
    }

    /**
     * 回收站列表
     * @GetMapping("recycle")
     * @return ResponseInterface
     * @Permission("task:mission:recycle")
     */
    public function recycle() : ResponseInterface
    {
        return $this->success($this->service->getPageListByRecycle($this->request->all()));
    }

    /**
     * 新增
     * @PostMapping("save")
     *
     * @param MissionTaskCreateRequest $request
     *
     * @return ResponseInterface
     * @Permission("task:mission:save")
     * @OperationLog
     */
    public function save(MissionTaskCreateRequest $request) : ResponseInterface
    {
        return $this->success(['id' => $this->service->save($request->all())]);
    }

    /**
     * 读取数据
     * @PostMapping ("read")
     *
     * @param \App\Task\Request\MissionTaskCreateRequest $request
     *
     * @return ResponseInterface
     * @Permission("task:mission:read")
     */
    public function read(MissionTaskCreateRequest $request) : ResponseInterface
    {
        $params = $request->all();
        try {
            $ret    = $this->getContainer()->get(ClientFactory::class)->create()->get(sprintf('%s:%s/%s/%s', env('JOB_SERVER_HOST'), env('JOB_SERVER_PORT'), 'task', 'detail'), [
                'query'   => [
                    'coroutine_id' => $params['coroutine_id'] ?? 0,
                    'id'           => $params['id'] ?? 0,
                    'serivice_id'  => $params['service_id'] ?? '',
                ],
                'headers' => $this->getSignature()
            ]);
            return $this->success($ret['data']??[]);
        }catch (\Throwable $exception){
            return  $this->error($exception->getMessage());
        }

    }

    /**
     * 更新
     * @PutMapping("update/{id}")
     *
     * @param int                      $id
     * @param MissionTaskUpdateRequest $request
     *
     * @return ResponseInterface
     * @Permission("task:mission:update")
     * @OperationLog
     */
    public function update(int $id, MissionTaskUpdateRequest $request) : ResponseInterface
    {
        return $this->service->update($id, $request->all()) ? $this->success() : $this->error();
    }

    /**
     * 单个或批量删除数据到回收站
     * @DeleteMapping("delete/{ids}")
     *
     * @param String $ids
     *
     * @return ResponseInterface
     * @Permission("task:mission:delete")
     * @OperationLog
     */
    public function delete(string $ids) : ResponseInterface
    {
        return $this->service->delete($ids) ? $this->success() : $this->error();
    }

    /**
     * 单个或批量真实删除数据 （清空回收站）
     * @DeleteMapping("realDelete/{ids}")
     *
     * @param String $ids
     *
     * @return ResponseInterface
     * @Permission("task:mission:realDelete")
     * @OperationLog
     */
    public function realDelete(string $ids) : ResponseInterface
    {
        return $this->service->realDelete($ids) ? $this->success() : $this->error();
    }

    /**
     * 单个或批量恢复在回收站的数据
     * @PutMapping("recovery/{ids}")
     *
     * @param String $ids
     *
     * @return ResponseInterface
     * @Permission("task:mission:recovery")
     * @OperationLog
     */
    public function recovery(string $ids) : ResponseInterface
    {
        return $this->service->recovery($ids) ? $this->success() : $this->error();
    }

    /**
     * @return string[]
     */
    private function getSignature() : array
    {
        //TODO
        return [
            'nonce'      => 'jcpxB9oadf6al6Tv',
            'timestamps' => '1639044971',
            'signature'  => 'MDcwYmNkZjc2ZThhYmYxNWUwYmNlZWFkNmE1YjU2M2U3MDQxNWNkN2RkN2QyMmVjODhhNDE3MGU5MzEyZTkyNQ==',
            'app_key'    => 'svpC69glRX0eJUqw',
            'payload'    => '57bcd60eefcac9701fd2407080a5a7b0',
            'secretKey'  => 'pOKCTaHwMZaKPk3lfbVYfW07NuFjMAXX'
        ];
    }

}
