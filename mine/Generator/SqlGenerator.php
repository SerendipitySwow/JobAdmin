<?php
/** @noinspection PhpExpressionResultUnusedInspection */
/** @noinspection PhpSignatureMismatchDuringInheritanceInspection */
/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */

declare(strict_types=1);
namespace Mine\Generator;

use App\Setting\Model\SettingGenerateTables;
use App\System\Model\SystemMenu;
use Hyperf\Utils\Filesystem\Filesystem;
use Mine\Exception\NormalStatusException;
use Mine\Helper\Id;
use Mine\Helper\LoginUser;
use Mine\Helper\Str;

/**
 * 菜单SQL文件生成
 * Class SqlGenerator
 * @package Mine\Generator
 */
class SqlGenerator extends MineGenerator implements CodeGenerator
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
    protected $adminId;

    /**
     * 设置生成信息
     * @param SettingGenerateTables $model
     * @param string $adminId
     * @return SqlGenerator
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function setGenInfo(SettingGenerateTables $model, string $adminId): SqlGenerator
    {
        $this->model = $model;
        $this->adminId = $adminId;
        $this->filesystem = make(Filesystem::class);
        if (empty($model->module_name) || empty($model->menu_name)) {
            throw new NormalStatusException(t('setting.gen_code_edit'));
        }
        return $this;
    }

    /**
     * 生成代码
     * @throws \Exception
     */
    public function generator(): void
    {
        $path = BASE_PATH . "/runtime/generate/{$this->getRoute()}Menu.sql";
        $this->filesystem->makeDirectory(BASE_PATH . "/runtime/generate/");
        $this->filesystem->put($path, $this->placeholderReplace()->getCodeContent());
    }

    /**
     * 预览代码
     * @throws \Exception
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
        return $this->getStubDir().'/sql.stub';
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
     * @throws \Exception
     */
    protected function placeholderReplace(): SqlGenerator
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
            '{ID}',
            '{PARENT_ID}',
            '{TABLE_NAME}',
            '{LEVEL}',
            '{NAME}',
            '{CODE}',
            '{ROUTE}',
            '{VUE_TEMPLATE}',
            '{ADMIN_ID}'
        ];
    }

    /**
     * 获取要替换占位符的内容
     * @throws \Exception
     */
    protected function getReplaceContent(): array
    {
        return [
            $this->getId(),
            $this->getParentId(),
            $this->getTableName(),
            $this->getLevel(),
            $this->model->menu_name,
            $this->getCode(),
            $this->getRoute(),
            $this->getVueTemplate(),
            $this->getAdminId()
        ];
    }

    /**
     * 获取菜单ID
     * @return int
     * @throws \Exception
     */
    protected function getId(): int
    {
        return (new Id())->getId();
    }

    /**
     * 获取菜单父ID
     * @return int
     */
    protected function getParentId(): int
    {
        return $this->model->belong_menu_id;
    }

    /**
     * 获取菜单表表名
     * @return string
     */
    protected function getTableName(): string
    {
        return (SystemMenu::getModel())->getTable();
    }

    /**
     * 获取菜单层级value
     * @return string
     */
    protected function getLevel(): string
    {
        $model = SystemMenu::find($this->model->belong_menu_id, ['id', 'level']);
        return $model->level . ',' . $model->id;
    }

    /**
     * 获取菜单标识代码
     * @return string
     */
    protected function getCode(): string
    {
        return Str::lower($this->model->module_name) . ':' . $this->getShortBusinessName();
    }

    /**
     * 获取vue router地址
     * @return string
     */
    protected function getRoute(): string
    {
        return $this->getShortBusinessName();
    }


    /**
     * 获取Vue模板路径
     * @return string
     */
    protected function getVueTemplate(): string
    {
        return Str::lower($this->model->module_name) . '/' . $this->getShortBusinessName() . '/index';
    }

    /**
     * 获取短业务名称
     * @return string
     */
    public function getShortBusinessName(): string
    {
        return Str::camel(str_replace(
            Str::lower($this->model->module_name),
            '',
            str_replace(env('DB_PREFIX'), '', $this->model->table_name)
        ));
    }

    /**
     * 获取当前登陆人ID
     * @return string
     */
    protected function getAdminId(): string
    {
        return (string) $this->adminId;
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