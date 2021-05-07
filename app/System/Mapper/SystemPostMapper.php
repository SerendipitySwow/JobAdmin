<?php

declare(strict_types = 1);
namespace App\System\Mapper;


use App\System\Model\SystemPost;
use Mine\Abstracts\AbstractMapper;

class SystemPostMapper extends AbstractMapper
{
    /**
     * @var SystemPost
     */
    public $mapper;

    public function assignModel()
    {
        $this->mapper = SystemPost::class;
    }
}