<?php

declare(strict_types=1);
namespace Mine\Generator;

use Mine\Mine;

class MineGenerator
{
    protected $stubDir;

    /**
     * @var Mine
     */
    protected $mine;

    public function __construct(Mine $mine)
    {
        $this->mine = $mine;
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