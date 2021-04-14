<?php

namespace Mine;

use Hyperf\DbConnection\Model\Model;
use Hyperf\Di\Annotation\Inject;
use Mine\Helper\Id;

/**
 * Class MineModel
 * @package Mine
 */
class MineModel extends Model
{
    /**
     * @Inject
     * @var Id
     */
    protected $gen;

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

}