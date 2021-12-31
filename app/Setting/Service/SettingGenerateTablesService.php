<?php

declare(strict_types=1);
namespace App\Setting\Service;

use App\Setting\Mapper\SettingGenerateTablesMapper;
use App\Setting\Model\SettingGenerateTables;
use App\System\Service\DataMaintainService;
use Hyperf\Utils\Filesystem\Filesystem;
use Mine\Abstracts\AbstractService;
use Mine\Annotation\Transaction;
use Mine\Generator\ApiGenerator;
use Mine\Generator\ControllerGenerator;
use Mine\Generator\MapperGenerator;
use Mine\Generator\ModelGenerator;
use Mine\Generator\RequestGenerator;
use Mine\Generator\ServiceGenerator;
use Mine\Generator\SqlGenerator;
use Mine\Generator\VueIndexGenerator;
use Mine\Generator\VueSaveGenerator;
use Psr\Container\ContainerInterface;

/**
 * 业务生成信息表业务处理类
 * Class SettingGenerateTablesService
 * @package App\Setting\Service
 */
class SettingGenerateTablesService extends AbstractService
{
    /**
     * @var SettingGenerateTablesMapper
     */
    public $mapper;

    /**
     * @var DataMaintainService
     */
    protected $dataMaintainService;

    /**
     * @var SettingGenerateColumnsService
     */
    protected $settingGenerateColumnsService;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * SettingGenerateTablesService constructor.
     * @param SettingGenerateTablesMapper $mapper
     * @param DataMaintainService $dataMaintainService
     * @param SettingGenerateColumnsService $settingGenerateColumnsService
     * @param ContainerInterface $container
     */
    public function __construct(
        SettingGenerateTablesMapper $mapper,
        DataMaintainService $dataMaintainService,
        SettingGenerateColumnsService $settingGenerateColumnsService,
        ContainerInterface $container
    )
    {
        $this->mapper = $mapper;
        $this->dataMaintainService = $dataMaintainService;
        $this->settingGenerateColumnsService = $settingGenerateColumnsService;
        $this->container = $container;
    }

    /**
     * 装载数据表
     * @param array $names
     * @return bool
     * @Transaction
     */
    public function loadTable(array $names): bool
    {
        foreach ($names as $item) {
            $tableInfo = [
                'table_name' => $item['name'],
                'table_comment' => $item['comment'],
                'type' => 'single',
            ];
            $id = $this->save($tableInfo);

            $columns = $this->dataMaintainService->getColumnList($item['name']);

            foreach ($columns as &$column) {
                $column['table_id'] = $id;
            }
            $this->settingGenerateColumnsService->save($columns);
        }

        return true;
    }

    /**
     * 同步数据表
     * @param int $id
     * @return bool
     * @Transaction
     */
    public function sync(int $id): bool
    {
        $table = $this->read($id);
        $columns = $this->dataMaintainService->getColumnList(
            str_replace(env('DB_PREFIX'), '', $table['table_name'])
        );
        $model = $this->settingGenerateColumnsService->mapper->getModel();
        $ids = $model->newQuery()->where('table_id', $table['id'])->pluck('id');

        $this->settingGenerateColumnsService->mapper->delete($ids->toArray());
        foreach ($columns as &$column) {
            $column['table_id'] = $id;
        }
        $this->settingGenerateColumnsService->save($columns);
        return true;
    }

    /**
     * 更新业务表
     * @param array $data
     * @return bool
     * @Transaction
     */
    public function updateTableAndColumns(array $data): bool
    {
        $id = $data['id'];
        $columns = $data['columns'];

        unset($data['columns']);

        if (is_array($data['belong_menu_id'])) {
            $data['belong_menu_id'] = array_pop($data['belong_menu_id']);
        }

        $data['package_name'] = empty($data['package_name']) ? null : ucfirst($data['package_name']);
        $data['namespace'] = "App\\{$data['module_name']}";

        if (empty($data['options'])) {
            unset($data['options']);
        }

        // 更新业务表
        $this->update($id, $data);

        // 更新业务字段表
        foreach ($columns as $column) {
            $this->settingGenerateColumnsService->update($column['id'], $column);
        }
        return true;
    }

    /**
     * 生成代码
     * @param string $ids
     * @return string
     * @throws \Exception
     */
    public function generate(string $ids): string
    {
        $ids = explode(',', $ids);
        $this->initGenerateSetting();
        $adminId = user()->getId();
        foreach ($ids as $id) {
            $this->generateCodeFile((int) $id, $adminId);
        }

        return $this->packageCodeFile();
    }

