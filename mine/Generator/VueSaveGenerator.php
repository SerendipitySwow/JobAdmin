<?php
/** @noinspection PhpExpressionResultUnusedInspection */
/** @noinspection PhpSignatureMismatchDuringInheritanceInspection */

declare(strict_types=1);
namespace Mine\Generator;

use App\Setting\Model\SettingGenerateColumns;
use App\Setting\Model\SettingGenerateTables;
use Hyperf\Utils\Filesystem\Filesystem;
use Mine\Exception\NormalStatusException;
use Mine\Helper\Str;

/**
 * Vue index文件生成
 * Class VueSaveGenerator
 * @package Mine\Generator
 */
class VueSaveGenerator extends MineGenerator implements CodeGenerator
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
     * @return VueSaveGenerator
     */
    public function setGenInfo(SettingGenerateTables $model): VueSaveGenerator
    {
        $this->model = $model;
        $this->filesystem = make(Filesystem::class);
        if (empty($model->module_name) || empty($model->menu_name)) {
            throw new NormalStatusException('请先编辑配置生成信息');
        }
        return $this;
    }

    /**
     * 生成代码
     * @return $this
     */
    public function generator(): VueSaveGenerator
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
     * 获取模板地址
     * @return string
     */
    protected function getTemplatePath(): string
    {
        return $this->getStubDir().'/Vue/save.stub';
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
    protected function placeholderReplace(): VueSaveGenerator
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
            '{CODE}',
            '{FIRST_SEARCH}',
            '{SEARCH_LIST}',
            '{COLUMN_LIST}',
            '{BUSINESS_EN_NAME}',
            '{QUERY_PARAMS}',
        ];
    }

    /**
     * 获取要替换占位符的内容
     */
    protected function getReplaceContent(): array
    {
        return [
            $this->getCode(),
            $this->getFirstSearch(),
            $this->getSearchList(),
            $this->getColumnList(),
            $this->getBusinessEnName(),
            $this->getQueryParams(),
        ];
    }

    /**
     * 获取标识代码
     * @return string
     */
    protected function getCode(): string
    {
        return Str::lower($this->model->module_name)
                . ':' .
                Str::studly(str_replace(env('DB_PREFIX'), '', $this->model->table_name));
    }

    /**
     * 获取第一个搜索
     * @return string
     */
    protected function getFirstSearch(): string
    {
        return '';
    }

    /**
     * 获取其余搜索列表
     * @return string
     */
    protected function getSearchList(): string
    {
        return '';
    }

    /**
     * 获取表格显示列
     * @return string
     */
    protected function getColumnList(): string
    {
        $model = SettingGenerateColumns::getModel();

        return '';
    }

    /**
     * 获取业务英文名
     * @return string
     */
    protected function getBusinessEnName(): string
    {
        return Str::studly(str_replace(env('DB_PREFIX'), '', $this->model->table_name));
    }

    /**
     * 获取需要搜索的字段列表
     * @return string
     */
    protected function getQueryParams(): string
    {
        return '';
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