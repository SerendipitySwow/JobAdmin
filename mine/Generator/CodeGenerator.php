<?php


namespace Mine\Generator;


use Mine\MineModel;

interface CodeGenerator
{
    public function setGenInfo($model);

    public function generator();

    public function preview();
}