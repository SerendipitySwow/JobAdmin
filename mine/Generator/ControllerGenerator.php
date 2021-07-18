<?php

/** @noinspection PhpSignatureMismatchDuringInheritanceInspection */

declare(strict_types=1);
namespace Mine\Generator;

use App\Setting\Model\SettingGenerateTables;
use Hyperf\Utils\Filesystem\Filesystem;
use Mine\Exception\NormalStatusException;
use Mine\Helper\Str;

/**
 * 控制器生成
 * Class ControllerGenerator
 * @package Mine\Generator
 */
class ControllerGenerator extends MineGenerator implements CodeGenerator
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
     * @return ControllerGenerator
     */
    public function setGenInfo(SettingGenerateTables $model): ControllerGenerator
    {
        $this->model = $model;
        $this->filesystem = make(Filesystem::class);
        if (empty($model->namespace)) {
            throw new NormalStatusException('请先编辑配置生成信息');
        }
        $this->setNamespace($model->namespace);
        return $this;
    }

    /**
     * 生成代码
     * @return $this
     */
    public function generator(): ControllerGenerator
    {
        return $this;
    }

    /**
     * 预览代码
     */
    public function preview(): string
    {
        return $this->getCodeContent();
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
        return $this->getStubDir().'/'.$this->getControllerType().'/controller.stub';
    }

    /**
     * 占位符替换
     */
    protected function placeholderReplace()
    {

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