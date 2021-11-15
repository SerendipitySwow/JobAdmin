<?php
/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */

declare (strict_types = 1);
namespace Mine\Abstracts;

use Mine\MineModel;
use Mine\Traits\MapperTrait;

/**
 * Class AbstractMapper
 * @package Mine\Abstracts
 */
abstract class AbstractMapper
{
    use MapperTrait;

    /**
     * @var MineModel
     */
    public $model;

    protected static $attributes = [];
    
    abstract public function assignModel();

    public function __construct()
    {
        $this->assignModel();
    }
    
    public static function load($data){
        self::$attributes = $data;
    }

    public function __get($name)
    {
        return self::$attributes[$name] ?? '';
    }

    /**
     * @return array
     */
    public function getAttributes():array
    {
        return self::$attributes;
    }
}
