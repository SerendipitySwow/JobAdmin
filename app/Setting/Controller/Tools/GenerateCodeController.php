<?php

declare(strict_types = 1);
namespace App\Setting\Controller\Tools;

use App\Setting\Request\Tool\LoadTableRequest;
use App\Setting\Service\SettingGenerateColumnsService;
use App\Setting\Service\SettingGenerateTablesService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Mine\Annotation\Auth;
use Mine\MineController;

/**
 * 代码生成器控制器
 * Class CodeController
 * @package App\Setting\Controller\Tools
 * @Controller(prefix="setting/code")
 * @Auth
 */
class GenerateCodeController extends MineController
{
    /**
     * 信息表服务
     * @Inject
     * @var SettingGenerateTablesService
     */
    protected $tableService;

    /**
     * 信息字段表服务
     * @Inject
     * @var SettingGenerateColumnsService
     */
    protected $columnService;

    /**
     * 代码生成列表分页
     * @GetMapping("index")
     */
    public function index(): \Psr\Http\Message\ResponseInterface
    {
        return $this->success($this->tableService->getPageList($this->request->All()));
    }

    /**
     * 预览代码
     * @GetMapping("preview")
     */
    public function preview()
    {

    }

    /**
     * 生成代码
     * @PostMapping("generate")
     */
    public function generate()
    {

    }

    /**
     * 加载数据表
     * @PostMapping("loadTable")
     *
     */
    public function loadTable(LoadTableRequest $request): \Psr\Http\Message\ResponseInterface
    {
        return $this->tableService->loadTable($request->input('names')) ? $this->success() : $this->error();
    }

    /**
     * 删除代码生成表
     * @DeleteMapping("delete/{ids}")
     */
    public function delete()
    {

    }

    /**
     * 同步数据库中的表信息跟字段
     * @PutMapping("sync/{ids}")
     */
    public function sync()
    {

    }
}