<?php

declare(strict_types=1);
namespace Mine;

use Hyperf\DbConnection\Model\Model;
use Hyperf\Di\Annotation\Inject;
use Mine\Helper\Id;

/**
 * Class MineModel
 * @package Mine
 * @method static onlyTrashed()
 */
class MineModel extends Model
{
    /**
     * @Inject
     * @var Id
     */
    protected $gen;

    /**
     * 隐藏的字段列表
     * @var string[]
     */
    protected $hidden = ['deleted_at'];

    /**
     * 状态
     */
    public const ENABLE = 0;
    public const DISABLE = 1;

    /**
     * 默认每页记录数
     */
    public const PAGE_SIZE = 15;

    /**
     * 生成一个主键 ID
     * @return int
     */
    public function genId(): int
    {
        /** @var Id $gen */
        return $this->gen->getId();
    }

    /**
     * 设置主键的值
     * @param string | int $value
     */
    public function setPrimaryKeyValue($value): void
    {
        $this->{$this->primaryKey} = $value;
    }

    /**
     * @return string
     */
    public function getPrimaryKeyType(): string
    {
        return $this->keyType;
    }

    /**
     * @param array $options
     * @return bool
     */
    public function save(array $options = []): bool
    {
        return parent::save($options);
    }

    /**
     * @param array $models
     * @return MineCollection
     */
    public function newCollection(array $models = []): MineCollection
    {
        return new MineCollection($models);
    }

}