    /**
     * 生成步骤
     * @param int $id
     * @param string $adminId
     * @return SettingGenerateTables
     * @throws \Exception
     */
    protected function generateCodeFile(int $id, string $adminId): SettingGenerateTables
    {
        /** @var SettingGenerateTables $model */
        $model = $this->read($id);

        $requestType = ['Create', 'Update'];

        $classList = [
            ControllerGenerator::class,
            ModelGenerator::class,
            ServiceGenerator::class,
            MapperGenerator::class,
            RequestGenerator::class,
            ApiGenerator::class,
            VueIndexGenerator::class,
            VueSaveGenerator::class,
            SqlGenerator::class
        ];

        foreach ($classList as $cls) {
            $class = make($cls);
            if (get_class($class) == 'Mine\Generator\RequestGenerator') {
                list($create, $update) = $requestType;
                $class->setGenInfo($model, $create)->generator();
                $class->setGenInfo($model, $update)->generator();
            } else if (get_class($class) == 'Mine\Generator\SqlGenerator'){
                $class->setGenInfo($model, $adminId)->generator();
            } else {
                $class->setGenInfo($model)->generator();
            }
        }

        return $model;
    }

    /**
     * 打包代码文件
     */
    protected function packageCodeFile(): string
    {
        $fs = $this->container->get(Filesystem::class);
        $zipFileName = BASE_PATH. '/runtime/mineadmin.zip';
        $path = BASE_PATH . '/runtime/generate';
        // 删除老的压缩包
        @unlink($zipFileName);
        $archive = new \ZipArchive();
        $archive->open($zipFileName, \ZipArchive::CREATE);
        $files = $fs->files($path);
        foreach ($files as $file) {
            $archive->addFile(
                $path . '/' . $file->getFilename(),
                $file->getFilename()
            );
        }
        $this->addZipFile($archive, $path);
        $archive->close();
        return $zipFileName;
    }

    protected function addZipFile(\ZipArchive $archive, string $path): void
    {
        $fs = $this->container->get(Filesystem::class);
        foreach ($fs->directories($path) as $directory) {
            if ($fs->isDirectory($directory)) {
                $archive->addEmptyDir(str_replace(BASE_PATH. '/runtime/generate/', '', $directory));
                $files = $fs->files($directory);
                foreach ($files as $file) {
                    $archive->addFile(
                        $directory . '/' . $file->getFilename(),
                        str_replace(
                            BASE_PATH. '/runtime/generate/', '', $directory
                        ) . '/' . $file->getFilename()
                    );
                }
                $this->addZipFile($archive, $directory);
            }
        }
    }

    /**
     * 初始化生成设置
     */
    protected function initGenerateSetting(): void
    {
        // 设置生成目录
        $genDirectory = BASE_PATH . '/runtime/generate';
        $fs = $this->container->get(Filesystem::class);

        // 先删除再创建
        $fs->cleanDirectory($genDirectory);
        $fs->deleteDirectory($genDirectory);
    }

    /**
     * 预览代码
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public function preview(int $id): array
    {
        /** @var SettingGenerateTables $model */
        $model = $this->read($id);

        return [
            [
                'tab_name' => 'Controller.php',
                'name' => 'controller',
                'code' => make(ControllerGenerator::class)->setGenInfo($model)->preview(),
                'lang' => 'php'
            ],
            [
                'tab_name' => 'Model.php',
                'name' => 'model',
                'code' => make(ModelGenerator::class)->setGenInfo($model)->preview(),
                'lang' => 'php',
            ],
            [
                'tab_name' => 'Service.php',
                'name' => 'service',
                'code' => make(ServiceGenerator::class)->setGenInfo($model)->preview(),
                'lang' => 'php',
            ],
            [
                'tab_name' => 'Mapper.php',
                'name' => 'mapper',
                'code' => make(MapperGenerator::class)->setGenInfo($model)->preview(),
                'lang' => 'php',
            ],
            [
                'tab_name' => 'CreateRequest.php',
                'name' => 'create_request',
                'code' => make(RequestGenerator::class)->setGenInfo($model, 'Create')->preview(),
                'lang' => 'php',
            ],
            [
                'tab_name' => 'UpdateRequest.php',
                'name' => 'update_request',
                'code' => make(RequestGenerator::class)->setGenInfo($model, 'Update')->preview(),
                'lang' => 'php',
            ],
            [
                'tab_name' => 'Api.js',
                'name' => 'api',
                'code' => make(ApiGenerator::class)->setGenInfo($model)->preview(),
                'lang' => 'javascript',
            ],
            [
                'tab_name' => 'Index.vue',
                'name' => 'index',
                'code' => make(VueIndexGenerator::class)->setGenInfo($model)->preview(),
                'lang' => 'vue',
            ],
            [
                'tab_name' => 'Save.vue',
                'name' => 'save',
                'code' => make(VueSaveGenerator::class)->setGenInfo($model)->preview(),
                'lang' => 'vue',
            ],
            [
                'tab_name' => 'Menu.sql',
                'name' => 'sql',
                'code' => make(SqlGenerator::class)->setGenInfo($model, user()->getId())->preview(),
                'lang' => 'sql',
            ],
        ];
    }
}