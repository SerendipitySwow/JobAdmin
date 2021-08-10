<?php

declare(strict_types=1);
namespace Mine;

use Hyperf\Database\Model\Builder;
use Hyperf\DbConnection\Model\Model;
use Hyperf\Di\Annotation\Inject;
use Hyperf\ModelCache\Cacheable;
use Mine\Helper\Id;

/**
 * Class MineModel
 * @package Mine
 * @method static onlyTrashed()
 */
class MineModel extends Model
{
    use Cacheable;

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
     * MineModel constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // 注册自定义方法
        $this->registerMethods();
    }

    /**
     * 生成一个主键 ID
     * @return int
     * @throws \Exception
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

    /**
     * 注册自定义方法
     */
    private function registerMethods()
    {
        // 数据权限方法
        Builder::macro('mineDataScope', function() {

        });
    }

}