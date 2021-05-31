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
    public $model;

    public function assignModel()
    {
        $this->model = SystemPost::class;
    }
}