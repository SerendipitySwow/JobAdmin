<?php
declare (strict_types = 1);
namespace Mine\Abstracts;

/**
 * Class AbstractMapper
 * @package Mine\Abstracts
 */
abstract class AbstractMapper
{
    protected $model;

    abstract protected function assignModel();

    public function __construct()
    {
        $this->assignModel();
    }

    public function getModel()
    {
        return $this->model;
    }
}