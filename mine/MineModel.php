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
     * 重写保存方法
     * @param array $options
     * @return bool
     */
    public function save(array $options = []): bool
    {
        if (!$this->incrementing && $this->keyType === 'int') {
            $key = $this->primaryKey;
            $this->$key = $this->genId();
        }
        return parent::save($options);
    }

}