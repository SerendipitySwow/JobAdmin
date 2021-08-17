<?php

declare(strict_types=1);
namespace App\Setting\Service;

use App\Setting\Mapper\SettingGenerateTablesMapper;
use App\Setting\Model\SettingGenerateTables;
use App\System\Service\DataMaintainService;
use Hyperf\DbConnection\Db;
use Mine\Abstracts\AbstractService;
use Mine\Generator\ApiGenerator;
use Mine\Generator\ControllerGenerator;
use Mine\Generator\MapperGenerator;
use Mine\Generator\ModelGenerator;
use Mine\Generator\RequestGenerator;
use Mine\Generator\ServiceGenerator;
use Mine\Generator\SqlGenerator;
use Mine\Generator\VueIndexGenerator;
use Mine\Generator\VueSaveGenerator;

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
     * SettingGenerateTablesService constructor.
     * @param SettingGenerateTablesMapper $mapper
     * @param DataMaintainService $dataMaintainService
     * @param SettingGenerateColumnsService $settingGenerateColumnsService
     */
    public function __construct(
        SettingGenerateTablesMapper $mapper,
        DataMaintainService $dataMaintainService,
        SettingGenerateColumnsService $settingGenerateColumnsService
    )
    {
        $this->mapper = $mapper;
        $this->dataMaintainService = $dataMaintainService;
        $this->settingGenerateColumnsService = $settingGenerateColumnsService;
    }

    /**
     * 装载数据表
     * @param array $names
     * @return bool
     */
    public function loadTable(array $names): bool
    {
        try {
            Db::beginTransaction();

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

            Db::commit();
            return true;
        } catch (\RuntimeException $e) {
            Db::rollBack();
            return false;
        }
    }

    /**
     * 同步数据表
     * @param int $id
     * @return bool
     */
    public function sync(int $id): bool
    {
        $table = $this->read($id);
        $columns = $this->dataMaintainService->getColumnList(
            str_replace(env('DB_PREFIX'), '', $table['table_name'])
        );
        $model = $this->settingGenerateColumnsService->mapper->getModel();
        $ids = $model->newQuery()->where('table_id', $table['id'])->pluck('id');

        try {
            Db::beginTransaction();
            $this->settingGenerateColumnsService->mapper->delete($ids->toArray());
            foreach ($columns as &$column) {
                $column['table_id'] = $id;
            }
            $this->settingGenerateColumnsService->save($columns);
            Db::commit();
        } catch (\RuntimeException $e) {
            Db::rollBack();
            return false;
        }
        return true;
    }

    /**
     * 更新业务表
     * @param array $data
     * @return bool
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
        $data['options'] = empty($data['options']) ? null : serialize($data['options']);

        try {
            Db::beginTransaction();
            // 更新业务表
            $this->update($id, $data);

            // 更新业务字段表
            foreach ($columns as $column) {
                $this->settingGenerateColumnsService->update($column['id'], $column);
            }

            Db::commit();
        } catch (\RuntimeException $e) {
            Db::rollBack();
            return false;
        }
        return true;
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
                'code' => make(SqlGenerator::class)->setGenInfo($model)->preview(),
                'lang' => 'sql',
            ],
        ];
    }

}