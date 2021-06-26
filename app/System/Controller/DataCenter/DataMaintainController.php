<?php


namespace App\System\Controller\DataCenter;


use App\System\Service\DataMaintainService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Mine\Annotation\Auth;
use Mine\Annotation\Permission;
use Mine\MineController;
use Psr\Http\Message\ResponseInterface;

/**
 * Class DataMaintainController
 * @package App\System\Controller\DataCenter
 * @Controller(prefix="system/dataMaintain")
 */
class DataMaintainController extends MineController
{
    /**
     * @Inject
     * @var DataMaintainService
     */
    public $service;

    /**
     * @GetMapping("index")
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getPageList($this->request->all()));
    }
}