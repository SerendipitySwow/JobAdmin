<?php
/** @noinspection PhpSignatureMismatchDuringInheritanceInspection */

declare(strict_types=1);
namespace Mine\Generator;

use App\Setting\Model\SettingGenerateColumns;
use App\Setting\Model\SettingGenerateTables;
use App\Setting\Service\SettingGenerateColumnsService;
use Hyperf\Utils\Filesystem\Filesystem;
use Mine\Exception\NormalStatusException;
use Mine\Helper\Str;

/**
 * Mapper类生成
 * Class MapperGenerator
 * @package Mine\Generator
 */
class MapperGenerator extends MineGenerator implements CodeGenerator
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
     * @return MapperGenerator
     */
    public function setGenInfo(SettingGenerateTables $model): MapperGenerator
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
     * @return $this
     */
    public function generator(): MapperGenerator
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
     * 获取生成的类型
     * @return string
     */
    public function getType(): string
    {
        return ucfirst($this->model->type);
    }

    /**
     * 获取模板地址
     * @return string
     */
    protected function getTemplatePath(): string
    {
        return $this->getStubDir().$this->getType().'/mapper.stub';
    }

    /**
     * 读取模板内容
     * @return string
     */
    protected function readTemplate(): string
    {
        return $this->filesystem->sharedGet($this->getTemplatePath());
    }

    /**
     * 占位符替换
     */
    protected function placeholderReplace(): MapperGenerator
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
            '{USE}',
            '{COMMENT}',
            '{CLASS_NAME}',
            '{MODEL}',
            '{FIELD_ID}',
            '{FIELD_PID}',
            '{SEARCH}'
        ];
    }

    /**
     * 获取要替换占位符的内容
     */
    protected function getReplaceContent(): array
    {
        return [
            $this->initNamespace(),
            $this->getUse(),
            $this->getComment(),
            $this->getClassName(),
            $this->getModelName(),
            $this->getFieldIdName(),
            $this->getFieldPidName(),
        ];
    }

    /**
     * 初始化服务类命名空间
     * @return string
     */
    protected function initNamespace(): string
    {
        return $this->getNamespace() . "\\Service";
    }

    /**
     * 获取控制器注释
     * @return string
     */
    protected function getComment(): string
    {
        return $this->model->menu_name. 'Mapper类';
    }

    /**
     * 获取使用的类命名空间
     * @return string
     */
    protected function getUse(): string
    {
        return <<<UseNamespace
Use {$this->getNamespace()}\\Model\\{$this->getBusinessName()};
UseNamespace;
    }

    /**
     * 获取类名称
     * @return string
     */
    protected function getClassName(): string
    {
        return $this->getBusinessName().'Mapper';
    }

    /**
     * 获取Model类名称
     * @return string
     */
    protected function getModelName(): string
    {
        return $this->getBusinessName();
    }

    /**
     * 获取树表ID
     * @return string
     */
    protected function getFieldIdName(): string
    {
        if ($this->getType() == 'Tree') {
            $options = json_decode($this->model->options);
            if ( $options->tree_id ?? false ) {
                return $options->tree_id;
            } else {
                return 'id';
            }
        }
        return '';
    }

    /**
     * 获取树表父ID
     * @return string
     */
    protected function getFieldPidName(): string
    {
        if ($this->getType() == 'Tree') {
            $options = json_decode($this->model->options);
            if ( $options->tree_pid ?? false ) {
                return $options->tree_pid;
            } else {
                return 'parent_id';
            }
        }
        return '';
    }

    /**
     * 获取搜索内容
     * @return string
     */
    protected function getSearch(): string
    {
        /* @var SettingGenerateColumns $model */
        $model = make(SettingGenerateColumnsService::class)->mapper->getModel();
        $data = $model->newQuery()
            ->where('table_id', $this->model->id)
            ->where('is_query', '1')
            ->get()->toArray();

        //TODO...

        return '';
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