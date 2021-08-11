<?php

/** @noinspection PhpSignatureMismatchDuringInheritanceInspection */

declare(strict_types=1);
namespace Mine\Generator;

use App\Setting\Model\SettingGenerateTables;
use Hyperf\Utils\Filesystem\Filesystem;
use Mine\Exception\NormalStatusException;
use Mine\Helper\Str;

/**
 * 验证器生成
 * Class RequestGenerator
 * @package Mine\Generator
 */
class RequestGenerator extends MineGenerator implements CodeGenerator
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
     * @var string
     */
    protected $type;

    /**
     * 设置生成信息
     * @param SettingGenerateTables $model
     * @param string $type
     * @return RequestGenerator
     */
    public function setGenInfo(SettingGenerateTables $model, string $type): RequestGenerator
    {
        $this->model = $model;
        $this->type  = $type;
        $this->filesystem = make(Filesystem::class);
        if (empty($model->module_name) || empty($model->menu_name)) {
            throw new NormalStatusException('请先编辑配置生成信息');
        }
        $this->setNamespace($this->model->namespace);
        return $this;
    }

    /**
     * 生成代码
     * @return $this
     */
    public function generator(): RequestGenerator
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
        return $this->getStubDir().$this->getControllerType().'/controller.stub';
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
    protected function placeholderReplace(): RequestGenerator
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
            '{COMMENT}',
            '{CLASS_NAME}',
            '{RULES}'
        ];
    }

    /**
     * 获取要替换占位符的内容
     */
    protected function getReplaceContent(): array
    {
        return [
            $this->initNamespace(),
            $this->getComment(),
            $this->getUse(),
            $this->getClassName(),
            $this->getServiceName(),
            $this->getControllerRoute(),
            $this->getCreateRequestName(),
            $this->getUpdateRequestName(),
        ];
    }

    /**
     * 初始化控制器命名空间
     * @return string
     */
    protected function initNamespace(): string
    {
        $namespace = $this->getNamespace() . "\\Controller";
        if (!empty($this->model->package_name)) {
            return $namespace . "\\" . $this->model->package_name;
        }
        return $namespace;
    }

    /**
     * 获取控制器注释
     * @return string
     */
    protected function getComment(): string
    {
        return $this->model->menu_name. '控制器';
    }

    /**
     * 获取使用的类命名空间
     * @return string
     */
    protected function getUse(): string
    {
        return <<<UseNamespace
Use {$this->getNamespace()}\\Service\\{$this->getBusinessName()}Service;
Use {$this->getNamespace()}\\Request\\{$this->getBusinessName()}CreateRequest;
Use {$this->getNamespace()}\\Request\\{$this->getBusinessName()}UpdateRequest;
UseNamespace;
    }

    /**
     * 获取控制器类名称
     * @return string
     */
    protected function getClassName(): string
    {
        return $this->getBusinessName().'Controller';
    }

    /**
     * 获取服务类名称
     * @return string
     */
    protected function getServiceName(): string
    {
        return $this->getBusinessName().'Service';
    }

    /**
     * 获取控制器路由
     * @return string
     */
    protected function getControllerRoute(): string
    {
        return sprintf(
            '%s/%s',
            Str::lower($this->model->module_name),
            $this->getBusinessName()
        );
    }

    /**
     * 获取方法路由
     * @param string $route
     * @return string
     */
    protected function getMethodRoute(string $route): string
    {
        return sprintf(
            '%s:%s:%s',
            Str::lower($this->model->module_name),
            $this->getBusinessName(),
            $route
        );
    }

    /**
     * 获取保存数据的验证器
     * @return string
     */
    protected function getCreateRequestName(): string
    {
        return $this->getBusinessName(). 'CreateRequest';
    }

    /**
     * 获取更新数据的验证器
     * @return string
     */
    protected function getUpdateRequestName(): string
    {
        return $this->getBusinessName(). 'UpdateRequest';
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