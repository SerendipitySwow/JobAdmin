<?php

declare(strict_types=1);
namespace Mine\Generator;

use Hyperf\Utils\Filesystem\Filesystem;
use Mine\Helper\Str;
use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;

class TableGenerator
{
    /**
     * @var array
     */
    protected $tableInfo;

    /**
     * @var string
     */
    protected $tableName;

    /**
     * @var string
     */
    protected $moduleName;

    /**
     * 创建数据表
     * @param bool $init
     * @return bool
     */
    public function createTable(bool $init = true): bool
    {
        $result = true;
        $init && $this->init();

        // 创建数据表迁移文件
        if ($this->tableInfo['migrate']) {
            $result = $this->createMigrateFile();
        }

        // 创建数据表
        if ($result) {
            $this->execSchemaSql();
        }

        return $result;
    }

    protected function init(): void
    {
        $this->setTableName(Str::lower(trim($this->tableInfo['name'])));
        $this->setModuleName(Str::lower($this->tableInfo['module']));
    }

    /**
     * 执行建表架构SQL
     */
    protected function execSchemaSql()
    {

    }

    /**
     * 创建迁移文件
     */
    protected function createMigrateFile(): bool
    {
        return true;
    }

    /**
    $table->addColumn('bigInteger', 'created_by', ['comment' => '创建者'])->nullable();
    $table->addColumn('bigInteger', 'updated_by', ['comment' => '更新者'])->nullable();
    $table->addColumn('timestamp', 'created_at', ['precision' => 0, 'comment' => '创建时间'])->nullable();
    $table->addColumn('timestamp', 'updated_at', ['precision' => 0, 'comment' => '更新时间'])->nullable();
    $table->addColumn('timestamp', 'deleted_at', ['precision' => 0, 'comment' => '删除时间'])->nullable();
     */

    public function setTableName(string $tableName): TableGenerator
    {
        $this->tableName = $tableName;
        return $this;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @return string
     */
    public function getModuleName(): string
    {
        return $this->moduleName;
    }

    /**
     * @param string $moduleName
     * @return TableGenerator
     */
    public function setModuleName(string $moduleName): TableGenerator
    {
        $this->moduleName = $moduleName;
        return $this;
    }


    public function setTableInfo(array $tableInfo): TableGenerator
    {
        $this->tableInfo = $tableInfo;
        return $this;
    }

    public function getTableInfo(): array
    {
        return $this->tableInfo;
    }
}