<?php

/** @noinspection PhpSignatureMismatchDuringInheritanceInspection */

declare(strict_types=1);
namespace Mine\Generator;

use App\Setting\Model\SettingGenerateTables;
use App\Setting\Service\SettingGenerateColumnsService;
use Hyperf\Utils\Filesystem\Filesystem;
use Mine\Exception\NormalStatusException;
use Mine\Helper\Str;

/**
 * 模型生成
 * Class ControllerGenerator
 * @package Mine\Generator
 */
class ModelGenerator extends MineGenerator implements CodeGenerator
{
    /**
     * @var SettingGenerateTables
     */
    protected $model;

    /**
     * @var string
     */
    protected $codeContent;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * 设置生成信息
     * @param SettingGenerateTables $model
     * @return ModelGenerator
     */
    public function setGenInfo(SettingGenerateTables $model): ModelGenerator
    {
        $this->model = $model;
        $this->filesystem = make(Filesystem::class);
        if (empty($model->module_name) || empty($model->menu_name)) {
            throw new NormalStatusException('请先编辑配置生成信息');
        }
        $this->setNamespace($this->model->namespace);
        return $this;
    }

    /**
     * 生成代码
     * @return ModelGenerator
     */
    public function generator(): ModelGenerator
    {
        return $this;
    }

    /**
     * 预览代码
     */
    public function preview(): string
    {
        return $this->placeholderReplace()->getCodeContent();
    }

    /**
     * 获取生成控制器的类型
     * @return string
     */
    public function getControllerType(): string
    {
        return ucfirst($this->model->type);
    }

    /**
     * 获取控制器模板地址
     * @return string
     */
    protected function getControllerTemplatePath(): string
    {
        return $this->getStubDir().'model.stub';
    }

    /**
     * 读取模板内容
     * @return string
     */
    protected function readTemplate(): string
    {
        return $this->filesystem->sharedGet($this->getControllerTemplatePath());
    }

    /**
     * 占位符替换
     */
    protected function placeholderReplace(): ModelGenerator
    {
        $this->setCodeContent(str_replace(
            $this->getPlaceHolderContent(),
            $this->getReplaceContent(),
            $this->readTemplate()
        ));

        return $this;
    }

    /**
     * 获取要替换的占位符
     */
    protected function getPlaceHolderContent(): array
    {
        return [
            '{NAMESPACE}',
            '{CLASS_NAME}',
            '{TABLE_NAME}',
            '{FILL_ABLE}',
        ];
    }

    /**
     * 获取要替换占位符的内容
     */
    protected function getReplaceContent(): array
    {
        return [
            $this->initNamespace(),
            $this->getClassName(),
            $this->getTableName(),
            $this->getFillAble(),
        ];
    }

    /**
     * 初始化模型命名空间
     * @return string
     */
    protected function initNamespace(): string
    {
        return $this->getNamespace() . "\\Model";
    }

    /**
     * 获取类名称
     * @return string
     */
    protected function getClassName(): string
    {
        return $this->getBusinessName();
    }

    /**
     * 获取表名称
     * @return string
     */
    protected function getTableName(): string
    {
        return $this->model->table_name;
    }

    /**
     * 获取file able
     */
    protected function getFillAble(): string
    {
        $data = make(SettingGenerateColumnsService::class)->getList(
            ['select' => 'column_name', 'table_id' => $this->model->id]
        );
        $columns = [];
        foreach ($data as $column) {
            $columns[] = "'".$column['column_name']."'";
        }

        return implode(', ', $columns);
    }


    /**
     * 获取业务名称
     * @return string
     */
    public function getBusinessName(): string
    {
        return Str::studly(str_replace(env('DB_PREFIX'), '', $this->model->table_name));
    }


    /**
     * 设置代码内容
     * @param string $content
     */
    public function setCodeContent(string $content)
    {
        $this->codeContent = $content;
    }

    /**
     * 获取代码内容
     * @return string
     */
    public function getCodeContent(): string
    {
        return $this->codeContent;
    }
}