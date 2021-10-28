<?php
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

    abstract public function assignModel();

    public function __construct()
    {
        $this->assignModel();
    }
}