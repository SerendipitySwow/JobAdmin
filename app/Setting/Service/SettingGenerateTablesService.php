<?php

declare(strict_types=1);
namespace App\Setting\Service;

use App\Setting\Mapper\SettingGenerateTablesMapper;
use App\System\Service\DataMaintainService;
use Hyperf\DbConnection\Db;
use Mine\Abstracts\AbstractService;
use Mine\Generator\ControllerGenerator;
use Mine\Generator\ModelGenerator;
use Mine\Generator\ServiceGenerator;

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
     * 预览代码
     * @param int $id
     * @return array
     */
    public function preview(int $id): array
    {
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
                'code' => '',
                'lang' => 'php',
            ],
            [
                'tab_name' => 'CreateRequest.php',
                'name' => 'create_request',
                'code' => '',
                'lang' => 'php',
            ],
            [
                'tab_name' => 'UpdateRequest.php',
                'name' => 'update_request',
                'code' => '',
                'lang' => 'php',
            ],
            [
                'tab_name' => 'Api.js',
                'name' => 'api',
                'code' => '',
                'lang' => 'javascript',
            ],
            [
                'tab_name' => 'Index.vue',
                'name' => 'index',
                'code' => '',
                'lang' => 'vue',
            ],
            [
                'tab_name' => 'Form.vue',
                'name' => 'form',
                'code' => '',
                'lang' => 'vue',
            ],
            [
                'tab_name' => 'Menu.sql',
                'name' => 'sql',
                'code' => '',
                'lang' => 'sql',
            ],
        ];
    }

}