<?php

declare(strict_types=1);
namespace Mine\Generator;

abstract class MineGenerator
{
    protected $stubDir;

    protected $namespace;

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

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @param mixed $namespace
     */
    public function setNamespace(string $namespace): void
    {
        $this->namespace = $namespace;
    }


}