<?php

declare(strict_types=1);
namespace Mine\Generator;

class MineGenerator
{
    protected $stubDir;

    public function __construct()
    {
        $this->setStubDir(BASE_PATH . '/mine/Generator/Stubs/');
    }

    public function getStubDir(): string
    {
        return $this->stubDir;
    }

    public function setStubDir(string $stubDir)
    {
        $this->stubDir = $stubDir;
    }
}